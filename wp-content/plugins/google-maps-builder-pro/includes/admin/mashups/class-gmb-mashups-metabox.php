<?php

/**
 * Google Maps Mashups
 *
 * Adds mashup metaboxes to user selected post types with Maps Builder Pro
 *
 * @package   Google_Maps_Builder_Admin
 * @author    WordImpress
 * @license   GPL-2.0+
 * @link      http://wordimpress.com
 * @copyright 2015 WordImpress
 */
class Google_Maps_Builder_Mashups_Metabox {

	public $enabled_post_types;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     2.0
	 */
	public function __construct() {

		$this->plugin_slug = Google_Maps_Builder()->get_plugin_slug();

		//Add metaboxes and fields to CPT
		add_action( 'cmb2_init', array( $this, 'mashup_metabox_fields' ) );
		add_action( 'cmb2_render_google_mashup_geocoder', array( $this, 'cmb2_render_google_mashup_geocoder' ), 10, 2 );
		add_filter( 'cmb2_sanitize_google_mashup_geocoder', array(
			$this,
			'cmb2_sanitize_google_mashup_geocoder'
		), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_mashup_scripts' ) );

	}


	/**
	 * Mashup Metabox Field
	 *
	 * Defines the Google Places CPT metabox and field configuration
	 *
	 * @since  2.0
	 * @return array
	 */
	public function mashup_metabox_fields() {

		$this->enabled_post_types = gmb_get_option( 'gmb_mashup_metabox' );

		//Sanity check
		if ( $this->enabled_post_types === false ) {
			return;
		}

		$prefix = '_gmb_';

		//Output metabox on appropriate CPTs
		$preview_box = cmb2_get_metabox( array(
			'id'           => 'google_maps_mashup_metabox',
			'title'        => __( 'Maps Builder Pro Mashup', $this->plugin_slug ),
			'object_types' => $this->enabled_post_types, // post type
			'context'      => 'side', //  'normal', 'advanced', or 'side'
			'priority'     => 'core', //  'high', 'core', 'default' or 'low'
			'show_names'   => true, // Show field names on the left
		) );
		$preview_box->add_field( array(
			'id'      => $prefix . 'mashup_autocomplete',
			'type'    => 'google_mashup_geocoder',
			'after'   => '<div class="gmb-toggle-fields-wrap"><a href="#" class="gmb-toggle-fields"><span class="dashicons dashicons-arrow-down"></span>' . __( 'View Location Fields', $this->plugin_slug ) . '</a></div>',
			'default' => '',
		) );

		$preview_box->add_field( array(
			'name'       => __( 'Marker Latitude', $this->plugin_slug ),
			'before_row' => '<div class="gmb-toggle">',
			'id'         => $prefix . 'lat',
			'type'       => 'text',
		) );
		$preview_box->add_field( array(
			'name' => __( 'Marker Longitude', $this->plugin_slug ),
			'id'   => $prefix . 'lng',
			'type' => 'text',
		) );
		$preview_box->add_field( array(
			'name' => __( 'Address', $this->plugin_slug ),
			'id'   => $prefix . 'address',
			'type' => 'text',
		) );

		$preview_box->add_field( array(
			'name'      => __( 'Marker Place ID', $this->plugin_slug ),
			'id'        => $prefix . 'place_id',
			'type'      => 'text',
			'after_row' => '</div>',//Closes .gmb-toggle
		) );
	}

	/**
	 * Enqueue Mashup Scripts
	 *
	 * @param $hook
	 *
	 * @return mixed
	 */
	public function enqueue_mashup_scripts( $hook ) {

		if ( $this->is_mashup_metabox_enabled() == false ) {
			return false;
		}
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		//Only enqueue on post edit screens
		if ( $hook === 'post.php' || $hook === 'post-new.php' ) {

			//Load Google Maps API on this CPT
			wp_register_script( $this->plugin_slug . '-admin-gmaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_slug . '-admin-gmaps' );

			//Check for Google Maps API JS conflicts
			Google_Maps_Builder()->scripts->check_for_multiple_google_maps_api_calls();

			//Register our mashup metabox JS
			wp_register_script( $this->plugin_slug . '-admin-mashups-script', GMB_PLUGIN_URL . 'assets/js/admin/admin-maps-mashup-metabox' . $suffix . '.js', array(
				'jquery'
			) );

			wp_enqueue_script( $this->plugin_slug . '-admin-mashups-script' );

			wp_register_style( $this->plugin_slug . '-admin-mashups-style', GMB_PLUGIN_URL . 'assets/css/gmb-mashup-metabox.css' );
			wp_enqueue_style( $this->plugin_slug . '-admin-mashups-style' );
		}


	}

	/**
	 * Is Mashup Metabox Enabled
	 *
	 * Conditional
	 * @return bool
	 */
	public function is_mashup_metabox_enabled() {

		$current_screen = get_current_screen();

		//False if not enabled or array (sanity check)
		if ( empty( $this->enabled_post_types ) || ! is_array( $this->enabled_post_types ) ) {
			return false;
		}

		//False if not enabled on this post type
		if ( ! isset( $current_screen->post_type ) || ! in_array( $current_screen->post_type, $this->enabled_post_types ) ) {
			return false;
		}

		//Bail if this isn't the post type in should be enabled on either
		return true;

	}


	/**
	 * Custom Google Autocomplete for Mashup
	 *
	 * @since  2.0
	 *
	 * @param $field
	 * @param $meta
	 *
	 * @return array
	 */
	function cmb2_render_google_mashup_geocoder( $field, $meta ) {

		$meta = wp_parse_args(
			$meta, array(
				'geocode'     => '',
				'geocode_set' => '',
			)
		);

		$output = '<div class="autocomplete-wrap" ' . ( $meta['geocode_set'] == '1' ? 'style="display:none;"' : '' ) . '>';

		$output .= '<label for="' . $field->args( 'id' ) . '">' . __( 'Add Location', $this->plugin_slug ) . '</label>';
		$output .= '<input type="text" name="' . $field->args( 'id' ) . '[geocode]" id="' . $field->args( 'id' ) . '" value="" class="search-autocomplete" />';
		$output .= '<input type="hidden" name="' . $field->args( 'id' ) . '[geocode_set]" id="' . $field->args( 'id' ) . '" value="' . $meta['geocode_set'] . '" class="search-autocomplete-set" />';
		$output .= '<p class="autocomplete-description"> ' . __( 'Enter the name of a point of interest, address, or establishment above or manually set the fields below.', $this->plugin_slug ) . '</p>';
		$output .= '</div>';//autocomplete-wrap
		$output .= '<div class="gmb-autocomplete-notice"' . ( $meta['geocode_set'] !== '1' ? 'style="display:none;"' : '' ) . '><p>' . __( 'Location set for this post', $this->plugin_slug ) . '</p><a href="#" class="gmb-reset-autocomplete button button-small">' . __( 'Reset', $this->plugin_slug ) . '</a>';
		$output .= '</div>';

		echo $output;

	}


	/**
	 * Sanitize Mashup Metabox
	 *
	 * @description: Clears out meta_key transient if it doesn't contain new metakey
	 * @since      2.0
	 */
	function cmb2_sanitize_google_mashup_geocoder() {

		global $post;
		$existing_transient = get_transient( $post->post_type . '_meta_keys' );

		if ( $existing_transient === false ) {
			return;
		}

		if ( ! in_array( '_gmb_lat', $existing_transient ) || ! in_array( '_gmb_lng', $existing_transient ) ) {
			delete_transient( $post->post_type . '_meta_keys' );
		}

	}


} //end class

new Google_Maps_Builder_Mashups_Metabox();
