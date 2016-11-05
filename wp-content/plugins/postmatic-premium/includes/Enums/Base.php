<?php
namespace Postmatic\Premium\Enums;

/**
 * Shared functionality for enum classes.
 * @url http://stackoverflow.com/questions/254514/php-and-enumerations
 * @since 0.2.0
 */
abstract class Base {

	/**
	 * @since 0.2.0
	 * @var array
	 */
	private static $constants = null;

	/**
	 * Get an array of valid constants.
	 * @since 0.2.0
	 * @return array Valid constant names and values.
	 */
	public static function get_constants() {

		if ( is_null( self::$constants ) ) {
			self::$constants = array();
		}

		$class = get_called_class();

		if ( !array_key_exists( $class, self::$constants ) ) {
			$reflection = new \ReflectionClass( $class );
			self::$constants[$class] = $reflection->getConstants();
		}

		return self::$constants[$class];
	}

	/**
	 * Determine if a constant name is valid.
	 * @since 0.2.0
	 * @param string $name
	 * @param bool $case_sensitive Whether to match case, default false.
	 * @return bool
	 */
	public static function is_valid_name( $name, $case_sensitive = false ) {

		$constants = self::get_constants();

		if ( $case_sensitive ) {
			return array_key_exists( $name, $constants );
		}

		$keys = array_map( 'strtolower', array_keys( $constants ) );
		return in_array( strtolower( $name ), $keys );
	}

	/**
	 * Determine if a constant value is valid.
	 * @since 0.2.0
	 * @param int $value
	 * @param bool $strict
	 * @return bool
	 */
	public static function is_valid_value( $value, $strict = false ) {

		$values = array_values( self::get_constants() );

		return in_array( $value, $values, $strict );
	}
}