<?php
/*
Plugin Name: HeroPress Sponsors CCT
Description: Registers the custom content type for Sponsors
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/


// Register Custom Post Type
function heropress_sponsors_cct() {

	$labels = array(
		'name'                => _x( 'Sponsors', 'Post Type General Name', 'heropress' ),
		'singular_name'       => _x( 'Sponsor', 'Post Type Singular Name', 'heropress' ),
		'menu_name'           => __( 'Sponsors', 'heropress' ),
		'parent_item_colon'   => __( 'Parent Sponsor:', 'heropress' ),
		'all_items'           => __( 'All Sponsors', 'heropress' ),
		'view_item'           => __( 'View Sponsor', 'heropress' ),
		'add_new_item'        => __( 'Add New Sponsor', 'heropress' ),
		'add_new'             => __( 'Add New', 'heropress' ),
		'edit_item'           => __( 'Edit Sponsor', 'heropress' ),
		'update_item'         => __( 'Update Sponsor', 'heropress' ),
		'search_items'        => __( 'Search Sponsors', 'heropress' ),
		'not_found'           => __( 'Not found', 'heropress' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'heropress' ),
	);
	$args = array(
		'label'               => __( 'hp-sponsors', 'heropress' ),
		'description'         => __( 'HeroPress Sponsors', 'heropress' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', ),
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
		'rewrite'             => array( 'slug' => 'sponsors' ),
	);
	register_post_type( 'hp-sponsors', $args );

}

add_action( 'init', function () {
	heropress_sponsors_cct();
	do_action( 'heropress_init' );
}, 100 );

