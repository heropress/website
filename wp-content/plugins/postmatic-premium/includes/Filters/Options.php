<?php
namespace Postmatic\Premium\Filters;

/**
 * Filter option values.
 * @since 0.5.0
 */
class Options {

	/**
	 * Use the default digests list in the API when digests are enabled.
	 *
	 * @since 0.5.0
	 * @param array $options
	 * @return array
	 */
	public static function default_options( array $options = array() ) {
		$options['custom_css'] = '';
		return $options;
	}
}