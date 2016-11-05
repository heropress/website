<?php
/*
Plugin Name: HeroPress Contributors CCT
Description: Registers the custom content type for Contributors
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/


// Register Custom Post Type
function heropress_contributors_cct() {

	$labels = array(
		'name'                => _x( 'Contributors', 'Post Type General Name', 'heropress' ),
		'singular_name'       => _x( 'Contributor', 'Post Type Singular Name', 'heropress' ),
		'menu_name'           => __( 'Contributors', 'heropress' ),
		'parent_item_colon'   => __( 'Parent Contributor:', 'heropress' ),
		'all_items'           => __( 'All Contributors', 'heropress' ),
		'view_item'           => __( 'View Contributor', 'heropress' ),
		'add_new_item'        => __( 'Add New Contributor', 'heropress' ),
		'add_new'             => __( 'Add New', 'heropress' ),
		'edit_item'           => __( 'Edit Contributor', 'heropress' ),
		'update_item'         => __( 'Update Contributor', 'heropress' ),
		'search_items'        => __( 'Search Contributors', 'heropress' ),
		'not_found'           => __( 'Not found', 'heropress' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'heropress' ),
	);
	$args = array(
		'label'               => __( 'hp-contributors', 'heropress' ),
		'description'         => __( 'HeroPress Contributors', 'heropress' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'author', ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => false,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite'             => array( 'slug' => 'contributors' ),
	);
	register_post_type( 'hp-contributors', $args );

}

add_action( 'init', function () {
	heropress_contributors_cct();
	do_action( 'heropress_init' );
}, 100 );

