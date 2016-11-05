<?php
namespace Postmatic\Premium\Widgets;


/**
 * Subscribers Chart Dashboard Widget
 * @since 0.5.0
 */
class Subscribers_Chart {

	/**
	 * Render Dashboard Widget
	 * @since 0.5.0
	 */
	static public function render() {
		?>
		<div class="upper">
			<div class="left">
				<h2 class="total"></h2>
				<small>total subscribers</small>
			</div>
			<div class="right">
				<h2 class="week"></h2>
				<small>this week</small>
			</div>
		</div>
		<canvas id="subscribersChart"></canvas>
		<?php

	}

	/**
	 * Get Chart data
	 * @since 0.5.0
	 * @returns Array
	 */
	static public function get_data() {

		global $wpdb;

		// Get all data
		$results = $wpdb->get_col( "SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key='prompt_subscriber_origin'" );

		// Resolve subscriber origins
		$posts = array_filter( array_map( array( __CLASS__, 'get_origin_timestamp' ), $results ) );
		$posts_total = count( $posts );

		// Get Last 90 days only, (last 89 + today)
		$limit = time() - ( 60 * 60 * 24 * 89 );
		$posts = array_filter( $posts, function ( $x ) use ( $limit ) {
			return $x > $limit;
		} );
		$posts_ninety = count( $posts );

		// Map timestamp to actual days from 90d ago.
		$posts = array_map( function ( $x ) use ( $limit ) {
			return (int)round( ( $x - $limit ) / ( 60 * 60 * 24 ) );
		}, $posts );
		$posts = array_count_values( $posts );

		$posts_data = array();
		$post_count = $posts_total - $posts_ninety;

		// Format data for chart use (90 spots array)
		for ( $i = 0; $i < 90; $i++ ) {
			if ( isset( $posts[$i] ) ) {
				$post_count += $posts[$i];
			}
			$posts_data[$i] = $post_count;
		}

		// Results for JS
		$last_week = $posts_data[82];
		$results = array(
			'total' => $posts_total,
			'post' => $posts_data,
			'week' => $posts_total - $last_week
		);

		return $results;
	}

	/**
	 * Return the subscriber origin timestamp from serialized data if present.
	 * @since 2.0.0
	 * @param string $data
	 * @return int|null
	 */
	protected static function get_origin_timestamp( $data ) {
		
		$origin = maybe_unserialize( $data );
		
		if ( is_a( $origin, 'Prompt_Subscriber_Origin' ) ) {
			return $origin->get_timestamp();
		}

		if ( is_object( $origin ) and isset( $origin->timestamp ) ) {
			return $origin->timestamp;
		}
		
		if ( isset( $origin['timestamp'] ) ) {
			return $origin['timestamp']; 
		}
		
		return null;
	}
}
