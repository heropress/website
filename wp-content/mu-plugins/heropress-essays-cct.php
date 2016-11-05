<?php
/*
Plugin Name: HeroPress Essays CCT
Description: Registers the custom content type for Essays
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/


// Register Custom Post Type
function heropress_essays_cct() {

	$labels = array(
		'name'                => _x( 'Essays', 'Post Type General Name', 'heropress' ),
		'singular_name'       => _x( 'Essay', 'Post Type Singular Name', 'heropress' ),
		'menu_name'           => __( 'Essays', 'heropress' ),
		'parent_item_colon'   => __( 'Parent Essay:', 'heropress' ),
		'all_items'           => __( 'All Essays', 'heropress' ),
		'view_item'           => __( 'View Essay', 'heropress' ),
		'add_new_item'        => __( 'Add New Essay', 'heropress' ),
		'add_new'             => __( 'Add New', 'heropress' ),
		'edit_item'           => __( 'Edit Essay', 'heropress' ),
		'update_item'         => __( 'Update Essay', 'heropress' ),
		'search_items'        => __( 'Search Essays', 'heropress' ),
		'not_found'           => __( 'Not found', 'heropress' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'heropress' ),
	);
	$args = array(
		'label'               => __( 'heropress-essays', 'heropress' ),
		'description'         => __( 'HeroPress Essays', 'heropress' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'comments', 'author', ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite'             => array( 'slug' => 'essays' ),
	);
	register_post_type( 'heropress-essays', $args );

}

add_action( 'init', function () {
	heropress_essays_cct();
	do_action( 'heropress_init' );
}, 100 );

