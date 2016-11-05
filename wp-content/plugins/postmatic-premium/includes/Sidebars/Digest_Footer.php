<?php
namespace Postmatic\Premium\Sidebars;

/**
 * A static named sidebar for digest email footer content.
 * @since 2.0.12
 */
class Digest_Footer extends Base {

	protected static $id = 'prompt-email-digest-footer-area';

	/**
	 * @since 0.2.0
	 * @param array $args
	 */
	public static function register( $args = array() ) {

		$defaults = array(
			'name' => __( 'Postmatic Digest Footer', 'postmatic-premium' ),
			'id' => static::$id,
			'description' => __(
				'These widgets will be included below the content of post digests that are sent via Postmatic.',
				'postmatic-premium'
			),
		);

		$args = wp_parse_args( $args, $defaults );

		parent::register( $args );
	}
}