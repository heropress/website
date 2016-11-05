<?php
namespace Postmatic\Premium\Models;

use Postmatic\Premium\Core;

/**
 * Adapt the basic plugin script model to use premium paths.
 * @since 0.3.0
 */
class Script extends \Prompt_Script {

	/**
	 * Script constructor.
	 * @since 0.3.0
	 * @param array $properties
	 */
	public function __construct( array $properties ) {

		parent::__construct( $properties );

		$core = Core::get_instance();

		if ( ! file_exists( $core->path( 'version' ) ) ) {
			$this->path = str_replace( '.min', '', $this->path );
		}

		$this->url = $core->url( $this->path );
	}
}