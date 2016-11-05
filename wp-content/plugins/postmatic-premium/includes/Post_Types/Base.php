<?php

namespace Postmatic\Premium\Post_Types;

/**
 * Handle common singleton post type implementation details.
 * @since 0.1.0
 */
abstract class Base {

	/**
	 * @since 0.1.0
	 * @var string
	 */
	protected $identifier;

	/**
	 * The WordPress post type object.
	 * @since 0.1.0
	 * @var object
	 */
	protected $object;

	/**
	 * Get the single instance of a post type.
	 * @since 0.1.0
	 * @return Base
	 */
	public static function get_instance() {
		static $instances = array();

		$called_class = get_called_class();

		if ( ! isset( $instances[$called_class] ) ) {
			$instances[$called_class] = new $called_class();
		}

		return $instances[$called_class];
	}

	/**
	 * Preserve singetonity.
	 * @since 0.1.0
	 */
	protected function __construct() {
	}

	/**
	 * Register the post type, returning the native post type object.
	 * @since 0.1.0
	 * @param array $args
	 * @return object
	 */
	abstract public function register( $args = array() );

	/**
	 * Get the post type identifier;
	 * @since 0.1.0
	 * @return string
	 */
	public function get_identifier() {
		return $this->identifier;
	}

	/**
	 * Get the post type object, registering first if needed.
	 * @since 0.1.0
	 * @return object
	 */
	public function get_object() {
		if ( ! $this->object ) {
			$this->object = $this->register();
		}
		return $this->object;
	}
}