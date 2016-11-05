<?php
namespace Postmatic\Premium\Actions;

use Postmatic\Premium\Models;

/**
 * Webhooks actions
 * @since 0.2.0
 */
class Webhooks {

	/**
	 * Subscribed
	 * @since 0.2.0
	 * @param string $user_id
	 * @param \Prompt_Interface_Subscribable $subscribable_object
	 */
	public static function subscribed( $user_id, $subscribable_object = null ) {

		$is_enabled = \Prompt_Core::$options->get( 'enable_webhooks' );

		if ( $is_enabled ) {
			$webhook = new Models\Webhook( $user_id, $subscribable_object );
			$webhook->execute( 'subscribe' );
		}
	}

	/**
	 * Unsubscribed
	 * @since 0.2.0
	 * @param string $user_id
	 * @param \Prompt_Interface_Subscribable $subscribable_object
	 */
	public static function unsubscribed( $user_id, $subscribable_object ) {

		$is_enabled = \Prompt_Core::$options->get( 'enable_webhooks' );

		if ( $is_enabled ) {
			$webhook = new Models\Webhook( $user_id, $subscribable_object );
			$webhook->execute( 'unsubscribe' );
		}
	}
}