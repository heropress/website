<?php
namespace Postmatic\Premium\Commands;

use Postmatic\Premium\Matchers;
use Postmatic\Premium\Repositories;

/**
 * Add subscription switching replies to the standard forward command.
 * @since 0.1.0
 */
class Forward extends \Prompt_Forward_Command {
	/**
	 * @var string
	 */
	protected static $instant_method = 'instant';
	/**
	 * @var string
	 */
	protected static $digest_method = 'digest';

	/**
	 * Add more command checks if the parent doesn't find one.
	 *
	 * @since 0.1.0
	 * @return string Text command if found, otherwise empty.
	 */
	protected function get_text_command() {

		$command = parent::get_text_command();

		if ( !empty( $command ) ) {
			return $command;
		}

		$stripped_text = $this->get_message_text();

		$instant_matcher = new \Prompt_Instant_Matcher( $stripped_text );
		if ( $instant_matcher->matches() ) {
			return self::$instant_method;
		}

		$digest_matcher = new Matchers\Digest( $stripped_text );
		if ( $digest_matcher->matches() ) {
			return self::$digest_method;
		}

		return '';
	}

	/**
	 * Subscribe to instant posts.
	 *
	 * @since 0.1.0
	 * @param bool $notify
	 */
	protected function instant( $notify = true ) {

		if ( ! \Prompt_Core::$options->get( 'enable_post_delivery' ) ) {
			return;
		}

		$this->unsubscribe_from_digests();

		$prompt_site = new \Prompt_Site();

		if ( $prompt_site->is_subscribed( $this->from_user_id ) ) {
			return;
		}

		$prompt_site->subscribe( $this->from_user_id );

		if ( $notify ) {
			\Prompt_Subscription_Mailing::send_subscription_notification( $this->from_user_id, $prompt_site );
		}
	}

	/**
	 * Change the user to a digest subscription if available.
	 *
	 * @since 0.1.0
	 * @param bool|false $notify
	 */
	protected function digest( $notify = true ) {

		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return;
		}

		$prompt_site = new \Prompt_Site();
		$prompt_site->unsubscribe( $this->from_user_id );

		$repo = new Repositories\Digest_List();
		$list = $repo->get_default();

		if ( $list->is_subscribed( $this->from_user_id ) ) {
			return;
		}

		$list->subscribe( $this->from_user_id );

		if ( $notify ) {
			\Prompt_Subscription_Mailing::send_subscription_notification( $this->from_user_id, $list );
		}
	}

	/**
	 * @since 0.1.0
	 */
	protected function unsubscribe_from_digests() {

		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return;
		}

		$repo = new Repositories\Digest_List();
		$list = $repo->get_default();

		$list->unsubscribe( $this->from_user_id );
	}

}
