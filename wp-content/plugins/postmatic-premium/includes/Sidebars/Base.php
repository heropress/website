<?php
namespace Postmatic\Premium\Sidebars;

/**
 * Common static sidebar functionality.
 * @since 0.2.0
 */
abstract class Base {

	/**
	 * @since 0.2.0
	 * @var string
	 */
	protected static $id;

	/**
	 * @since 0.2.0
	 * @param array $args register_sidebar() arguments
	 */
	public static function register( $args = array() ) {

		$defaults = array(
			'before_widget' => "<div class='postmatic-widget'>",
			'after_widget' => '</div>',
			'before_title' => "<h4>",
			'after_title' => '</h4>'
		);

		$args = wp_parse_args( $args, $defaults );

		static::$id = register_sidebar( $args );
	}

	/**
	 * Emit the sidebar HTML.
	 * @since 0.2.0
	 */
	public static function echo_html() {

		$sidebars_widgets = wp_get_sidebars_widgets();
		$count = isset( $sidebars_widgets[static::$id] ) ? count( $sidebars_widgets[static::$id] ) : 0;

		if ( $count ) {
			echo "<div id=\"widgets-$count\" class=\"gutter\">";
		}

		dynamic_sidebar( static::$id );

		if ( $count ) {
			echo "</div>";
		}
	}

	/**
	 * Return the sidebar HTML.
	 * @since 0.2.0
	 * @return string
	 */
	public static function render_html() {
		ob_start();
		static::echo_html();
		return ob_get_clean();
	}

	/**
	 * Whether the sidebar is registered.
	 * @since 0.2.0
	 * @return bool
	 */
	public static function is_registered() {
		return is_registered_sidebar( static::$id );
	}

	/**
	 * Unregister the sidebar.
	 * @since 0.2.0
	 */
	public static function unregister() {
		unregister_sidebar( static::$id );
	}

}