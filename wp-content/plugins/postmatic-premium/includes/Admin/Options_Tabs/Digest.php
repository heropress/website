<?php
namespace Postmatic\Premium\Admin\Options_Tabs;

use Postmatic\Premium\Repositories;

use Postmatic\Premium\Lists;
use Postmatic\Premium\Models;
use Postmatic\Premium\Email_Batches;
use Postmatic\Premium\Rendering_Contexts;
use Postmatic\Premium\Enums;

/**
 * Digest options tab
 * @since 0.1.0
 */
class Digest extends \Prompt_Admin_Options_Tab {

	/** @var array */
	protected static $empty_digest_schedule = array(
		'digest_start_time' => '',
		'digest_frequency_days' => '',
	);
	/** @var string */
	protected static $date_format = 'M j, Y g:i a';
	/** @var array */
	protected static $digest_theme_choices;

	/** @var  Lists\Digest */
	protected $list;
	/** @var array */
	protected $digest_schedule;
	/** @var  Repositories\Scheduled_Callback_HTTP */
	protected $callback_repo;
	/** @var  Repositories\Digest_List */
	protected $list_repo;

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param bool|string                          $options
	 * @param array                                $overridden_options
	 * @param Repositories\Scheduled_Callback_HTTP $callback_repo
	 * @param Repositories\Digest_List        $list_repo
	 */
	public function __construct( $options, $overridden_options = null, $callback_repo = null, $list_repo = null ) {
		parent::__construct( $options, $overridden_options );
		self::$digest_theme_choices = array(
			'none' => __( 'Basic', 'postmatic-premium' ),
			'traditional' => __( 'Traditional', 'postmatic-premium' ),
			'newsy' => __( 'News', 'postmatic-premium' ),
			'photo' => __( 'Photo', 'postmatic-premium' ),
			'grid' => __( 'Modern', 'postmatic-premium' ),
		);
		$this->callback_repo = $callback_repo ? $callback_repo : new Repositories\Scheduled_Callback_HTTP();
		$this->list_repo = $list_repo ? $list_repo : new Repositories\Digest_List();
		$this->list = $this->list_repo->get_default();
		$this->get_digest_schedule();
	}

	/**
	 * Tab name
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function name() {
		return __( 'Configure Digests', 'postmatic-premium' );
	}

	/**
	 * Tab slug
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function slug() {
		return 'digests';
	}

	/**
	 * Save options
	 *
	 * @since 0.1.0
	 *
	 */
	public function form_handler() {

		if ( !isset( $_POST['digest_introduction'] ) and !isset( $_POST['send_digest_preview_button'] ) ) {
			return;
		}

		$save_plan = false;

		$new_theme_slug = $this->new_data_posted( 'digest_theme_slug', $this->list->get_theme_slug() );
		if ( $new_theme_slug and in_array( $new_theme_slug, array_keys( self::$digest_theme_choices ) ) ) {
			$this->list->set_theme_slug( $new_theme_slug );
			$save_plan = true;
		}

		$sanitized_introduction = $this->new_data_posted(
			'digest_introduction',
			$this->list->get_introduction_html(),
			array( 'stripslashes', 'wp_kses_post' )
		);
		if ( $sanitized_introduction !== false ) {
			$this->list->set_introduction_html( $sanitized_introduction );
			$save_plan = true;
		}

		$sanitized_name = $this->new_data_posted(
			'digest_name',
			$this->list->subscription_object_label(),
			array( 'stripslashes', 'sanitize_text_field' )
		);
		if ( $sanitized_name !== false ) {
			$this->list->set_name( $sanitized_name );
			$save_plan = true;
		}

		$include_full_post_requests = isset( $_POST['digest_include_full_post_requests'] );
		if ( $include_full_post_requests != $this->list->get_include_full_post_requests() ) {
			$this->list->set_include_full_post_requests( $include_full_post_requests );
			$save_plan = true;
		}

		$subject_style = $this->new_data_posted( 'digest_subject_style', $this->list->get_subject_style(), 'intval' );
		if ( $subject_style !== false ) {
			$this->list->set_subject_style( $subject_style );
			$save_plan = true;
		}

		if ( $save_plan ) {
			$this->list_repo->save( $this->list );
			$this->add_notice( __( 'Digest information updated.', 'postmatic-premium' ) );
		}

		if ( empty( $_POST['digest_frequency_days'] ) and $this->list->get_callback_id() ) {
			$this->delete_digest_schedule();
			$this->add_notice( __( 'Digest schedule removed.', 'postmatic-premium' ) );
		}

		if (
			$this->new_data_posted( 'digest_start_time', $this->digest_schedule['digest_start_time'] )
			or
			$this->new_data_posted( 'digest_frequency_days', $this->digest_schedule['digest_frequency_days'] )
		) {
			$local_start_time = strtotime( $_POST['digest_start_time'] );
			$frequency_days = intval( $_POST['digest_frequency_days'] );
			$this->replace_scheduled_callback( $local_start_time, $frequency_days );
		}

		if ( isset( $_POST['send_digest_preview_button'] ) ) {
			$this->send_digest_preview();
		}

	}

