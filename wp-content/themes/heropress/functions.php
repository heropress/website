<?php

/**
 * Include the parent theme CSS
 */
function get_parent_theme_css() {
	$ver = filemtime( get_stylesheet_directory() . '/css/heropress.css');
    wp_enqueue_style( 'make-theme', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'heropress-css', get_stylesheet_directory_uri() . '/css/heropress.css', [], $ver );
}
add_action( 'wp_enqueue_scripts', 'get_parent_theme_css' );

function hp_pinterest() {
	echo '<meta name="p:domain_verify" content="fa5e77b69a59cb20e640dd0059babca6"/>' . "\n";
}
add_action( 'wp_head', 'hp_pinterest' );

/**
 * Include template tags
 */
include "template-tags/contributor-data.php";
