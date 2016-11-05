<?php
namespace Postmatic\Premium\Rendering_Contexts;

use Postmatic\Premium\Lists;
use Postmatic\Premium\Models;
use Postmatic\Premium\Repositories;
use Postmatic\Premium\Analyzers;
use Postmatic\Premium\Enums;

/**
 * Manage the query and other context needed to render digests.
 *
 * @since 0.1.0
 *
 */
class Digest {

	/** @var  Lists\Posts\Digest */
	protected $post;
	/** @var  Models\Scheduled_Callback */
	protected $callback;
	/** @var  \WP_Query */
	protected $wp_query;
	/** @var  Repositories\Scheduled_Callback_HTTP */
	protected $callback_repo;
	/** @var  \Prompt_Post_Rendering_Modifier[] */
	protected $modifiers;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Posts\Digest $post
	 * @param Models\Scheduled_Callback $callback
	 * @param \Prompt_Post_Rendering_Modifier[] $modifiers
	 * @param Repositories\Scheduled_Callback_HTTP $callback_repo
	 */
	public function __construct(
		Lists\Posts\Digest $post,
		Models\Scheduled_Callback $callback = null,
		$modifiers = null,
		Repositories\Scheduled_Callback_HTTP $callback_repo = null
	) {
		$this->post = $post;
		$this->callback = $callback;
		$this->modifiers = $modifiers;
		$this->callback_repo = $callback_repo ? $callback_repo : new Repositories\Scheduled_Callback_HTTP();
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return bool|\WP_Error
	 */
	public function setup() {

		if ( ! $this->callback ) {
			$callback_id = $this->get_digest_list()->get_callback_id();
			$this->callback = $this->callback_repo->get_by_id( $callback_id );
		}

		if ( is_wp_error( $this->callback ) ) {
			return $this->callback;
		}

		$this->wp_query = new \WP_Query( array(
			'posts_per_page' => -1,
			'meta_query' => Lists\Posts\Post::include_in_digest_meta_clauses(),
			'post_type' => \Prompt_Core::$options->get( 'site_subscription_post_types' ),
			'date_query' => array(
				'column' => 'post_date_gmt',
				array(
					'after' => date( 'c', time() - $this->callback->get_recurrence_seconds() ),
				),
			),
			'post_status' => 'publish',
		) );

		$this->add_modifiers();

		$this->modifiers = apply_filters(
			'postmatic/premium/rendering_contexts/digest/modifiers',
			$this->modifiers,
			$this->post
		);

		foreach( $this->modifiers as $modifier ) {
			$modifier->setup();
		}

		return true;
	}

	/**
	 * Restore the context after rendering.
	 * @since 0.1.0
	 */
	public function reset() {
		wp_reset_postdata();

		foreach( $this->modifiers as $modifier ) {
			$modifier->reset();
		}
	}

	/**
	 * @since 0.1.0
	 * @return Lists\Digest
	 */
	public function get_digest_list() {
		return $this->post->get_digest_list();
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return Lists\Posts\Digest
	 */
	public function get_digest_post() {
		return $this->post;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return \WP_Query
	 */
	public function get_wp_query() {
		return $this->wp_query;
	}

	/**
	 * Template function to echo a comments by line string.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function the_comments_by_line() {
		echo $this->get_the_comments_by_line();
	}

	/**
	 * Template function to get a comments by line string.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_the_comments_by_line() {

		$number = get_comments_number();

		if ( ! get_comments_number() ) {
			return '';
		}

		$comments = get_approved_comments( get_the_ID() );
		$authors = array_map( 'get_comment_author', $comments );
		$add_span = create_function( '$text', 'return "<span>" . $text . "</span>";' );
		$authors = array_map( $add_span, $authors );

		/* translators: part of the phrase "3 comments by A & B" */
		$by = __( 'by', 'Postmatic' );

		if ( $number == 1 ) {
			return $by . ' ' . $authors[0];
		}

		if ( $number == 2 ) {
			return sprintf( '%1$s %2$s &amp; %3$s', $by, $authors[0], $authors[1] );
		}

		if ( $number == 3 ) {
			return sprintf( '%1$s %2$s, %3$s, &amp; %4$s', $by, $authors[0], $authors[1], $authors[2] );
		}

		$analyzer = new Analyzers\Comments( $comments );

		$top_authors = array_unique( array(
			$analyzer->get_most_discussed_author_name(),
			$analyzer->get_most_prolific_author_name(),
		) );
		$others_count = $number - count( $top_authors );
		$top_authors = implode( ', ', array_map( $add_span, $top_authors ) );

		/* translators: example phrase "8 comments by A, B, & 23 others" */
		return sprintf( __( 'by %1$s, &amp; %2$d others', 'Postmatic' ), $top_authors, $others_count );
	}

	/**
	 * Add data to track a successful digest mailing.
	 *
	 * @since 0.1.0
	 * @param $batch_id
	 * @return $this;
	 */
	public function record_successful_mailing( $batch_id ) {

		$this->post->add_outbound_message_batch_ids( $batch_id );

		if ( ! $this->wp_query or $this->wp_query->post_count == 0 ) {
			return $this;
		}

		foreach ( $this->wp_query->posts as $post ) {
			$prompt_post = new Lists\Posts\Post( $post->ID );
			$prompt_post->add_sent_digest( $this->get_digest_list()->id() );
		}

		return $this;
	}

	/**
	 * @since 0.2.0
	 */
	public function subject() {
		$subject = Enums\Digest_Subject_Styles::MOST_RECENT_PLUS == $this->get_digest_list()->get_subject_style() ?
			$this->most_recent_plus_subject() :
			$this->date_name_subject();

		if ( 'draft' == $this->get_digest_post()->get_wp_post()->post_status ) {
			$subject = sprintf( __( 'PREVIEW of %s', 'postmatic-premium' ), $subject );
		}

		return html_entity_decode( $subject );
	}

	/**
	 * @since 0.2.0
	 * @return string
	 */
	protected function date_name_subject() {
		return sprintf(
			'%s | %s',
			$this->get_digest_list()->subscription_object_label(),
			date( 'F j, Y' )
		);
	}

	/**
	 * @since 0.2.0
	 * @return string
	 */
	protected function most_recent_plus_subject() {

		if ( ! $this->wp_query or $this->wp_query->post_count == 0 ) {
			return __( 'More content coming soon', 'postmatic-premium' );
		}

		$most_recent_title = $this->wp_query->posts[0]->post_title;

		if ( $this->wp_query->post_count == 1 ) {
			return $most_recent_title;
		}

		/* translators: %1$s is the most recent post name, %2$d a count, and %3$d the digest name */
		return sprintf(
			__( '%1$s + %2$d more new posts from %3$s', 'postmatic-premium' ),
			$most_recent_title,
			$this->wp_query->post_count - 1,
			$this->get_digest_list()->subscription_object_label()
		);
	}

	/**
	 * @since 0.1.0
	 */
	protected function add_modifiers() {

		if ( ! is_null( $this->modifiers ) ) {
			return;
		}

		$this->modifiers = array(
			new \Prompt_Excerpt_Post_Rendering_Modifier(),
			new \Prompt_Handlebars_Escape_Post_Rendering_Modifier(),
		);
	}
}