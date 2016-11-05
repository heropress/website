<?php
/*
Plugin Name: HeroPress Add Image Sizes
Description: Creates heropress-thumb size
Author: Topher
Version: 1.0.0
*/

function heropress_add_image_sizes() {
	add_image_size( 'heropress-thumb', 300, 9999 );
}
add_action( 'init', 'heropress_add_image_sizes' );
