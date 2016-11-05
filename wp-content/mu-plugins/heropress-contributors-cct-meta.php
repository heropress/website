<?php
/*
Plugin Name: Palace Contributors CCT Meta Boxes
Description: Creates meta boxes for the Contributors CCT using CMB2
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function hp_contributors_page_meta_boxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_heropress_';

	/**
	 * Metabox for holding Contributor details
	 */
	$meta_boxes['hp-contributor_details'] = array(
		'id'			=> 'hp-contributor_details',
		'title'			=> __( 'Contributor Details', 'heropress' ),
		'object_types'	=> array( 'hp-contributors', ), // Post type
		'context'		=> 'advanced',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'fields'		=> array(
			array(
				'name' => __( 'Twitter', 'heropress' ),
				'desc' => __( 'No @', 'heropress' ),
				'id'   => $prefix . 'contributor_twitter',
				'type' => 'text_medium',
			),
			array(
				'name' => __( 'Web Site', 'heropress' ),
				'id'   => $prefix . 'contributor_url',
				'type' => 'text_url',
			),
			array(
				'name' => __( 'Facebook', 'heropress' ),
				'id'   => $prefix . 'contributor_facebook',
				'type' => 'text_url',
			),
			array(
				'name' => __( 'GitHub', 'heropress' ),
				'id'   => $prefix . 'contributor_github',
				'type' => 'text_url',
			),
			array(
				'name' => __( 'WordPress.tv', 'heropress' ),
				'id'   => $prefix . 'contributor_wptv',
				'type' => 'text_url',
			),
			array(
				'name' => __( 'WordPress.org Profile', 'heropress' ),
				'id'   => $prefix . 'contributor_dot_org',
				'type' => 'text_url',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'hp_contributors_page_meta_boxes' );
