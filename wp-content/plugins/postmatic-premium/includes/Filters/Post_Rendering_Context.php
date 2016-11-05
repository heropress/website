<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Post_Rendering_Modifiers;

/**
 * Filter post rendering operations.
 * @since 0.1.0
 */
class Post_Rendering_Context {

	/**
	 * Add premium post rendering modifiers.
	 * @since 0.1.0
	 * @param \Prompt_Post_Rendering_Modifier[] $modifiers
	 * @param \WP_Post $post
	 * @param array $featured_image_src
	 * @return \Prompt_Post_Rendering_Modifier[] Augmented modifiers.
	 */
	public static function modifiers( $modifiers, $post, $featured_image_src ) {

		if ( \Prompt_Enum_Email_Transports::LOCAL == \Prompt_Core::$options->get( 'email_transport' ) ) {
			return $modifiers;
		}

		$modifiers[] = new Post_Rendering_Modifiers\Shortcode();
		$modifiers[] = new Post_Rendering_Modifiers\Incompatible();
		$modifiers[] = new Post_Rendering_Modifiers\Lazy_Load();
		$modifiers[] = new Post_Rendering_Modifiers\Image( $featured_image_src );

		if ( \Prompt_Core::$options->get( 'enable_skimlinks' ) ) {
			$modifiers[] = new Post_Rendering_Modifiers\Skimlinks();
		}

		if ( class_exists( 'ET_Bloom' ) ) {
			$modifiers[] = new Post_Rendering_Modifiers\Bloom();
		}

		if ( class_exists( 'Jetpack' ) ) {
			$modifiers[] = new Post_Rendering_Modifiers\Jetpack();
		}

		return $modifiers;
	}
}