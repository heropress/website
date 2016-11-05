<?php
namespace Postmatic\Premium\Models;

/**
 * Postmatic behavior specific to a comment.
 *
 * Encapsulates a WordPress comment, since WordPress doesn't allow extension.
 *
 * @since 0.4.0
 */
class Comment {

	/**
	 * @since 0.4.0
	 * @var string
	 */
	protected static $sent_digest_meta_key = '_postmatic_digested';

	/** @var int */
	protected $id;
	/** @var object|\WP_Comment */
	protected $wp_comment;

	/**
	 * @since 0.4.0
	 * @param $comment_id_or_object
	 */
	public function __construct( $comment_id_or_object ) {
		if ( is_object( $comment_id_or_object ) ) {
			$this->id = $comment_id_or_object->comment_ID;
			$this->wp_comment = $comment_id_or_object;
		} else {
			$this->id = intval( $comment_id_or_object );
		}
	}

	/**
	 * @since 0.4.0
	 * @return int
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * @since 0.4.0
	 * @return object|\WP_Comment
	 */
	public function get_wp_comment() {
		if ( !isset( $this->wp_comment ) ) {
			$this->wp_comment = get_comment( $this->id );
		}
		return $this->wp_comment;
	}

	/**
	 * Record this comment's inclusion in a digest.
	 * @since 0.4.0
	 * @return $this
	 */
	public function set_digested() {
		update_comment_meta( $this->id, static::$sent_digest_meta_key, time() );
		return $this;
	}

	/**
	 * Get meta query clauses to select comments that have not yet been sent out in a digest.
	 *
	 * @since 0.4.0
	 * @return array
	 */
	public static function include_in_digest_meta_clauses() {
		return array(
			array( 'key' => static::$sent_digest_meta_key, 'compare' => 'NOT EXISTS' )
		);
	}
}