<?php
/*
Plugin Name: HeroPress Add Image to RSS Feed
Description: Automatically adds the featured image to RSS feed as a node.  Also creates heropress-thumb size
Author: Topher
Version: 1.0.0
*/

function heropress_image_rss_node() {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ) {
		$attachment_id       = get_post_thumbnail_id( $post->ID );
		$image_attributes    = wp_get_attachment_image_src( $attachment_id, 'heropress-thumb' );
		$thumbnail           = $image_attributes[0];
		$thumbnail_full_path =  ABSPATH . wp_make_link_relative( $thumbnail );
		echo '<enclosure url="' . esc_url( $thumbnail ) . '" length="' . absint( filesize( $thumbnail_full_path ) ) . '" type="' . esc_attr( get_post_mime_type( $attachment_id ) ) . '"/>' . "\n";
	}
}
add_action( 'rss2_item', 'heropress_image_rss_node' );
