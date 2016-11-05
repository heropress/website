<?php
/**
 * Scripts
 *
 * @package     GMB
 * @subpackage  Functions
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Google_Maps_Builder_Scripts {

	/**
	 * Var for loading google maps api
	 * Var for dependency
	 */
	protected $google_maps_conflict = false;


	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {

		$this->plugin_slug     = Google_Maps_Builder()->get_plugin_slug();
		$this->plugin_settings = get_option( 'gmb_settings' );

		//Frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts' ), 11 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );

		add_action( 'wp_print_scripts', array( $this, 'check_for_multiple_google_maps_api_calls' ) );

		add_action( 'admin_print_scripts', array( $this, 'check_for_multiple_google_maps_api_calls' ) );

		//Admin
		add_action( 'admin_head', array( $this, 'icon_style' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}


	/*----------------------------------------------------------------------------------
	Frontend
	------------------------------------------------------------------------------------*/

	/**
	 * Load Frontend Scripts
	 *
	 * Enqueues the required scripts to display maps on the frontend only.
	 *
	 * @since 2.0
	 * @global $give_options
	 * @global $post
	 * @return void
	 */
	function load_frontend_scripts() {

		$google_maps_api_url_args = array(
			'sensor'    => 'false',
			'libraries' => 'places'
		);
		//Google Maps API key present?
		if ( ! empty( $this->plugin_settings['gmb_maps_api_key'] ) ) {
			$google_maps_api_url_args['key'] = $this->plugin_settings['gmb_maps_api_key'];
		}
		//Preferred Language?
		if ( ! empty( $this->plugin_settings['gmb_language'] ) ) {
			$google_maps_api_url_args['language'] = $this->plugin_settings['gmb_language'];
		}
		//Signed In?
		if ( ! empty( $this->plugin_settings['gmb_signed_in'] ) && $this->plugin_settings['gmb_signed_in'] == 'enabled' ) {
			$google_maps_api_url_args['signed_in'] = true;
		}

		$google_maps_api_url = add_query_arg( $google_maps_api_url_args, 'https://maps.googleapis.com/maps/api/js?v=3.exp' );

		wp_register_script( 'google-maps-builder-gmaps', $google_maps_api_url, array( 'jquery' ) );
		wp_enqueue_script( 'google-maps-builder-gmaps' );


		$js_dir     = GMB_PLUGIN_URL . 'assets/js/frontend/';
		$js_plugins = GMB_PLUGIN_URL . 'assets/js/plugins/';
		$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Use minified libraries if SCRIPT_DEBUG is turned off
		wp_register_script( 'google-maps-builder-plugin-script', $js_dir . 'google-maps-builder' . $suffix . '.js', array( 'jquery' ), GMB_VERSION, true );
		wp_enqueue_script( 'google-maps-builder-plugin-script' );

		wp_register_script( 'google-maps-builder-maps-icons', GMB_PLUGIN_URL . 'includes/libraries/map-icons/js/map-icons.js', array( 'jquery' ), GMB_VERSION, true );
		wp_enqueue_script( 'google-maps-builder-maps-icons' );

		wp_register_script( 'google-maps-builder-clusterer', $js_plugins . 'markerclusterer' . $suffix . '.js', array( 'jquery' ), GMB_VERSION, true );
		wp_enqueue_script( 'google-maps-builder-clusterer' );

		wp_register_script( 'google-maps-builder-infobubble', $js_plugins . 'infobubble' . $suffix . '.js', array( 'jquery' ), GMB_VERSION, true );
		wp_enqueue_script( 'google-maps-builder-infobubble' );

		wp_localize_script( $this->plugin_slug . '-plugin-script', 'gmb_data', array() );

	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    2.0
	 */
	function enqueue_frontend_styles() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_style( 'google-maps-builder-plugin-styles', GMB_PLUGIN_URL . 'assets/css/google-maps-builder' . $suffix . '.css', array(), GMB_VERSION );
		wp_enqueue_style( 'google-maps-builder-plugin-styles' );

		wp_register_style( 'google-maps-builder-map-icons', GMB_PLUGIN_URL . 'includes/libraries/map-icons/css/map-icons.css', array(), GMB_VERSION );
		wp_enqueue_style( 'google-maps-builder-map-icons' );

	}

	/**
	 * Load Google Maps API
	 *
	 * @description: Determine if Google Maps API script has already been loaded
	 * @since      : 1.0.3
	 * @return bool $multiple_google_maps_api
	 */
	public function check_for_multiple_google_maps_api_calls() {

		global $wp_scripts;

		if ( ! $wp_scripts ) {
			return false;
		}

		//loop through registered scripts
		foreach ( $wp_scripts->registered as $registered_script ) {

			//find any that have the google script as the source, ensure it's not enqueud by this plugin
			if (
				( strpos( $registered_script->src, 'maps.googleapis.com/maps/api/js' ) !== false &&
				  strpos( $registered_script->handle, 'google-maps-builder' ) === false ) ||
				( strpos( $registered_script->src, 'maps.google.com/maps/api/js' ) !== false &&
				  strpos( $registered_script->handle, 'google-maps-builder' ) === false )
			) {

				//Remove this script from loading
				wp_deregister_script( $registered_script->handle );
				wp_dequeue_script( $registered_script->handle );


				$this->google_maps_conflict = true;
				//ensure we can detect scripts on the frontend from backend; we'll use an option to do this
				if ( ! is_admin() ) {
					update_option( 'gmb_google_maps_conflict', true );
				}

			}

		}

		//Ensure that if user resolved conflict on frontend we remove the option flag
		if ( $this->google_maps_conflict === false && ! is_admin() ) {
			update_option( 'gmb_google_maps_conflict', false );
		}

	}


	/*----------------------------------------------------------------------------------
	WP-Admin
	------------------------------------------------------------------------------------*/
	/**
	 * Admin Dashicon
	 *
	 * @description Displays a cute lil map dashicon on our CPT
	 */
	function icon_style() {
		?>
		<style rel="stylesheet" media="screen">
			#adminmenu #menu-posts-google_maps div.wp-menu-image:before {
				font-family: 'dashicons' !important;
				content: '\f231';
			}
		</style>
		<?php return;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * Return early if no settings page is registered.
	 * @since     2.0
	 *
	 * @param $hook
	 *
	 * @return    null
	 */
	function enqueue_admin_styles( $hook ) {

		global $post;
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		//Only enqueue scripts for CPT on post type screen
		if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && 'google_maps' === $post->post_type || $hook == 'google_maps_page_gmb_settings' || $hook == 'google_maps_page_gmb_import_export' ) {

			wp_register_style( $this->plugin_slug . '-admin-styles', GMB_PLUGIN_URL . 'assets/css/gmb-admin' . $suffix . '.css', array(), GMB_VERSION );
			wp_enqueue_style( $this->plugin_slug . '-admin-styles' );

			wp_register_style( $this->plugin_slug . '-map-icons', GMB_PLUGIN_URL . 'includes/libraries/map-icons/css/map-icons.css', array(), GMB_VERSION );
			wp_enqueue_style( $this->plugin_slug . '-map-icons' );

		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since    2.0
	 *
	 * @param $hook
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	function enqueue_admin_scripts( $hook ) {
		global $post;
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$js_dir     = GMB_PLUGIN_URL . 'assets/js/admin/';
		$js_plugins = GMB_PLUGIN_URL . 'assets/js/plugins/';

		//Builder Google Maps API URL
		$google_maps_api_key = gmb_get_option( 'gmb_maps_api_key' );
		$gmb_language        = gmb_get_option( 'gmb_language' );
		$signed_in_option    = gmb_get_option( 'gmb_signed_in' );

		$google_maps_api_url_args = array(
			'sensor'    => 'false',
			'libraries' => 'places,drawing'
		);
		//Google Maps API key present?
		if ( ! empty( $google_maps_api_key ) ) {
			$google_maps_api_url_args['key'] = $google_maps_api_key;
		}
		//Preferred Language?
		if ( ! empty( $google_maps_api_key ) ) {
			$google_maps_api_url_args['language'] = $gmb_language;
		}
		//Signed In?
		if ( ! empty( $signed_in_option ) && $signed_in_option == 'enabled' ) {
			$google_maps_api_url_args['signed_in'] = true;
		}

		$google_maps_api_url = add_query_arg( $google_maps_api_url_args, 'https://maps.googleapis.com/maps/api/js?v=3.exp' );


		//Only enqueue scripts for CPT on post type screen
		if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && 'google_maps' === $post->post_type ) {

			wp_enqueue_style( 'wp-color-picker' );

			wp_register_script( $this->plugin_slug . '-admin-magnific-popup', $js_plugins . 'gmb-magnific' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-magnific-popup' );

			wp_register_script( $this->plugin_slug . '-admin-gmaps', $google_maps_api_url, array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_slug . '-admin-gmaps' );

			wp_register_script( $this->plugin_slug . '-map-icons', GMB_PLUGIN_URL . 'includes/libraries/map-icons/js/map-icons.js', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_slug . '-map-icons' );

			wp_register_script( $this->plugin_slug . '-admin-qtip', $js_plugins . 'jquery.qtip' . $suffix . '.js', array( 'jquery' ), GMB_VERSION, true );
			wp_enqueue_script( $this->plugin_slug . '-admin-qtip' );

			//Map base
			wp_register_script( $this->plugin_slug . '-admin-map-builder', $js_dir . 'admin-google-map' . $suffix . '.js', array(
				'jquery',
				'wp-color-picker'
			), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-map-builder' );

			//Modal magnific
			wp_register_script( $this->plugin_slug . '-admin-magnific-builder', $js_dir . 'admin-maps-magnific' . $suffix . '.js', array(
				'jquery',
				'wp-color-picker'
			), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-magnific-builder' );

			//Directions
			wp_register_script( $this->plugin_slug . '-admin-map-directions', $js_dir . 'admin-maps-directions' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-map-directions' );

			//Map Controls
			wp_register_script( $this->plugin_slug . '-admin-map-controls', $js_dir . 'admin-maps-controls' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-map-controls' );

			//Marker Clustering
			wp_register_script( $this->plugin_slug . '-admin-map-marker-clustering', $js_plugins . 'markerclusterer' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-map-marker-clustering' );

			$api_key     = gmb_get_option( 'gmb_maps_api_key' );
			$geolocate   = gmb_get_option( 'gmb_lat_lng' );
			$post_status = get_post_status( $post->ID );

			$maps_data = array(
				'api_key'           => $api_key,
				'geolocate_setting' => isset( $geolocate['geolocate_map'] ) ? $geolocate['geolocate_map'] : 'yes',
				'default_lat'       => isset( $geolocate['latitude'] ) ? $geolocate['latitude'] : '32.715738',
				'default_lng'       => isset( $geolocate['longitude'] ) ? $geolocate['longitude'] : '-117.16108380000003',
				'plugin_url'        => GMB_PLUGIN_URL,
				'default_marker'    => apply_filters( 'gmb_default_marker', GMB_PLUGIN_URL . 'assets/img/spotlight-poi.png' ),
				'ajax_loader'       => set_url_scheme( apply_filters( 'gmb_ajax_preloader_img', GMB_PLUGIN_URL . 'assets/images/spinner.gif' ), 'relative' ),
				'snazzy'            => GMB_PLUGIN_URL . 'assets/js/admin/snazzy.json',
				'modal_default'     => gmb_get_option( 'gmb_open_builder' ),
				'post_status'       => $post_status,
				'signed_in_option'  => $signed_in_option,
				'site_name'         => get_bloginfo( 'name' ),
				'site_url'          => get_bloginfo( 'url' ),
				'i18n'              => array(
					'update_map'               => $post_status == 'publish' ? __( 'Update Map', $this->plugin_slug ) : __( 'Publish Map', $this->plugin_slug ),
					'set_place_types'          => __( 'Update Map', $this->plugin_slug ),
					'places_selection_changed' => __( 'Place selections have changed.', $this->plugin_slug ),
					'multiple_places'          => __( 'Hmm, it looks like there are multiple places in this area. Please confirm which place you would like this marker to display:', $this->plugin_slug ),
					'btn_drop_marker'          => '<span class="dashicons dashicons-location"></span>' . __( 'Drop a Marker', $this->plugin_slug ),
					'btn_drop_marker_click'    => __( 'Click on the Map', $this->plugin_slug ),
					'btn_edit_marker'          => __( 'Edit Marker', $this->plugin_slug ),
					'btn_delete_marker'        => __( 'Delete Marker', $this->plugin_slug ),
					'visit_website'            => __( 'Visit Website', $this->plugin_slug ),
					'get_directions'           => __( 'Get Directions', $this->plugin_slug )
				),
			);
			wp_localize_script( $this->plugin_slug . '-admin-map-builder', 'gmb_data', $maps_data );

		}

		//Setting Scripts
		if ( $hook == 'google_maps_page_gmb_settings' ) {

			wp_register_script( $this->plugin_slug . '-admin-settings', $js_dir . 'admin-settings' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-settings' );

		}

		//Import/Export Scripts
		if ( $hook == 'google_maps_page_gmb_import_export' ) {

			wp_register_script( $this->plugin_slug . '-admin-import-export', $js_dir . 'admin-import-export' . $suffix . '.js', array( 'jquery' ), GMB_VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-import-export' );

		}


		wp_enqueue_style( 'dashicons' );


	}

}//end class


