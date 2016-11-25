<?php
/*
Plugin Name: HeroPress Sponsors CCT Meta Boxes
Description: Creates meta boxes for the Sponsors CCT using CMB2
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
function hp_sponsors_page_meta_boxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_heropress_';

	/**
	 * Metabox for holding Sponsor details
	 */
	$meta_boxes['hp-sponsor_details'] = array(
		'id'			=> 'hp-sponsor_details',
		'title'			=> __( 'Sponsor Details', 'heropress' ),
		'object_types'	=> array( 'hp-sponsors', ), // Post type
		'context'		=> 'advanced',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'fields'		=> array(
			array(
				'name' => __( 'Web Site', 'heropress' ),
				'id'   => $prefix . 'sponsor_url',
				'type' => 'text_url',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'hp_sponsors_page_meta_boxes' );
