<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Repositories;
use Postmatic\Premium\Lists;

/**
 * Filter list management items.
 * @since 0.1.0
 */
class Subscribing {

	/**
	 * Add digest list to signup lists when enabled.
	 * @since 0.1.0
	 * @param \Prompt_Interface_Subscribable[] $lists
	 * @return \Prompt_Interface_Subscribable[]
	 */
	public static function get_signup_lists( $lists ) {
		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return $lists;
		}

		$repo = new Repositories\Digest_List();
		$lists[] = $repo->get_default();
		return $lists;
	}

	/**
	 * Make a digest list from base values.
	 *
	 * @since 0.1.0
	 * @param \Prompt_Interface_Subscribable $list
	 * @param mixed $base_value
	 * @return \Prompt_Interface_Subscribable|null $list
	 */
	public static function make_subscribable( \Prompt_Interface_Subscribable $list = null, $base_value = '' ) {

		if ( ! \Prompt_Core::$options->get( 'enable_digests' ) ) {
			return $list;
		}
		
		if ( !$list and !is_numeric( $base_value ) ) {
			$base_value = static::get_id_from_slug( $base_value );
		}

		$repo = new Repositories\Digest_List();

		return $repo->get_by_id( intval( $base_value ) );
	}

	/**
	 * Add digest list class to subscribable classes.
	 * @since 0.1.0
	 * @param string[] $classes
	 * @return string[]
	 */
	public static function get_subscribable_classes( $classes ) {
		$classes[] = 'Postmatic\Premium\Lists\Digest';
		return $classes;
	}

	/**
	 * @since 0.5.0
	 * @param string $slug
	 * @param \Prompt_Interface_Subscribable|null $list
	 * @return string
	 */
	public static function get_subscribable_slug( $slug = '', \Prompt_Interface_Subscribable $list = null ) {

		if ( !$list instanceof Lists\Digest ) {
			return $slug;
		}
		
		return 'digest/' . $list->id();
	}
	
	/**
	 * @since 0.5.0
	 * @param string $slug
	 * @return string
	 */
	protected static function get_id_from_slug( $slug ) {
		$parts = explode( '/', $slug );
		return array_pop( $parts );
	}
}
