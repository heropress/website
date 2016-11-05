<?php
namespace Postmatic\Premium;

/**
 * Core philosophy: do as little as possible unless we're being asked for more.
 * @since 0.1
 */
class Core {

	/**
	 * The singleton instance
	 * @since 0.1
	 * @var Core
	 */
	protected static $instance = null;

	/**
	 * @since 0.1
	 * @var array
	 */
	protected $notices = array();
	/**
	 * @since 0.3.0
	 * @var Admin\Metaboxes\Digest
	 */
	protected $digest_metabox;

	/**
	 * Get the singleton instance, creating it if needed.
	 * @since 0.1
	 * @return Core
	 */
	final public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new Core();
		}

		return static::$instance;
	}

	/**
	 * Get the plugin basename.
	 * @since 0.3.0
	 * @return string
	 */
	public function basename() {
		return plugin_basename( path_join( dirname( __DIR__ ), 'postmatic-premium.php' ) );
	}

	/**
	 * Get a plugin file path.
	 * @since 0.1
	 * @param string $path_from_plugin_root Path to append
	 * @return string
	 */
	public function path( $path_from_plugin_root = '' ) {
		return path_join( dirname( __DIR__ ), $path_from_plugin_root );
	}

	/**
	 * Get a plugin file URL.
	 * @since 0.1
	 * @param string $path_from_plugin_root Path to append
	 * @return string
	 */
	public function url( $path_from_plugin_root = '' ) {
		return plugins_url( $path_from_plugin_root, __DIR__ );
	}

	/**
	 * Echo any queued admin notices.
	 * @since 0.1
	 */
	public function display_admin_notices() {
		foreach( $this->notices as $notice ) {
			echo $notice;
		}
	}

	/**
	 * @since 0.1.0
	 */
	public function register_post_types() {
		if ( \Prompt_Core::$options->get( 'enable_digests' ) ) {
			Post_Types\Digest::get_instance()->register();
		}
	}

	/**
	 * @since 0.3.0
	 */
	public function load_admin() {

		$this->digest_metabox = new Admin\Metaboxes\Digest(
			'posmatic_digest_delivery',
			__( 'Postmatic Digest Delivery', 'postmatic-premium' ),
			array(
				'post_type' => \Prompt_Core::$options->get( 'site_subscription_post_types' ),
				'context' => 'side',
				'priority' => 'high',
			)
		);

	}

	/**
	 * Deactivate a separate install of Postmatic Basic and prompt to delete it.
	 * @since 0.3.0
	 */
	public function deactivate_separate_basic_once() {

		if ( !get_transient( 'postmatic-premium-activated' ) ) {
			return;
		}

		delete_transient( 'postmatic-premium-activated' );

		if ( !$this->is_separate_basic_active() ) {
			return;
		}

		$deactivate_basename = \Prompt_Core::$basename;
		deactivate_plugins( $deactivate_basename, $silent = true );

		$delete_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'delete-selected',
					'checked[]' => $deactivate_basename,
					'plugin_status' => 'all',
					'paged' => 1
				)
			),
			'bulk-plugins'
		);

		$delete_link = sprintf(
			'<a href="%s" class="button-primary">%s</a>',
			$delete_url,
			__( 'Delete', 'postmatic-premium' )
		);

		$this->notices[] = sprintf(
			'<div class="updated"><p>%1$s %2$s</p></div>',
			__( 'Postmatic Basic is no longer necessary. It has been deactivated and is safe to delete.', 'postmatic-premium' ),
			$delete_link
		);
	}

	/**
	 * Core constructor.
	 *
	 * Designed to be constructed at the plugins_loaded phase of a WordPress request.
	 *
	 * @since 0.1
	 */
	protected function __construct() {
		
		load_plugin_textdomain( 'postmatic-premium', false, path_join( basename( dirname( __DIR__) ), 'languages' ) );
		
		if ( class_exists( '\Prompt_Core' )  ) {
			add_action( 'admin_init', array( $this, 'deactivate_separate_basic_once' ) );
		} else {
			// There is not an active separate Postmatic install
			$this->load_bundled_basic();
		}

		// Version check may display a notice, so add this hook first
		add_action( 'admin_notices', array( $this, 'display_admin_notices' ) );

		if ( version_compare( \Prompt_Core::version(), '2.0.0-beta6', '<' ) ) {
			$this->prompt_to_fix_unusable_postmatic_version();
			return;
		}

		add_action( 'init', array( $this, 'register_post_types' ) );

		// Add free plugin integration hooks (alpha order by hook)
		add_action(
			'admin_enqueue_scripts',
			array( 'Postmatic\Premium\Actions\Dashboard_Widgets', 'enqueue' )
		);
		add_filter(
			'prompt/command_handling/get_class',
			array( 'Postmatic\Premium\Filters\Command_Handling', 'get_class' )
		);
		add_filter(
			'prompt/default_options',
			array( 'Postmatic\Premium\Filters\Options', 'default_options' )
		);
		add_filter(
			'prompt/comment_notifications/allow',
			array( 'Postmatic\Premium\Filters\Comment_Notifications', 'allow' ),
			10,
			2
		);
		add_filter(
			'prompt/email_batch/footer_html',
			array( 'Postmatic\Premium\Filters\Email_Batch', 'footer_html' ),
			10,
			2
		);
		add_filter(
			'prompt/email_batch/header_html',
			array( 'Postmatic\Premium\Filters\Email_Batch', 'header_html' ),
			10,
			2
		);
		add_filter(
			'prompt/email_batch/integration_css',
			array( 'Postmatic\Premium\Filters\Email_Batch', 'integration_css' )
		);
		add_filter(
			'prompt/email_batch/sidebar_html',
			array( 'Postmatic\Premium\Filters\Email_Batch', 'sidebar_html' ),
			10,
			2
		);
		add_filter(
			'prompt/make_comment_flood_controller',
			array( 'Postmatic\Premium\Filters\Factory', 'make_comment_flood_controller' ),
			10,
			2
		);
		add_filter(
			'prompt/options_page/tabs',
			array( 'Postmatic\Premium\Filters\Options_Page', 'tabs' )
		);
		add_filter(
			'prompt/post_email_batch/extra_footnote_content',
			array( 'Postmatic\Premium\Filters\Footnote_Content', 'extra_post_footnote_content' )
		);
		add_filter(
			'prompt/post_email_batch/template_data',
			array( 'Postmatic\Premium\Filters\Post_Email_Batch', 'template_data' ),
			10,
			2
		);
		add_filter(
			'prompt/post_rendering_context/modifiers',
			array( 'Postmatic\Premium\Filters\Post_Rendering_Context', 'modifiers' ),
			10,
			3
		);
		add_action(
			'prompt/subscribed',
			array( 'Postmatic\Premium\Actions\Webhooks', 'subscribed' ),
			10,
			2
		);
		add_filter(
			'prompt/subscribing/get_subscribable_slug',
			array( 'Postmatic\Premium\Filters\Subscribing', 'get_subscribable_slug' ),
			10,
			2
		);
		add_filter(
			'prompt/subscribing/get_signup_lists',
			array( 'Postmatic\Premium\Filters\Subscribing', 'get_signup_lists' )
		);
		add_filter(
			'prompt/subscribing/make_subscribable',
			array( 'Postmatic\Premium\Filters\Subscribing', 'make_subscribable' ),
			10,
			2
		);
		add_filter(
			'prompt/subscribing/get_subscribable_classes',
			array( 'Postmatic\Premium\Filters\Subscribing', 'get_subscribable_classes' )
		);
		add_filter(
			'prompt/subscription_mailing/extra_welcome_footnote_content',
			array( 'Postmatic\Premium\Filters\Footnote_Content', 'extra_welcome_footnote_content' ),
			10,
			2
		);
		add_action(
			'prompt/unsubscribed',
			array( 'Postmatic\Premium\Actions\Webhooks', 'unsubscribed' ),
			10,
			2
		);

		// Add local hooks for callbacks and retries
		add_action(
			'postmatic/premium/mailers/digest/initiate',
			array( 'Postmatic\Premium\Mailers\Digest', 'initiate' ),
			10,
			2
		);
		add_action(
			'postmatic/premium/mailers/comment_digest/initiate',
			array( 'Postmatic\Premium\Mailers\Comment_Digest', 'initiate' ),
			10,
			2
		);
		// Maintain compatibility with early beta which used a prompt-named hook
		add_action(
			'prompt/digest_mailing/send_digests',
			array( 'Postmatic\Premium\Mailers\Digest', 'initiate' ),
			10,
			2
		);

		// Add native WordPress feature hooks
		add_action(
			'admin_init',
			array( $this, 'load_admin' )
		);
		add_action(
			'comment_approved_to_unapproved',
			array( 'Postmatic\Premium\Filters\Comment_Moderation', 'approved_to_unapproved' )
		);
		add_filter(
			'comment_moderation_recipients',
			array( 'Postmatic\Premium\Filters\Comment_Moderation', 'recipients' ),
			10,
			2
		);
		add_action(
			'update_option_prompt_options',
			array( 'Postmatic\Premium\Actions\Option', 'update' ),
			10,
			3
		);
		add_action(
			'widgets_init',
			array( 'Postmatic\Premium\Actions\Widgets', 'init' ),
			100 // Let the theme sidebars load first
		);
		add_action(
			'wp_ajax_postmatic_get_commenters',
			array( 'Postmatic\Premium\Actions\Invite', 'ajax_get_commenters' )
		);
		add_action(
			'wp_ajax_postmatic_get_invite_users',
			array( 'Postmatic\Premium\Actions\Invite', 'ajax_get_invite_users' )
		);
		add_action(
			'wp_dashboard_setup',
			array( 'Postmatic\Premium\Actions\Dashboard_Widgets', 'setup_widget' )
		);

	}

	/**
	 * @since 0.1.0
	 */
	protected function load_bundled_basic() {
		require_once( $this->path( 'vendor/plugins/postmatic/postmatic.php' ) );
		// Help Prompt catch up to plugins_loaded time
		\Prompt_Core::action_plugins_loaded();
	}

	/**
	 * @since 0.1.0
	 */
	protected function prompt_to_fix_unusable_postmatic_version() {

		if ( ! function_exists( 'caldera_warnings_dismissible_notice' ) ) {
			return;
		}

		$deactivate_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'deactivate',
					'plugin' => \Prompt_Core::$basename,
					'plugin_status' => 'all',
					'paged' => 1
				),
				admin_url( 'plugins.php' )
			),
			'deactivate-plugin_' . \Prompt_Core::$basename
		);

		$deactivate_link = sprintf(
			'<a href="%s" class="button-primary">%s</a>',
			$deactivate_url,
			__( 'Sure, deactivate it now', 'postmatic-premium' )
		);

		$this->notices[] = \caldera_warnings_dismissible_notice(
			__(
				'You have an older version of Postmatic installed. We recommend deactivating it to use the more current version bundled with Postmatic Premium.',
				'postmatic-premium'
			) . ' ' . $deactivate_link
		);
	}

	/**
	 * Whether a separate install of Postmatic Basic is active.
	 * @since 0.3.0
	 * @return bool
	 */
	protected function is_separate_basic_active() {
		return ( false === strpos( \Prompt_Core::$dir_path, Core::get_instance()->path() ) );
	}
}
