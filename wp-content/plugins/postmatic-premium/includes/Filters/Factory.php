<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Flood_Controllers;

/**
 * Filter factory created objects
 * @since 2.0.0
 */
class Factory {

	/**
	 * @since 2.0.0
	 * @param \Prompt_Comment_Flood_Controller $controller 
	 * @param null|object|\WP_Comment $comment
	 * @return \Prompt_Comment_Flood_Controller 
	 */
	public static function make_comment_flood_controller( \Prompt_Comment_Flood_Controller $controller, $comment = null ) {
		if ( ! \Prompt_Core::$options->is_api_transport() ) {
			return $controller;
		}
		return new Flood_Controllers\Comment( $comment );
	}
}