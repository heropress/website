<?php

namespace Postmatic\Premium\Post_Types;

/**
 * @since 0.1.0
 */
class Digest extends Base {

	/**
	 * Configure for digests.
	 * @since 0.1.0
	 */
	protected function __construct() {
		$this->identifier = 'prompt_digest';
	}

	/**
	 * Register the digest post type.
	 * @since 0.1.0
	 * @return object The registered post type.
	 */
	public function register( $args = array() ) {

		if ( post_type_exists( $this->identifier ) ) {
			$this->object = get_post_type_object( $this->identifier );
			return $this->object;
		}

		$defaults = array(
			'labels' => array(
				'name' => __( 'Digests', 'Postmatic' ),
				'singular_name' => __( 'Digest', 'Postmatic' ),
				'all_items' => __( 'Digests', 'Postmatic' ),
				'new_item' => __( 'New digest', 'Postmatic' ),
				'add_new' => __( 'Add New', 'Postmatic' ),
				'add_new_item' => __( 'Add New digest', 'Postmatic' ),
				'edit_item' => __( 'Edit digest', 'Postmatic' ),
				'view_item' => __( 'View digest', 'Postmatic' ),
				'search_items' => __( 'Search digests', 'Postmatic' ),
				'not_found' => __( 'No digests found', 'Postmatic' ),
				'not_found_in_trash' => __( 'No digests found in trash', 'Postmatic' ),
				'parent_item_colon' => __( 'Parent digest', 'Postmatic' ),
				'menu_name' => __( 'Digests', 'Postmatic' ),
			),
			'public' => false,
			'hierarchical' => false,
			'show_ui' => false,
			'show_in_nav_menus' => false,
			'supports' => array( 'title', 'editor' ),
			'has_archive' => false,
			'rewrite' => false,
			'query_var' => false,
			'menu_icon' => 'none',
		);

		$args = wp_parse_args( $args, $defaults );

		$this->object = register_post_type( $this->identifier, $args );

		return $this->object;
	}

}