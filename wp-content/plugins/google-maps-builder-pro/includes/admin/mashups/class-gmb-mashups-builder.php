<?php

/**
 * Google Maps Mashups
 *
 * Adds mashup functionality to Maps Builder Pro
 *
 * @package   Google_Maps_Builder_Admin
 * @author    WordImpress
 * @license   GPL-2.0+
 * @link      http://wordimpress.com
 * @copyright 2015 WordImpress
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Google_Maps_Builder_Mashups_Builder {

	/**
	 * Go
	 * @since     2.0
	 */
	public function __construct() {

		$this->plugin_slug = Google_Maps_Builder()->get_plugin_slug();

		//CMB2 - Add metaboxes and fields to CPT
		add_action( 'cmb2_init', array( $this, 'mashup_builder_fields' ) );
		add_action( 'cmb2_render_select_taxonomies', array( $this, 'gmb_cmb_render_select_taxonomies' ), 10, 5 );
		add_action( 'cmb2_render_select_terms', array( $this, 'gmb_cmb_render_select_terms' ), 10, 5 );
		add_action( 'cmb2_render_select_custom_meta', array( $this, 'gmb_cmb_render_select_custom_meta' ), 10, 5 );
		add_action( 'cmb2_render_mashups_load_panel', array( $this, 'gmb_cmb_render_mashups_load_panel' ), 10, 5 );
		add_action( 'cmb2_render_customize_mashup_marker', array( $this, 'gmb_cmb_customize_mashup_marker' ), 10, 5 );

		//Scripts + AJAX
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_mashup_builder_scripts' ) );
		add_action( 'wp_ajax_get_post_types_taxonomies', array( $this, 'get_post_types_taxonomies_callback' ) );
		add_action( 'wp_ajax_get_taxonomy_terms', array( $this, 'get_taxonomy_terms_callback' ) );
		add_action( 'wp_ajax_get_mashup_markers', array( $this, 'get_mashup_markers_callback' ) );
		add_action( 'wp_ajax_nopriv_get_mashup_markers', array( $this, 'get_mashup_markers_callback' ) );
		add_action( 'wp_ajax_get_mashup_marker_infowindow', array( $this, 'get_mashup_marker_infowindow_callback' ) );
		add_action( 'wp_ajax_nopriv_get_mashup_marker_infowindow', array(
			$this,
			'get_mashup_marker_infowindow_callback'
		) );
	}

	/**
	 * Enqueue Mashup Builder Scripts
	 *
	 * @param $hook
	 */
	public function enqueue_mashup_builder_scripts( $hook ) {
		global $post;
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		//Only enqueue scripts for CPT on post type screen
		if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && 'google_maps' === $post->post_type ) {
			wp_register_script( $this->plugin_slug . '-admin-mashups', GMB_PLUGIN_URL . 'assets/js/admin/admin-maps-mashups' . $suffix . '.js', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_slug . '-admin-mashups' );

			$ajax_array = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'i18n'     => array(
					'load_markers'      => __( 'Load Markers', $this->plugin_slug ),
					'mashup_configured' => __( 'Mashup Configured', $this->plugin_slug )
				)
			);
			wp_localize_script( $this->plugin_slug . '-admin-mashups', 'gmb_mashup', $ajax_array );


		}

	}


	/**
	 * Mashup Metabox Field
	 *
	 * Defines the Google Places CPT metabox and field configuration
	 *
	 * @since  2.0
	 * @return array
	 */
	public function mashup_builder_fields() {

		$prefix = 'gmb_';

		$mashup_metabox = cmb2_get_metabox( array(
			'id'           => 'google_maps_mashup_builder',
			'title'        => __( 'Mashups', $this->plugin_slug ),
			'description'  => __( 'Aggregate map markers from post types of your choosing.', $this->plugin_slug ),
			'object_types' => array( 'google_maps' ), // post type
			'context'      => 'normal', //  'normal', 'advanced', or 'side'
			'priority'     => 'default', //  'high', 'core', 'default' or 'low'
			'show_names'   => true, // Show field names on the left
		) );
		$group_field_id = $mashup_metabox->add_field( array(
			'name'        => __( 'Mashup Groups', $this->plugin_slug ),
			'id'          => $prefix . 'mashup_group',
			'type'        => 'group',
			'description' => __( 'Select the criteria for loading markers within each mashup group.', $this->plugin_slug ),
			'options'     => array(
				'group_title'   => __( 'Mashup: {#}', 'cmb' ),
				'add_button'    => __( 'Add Another Mashup', $this->plugin_slug ),
				'remove_button' => __( 'Remove', $this->plugin_slug ),
				'sortable'      => false, // beta
			),
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Post Type', $this->plugin_slug ),
			'id'          => 'post_type',
			'description' => __( 'Select the post type containing your marker information.', $this->plugin_slug ),
			'row_classes' => 'gmb-mashup-post-type-field',
			'type'        => 'select_posttype',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Taxonomy Filter', $this->plugin_slug ),
			'id'          => 'taxonomy',
			'row_classes' => 'gmb-taxonomy-select-field',
			'description' => __( 'Select the taxonomy (if any) that you would like to filter markers by.', $this->plugin_slug ),
			'type'        => 'select_taxonomies',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Taxonomy Terms', $this->plugin_slug ),
			'id'          => 'terms',
			'row_classes' => 'gmb-terms-multicheck-field',
			'description' => __( 'Select the terms from this taxonomy that you would like to filter markers by.', $this->plugin_slug ),
			'type'        => 'select_terms',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Latitude Field', $this->plugin_slug ),
			'id'          => 'latitude',
			'default'     => '_gmb_lat',
			'row_classes' => 'gmb-latitude-select-field',
			'description' => __( 'Select the field containing the marker latitude data. Default is set to use Maps Builder field.', $this->plugin_slug ),
			'type'        => 'select_custom_meta',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Longitude Field', $this->plugin_slug ),
			'id'          => 'longitude',
			'default'     => '_gmb_lng',
			'row_classes' => 'gmb-longitude-select-field',
			'description' => __( 'Select the field containing the marker longitude data. Default is set to use Maps Builder field.', $this->plugin_slug ),
			'type'        => 'select_custom_meta',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Show Featured Image', $this->plugin_slug ),
			'id'          => 'featured_img',
			'default'     => 'yes',
			'row_classes' => 'gmb-featured-image-field',
			'description' => __( 'Would you like the featured image displayed in the marker\'s infowindow?', $this->plugin_slug ),
			'options'     => array(
				'yes' => 'Yes',
				'no'  => 'No'
			),
			'type'        => 'radio_inline',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name' => __( 'Customize Mashup Marker', $this->plugin_slug ),
			'id'   => 'set_custom',
			'type' => 'customize_mashup_marker',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Marker Image', $this->plugin_slug ),
			'id'          => 'marker_img',
			'row_classes' => 'gmb-mashup-marker-label gmb-hidden',
			'type'        => 'file',
			'options'     => array(
				'url'                  => false,
				'add_upload_file_text' => __( 'Add Marker Image', $this->plugin_slug )
			),
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Marker Data', $this->plugin_slug ),
			'id'          => 'marker',
			'row_classes' => 'gmb-mashup-marker-label gmb-hidden',
			'type'        => 'textarea_code',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Marker Label Data', $this->plugin_slug ),
			'id'          => 'label',
			'row_classes' => 'gmb-mashup-marker-label gmb-hidden',
			'type'        => 'textarea_code',
		) );
		$mashup_metabox->add_group_field( $group_field_id, array(
			'name'        => __( 'Load Mashup', $this->plugin_slug ),
			'id'          => 'load_panel',
			'row_classes' => 'gmb-mashup-loading',
			'type'        => 'mashups_load_panel',
		) );

	}


	/**
	 * Mashups Select Taxonomies
	 *
	 * @param $field
	 * @param $value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	public function gmb_cmb_render_select_taxonomies( $field, $value, $object_id, $object_type, $field_type_object ) {

		$group_data_array = maybe_unserialize( get_post_meta( $object_id, 'gmb_mashup_group', true ) );
		$post_type        = isset( $group_data_array[ $field->group->index ]['post_type'] ) ? $group_data_array[ $field->group->index ]['post_type'] : 'post';

		//First check to see if mashups post type field has been set
		if ( ! empty( $post_type ) ) {

			//Get taxonomies for CPT
			$taxonomies = get_object_taxonomies( $post_type, 'objects' );
			$options    = '';

			//Default "None"
			$options .= $field_type_object->select_option( array(
				'label'   => 'No filter',
				'value'   => 'none',
				'checked' => $value == 'none',
			) );

			//Do we have taxonomies?
			if ( $taxonomies ) {
				foreach ( $taxonomies as $taxonomy ) {
					$options .= $field_type_object->select_option( array(
						'label'   => $taxonomy->labels->name,
						'value'   => $taxonomy->name,
						'checked' => $value == $taxonomy->name,
					) );
				}
			} else {
				$options .= $field_type_object->select_option( array(
					'label' => __( 'No taxonomies found', $this->plugin_slug ),
					'value' => 'none'
				) );
			}
			//Output taxonomies select
			echo $field_type_object->select( array(
				'options'      => $options,
				'autocomplete' => 'off'
			) );

		}


	}

	/**
	 * Mashups Select Terms
	 *
	 * @param $field
	 * @param $value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	public function gmb_cmb_render_select_terms( $field, $value, $object_id, $object_type, $field_type_object ) {

		$group_data_array = maybe_unserialize( get_post_meta( $object_id, 'gmb_mashup_group', true ) );
		$post_type        = isset( $group_data_array[ $field->group->index ]['post_type'] ) ? $group_data_array[ $field->group->index ]['post_type'] : 'post';
		$taxonomy         = isset( $group_data_array[ $field->group->index ]['taxonomy'] ) ? $group_data_array[ $field->group->index ]['taxonomy'] : 'category';
		$output           = '';

		//Get Terms
		$args['taxonomy'] = isset( $taxonomy ) ? $taxonomy : '';
		$args             = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );
		$taxonomy         = $args['taxonomy'];
		$terms            = (array) get_terms( $taxonomy, $args );

		//First check to see if mashups post type field has been set
		if ( ! empty( $post_type ) && ! empty( $terms ) && ! isset( $terms['errors'] ) ) {

			$output .= '<ul class="cmb2-checkbox-list cmb2-list">';

			$output .= $this->gmb_get_terms_checklist( $terms, $field->group->index, $value );

			$output .= '</ul><p class="cmb2-metabox-description">' . __( 'Select the taxonomies (if any) that you would like to filter by.', $this->plugin_slug ) . '</p>';

		} else {
			$output = '<ul class="cmb2-checkbox-list cmb2-list"><li>' . __( 'No terms found for this taxonomy', $this->plugin_slug ) . '</li></ul>';
		}


		echo $output;


	}

	/**
	 * Mashups Select Terms
	 *
	 * @param $field
	 * @param $value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	public function gmb_cmb_render_select_custom_meta( $field, $value, $object_id, $object_type, $field_type_object ) {

		$group_data_array = maybe_unserialize( get_post_meta( $object_id, 'gmb_mashup_group', true ) );
		$post_type        = isset( $group_data_array[ $field->group->index ]['post_type'] ) ? $group_data_array[ $field->group->index ]['post_type'] : 'post';

		//First check to see if mashups post type field has been set
		if ( ! empty( $post_type ) ) {

			//Get taxonomies for CPT
			$meta_keys = $this->generate_post_type_meta_keys( $post_type );
			$options   = '';

			//Do we have taxonomies?
			if ( $meta_keys ) {
				foreach ( $meta_keys as $meta_key ) {

					$options .= $field_type_object->select_option( array(
						'label'   => $meta_key,
						'value'   => $meta_key,
						'checked' => ( ! empty( $value ) ? $value : $field->args['default'] ) == $meta_key
					) );
				}

			} else {
				$options .= $field_type_object->select_option( array(
					'label' => __( 'No custom fields found', $this->plugin_slug ),
					'value' => 'none'
				) );
			}
			//Output taxonomies select
			echo $field_type_object->select( array(
				'options'      => $options,
				'autocomplete' => 'off'
			) );

		}


	}

	/**
	 * Generate Post Type Meta Keys
	 *
	 * @see: http://wordpress.stackexchange.com/questions/58834/echo-all-meta-keys-of-a-custom-post-type
	 * @return array
	 */
	function generate_post_type_meta_keys( $post_type ) {
		global $wpdb;
		$existing_transient = get_transient( $post_type . '_meta_keys' );

		if ( $existing_transient ) {
			return $existing_transient;
		}

		$query     = "
	        SELECT DISTINCT($wpdb->postmeta.meta_key)
	        FROM $wpdb->posts
	        LEFT JOIN $wpdb->postmeta
	        ON $wpdb->posts.ID = $wpdb->postmeta.post_id
	        WHERE $wpdb->posts.post_type = '%s'
	        AND $wpdb->postmeta.meta_key != ''
	    ";
		$meta_keys = $wpdb->get_col( $wpdb->prepare( $query, $post_type ) );

		if ( empty( $meta_keys ) ) {
			return array( __( 'No meta keys found', $this->plugin_slug ) );
		}

		set_transient( $post_type . '_meta_keys', $meta_keys, 60 * 60 * 24 ); # 1 Day Expiration

		return $meta_keys;

	}


	/**
	 * AJAX Taxonomies Callback
	 *
	 * @description Used to query taxonomies and taxonomy terms
	 *
	 * @since       2.0
	 */
	function get_post_types_taxonomies_callback() {

		//Set Vars
		$post_type                    = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';
		$repeater_index               = isset( $_POST['index'] ) ? $_POST['index'] : '';
		$taxonomies                   = get_object_taxonomies( $post_type, 'objects' );
		$i                            = 0;
		$tax_terms                    = '';
		$response                     = '';
		$response['taxonomy_options'] = '';
		$response['meta_key_options'] = '';


		//Do we have taxonomies?
		if ( $taxonomies ) {


			//Default "no filter" options
			$response['taxonomy_options'] .= '<option value="none">' . __( 'No filter', 'gmb' ) . '</option>';

			//Create taxonomy options
			foreach ( $taxonomies as $taxonomy ) {
				//Set term query var on last loop through
				if ( $i == 0 ) {
					$tax_terms = $taxonomy->name;
				}
				$response['taxonomy_options'] .= '<option value="' . $taxonomy->name . '">' . $taxonomy->labels->name . '</option>';
				$i ++;
			}
			$response['status'] = 'taxonomies found';

			//Get terms multicheck list for taxonomy and send to JS
			$args['taxonomy']            = isset( $tax_terms ) ? $tax_terms : '';
			$args                        = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );
			$taxonomy                    = $args['taxonomy'];
			$terms                       = (array) get_terms( $taxonomy, $args );
			$response['terms_checklist'] = $this->gmb_get_terms_checklist( $terms, $repeater_index, '' );


		} else {

			$response['taxonomy_options'] = '<option value="none">' . __( 'No taxonomies found', $this->plugin_slug ) . '</option>';
			$response['status']           = 'none';

		}

		//If post type return meta_keys
		if ( $post_type ) {
			//Get custom meta keys and send to JS
			$meta_keys = $this->generate_post_type_meta_keys( $post_type );
			foreach ( $meta_keys as $meta_key_option ) {
				$response['meta_key_options'] .= '<option value="' . $meta_key_option . '">' . $meta_key_option . '</option>';
			}
		}


		echo json_encode( $response );

		wp_die();

	}


	/**
	 * AJAX Taxonomies Callback
	 */
	function get_taxonomy_terms_callback() {

		//Set Vars
		$repeater_index = isset( $_POST['index'] ) ? $_POST['index'] : '';
		$taxonomy       = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$response       = '';
		$terms          = (array) get_terms( $taxonomy );

		//Do we have taxonomies?
		if ( $terms ) {

			$response['terms_checklist'] = '<ul class="cmb2-checkbox-list cmb2-list">';

			$response['terms_checklist'] .= $this->gmb_get_terms_checklist( $terms, $repeater_index, '' );

			$response['terms_checklist'] .= '</ul><p class="cmb2-metabox-description">' . __( 'Select the taxonomies (if any) that you would like to filter by.', $this->plugin_slug ) . '</p>';
			//Get terms multicheck list for taxonomy and send to JS
			$response['status'] = 'success';

		} else {

			$response['terms_checklist'] = '<li>' . __( 'No terms found for this taxonomy', $this->plugin_slug ) . '</li>';
			$response['status']          = 'none';

		}

		echo json_encode( $response );

		wp_die();

	}

	/**
	 * AJAX Taxonomies Callback
	 */
	function get_mashup_markers_callback() {

		//Set Vars
		$repeater_index = isset( $_POST['index'] ) ? $_POST['index'] : '';
		$taxonomy       = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$terms          = isset( $_POST['terms'] ) ? $_POST['terms'] : '';
		$post_type      = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';
		$lat_field      = isset( $_POST['lat_field'] ) ? $_POST['lat_field'] : '_gmb_lat';
		$lng_field      = isset( $_POST['lng_field'] ) ? $_POST['lng_field'] : '_gmb_lng';
		$response       = '';

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => - 1
		);
		//Handle taxonomy & terms filter
		if ( ! empty( $taxonomy ) && $taxonomy !== 'none' ) {

			//Build $args taxonomy params
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $terms,
					'operator' => 'IN',
				)
			);

		}

		//Check if we have a transient here & we're not busting it
		$transient_name = md5( 'gmb_mashup_' . http_build_query( $args ) ); //md5 to keep characters under 40
		$saved_query    = get_transient( $transient_name );

		//@TODO: Is saving a transient necessary for performance?
		//		if ( $saved_query !== false ) {
		//			echo json_encode( maybe_unserialize( $saved_query ) );
		//			wp_die();
		//		}

		// The Query
		$wp_query = new WP_Query( $args );

		// The Loop
		if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) :

			$wp_query->the_post();
			$post_id = get_the_ID();

			$response[ $post_id ]['title']     = get_the_title( $post_id );
			$response[ $post_id ]['id']        = $post_id;
			$response[ $post_id ]['address']   = get_post_meta( $post_id, '_gmb_address', true ); //Geocoding Coming soon
			$response[ $post_id ]['latitude']  = get_post_meta( $post_id, $lat_field, true );
			$response[ $post_id ]['longitude'] = get_post_meta( $post_id, $lng_field, true );

		endwhile; endif;
		wp_reset_postdata();

		//Set query transient
		if ( is_array( $response ) ) {
			set_transient( $transient_name, $response, 24 * HOUR_IN_SECONDS ); //save transient for 24 hours
			echo json_encode( $response );

		} else {

			$response['error'] = __( 'Error - No posts found.', $this->plugin_slug );

			echo json_encode( $response );

		}

		wp_die();


	}

	/**
	 * AJAX Marker Infowindow Callback
	 *
	 * @description Returns the infowindow content for a mashup marker
	 */
	function get_mashup_marker_infowindow_callback() {

		//Set Vars
		$marker_data       = isset( $_POST['marker_data'] ) ? $_POST['marker_data'] : '';
		$post_id           = isset( $marker_data['id'] ) ? intval( $marker_data['id'] ) : '';
		$featured_img_show = isset( $_POST['featured_img'] ) ? $_POST['featured_img'] : '';

		$post_object      = get_post( $post_id );
		$marker_title     = $post_object->post_title;
		$marker_content   = wp_trim_words( $post_object->post_content, 55 );
		$marker_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );

		$response = '';

		$response['infowindow'] = '<div id="infobubble-content" class="main-place-infobubble-content">';

		if ( ! empty( $marker_thumbnail[0] ) && $featured_img_show !== 'false' ) {
			$response['infowindow'] .= '<div class="place-thumb"><img src="' . $marker_thumbnail[0] . '" alt="' . $marker_title . '"></div>';
		}
		if ( ! empty( $marker_title ) ) {
			$response['infowindow'] .= '<p class="place-title">' . $marker_title . '</p>';
		}

		if ( ! empty( $marker_content ) ) {
			$response['infowindow'] .= '<p class="place-description">' . $marker_content . '</p>';
		}

		$response['infowindow'] .= '<a href="' . get_permalink( $post_id ) . '" title="' . $marker_title . '" class="gmb-mashup-single-link">' . apply_filters( 'gmb_mashup_infowindow_content_readmore', __( 'Read More &raquo;', $this->plugin_slug ) ) . '</a>';

		$response['infowindow'] .= '</div>';


		$response = apply_filters( 'gmb_mashup_infowindow_content', $response, $marker_data, $post_id ); //Filter so users can add/remove fields

		echo json_encode( $response );

		wp_die();


	}


	/**
	 * Get Terms Checklist
	 *
	 * @param $terms array - a list of terms to loop through
	 * @param $index int - the index of this repeater group
	 * @param $value string - default value to match up if any
	 *
	 * @return string
	 */
	public function gmb_get_terms_checklist( $terms, $index, $value ) {
		$output = '';
		$i      = 0;

		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {

				$output .= '<li>
							<input type="checkbox" class="cmb2-option" name="gmb_mashup_group[' . $index . '][terms][]" id="gmb_mashup_group_' . $index . '_terms' . $i . '" value="' . $term->term_id . '" ' . ( is_array( $value ) && in_array( $term->term_id, $value ) ? 'checked="checked"' : '' ) . ' data-iterator="' . $index . '">
							<label for="gmb_mashup_group_' . $index . '_terms' . $i . '">' . $term->name . '</label>
							</li>';

				$i ++;
			}
		} //end foreach

		return $output;

	}


	/**
	 * Render Loading Panel
	 *
	 * @param $field
	 * @param $value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	public function gmb_cmb_render_mashups_load_panel( $field, $value, $object_id, $object_type, $field_type_object ) {

		//Output our hidden field so we have
		echo $field_type_object->input( array(
			'id'   => 'mashup_configured',
			'type' => 'hidden',
		) );
		echo '<div class="mashup-load-status-wrap"><label>' . __( 'Marker Load Status:', $this->plugin_slug ) . '</label><div class="mashup-load-status"><ol></ol></div></div>';
		if ( $value == 'true' ) {
			echo '<button class="gmb-load-mashup button" disabled="disabled">' . __( 'Mashup Configured', $this->plugin_slug ) . '</button>';
		} else {
			echo '<button class="gmb-load-mashup button button-primary">' . __( 'Load Markers', $this->plugin_slug ) . '</button>';
		}

		echo '<img src="' . GMB_PLUGIN_URL . 'assets/img/loading.GIF" class="gmb-mashups-loading">';

	}

	/**
	 * CMB2 Custom Field: Button that opens marker icon modal
	 *
	 * @param $field
	 * @param $value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	public function gmb_cmb_customize_mashup_marker( $field, $value, $object_id, $object_type, $field_type_object ) {

		//Output button
		echo '<button class="gmb-set-mashup-marker button gmb-magnific-inline" data-target="marker-icon-modal" data-mfp-src="#marker-icon-modal" data-iterator="' . $field->group->index . '">' . __( 'Configure Mashup Marker', $this->plugin_slug ) . '</button>';


	}

} //end class

new Google_Maps_Builder_Mashups_Builder();
