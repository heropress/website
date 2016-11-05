<?php
namespace Postmatic\Premium\Commands;

use Postmatic\Premium\Matchers;
use Postmatic\Premium\Repositories;

/**
 * Add subscription switching commands to the standard new post comment reply.
 * @since 0.1.0
 */
class New_Post_Comment extends \Prompt_New_Post_Comment_Command {

	/** @var string */
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

		$digest_matcher = new Matchers\Digest( $stripped_text );
		if ( $digest_matcher->matches() ) {
			return self::$digest_method;
		}

		return '';
	}

	/**
	 * Change the user to a digest subscription if available.
	 *
	 * @since 0.1.0
	 */
	protected function digest() {

		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return;
		}

		$repo = new Repositories\Digest_List();
		$list = $repo->get_default();

		$this->unsubscribe( $notify = false );

		$list->subscribe( $this->user_id );

		\Prompt_Subscription_Mailing::send_subscription_notification( $this->user_id, $list );
	}

}