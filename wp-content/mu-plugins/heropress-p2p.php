<?php
/*
Plugin Name: HeroPress Posts 2 Posts Config
Description: Creates all the relationships needed for P2P
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

function heropress_connection_types() {

	p2p_register_connection_type(
		array(
			'name'		 => 'essays_to_contributors',
			'from'		 => 'heropress-essays',
			'to'		 => 'hp-contributors',
			'reciprocal' => false,
			'sortable'	 => 'any',
		)
	);

	p2p_register_connection_type(
		array(
			'name'		 => 'podcast_to_contributors',
			'from'		 => 'podcast',
			'to'		 => 'hp-contributors',
			'reciprocal' => false,
			'sortable'	 => 'any',
		)
	);

}
add_action( 'p2p_init', 'heropress_connection_types' );
