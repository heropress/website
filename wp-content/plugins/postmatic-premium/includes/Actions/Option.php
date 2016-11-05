<?php
namespace Postmatic\Premium\Actions;

use Postmatic\Premium\Repositories;

/**
 * Take action based on core options tab events.
 * @since 0.1.0
 */
class Option {

	/**
	 * When core options are updated, perform any necessary related adjustments like removing digest callbacks.
	 * @since 2.0.0
	 * @param array $old_value
	 * @param array $new_value
	 * @param string $key
	 * @param Repositories\Digest_List|null $list_repo
	 * @param Repositories\Scheduled_Callback_HTTP|null $callback_repo
	 */
	public static function update(
		$old_value,
		$new_value,
		$key = '',
		Repositories\Digest_List $list_repo = null,
		Repositories\Scheduled_Callback_HTTP $callback_repo = null
	) {

		if ( ! \Prompt_Core::$options or $key != \Prompt_Core::$options->get_key() ) {
			return;
		}

		if ( $old_value == $new_value ) {
			return;
		}

		if ( ! array_key_exists( 'enable_digests', $new_value ) or ! array_key_exists( 'enable_digests', $old_value ) ) {
			return;
		}

		if ( $new_value['enable_digests'] or ! $old_value['enable_digests'] ) {
			return;
		}

		self::disabled_digests( $list_repo, $callback_repo );
	}

	/**
	 * When digests are disabled, delete all digest scheduled callbacks.
	 *
	 * @since 0.1.0
	 * @param Repositories\Digest_List $list_repo Optional digest list repository
	 * @param Repositories\Scheduled_Callback_HTTP $callback_repo Optional callback repository
	 */
	protected static function disabled_digests(
		Repositories\Digest_List $list_repo = null,
		Repositories\Scheduled_Callback_HTTP $callback_repo = null
	) {

		$list_repo = $list_repo ?: new Repositories\Digest_List();

		$callback_repo = $callback_repo ?: new Repositories\Scheduled_Callback_HTTP();

		$lists = $list_repo->all();

		foreach( $lists as $list ) {
			if ( $list->get_callback_id() ) {
				$callback_repo->delete( $list->get_callback_id() );
				$list->set_callback_id( null );
				$list_repo->save( $list );
			}
		}
	}
}