<?php
namespace Postmatic\Premium\Sidebars;

/**
 * A static named sidebar for comment email footer content.
 * @since 0.2.0
 */
class Comment_Footer extends Base {

	protected static $id = 'prompt-comment-email-footer-area';

	/**
	 * @since 0.2.0
	 * @param array $args
	 */
	public static function register( $args = array() ) {

		$defaults = array(
			'name' => 'Postmatic Comments Footer',
			'id' => static::$id,
			'description' => __(
				'These widgets will be included below the comments in Postmatic comment notifications. Need inspiration? Try our widgets directory at http://gopostmatic.com/widgets.',
				'postmatic-premium'
			),
		);

		$args = wp_parse_args( $args, $defaults );

		parent::register( $args );
	}
}