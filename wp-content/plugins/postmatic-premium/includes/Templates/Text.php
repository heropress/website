<?php
namespace Postmatic\Premium\Templates;

use Postmatic\Premium\Core;

/**
 * Local text template model
 * @since 0.1.0
 */
class Text extends \Prompt_Text_Template {

	/**
 	 * Override the free plugin's fallback template directory.
 	 *
	 * @since 0.1.0
	 * @param string $name
	 * @param string $dir Optional fallback directory
	 */
	public function __construct( $name, $dir = null ) {
		$dir = $dir ?: Core::get_instance()->path( 'templates' );
		parent::__construct( $name, $dir );
	}
}