<?php
/*
Plugin Name: HeroPress Configuration Options
Description: Includes CMB2
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

// get Custom Meta Boxes 2
include WP_CONTENT_DIR . '/mu-plugins/cmb2/init.php';

// include Posts 2 Posts
include WP_CONTENT_DIR . '/mu-plugins/posts-to-posts/posts-to-posts.php';

// set custom feed template in theme
function heropress_custom_feed() {  
    load_template( get_stylesheet_directory() . '/feed-rss2.php');  
}
function heropress_add_custom_feed() {
	add_feed('rss2', 'heropress_custom_feed');
}
add_action( 'init', 'heropress_add_custom_feed' );

function hp_feed_merge( $qv ) {
    if ( isset( $qv['feed'] ) && ! isset( $qv['post_type'] ) ) {
        $qv['post_type'] = array( 'post', 'heropress-essays', );
    }
    return $qv;
}
add_filter('request', 'hp_feed_merge');
