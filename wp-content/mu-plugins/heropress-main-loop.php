<?php
/*
Plugin Name: HeroPress Main Loop
Description: Edits the main page loop
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

function filter_front_page_loop( $query ) {

    // check to see if we're editing the main query on the page.
    if( $query->is_main_query() ){

        // Check to make sure I'm on the Coaches archive page OR the Make page AND I'm not in the admin area
        if ( $query->is_front_page() AND !is_admin() ) {

            // now I want to order by the year field, so I do that
            $query->set('post_type', array( 'post', 'heropress-essays' ) );
        }

    }
    return $query;

}
// now I apply my function to pre_get_posts and Bob's your uncle
add_filter( 'pre_get_posts', 'filter_front_page_loop' );