	/**
	 * Enqueue scripts.
	 * @since 0.3.0
	 */
	public function page_head() {

		wp_enqueue_style(
			'datetimepicker',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.4.5/jquery.datetimepicker.min.css',
			array(),
			'2.4.5'
		);

		wp_enqueue_script(
			'datetimepicker',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.4.5/jquery.datetimepicker.min.js',
			array(),
			'2.4.5'
		);

		$script = new Models\Script( array(
			'handle' => 'postmatic-digest-options-tab',
			'path' => 'js/digest-options-tab.js',
			'dependencies' => array( 'datetimepicker', 'jquery' )
		) );

		$script->enqueue();

		$account_email = \Prompt_Core::$options->get( 'account_email' );
		$user = wp_get_current_user();
		$intercom_settings = array(
			'app_id' => 'm2mvuw7l',
			'email' => $account_email ?: $user->user_email,
			'name' => $user->display_name,
			'created_at' => strtotime( $user->user_registered ),
		);

		$script->localize( 'intercomSettings', $intercom_settings );
	}

	/**
	 * Return tab content
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function render() {

		ob_start();
		wp_editor( $this->list->get_introduction_html(), 'digest_introduction' );
		$introduction_editor = ob_get_clean();

		$elements = array(
			html(
				'div class="intro-text"',
				html( 'h2', __( 'Configure Postmatic Digests', 'postmatic-premium' ) ),
				html( 'p',
					__( 'Choose a layout, set a frequency, and add some introductory text. We\'ll send digests of your content automatically.',
						'postmatic-premium'
					)
				)
			),

			html(
				'div id="digest-name"',
				html( 'h2', __( 'Name your digest', 'postmatic-premium' ) ),
				$this->input(
					array(
						'desc' => __( 'This appears in optin emails and the digest subject line. Try something like <em>Acme Weekly</em> or <em>Acme Daily Roundup</em>.', 'postmatic-premium' ),
						'type' => 'text',
						'name' => 'digest_name',
						'value' => $this->list->subscription_object_label(),
						'extra' => array( 'class' => 'last-submit' ),
					)
				)
			),
			html(
				'div id="digest-introduction"',
				html( 'h2', __( 'Optional Introduction', 'postmatic-premium' ) ),
				$introduction_editor
			),
			html(
				'div id="digest-theme"',
				html( 'h2', __( 'Choose a layout', 'postmatic-premium' ) ),
				$this->digest_theme_choices_html()
			),
			html(
				'div id="digest-include-full-post-requests"',
				html( 'h4', __( 'Use <em>Add to my Inbox</em>?', 'postmatic-premium' ) ),
				$this->input(
					array(
						'type' => 'checkbox',
						'name' => 'digest_include_full_post_requests',
						'value' => 1,
						'desc' => __( 'Yes, let my readers request copies of my posts and conversations be delivered to their inbox. Users can click any post in the digest to receive the full contents of the post, along with the conversation to that point.  We\'ll wrap it up all up and send it as an email. They can then jump into the conversation right away. Highly recommended if you are pushing for engagement.' ),
						'checked' => $this->list->get_include_full_post_requests(),
					)
				)
			),
			html(
				'div id="digest-subject-style"',
				html( 'h4', __( 'What should we use for the subject of the digest email?', 'postmatic-premium' ) ),
				$this->input(
					array(
						'type' => 'radio',
						'name' => 'digest_subject_style',
						'choices' => array(
							Enums\Digest_Subject_Styles::NAME_DATE => __( 'Acme Daily Digest | July 24, 2016 <small>Name and date</small>', 'postmatic-premium' ),
							Enums\Digest_Subject_Styles::MOST_RECENT_PLUS => __( 'How to Catch a Roadrunner + 3 more posts from Acme Daily Digest <small>Smart subjects based on your latest post</small>', 'postmatic-premium' ),
						),
						'selected' => $this->list->get_subject_style(),
					)
				)
			),
			html( 'h2', __( 'Schedule Digest Delivery', 'postmatic-premium' ) ),
			html( 'p', __( 'Each time a digest is sent it will include all of the posts that have been published since the last digest. If you publish multiple times per day a daily digest may be a good fit. If you publish once a day, try a weekly digest. If you only publish once a week a monthly digest would be the way to go.', 'postmatic-premium' ) ),
			html(
				'div id="digest-frequency"',
				html( 'h4', __( 'How frequently should we send the digest?', 'postmatic-premium' ) ),
				$this->input(
					array(
						'type' => 'select',
						'name' => 'digest_frequency_days',
						/* translators: Full phrase is Send the digest every <menu> days. */
						'desc' => __( 'Send the digest every', 'postmatic-premium' ),
						'desc_pos' => 'before',
						'choices' => range( 1, 99 ),
						'extra' => array( 'class' => 'last-submit' ),
					),
					$this->digest_schedule
				),
				/* translators: Full phrase is Send the digest every <menu> days. */
				html( 'label', __( 'days.', 'postmatic-premium' ) )
			),
			html(
				'div id="digest-start-time"',
				html( 'h4', __( 'When should we send your first digest?', 'postmatic-premium' ) ),
				$this->input(
					array(
						'type' => 'text',
						'name' => 'digest_start_time',
						'desc' => sprintf(
							__( 'The digest will automatically be sent according to this date and time. We\'ll be using %s time.', 'postmatic-premium' ),
							$this->timezone_string()
						),
						'extra' => array( 'class' => 'last-submit' ),
					),
					$this->digest_schedule
				)
			),
		);

		$elements[] = html(
			'input class="button button-primary" id="digest-preview" type="submit" name="send_digest_preview_button"',
			array( 'value' => __( 'Save changes and email me a preview', 'postmatic-premium' ) )
		);

		$welcome_content = html(
			'div class="welcome" id="digest-welcome"',
			html( 'h2', __( 'Post Digests by Postmatic', 'postmatic-premium' ) ),
			html( 'p', __( 'Your content, their schedule.', 'postmatic-premium' ) )
		);

		return $welcome_content . $this->form_wrap( implode( '', $elements ) );
	}

	/**
	 * @since 0.1.0
	 * @return bool
	 */
	public function delete_digest_schedule() {

		$callback_id = $this->list->get_callback_id();

		if ( !$callback_id ) {
			return true;
		}

		if ( is_wp_error( $this->callback_repo->delete( $callback_id ) ) ) {
			return false;
		}

		$this->digest_schedule = self::$empty_digest_schedule;
		$this->list->set_callback_id( 0 );
		$this->list_repo->save( $this->list );
		return true;
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	protected function digest_theme_choices_html() {
		$inputs = array();
		foreach ( self::$digest_theme_choices as $slug => $label ) {
			$id = 'digest-theme-' . $slug;
			$radio_args = array(
				'id' => $id,
				'name' => 'digest_theme_slug',
				'type' => 'radio',
				'value' => $slug,
			);
			if ( $slug == $this->list->get_theme_slug() ) {
				$radio_args['checked'] = 'checked';
			}
			$inputs[] = html(
				'label',
				array( 'for' => $id ),
				html( 'input class="last-submit"', $radio_args ),
				$label
			);
		}
		return implode( "\n", $inputs );
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int $local_start_time
	 * @param int $frequency_days
	 */
	protected function replace_scheduled_callback( $local_start_time, $frequency_days ) {

		if ( !$local_start_time ) {
			$this->add_notice(
				__( 'Unrecognized start time format, try 2016-01-31 6:00am PST for example.', 'postmatic-premium' ),
				'error'
			);
			return;
		}

		$gmt_start_time = strtotime( get_gmt_from_date( date( 'Y-m-d H:i:s', $local_start_time ) ) );

		if ( $gmt_start_time < time() ) {
			$this->add_notice(
				__( 'Next digest time should be in the future.', 'postmatic-premium' ),
				'error'
			);
			return;
		}

		$seconds = $frequency_days * DAY_IN_SECONDS;
		if ( $seconds <= 0 ) {
			$this->add_notice(
				__( 'Digest frequency must be at least one day.', 'postmatic-premium' ),
				'error'
			);
			return;
		}

		$callback_id = $this->set_digest_schedule( $gmt_start_time, $seconds );

		if ( !$callback_id ) {
			return;
		}

		$this->list->set_callback_id( $callback_id );

		$this->list_repo->save( $this->list );

		$this->add_notice( __( 'Digest schedule set.', 'postmatic-premium' ) );
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @return bool
	 */
	protected function get_digest_schedule() {

		if ( !$this->list->get_callback_id() ) {
			return false;
		}

		$callback = $this->callback_repo->get_by_id( $this->list->get_callback_id() );

		if ( is_wp_error( $callback ) ) {
			return false;
		}

		$next_invocation_gmt_date = date( 'Y-m-d H:i:s', strtotime( $callback->get_next_invocation_on() ) );

		$this->digest_schedule = array(
			'digest_start_time' => get_date_from_gmt( $next_invocation_gmt_date, self::$date_format ),
			'digest_frequency_days' => $callback->get_recurrence_days(),
		);

		return true;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int $start_timestamp
	 * @param int $recurrence_seconds
	 * @return false|int Callback ID
	 */
	protected function set_digest_schedule( $start_timestamp, $recurrence_seconds ) {

		if ( !$this->delete_digest_schedule() ) {
			return false;
		}

		$callback = new Models\Scheduled_Callback(
			array(
				'start_timestamp' => $start_timestamp,
				'recurrence_seconds' => $recurrence_seconds,
				'metadata' => array(
					'prompt/digest_mailing/send_digests',
					array( $this->list->id() )
				)
			)
		);

		$callback_id = $this->callback_repo->save( $callback );

		if ( is_wp_error( $callback_id ) ) {
			return false;
		}

		$this->digest_schedule = array(
			'digest_start_time' => get_date_from_gmt( date( 'Y-m-d H:i:s', $start_timestamp ), self::$date_format ),
			'digest_frequency_days' => $recurrence_seconds / DAY_IN_SECONDS,
		);

		return $callback_id;
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 */
	protected function send_digest_preview() {

		if ( !$this->list->get_callback_id() ) {
			$this->add_notice(
				__( 'Please make sure you have a valid digest frequency and start date set.', 'postmatic-premium' ),
				'error'
			);
			return;
		}

		$digest_post = Lists\Posts\Digest::create( $this->list );

		$batch = new Email_Batches\Digest( new Rendering_Contexts\Digest( $digest_post ) );

		$batch->add_recipient( new \Prompt_User( get_current_user_id() ) );

		\Prompt_Factory::make_post_adhoc_mailer( $batch )->send();

		$this->add_notice( __( 'Preview sent.', 'postmatic-premium' ) );
	}

	/**
	 *
	 * @since 0.1.0
	 *
	 * @param string $name
	 * @param mixed  $old_value
	 * @return bool|mixed False or the sanitized new data;
	 */
	protected function new_data_posted( $name, $old_value, $sanitizers = array() ) {
		if ( !isset( $_POST[$name] ) ) {
			return false;
		}

		if ( !is_array( $sanitizers ) ) {
			$sanitizers = array( $sanitizers );
		}

		$value = $_POST[$name];
		foreach ( $sanitizers as $sanitizer ) {
			$value = call_user_func( $sanitizer, $value );
		}

		return ( $value != $old_value ) ? $value : false;
	}

	/**
	 * Get the name of the currently active timezone.
	 *
	 * @see   https://core.trac.wordpress.org/ticket/24730
	 * @since 0.1.0
	 *
	 * @return string
	 */
	protected function timezone_string() {
		$tzstring = get_option( 'timezone_string' );
		if ( !$tzstring ) {
			// Create a UTC+- zone if no timezone string exists
			$current_offset = get_option( 'gmt_offset' );
			if ( 0 == $current_offset )
				$tzstring = 'UTC';
			elseif ( $current_offset < 0 )
				$tzstring = 'Etc/GMT' . $current_offset;
			else
				$tzstring = 'Etc/GMT+' . $current_offset;
		}
		$zone = new \DateTimeZone( $tzstring );
		return $zone->getName();
	}
}
