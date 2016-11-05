<?php
namespace Postmatic\Premium\Actions;

class Invite {

	/**
	 * Handle commenter requests from the invite settings tab
	 */
	public static function ajax_get_commenters() {
		/** @var \WPDB $wpdb */
		global $wpdb;

		// Ask for some time for this one
		ini_set('max_execution_time', 300);

		$query = "SELECT MAX( c.comment_author ) as name, " .
			"c.comment_author_email as address, " .
			"MAX( c.comment_date ) as date, " .
			"COUNT( c.comment_author_email ) as count " .
			"FROM {$wpdb->comments} c " .
			"WHERE c.user_id = 0 " .
			"AND c.comment_type = '' " .
			"AND c.comment_approved = 1 " .
			"AND c.comment_author_email <> '' " .
			"AND NOT EXISTS( SELECT 1 FROM {$wpdb->users} WHERE user_email = c.comment_author_email )" .
			"AND NOT EXISTS( " .
				"SELECT 1 FROM {$wpdb->comments} pc " .
				"WHERE pc.comment_author_email = c.comment_author_email AND pc.comment_type = 'prompt_pre_reg' )" .
			"GROUP BY c.comment_author_email ";

		$results = $wpdb->get_results( $query );

		wp_send_json( $results );
	}

	/**
	 * Handle user requests from the invite settings tab.
	 */
	public static function ajax_get_invite_users() {

		$exclude_subscriber_ids = array();

		foreach ( \Prompt_Subscribing::get_signup_lists() as $signup_list ) {
			$exclude_subscriber_ids = array_merge( $exclude_subscriber_ids, $signup_list::all_subscriber_ids() );
		}
		
		$users = get_users( array( 'exclude' => $exclude_subscriber_ids ) );

		$post_subscriber_ids = \Prompt_Post::all_subscriber_ids();

		$results = array();
		foreach( $users as $user ) {

			if ( empty( $user->user_email ) )
				continue;

			$results[] = array(
				'name' => $user->display_name,
				'address' => $user->user_email,
				'roles' => $user->roles,
				'is_post_subscriber' => in_array( $user->ID, $post_subscriber_ids ),
			);
		}

		wp_send_json( $results );
	}

}
