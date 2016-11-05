<?php
namespace Postmatic\Premium\Filters;

/**
 * Filter command codecs.
 * @since 0.1.0
 */
class Command_Handling {

	protected static $subclass_map = array(
		'Prompt_Confirmation_Command' => 'Postmatic\Premium\Commands\Confirmation',
		'Prompt_New_Post_Comment_Command' => 'Postmatic\Premium\Commands\New_Post_Comment',
		'Prompt_Forward_Command' => 'Postmatic\Premium\Commands\Forward',
	);

	/**
	 * Replace decoded command classes with a premium implementation if we have one.
	 * @since 0.1.0
	 * @param string $class
	 * @return string The class we want to use
	 */
	public static function get_class( $class ) {
		if ( ! isset( static::$subclass_map[$class] ) ) {
			return $class;
		}
		return static::$subclass_map[$class];
	}

}