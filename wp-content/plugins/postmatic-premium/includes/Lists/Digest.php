<?php
namespace Postmatic\Premium\Lists;

use Postmatic\Premium\Repositories\Digest_List as Repo;
use Postmatic\Premium\Matchers;
use Postmatic\Premium\Enums;

/**
 * Manage subscription data for a digest list.
 * @since 0.1.0
 */
class Digest extends \Prompt_Option_Subscribable_Object {

	/** @var string  */
	static protected $option_key_format = 'prompt_digest_%d_subscriber_ids';

	/** @var  int */
	protected $id;
	/** @var  int */
	protected $callback_id;
	/** @var  int */
	protected $author_id;
	/** @var  string */
	protected $theme_slug;
	/** @var  string */
	protected $introduction_html;
	/** @var  string */
	protected $name;
	/** @var  bool */
	protected $include_full_post_requests = true;
	/** @var  int */
	protected $subject_style;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int $id
	 * @param array $values {
	 *      Digest plan fields
	 * @var int $callback_id
	 * @var string $introduction_html
	 * @var string $name
	 * @var bool $include_full_post_requests
	 * }
	 */
	public function __construct( $id, $values = array() ) {
		$this->id = intval( $id );
		/* translators: %s is site name */
		$this->name = sprintf(
			__( '%s Digest', 'postmatic-premium' ),
			get_option( 'blogname' )
		);
		$this->author_id = get_current_user_id();
		$this->theme_slug = 'none';
		$this->subject_style = Enums\Digest_Subject_Styles::NAME_DATE;
		foreach ( $values as $key => $value ) {
			call_user_func( array( $this, 'set_' . $key), $value );
		}
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	protected function option_key() {
		return sprintf( self::$option_key_format, $this->id );
	}

	/**
	 * @since 0.1.0
	 * @return int
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function subscription_url() {
		return get_home_url();
	}

	/**
	 * A title.
	 *
	 * @since 0.1.0
	 *
	 * @param string $format 'html' or 'text', default 'html'.
	 * @return string
	 */
	public function subscription_object_label( $format = \Prompt_Enum_Content_Types::HTML ) {
		return \Prompt_Content_Handling::html_or_reduced_utf8( $format, $this->name );
	}

	/**
	 * A confirmation message.
	 *
	 * @since 0.1.0
	 *
	 * @param string $format 'html' or 'text', default 'html'.
	 * @return string
	 */
	public function subscription_description( $format = \Prompt_Enum_Content_Types::HTML ) {
		return \Prompt_Content_Handling::html_or_reduced_utf8(
			$format,
			sprintf(
				__( 'You have successfully subscribed to %s. You\'ll receive your first copy as soon as it is published.', 'postmatic-premium' ),
				$this->name
			)
		);
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param string $format 'html' or 'text', default 'html'.
	 * @return string
	 */
	public function select_reply_prompt( $format = \Prompt_Enum_Content_Types::HTML ) {
		$subscribe_mailto = sprintf(
			'mailto:{{{reply_to}}}?subject=%s&body=%s',
			__( 'Just hit send', 'postmatic-premium' ),
			$this->subscribe_phrase()
		);
		return \Prompt_Content_Handling::html_or_reduced_utf8(
			$format,
			sprintf(
				__(
					'To receive less mail you can subscribe to %s. In order to receive digests of posts reply to this email with the word \'%s\'.',
					'postmatic-premium'
				),
				$this->name,
				"<a href=\"$subscribe_mailto\">{$this->subscribe_phrase()}</a>"
			)
		);
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function subscribe_phrase() {
		$phrase = Matchers\Digest::target();
		if ( $this->id ) {
			$phrase .= '-' . $this->id;
		}
		return $phrase;
	}


	/**
	 * @since 0.1.0
	 * @param string $text
	 * @return string
	 */
	public function matches_subscribe_phrase( $text ) {
		$matcher = new Matchers\Digest( $text );
		return $matcher->matches();
	}

	/**
	 * @since 0.1.0
	 * @param string $name
	 * @return $this
	 */
	public function set_name( $name ) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @since 0.1.0
	 * @return int
	 */
	public function get_callback_id() {
		return $this->callback_id;
	}

	/**
	 * @since 0.1.0
	 * @param int $callback_id
	 * @return $this
	 */
	public function set_callback_id( $callback_id ) {
		$this->callback_id = intval( $callback_id );
		return $this;
	}

	/**
	 * @since 0.1.0
	 * @return int
	 */
	public function get_author_id() {
		return $this->author_id;
	}

	/**
	 * @since 0.1.0
	 * @param int $author_id
	 * @return $this
	 */
	public function set_author_id( $author_id ) {
		$this->author_id = $author_id;
		return $this;
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function get_theme_slug() {
		return $this->theme_slug;
	}

	/**
	 * @since 0.1.0
	 * @param string $theme_slug
	 * @return $this
	 */
	public function set_theme_slug( $theme_slug ) {
		$this->theme_slug = $theme_slug;
		return $this;
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function get_introduction_html() {
		return $this->introduction_html;
	}

	/**
	 * @since 0.1.0
	 * @param string $introduction_html
	 * @return $this
	 */
	public function set_introduction_html( $introduction_html ) {
		$this->introduction_html = $introduction_html;
		return $this;
	}

	/**
	 * @since 0.1.0
	 * @return boolean
	 */
	public function get_include_full_post_requests() {
		return $this->include_full_post_requests;
	}

	/**
	 * @since 0.1.0
	 * @param boolean $include_full_post_requests
	 * @return $this
	 */
	public function set_include_full_post_requests( $include_full_post_requests ) {
		$this->include_full_post_requests = $include_full_post_requests;
		return $this;
	}

	/**
	 * @since 0.2.0
	 * @return int
	 */
	public function get_subject_style() {
		return $this->subject_style;
	}

	/**
	 * @since 0.2.0
	 * @param int $subject_style
	 * @return Digest
	 */
	public function set_subject_style( $subject_style ) {

		if ( ! Enums\Digest_Subject_Styles::is_valid_value( $subject_style ) ) {
			trigger_error(
				sprintf(
					__( 'Invalid subject style %d', 'postmatic-premium' ),
					$subject_style
				),
				E_USER_WARNING
			);
			return $this;
		}

		$this->subject_style = $subject_style;
		return $this;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_values_array() {
		return array(
			'name' => $this->subscription_object_label(),
			'callback_id' => $this->get_callback_id(),
			'author_id' => $this->get_author_id(),
			'theme_slug' => $this->get_theme_slug(),
			'introduction_html' => $this->get_introduction_html(),
			'include_full_post_requests' => $this->get_include_full_post_requests(),
			'subject_style' => $this->get_subject_style(),
		);
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int $user_id
	 * @param Repo $repo Optional
	 * @return array
	 */
	public static function subscribed_object_ids( $user_id, Repo $repo = null ) {
		$ids = array();
		$repo = $repo ?: new Repo();
		foreach ( $repo->all() as $list ) {
			if ( $list->is_subscribed( $user_id ) ) {
				$ids[] = $list->id();
			}
		}
		return $ids;
	}

	/**
	 * @since 0.1.0
	 * @param Repo $repo Optional
	 * @return array
	 */
	public static function all_subscriber_ids( Repo $repo = null ) {
		$ids = array();

		$repo = $repo ?: new Repo();
		foreach ( $repo->all() as $list ) {
			$ids = array_unique( array_merge( $ids, $list->subscriber_ids() ) );
		}
		return $ids;
	}

}