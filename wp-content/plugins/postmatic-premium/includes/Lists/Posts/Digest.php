<?php
namespace Postmatic\Premium\Lists\Posts;

use Postmatic\Premium\Lists;
use Postmatic\Premium\Repositories;
use Postmatic\Premium\Post_Types;
use Postmatic\Premium\Models;

/**
 * Behavior specific to a digest post
 *
 * Each digest post belongs to a digest list that determines when it is sent and who it is
 * sent to. Currently we don't manage subscriptions to comments on a digest post, but it has
 * the capability inherited from Prompt_Post which makes it a (potential) list also.
 *
 * @since 0.1.0
 */
class Digest extends \Prompt_Post {

	/** @var string Uses plan naming for compatibility with early beta releases */
	protected static $list_id_meta_key = '_prompt_digest_plan_id';
	/** @var string */
	protected static $callback_id_meta_key = '_postmatic_digest_callback_id';

	/** @var  int */
	protected $list_id;
	/** @var  Lists\Digest */
	protected $list;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int|\WP_Post $post_id_or_object
	 * @param int|Lists\Digest $list_id_or_object Optional for parent constructor compatibility
	 */
	public function __construct( $post_id_or_object, $list_id_or_object = null ) {
		parent::__construct( $post_id_or_object );

		if ( is_null( $list_id_or_object ) ) {
			$this->list_id = get_post_meta( $this->id, self::$list_id_meta_key, true );
			return;
		}

		if ( $list_id_or_object instanceof Lists\Digest ) {
			$this->list = $list_id_or_object;
			$this->list_id = $this->list->id();
			return;
		}

		$this->list_id = $list_id_or_object;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return Lists\Digest
	 */
	public function get_digest_list() {
		if ( !isset( $this->list ) ) {
			$list_repository =  new Repositories\Digest_List();
			$this->list = $list_repository->get_by_id( $this->list_id );
		}
		return $this->list;
	}

	/**
	 * Get the IDs of users who should receive this digest.
	 *
	 * @return array An array of user IDs.
	 */
	public function recipient_ids() {

		$post = $this->get_wp_post();

		if ( Post_Types\Digest::get_instance()->get_identifier() != $post->post_type ) {
			return array();
		}

		$recipient_ids = $this->cached_recipient_ids();

		if ( !$recipient_ids ) {

			$recipient_ids = $this->get_digest_list()->subscriber_ids();

			/**
			 * Filter the recipient ids of notifications for a post.
			 *
			 * @param array $recipient_ids
			 * @param \WP_Post $post
			 */
			$recipient_ids = apply_filters( 'prompt/recipient_ids/digest_post', $recipient_ids, $post );

			if ( 'publish' == $post->post_status ) {
				update_post_meta( $post->ID, self::$recipient_ids_meta_key, $recipient_ids );
			}

		}

		return $recipient_ids;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Digest $list
	 * @param Models\Scheduled_Callback $callback
	 * @return bool
	 */
	public static function is_due( $list, $callback ) {
		$post = static::most_recent( $list );

		if ( !$post ) {
			return true;
		}

		return static::minimum_recurrence_time_has_passed( $post, $callback );
	}

	/**
	 * Get the most recent digest post for a list.
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Digest $list
	 * @return null|Lists\Posts\Digest
	 */
	public static function most_recent( Lists\Digest $list ) {
		$posts = get_posts( array(
			'posts_per_page' => 1,
			'post_type' => Post_Types\Digest::get_instance()->get_identifier(),
			'post_status' => 'publish',
			'meta_query' => array(
				array( 'key' => self::$list_id_meta_key, 'value' => $list->id() ),
				array( 'key' => self::$callback_id_meta_key, 'value' => $list->get_callback_id() )
			),
			'orderby' => 'post_date_gmt',
			'order' => 'DESC',
		) );

		return !empty( $posts ) ? new Lists\Posts\Digest( $posts[0], $list ) : null;
	}

	/**
	 * Make a new unmailed digest post.
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Digest $list
	 * @param array $values
	 * @return Lists\Posts\Digest
	 */
	public static function create( Lists\Digest $list, $values = array() ) {

		$default_values = array(
			'post_title' => $list->subscription_object_label() . ' | ' . date( 'Y-m-d' ),
			'post_author' => $list->get_author_id(),
			'post_type' => Post_Types\Digest::get_instance()->get_identifier(),
			'post_status' => 'draft',
		);

		$values = array_merge( $default_values, $values );

		$post_id = wp_insert_post( $values );

		update_post_meta( $post_id, self::$list_id_meta_key, $list->id() );
		update_post_meta( $post_id, self::$callback_id_meta_key, $list->get_callback_id() );

		return new Lists\Posts\Digest( $post_id, $list );
	}

	/**
	 * Determine if enough time has passed since the last digest.
	 *
	 * @since 0.1.0
	 *
	 * @param Lists\Posts\Digest $post
	 * @param Models\Scheduled_Callback $callback
	 * @return bool
	 */
	protected static function minimum_recurrence_time_has_passed( Lists\Posts\Digest $post, Models\Scheduled_Callback $callback ) {
		$minimum_recurrence_seconds = 0.9 * $callback->get_recurrence_seconds();
		return ( strtotime( $post->get_wp_post()->post_date_gmt . '+0000' ) + $minimum_recurrence_seconds ) < time();
	}
}