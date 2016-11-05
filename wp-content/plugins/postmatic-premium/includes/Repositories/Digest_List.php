<?php
namespace Postmatic\Premium\Repositories;

use Postmatic\Premium\Lists;

/**
 * Manage persistence of digest plans
 *
 * @since 0.1.0
 *
 */
class Digest_List {

	/** @var int Assuming one plan for now, ID 0 */
	protected static $digest_plan_id = 0;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param $id
	 * @return null|\Postmatic\Premium\Lists\Digest Null if not found.
	 */
	public function get_by_id( $id ) {
		$digest_plans = \Prompt_Core::$options->get( 'digest_plans' );

		if ( !isset( $digest_plans[$id] ) ) {
			return null;
		}

		return new Lists\Digest( $id, $digest_plans[$id] );
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Digest $digest
	 */
	public function save( Lists\Digest $digest ) {
		$digest_plans = \Prompt_Core::$options->get( 'digest_plans' );

		$digest_plans[$digest->id()] = $digest->get_values_array();
		\Prompt_Core::$options->set( 'digest_plans', $digest_plans );
	}

	/**
	 * Delete a list and associated callback if set.
	 *
	 * @since 0.1.0
	 * @param int $id
	 * @param Scheduled_Callback_HTTP $callback_repo Optional callback repository.
	 */
	public function delete( $id, Scheduled_Callback_HTTP $callback_repo = null ) {
		$list = $this->get_by_id( $id );

		if ( ! $list ) {
			return;
		}

		if ( $list->get_callback_id() ) {
			$callback_repo = $callback_repo ?: new Scheduled_Callback_HTTP();
			$callback_repo->delete( $list->get_callback_id() );
		}

		$digest_plans = \Prompt_Core::$options->get( 'digest_plans' );
		unset( $digest_plans[$id] );
		\Prompt_Core::$options->set( 'digest_plans', $digest_plans );
	}

	/**
	 * Get the default plan, creating it if necessary.
	 *
	 * @since 0.1.0
	 *
	 * @return Lists\Digest
	 */
	public function get_default() {
		$plan = $this->get_by_id( self::$digest_plan_id );
		if ( !$plan ) {
			$plan = new Lists\Digest( self::$digest_plan_id );
			$this->save( $plan );
		}
		return $plan;
	}

	/**
	 * Shortcut to get the digest plans array from options.
	 *
	 * @since 0.1.0
	 *
	 * @return Lists\Digest[]
	 */
	public function all() {
		$digest_plans = \Prompt_Core::$options->get( 'digest_plans' );
		$plans = array();
		foreach ( $digest_plans as $id => $values ) {
			$plans[] = new Lists\Digest( $id, $values );
		}
		return $plans;
	}
}