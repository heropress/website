<?php
namespace Postmatic\Premium\Lists\Posts;

class Post extends \Prompt_Post {

	/** @var string */
	protected static $digest_meta_key = '_prompt_in_digest';
	/** @var string */
	protected static $exclude_meta_key = '_prompt_exclude_from_digests';
	/** @var string */
	protected static $comment_digest_callback_id_meta_key = '_prompt_comment_digest_callback_id';
	/** @var string */
	protected static $digested_comments_date_gmt_meta_key = '_prompt_digested_comments_date_gmt';

	/**
	 * Record that this post has been included in a digest mailing.
	 *
	 * @since 0.3.0
	 * @param int $digest_plan_id
	 * @return $this
	 */
	public function add_sent_digest( $digest_plan_id ) {
		add_post_meta( $this->id, static::$digest_meta_key, $digest_plan_id );
		return $this;
	}

	/**
	 * Toggle the flag to exclude the post from digests.
	 * @since 0.3.0
	 * @param bool $exclude
	 * @return $this
	 */
	public function set_exclude_from_digests( $exclude = true ) {
		if ( $exclude ) {
			update_post_meta( $this->id, static::$exclude_meta_key, true );
		} else {
			delete_post_meta( $this->id, static::$exclude_meta_key );
		}
		return $this;
	}

	/**
	 * Whether the post is excluded from digests.
	 * @since 0.3.0
	 * @return bool
	 */
	public function get_exclude_from_digests() {
		return (bool) get_post_meta( $this->id, static::$exclude_meta_key, true );
	}

	/**
	 * @since 0.4.0
	 * @return bool
	 */
	public function in_digest_discussion_mode() {
		return ( 0 !== $this->get_flood_control_comment_id() );
	}

	/**
	 * @since 0.4.0
	 * @param int|null $id Null to remove
	 * @return $this
	 */
	public function set_comment_digest_callback_id( $id = null ) {
		if ( $id ) {
			update_post_meta( $this->id, static::$comment_digest_callback_id_meta_key, intval( $id ) );
		} else {
			delete_post_meta( $this->id, static::$comment_digest_callback_id_meta_key );
		}
		return $this;
	}

	/**
	 * @since 0.4.0
	 * @return int|null Null if none set.
	 */
	public function get_comment_digest_callback_id() {
		$callback_id = get_post_meta( $this->id, static::$comment_digest_callback_id_meta_key, true );
		return $callback_id ? intval( $callback_id ) : null;
	}

	/**
	 * Get the last time comments were digested in GMT.
	 *
	 * Defaults to the GMT post date.
	 *
	 * @since 0.4.0
	 * @return string
	 */
	public function get_digested_comments_date_gmt() {
		$date = get_post_meta( $this->id, static::$digested_comments_date_gmt_meta_key, true );
		$date = $date ?: $this->get_wp_post()->post_date_gmt;
		return $date;
	}

	/**
	 * Set the last time comments were digested in GMT.
	 *
	 * @since 0.4.0
	 * @param string $date
	 * @return $this
	 */
	public function set_digested_comments_date_gmt( $date ) {
		update_post_meta( $this->id, static::$digested_comments_date_gmt_meta_key, $date );
		return $this;
	}

	/**
	 * Get an array of date clauses to select undigested comments on this post.
	 * @since 0.4.0
	 * @return array
	 */
	public function undigested_comments_date_clauses() {
		return array(
			array( 'column' => 'comment_date_gmt', 'after' => $this->get_digested_comments_date_gmt() )
		);
	}

	/**
	 * Get a meta query clause to select posts that have not yet been sent out in a digest.
	 *
	 * @since 0.4.0
	 * @return array
	 */
	public static function include_in_digest_meta_clauses() {
		return array(
			array( 'key' => self::$digest_meta_key, 'compare' => 'NOT EXISTS', ),
			array( 'key' => self::$exclude_meta_key, 'compare' => 'NOT EXISTS', ),
		);
	}
}