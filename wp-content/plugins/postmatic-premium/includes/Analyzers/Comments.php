<?php
namespace Postmatic\Premium\Analyzers;

/**
 * Analyze comments for highlights such as most discussed and most prolific author.
 *
 * @since 0.1.0
 *
 */
class Comments {

	/** @var  array */
	protected $comments;
	/** @var bool */
	protected $analyzed = false;
	/** @var  array */
	protected $author_counts_by_name;
	/** @var  string */
	protected $most_prolific_author;
	/** @var  array */
	protected $id_index = array();
	/** @var  array */
	protected $thread_count_by_root_id = array();
	/** @var int */
	protected $max_thread_count = 0;
	/** @var int */
	protected $max_thread_root_id;
	/** @var int */
	protected $max_thread_author;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param array $comments
	 */
	public function __construct( array $comments ) {
		$this->comments = $comments;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_most_prolific_author_name() {
		$this->ensure_analyzed();
		return $this->most_prolific_author;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_most_discussed_author_name() {
		$this->ensure_analyzed();
		return $this->max_thread_author;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 */
	protected function ensure_analyzed() {

		if ( $this->analyzed ) {
			return;
		}

		foreach( $this->comments as $comment ) {
			$this->index( $comment );
			$this->update_author_counts( $comment );
		}

		// Update thread counts after id index is complete

		foreach( $this->comments as $comment ) {
			$this->update_thread_count( $comment );
		}

		$this->analyzed = true;
	}

	/**
	 * @since 0.1.0
	 * @param object $comment
	 */
	protected function update_author_counts( $comment ) {

		$author = get_comment_author( $comment );

		$this->author_counts_by_name[$author] = isset( $this->author_counts_by_name[$author] ) ?
			$this->author_counts_by_name[$author]++ :
			1;

		if ( ! isset( $this->most_prolific_author ) ) {
			$this->most_prolific_author = $author;
		}

		if ( $this->author_counts_by_name[$author] > $this->author_counts_by_name[$this->most_prolific_author] ) {
			$this->most_prolific_author = $author;
		}

	}

	/**
	 * @since 0.1.0
	 * @param object $comment
	 */
	protected function index( $comment ) {
		$this->id_index[$comment->comment_ID] = $comment;

		if ( ! $comment->comment_parent ) {
			$this->thread_count_by_root_id[$comment->comment_ID] = 0;
		}
	}

	/**
	 * @since 0.1.0
	 * @param object $comment
	 */
	protected function update_thread_count( $comment ) {

		$root_id = $comment->comment_ID;

		while( $this->id_index[$root_id]->comment_parent ) {
			$root_id = $this->id_index[$root_id]->comment_parent;
		}

		$this->thread_count_by_root_id[$root_id]++;

		if ( $this->thread_count_by_root_id[$root_id] > $this->max_thread_count ) {
			$this->max_thread_count = $this->thread_count_by_root_id[$root_id];
			$this->max_thread_root_id = $root_id;
			$this->max_thread_author = get_comment_author( $this->id_index[$root_id] );
		}

	}

}