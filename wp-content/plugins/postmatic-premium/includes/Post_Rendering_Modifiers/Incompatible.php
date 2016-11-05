<?php
namespace Postmatic\Premium\Post_Rendering_Modifiers;

/**
 * Handle rendering incompatible placeholders in post content.
 * @since 0.1.0
 */
class Incompatible extends \Prompt_Post_Rendering_Modifier {

	/**
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8, 1 );
		$this->add_filter( 'embed_oembed_html', array( $this, 'use_original_oembed_url' ), 10, 2 );
		$this->add_filter( 'the_content', array( $this, 'strip_incompatible_tags' ), 11, 1 );
	}

	/**
	 * Replace constructed provider URL with the original for placeholders.
	 *
	 * @since 0.1.0
	 *
	 * @param string $html
	 * @param string $url
	 * @return string
	 */
	public function use_original_oembed_url( $html, $url ) {
		if ( ! $this->has_incompatible_tag( $html ) )
			return $html;

		return preg_replace( '#https?://[^"\']*#', $url, $html );
	}

	/**
	 * @since 0.1.0
	 * @param string $content
	 * @return string Content with incompatible tags removed
	 */
	public function strip_incompatible_tags( $content ) {

		if ( ! $this->has_incompatible_tag( $content ) )
			return $content;

		$content = preg_replace_callback(
			'#<(iframe|object|form)([^>]*)(src|data|action)=[\'"]([^\'"]*)[\'"][^>]*>.*?<\\/\\1>#',
			array( $this, 'strip_incompatible_tag' ),
			$content
		);

		return $content;
	}

	/**
	 * @since 0.1.0
	 * @param array $m matches
	 * @return string replacement
	 */
	protected function strip_incompatible_tag( $m ) {
		$class = $m[1];

		$url_parts = parse_url( $m[4] );

		$url = null;
		if ( $url_parts and isset( $url_parts['host'] ) ) {
			$class = 'embed ' . str_replace( '.', '-', $url_parts['host'] );
			$url = $m[4];
		}

		return $this->incompatible_placeholder( $class, $url );
	}

	/**
	 * @since 0.1.0
	 * @param string $content
	 * @return bool
	 */
	protected function has_incompatible_tag( $content ) {
		return (
			false !== strpos( $content, '<iframe' )
			or
			false !== strpos( $content, '<object' )
			or
			false !== strpos( $content, '<form' )
		);
	}

}
