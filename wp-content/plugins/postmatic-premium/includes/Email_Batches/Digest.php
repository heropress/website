<?php
namespace Postmatic\Premium\Email_Batches;

use Postmatic\Premium\Rendering_Contexts;
use Postmatic\Premium\Templates;
use Postmatic\Premium\Matchers;

/**
 * An email batch that knows how to render digest emails.
 *
 * @since 0.1.0
 *
 */
class Digest extends \Prompt_Email_Batch {

	/** @var  Rendering_Contexts\Digest */
	protected $context;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param Rendering_Contexts\Digest $context
	 */
	public function __construct( Rendering_Contexts\Digest $context ) {
		$this->context = $context;

		$context->setup();

		$template_data = array(
			'digest_query' => $context->get_wp_query(),
			'introduction' => apply_filters( 'the_content', $context->get_digest_list()->get_introduction_html() ),
			'context' => $this->context,
		);

		$html_template = new Templates\HTML( "digest-email.php" );
		$text_template = new Templates\Text( "digest-email-text.php" );
		list( $footnote_html, $footnote_text ) = $this->footnote_content();

		if ( 'draft' == $context->get_digest_post()->get_wp_post()->post_status ) {
			$footnote_html = $footnote_text = '';
		}

		$batch_message_template = array(
			'subject' => $context->subject(),
			'from_name' => html_entity_decode( get_option( 'blogname' ) ),
			'text_content' => $text_template->render( $template_data ),
			'html_content' => $html_template->render( $template_data ),
			'reply_to' => '{{{reply_to}}}',
			'message_type' => \Prompt_Enum_Message_Types::DIGEST,
			'is_' . $context->get_digest_list()->get_theme_slug() . '_theme' => true,
			'footnote_html' => $footnote_html,
			'footnote_text' => $footnote_text,
		);

		$context->reset();

		parent::__construct( $batch_message_template );
	}

	/**
	 * Add recipients who have not already been sent a notice for this digest.
	 *
	 * @since 0.1.0
	 *
	 * @return $this
	 */
	public function add_unsent_recipients() {

		$recipient_ids = $this->context->get_digest_post()->unsent_recipient_ids();

		foreach ( $recipient_ids as $recipient_id ) {
			$this->add_recipient( new \Prompt_User( $recipient_id ) );
		}

		return $this;
	}

	/**
	 * Record current recipients so they are not sent another notice for this digest.
	 *
	 * @since 0.1.0
	 *
	 * @return $this;
	 */
	public function lock_for_sending() {

		$recipient_ids = wp_list_pluck( $this->individual_message_values, 'id' );

		$this->context->get_digest_post()->add_sent_recipient_ids( $recipient_ids );

		return $this;
	}

	/**
	 * Record a temporary failure for current recipients so they will still be sent a notice for this digest on retry.
	 *
	 * @since 0.1.0
	 *
	 * @return $this;
	 */
	public function clear_for_retry() {

		$recipient_ids = wp_list_pluck( $this->individual_message_values, 'id' );

		$this->context->get_digest_post()->remove_sent_recipient_ids( $recipient_ids );

		return $this;
	}

	/**
	 * Add data to track a successful digest mailing.
	 *
	 * @since 0.1.0
	 * @param $batch_id
	 * @return $this;
	 */
	public function record_successful_mailing( $batch_id ) {
		$this->context->record_successful_mailing( $batch_id );
		return $this;
	}

	/**
	 * Add recipient-specific values to the batch.
	 *
	 * @since 0.1.0
	 *
	 * @param \Prompt_User $recipient
	 * @return $this
	 */
	public function add_recipient( \Prompt_User $recipient ) {

		if ( ! $recipient->get_wp_user() ) {
			trigger_error( __( 'Did not add an invalid digest recipient', 'postmatic-premium' ), E_USER_NOTICE );
			return $this;
		}

		$unsubscribe_link = new \Prompt_Unsubscribe_Link( $recipient->get_wp_user() );

		$values = array(
			'id' => $recipient->id(),
			'to_name' => $recipient->get_wp_user()->display_name,
			'to_address' => $recipient->get_wp_user()->user_email,
			'unsubscribe_url' => $unsubscribe_link->url(),
		);

		$command = new \Prompt_Forward_Command();
		$command->set_subscription_object( $this->context->get_digest_list() );
		$command->set_from_user_id( $recipient->id() );
		$command->set_to_user_id( $this->context->get_digest_list()->get_author_id() );

		$values['reply_to'] = $this->trackable_address( \Prompt_Command_Handling::get_command_metadata( $command ) );

		if ( $this->context->get_digest_list()->get_include_full_post_requests() ) {
			$values = array_merge( $values, $this->full_post_request_values( $recipient->id() ) );
		}

		return $this->add_individual_message_values( $values );
	}

	/**
	 * Get the digest rendering context.
	 *
	 * @since 0.1.0
	 *
	 * @return Rendering_Contexts\Digest
	 */
	public function get_context() {
		return $this->context;
	}

	/**
	 * Makes a macro for requesting a full version of each post by mail.
	 *
	 * @since 0.1.0
	 *
	 * @param int $recipient_id
	 * @return array
	 */
	protected function full_post_request_values( $recipient_id ) {

		$values = array();

		foreach ( $this->context->get_wp_query()->posts as $post ) {
			$key = sprintf( 'mail_post_%d_to_me', $post->ID );
			$command = new \Prompt_Post_Request_Command();
			$command->set_user_id( $recipient_id );
			$command->set_post_id( $post->ID );
			$values[$key] = $this->trackable_address( \Prompt_Command_Handling::get_command_metadata( $command ) );
		}

		return $values;
	}

	/**
	 * @since 0.1.0
	 *
	 * @return array Two strings, HTML then text
	 */
	protected function footnote_content() {
		$html_parts = array();
		$text_parts = array();

		/* translators: %s is a subscription list title */
		$why_format = __( 'You received this email because you\'re subscribed to %s.', 'postmatic-premium' );
		$html_parts[] = sprintf( $why_format, $this->get_context()->get_digest_list()->subscription_object_label() );
		$text_parts[] = sprintf(
			$why_format,
			$this->get_context()->get_digest_list()->subscription_object_label( \Prompt_Enum_Content_Types::TEXT )
		);

		if ( \Prompt_Core::$options->get( 'enable_post_delivery' ) ) {
			$instant_mailto = sprintf(
				'mailto:{{{reply_to}}}?subject=%s&body=%s',
				rawurlencode( __( 'Switch to posts as they are published', 'postmatic-premium' ) ),
				rawurlencode( \Prompt_Instant_Matcher::target() )
			);
			/* translators: %s is the instant command word */
			$digest_format = __( 'To receive posts as they are published, reply with word \'%s\'.', 'postmatic-premium' );
			$html_parts[] = sprintf(
				$digest_format,
				"<a href=\"$instant_mailto\">" . \Prompt_Instant_Matcher::target() . '</a>'
			);
			$text_parts[] = sprintf( $digest_format, \Prompt_Instant_Matcher::target() );
		}

		/* translators: %s is the unsubscribe command word */
		$unsub_format = __( 'To unsubscribe reply with the word \'%s\'.', 'postmatic-premium' );

		$html_parts[] = sprintf(
			$unsub_format,
			"<a href=\"{$this->unsubscribe_mailto()}\">" . \Prompt_Unsubscribe_Matcher::target() . '</a>'
		);
		$text_parts[] = sprintf( $unsub_format, \Prompt_Unsubscribe_Matcher::target() );

		return array( implode( ' ', $html_parts ), implode( ' ', $text_parts ) );
	}
}