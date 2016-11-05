<?php
namespace Postmatic\Premium\Commands;

use Postmatic\Premium\Matchers;
use Postmatic\Premium\Repositories;

/**
 * Add subscription switching commands to the standard confirmation.
 * @since 0.1.0
 */
class Confirmation extends \Prompt_Confirmation_Command {
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
	 * Change the user to a digest from a site subscription.
	 * @since 0.1.0
	 */
	protected function digest() {

		if ( !in_array( \Prompt_Enum_Message_Types::DIGEST, \Prompt_Core::$options->get( 'enabled_message_types' ) ) ) {
			return;
		}

		if ( 'Prompt_Site' != $this->object_type ) {
			// We only expect to change from site to digest
			return;
		}

		$list_repo = new Repositories\Digest_List();
		$list = $list_repo->get_default();

		$this->unsubscribe( $notify = false );

		$list->subscribe( $this->user_id );

		\Prompt_Subscription_Mailing::send_subscription_notification( $this->user_id, $list );
	}

	/**
	 * Change the user to a site from a digest subscription.
	 * @since 0.1.0
	 */
	protected function instant() {

		if ( 'Postmatic\Premium\Lists\Digest' != $this->object_type ) {
			return;
		}

		$this->unsubscribe( $notify = false );

		$site = new \Prompt_Site();

		if ( $site->is_subscribed( $this->user_id ) ) {
			return;
		}

		$site->subscribe( $this->user_id );

		\Prompt_Subscription_Mailing::send_subscription_notification( $this->user_id, $site );
	}

}