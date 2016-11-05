<?php
namespace Postmatic\Premium\Post_Rendering_Modifiers;

/**
 * Handle rendering of lazy load image scripts in post content.
 * @since 0.1.0
 */
class Lazy_Load extends \Prompt_Post_Rendering_Modifier {

	/**
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->add_filter( 'the_content', array( $this, 'include_noscript_content' ), 100, 1 );
		$this->add_filter( 'do_rocket_lazyload', '__return_false', 10, 1 );
	}

	/**
	 * Remove noscript tags, but retain their content.
	 *
	 * @since 0.1.0
	 * @param string $content
	 * @return string
	 */
	public function include_noscript_content( $content ) {
		$content = str_replace( '<noscript>', '', $content );
		return str_replace( '</noscript>', '', $content );
	}

}
