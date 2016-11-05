<?php
namespace Postmatic\Premium\Sidebars;

/**
 * A static named sidebar for standard email header content.
 * @since 0.2.0
 */
class Header extends Base {

	protected static $id = 'postmatic-email-header-area';

	/**
	 * @since 0.2.0
	 * @param array $args
	 */
	public static function register( $args = array() ) {

		$defaults = array(
			'name' => 'Postmatic Header',
			'id' => static::$id,
			'description' => __(
				'These widgets will be included above new posts and digests which are sent via Postmatic. Need inspiration? Try our widgets directory at http://gopostmatic.com/widgets.',
				'postmatic-premium'
			),
		);

		$args = wp_parse_args( $args, $defaults );

		parent::register( $args );
	}
}