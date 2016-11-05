<?php
namespace Postmatic\Premium\Sidebars;

/**
 * A static named sidebar for standard email footer content.
 * @since 0.2.0
 */
class Footer extends Base {

	protected static $id = 'prompt-email-footer-area';

	/**
	 * @since 0.2.0
	 * @param array $args
	 */
	public static function register( $args = array() ) {

		$defaults = array(
			'name' => 'Postmatic Posts Footer',
			'id' => static::$id,
			'description' => __(
				'These widgets will be included below the content of new posts that are sent via Postmatic. Need inspiration? Try our widgets directory at http://gopostmatic.com/widgets.',
				'postmatic-premium'
			),
		);

		$args = wp_parse_args( $args, $defaults );

		parent::register( $args );
	}
}