<?php
namespace Postmatic\Premium\Post_Rendering_Modifiers;

/**
 * Manage Jetpack modifications to post rendering.
 * @since 0.1.0
 */
class Jetpack extends \Prompt_Post_Rendering_Modifier {

	/**
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->remove_shortcode( 'gallery', 'gallery_shortcode' );
		$this->add_shortcode( 'gallery', array( $this, 'suppress_jetpack_tiled_gallery' ) );
		$this->add_filter( 'jetpack_photon_override_image_downsize', '__return_true', 10, 1 );
	}

	/**
	 * @since 0.1.0
	 * @param array $atts
	 * @return string
	 */
	public function suppress_jetpack_tiled_gallery( $atts ) {

		// Jetpack adds the type attribute
		if ( isset( $atts['type'] ) )
			return '';

		return gallery_shortcode( $atts );
	}

}

