<?php
namespace Postmatic\Premium\Post_Rendering_Modifiers;

/**
 * Handle image rendering in post email content.
 * @since 0.1.0
 */
class Image extends \Prompt_Post_Rendering_Modifier {

	/** @var  array */
	protected $featured_image_src;

	/**
	 * @since 0.1.0
	 * @param array $featured_image_src Featured image URL if there is one, empty if not.
	 */
	public function __construct( $featured_image_src ) {
		$this->featured_image_src = $featured_image_src;

		if ( function_exists( 'hammy_replace_images' ) )
			$this->remove_filter( 'the_content', 'hammy_replace_images', 999, 1 );

		$this->add_filter( 'the_content', array( $this, 'strip_image_height_attributes' ), 11, 1 );
		$this->add_filter( 'the_content', array( $this, 'limit_image_width_attributes' ), 11, 1 );
		$this->add_filter( 'the_content', array( $this, 'strip_duplicate_featured_images' ), 100, 1 );
	}

	/**
	 * @since 0.1.0
	 * @param string $content
	 * @return string
	 */
	public function strip_image_height_attributes( $content ) {
		return preg_replace( '/(<img[^>]*?) height=["\']\d*["\']([^>]*?>)/', '$1$2', $content );
	}

	/**
	 * @since 0.1.0
	 * @param string $content
	 * @return string
	 */
	public function limit_image_width_attributes( $content ) {
		return preg_replace_callback(
			'/(<img[^>]*?) width=["\'](\d*)["\']([^>]*?>)/',
			array( __CLASS__, 'limit_image_width_attribute' ),
			$content
		);
	}

	/**
	 * @since 0.1.0
	 * @param array $match
	 * @return string replacement
	 */
	protected function limit_image_width_attribute( $match ) {
		$max_width = 709;

		$width = intval( $match[2] );

		if ( $width <= $max_width )
			return $match[0];

		$tag = $match[1] . ' width="' . $max_width . '"' . $match[3];

		return $this->add_image_size_class( $tag );
	}

	/**
	 * Remove featured images of any size if Postmatic is supplying one.
	 *
	 * @since 0.1.0
	 * @param string $content
	 * @return string Modified content
	 */
	public function strip_duplicate_featured_images( $content ) {

		if ( empty( $this->featured_image_src[0] ) )
			return $content;

		$url_parts = parse_url( $this->featured_image_src[0] );

		$basename = basename( $url_parts['path'] );

		$last_hyphen_pos = strrpos( $basename, '-');

		$match = $last_hyphen_pos ? substr( $basename, 0, $last_hyphen_pos ) : $basename;

		return preg_replace(
			'/<img[^>]*src=["\'][^"\']*' . preg_quote( $match, '/' ) . '[^>]*>/',
			'',
			$content
		);
	}

	/**
	 * @since 0.1.0
	 * @param string $tag
	 * @return string Tag with added retina class
	 */
	protected function add_image_size_class( $tag ) {

		if ( preg_match( '/class=[\'"]([^\'"]*)[\'"]/', $tag, $matches ) ) {
			$classes = explode( ' ', $matches[1] );
			$classes[] = 'retina';
			return str_replace( $matches[0], 'class="' . implode( ' ', $classes ) . '"', $tag );
		}

		return str_replace( '<img', '<img class="retina"', $tag );
	}

}
