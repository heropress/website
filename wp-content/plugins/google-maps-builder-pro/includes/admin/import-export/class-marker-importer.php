<?php
/**
 * CSV Marker Importer
 *
 * @since       2.0
 * @package     Google_Maps_Builder
 * @copyright   Copyright (c) 2015, WordImpress
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class GMB_CSV_Marker_Importer {

	private $page;


	/**
	 * Run action and filter hooks
	 *
	 * @since       2.0
	 * @access      public
	 */
	public function __construct() {

		$this->page        = 'edit.php?post_type=google_maps&page=gmb_import_export';
		$this->plugin_slug = Google_Maps_Builder()->get_plugin_slug();

		// Handle uploading of a CSV
		add_action( 'gmb_upload_csv', array( $this, 'upload' ) );

		// Handle mapping CSV fields to GMB fields
		add_action( 'gmb_map_csv', array( $this, 'map' ) );

		//Add metabox
		add_action( 'gmb_import_page', array( $this, 'add_metabox' ) );

	}


	/**
	 * Add metabox
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function add_metabox() {

		$wp_upload_dir = wp_upload_dir();

		ob_start();

		echo '<div class="postbox import-export-metabox" id="gmb-marker-import">';
		echo '<h3 class="hndle ui-sortable-handle">' . __( 'Import Map Markers from CSV', 'google-maps-builder' ) . '</h3>';
		echo '<div class="inside">';

		echo '<p class="intro">' . sprintf( __( 'Import map markers to your site from a .csv file. Please use the %1$sexample marker import csv%2$s as reference.', 'google-maps-builder' ), '<a href="' . GMB_PLUGIN_URL . 'includes/admin/import-export/samples/markers.csv' . '">', '</a>' ) . '</p>';

		echo '<form method="post" enctype="multipart/form-data" action="' . admin_url( $this->page ) . '">';

		if ( isset( $_GET['errno'] ) && isset( $_GET['type'] ) && $_GET['type'] == 'markers' ) {
			gmb_csv_error_handler( $_GET['errno'] );
		}

		/*-----------------------------------
		STEP 1
		--------------------------------------*/
		if ( empty( $_GET['step'] ) || $_GET['step'] == 1 || ( isset( $_GET['type'] ) && $_GET['type'] != 'markers' ) ) {
			if ( empty( $_GET['step'] ) || $_GET['step'] == 1 ) {
				// Cleanup data to prevent accidental carryover
				$this->cleanup();
			}

			echo '<div class="map-selection">';
			echo '<label>' . __( 'Step 1: Select a map to import markers', $this->plugin_slug ) . '</label>';
			echo Google_Maps_Builder()->html->maps_dropdown();
			echo '</div>';

			echo '<div class="csv-upload gmb-hidden">';
			echo '<label>' . __( 'Step 2: Upload a properly formatted CSV file', $this->plugin_slug ) . '</label>';
			echo '<p><input type="file" name="import_file" /></p>';
			echo '<p><label for="has_headers"><input type="checkbox" id="has_headers" name="has_headers" checked="yes" /> ' . __( 'Does the CSV include a header row?', 'google-maps-builder' ) . '</label></p>';
			echo '<input type="hidden" name="gmb_action" value="upload_csv" />';
			wp_nonce_field( 'gmb_import_nonce', 'gmb_import_nonce' );
			submit_button( __( 'Next', 'google-maps-builder' ), 'secondary', 'submit', false );
			echo '</div>';

		} /*-----------------------------------
			STEP 2
		--------------------------------------*/
		elseif ( $_GET['step'] == 2 && isset( $_GET['type'] ) && $_GET['type'] == 'markers' ) {

			$fields = get_transient( 'gmb_csv_headers' );

			// Display CSV fields for mapping
			echo '<div class="csv-mapping-header">';
			echo '<span>' . __( 'CSV Headers', 'google-maps-builder' ) . '</span>';
			echo '<span>' . __( 'Map Fields', 'google-maps-builder' ) . '</span>';
			echo '</div>';

			foreach ( $fields as $id => $field ) {
				if ( get_transient( 'has_headers' ) ) {
					$field_label = $field;
					$field_id    = $field;
				} else {
					$i           = $id + 1;
					$field_label = 'column_' . $i;
					$field_id    = $id;
				}

				echo '<div class="field-wrap">';
				echo '<div class="field-label">' . $field_label . '</div>';
				echo '<select name="csv_fields[' . $field_id . ']" >' . $this->get_fields( $field_label ) . '</select>';
				echo '</div>';
			}

			echo '<p><input type="hidden" name="gmb_action" value="map_csv" />';
			wp_nonce_field( 'gmb_import_nonce', 'gmb_import_nonce' );
			submit_button( __( 'Import', 'google-maps-builder' ), 'secondary', 'submit', false );
			echo '</p>';

		}

		echo '</form>';
		echo '</div>';
		echo '</div>';
	}


	/**
	 * Cleanup unneeded transients
	 *
	 * @since       1.0.0
	 * @access      private
	 * @return      void
	 */
	private function cleanup() {
		if ( get_transient( 'gmb_file_errors' ) ) {
			delete_transient( 'gmb_file_errors' );
		}
		if ( get_transient( 'gmb_image_errors' ) ) {
			delete_transient( 'gmb_image_errors' );
		}
		if ( get_transient( 'gmb_csv_headers' ) ) {
			delete_transient( 'gmb_csv_headers' );
		}
		if ( get_transient( 'gmb_csv_file' ) ) {
			delete_transient( 'gmb_csv_file' );
		}
		if ( get_transient( 'gmb_marker_map' ) ) {
			delete_transient( 'gmb_marker_map' );
		}
		if ( get_transient( 'gmb_csv_map' ) ) {
			delete_transient( 'gmb_csv_map' );
		}
		if ( get_transient( 'has_headers' ) ) {
			delete_transient( 'has_headers' );
		}
	}


	/**
	 * Get dropdown list of available fields
	 *
	 * @since       2.0
	 * @access      public
	 *
	 * @param       string $parent the name of a particular select element
	 *
	 * @return      string
	 */
	public function get_fields( $parent ) {
		$fields = array(
			'title'             => __( 'Title', 'google-maps-builder' ),
			'description'       => __( 'Description', 'google-maps-builder' ),
			'reference'         => __( 'Google Place Reference (deprecated)', 'google-maps-builder' ),
			'place_id'          => __( 'Google Place ID', 'google-maps-builder' ),
			'latitude'          => __( 'Latitude', 'google-maps-builder' ),
			'longitude'         => __( 'Longitude', 'google-maps-builder' ),
			'marker_img_id'     => __( 'Marker Image ID', 'google-maps-builder' ),
			'marker_img_url'    => __( 'Marker Image URL', 'google-maps-builder' ),
			'marker_data'       => __( 'Marker Data', 'google-maps-builder' ),
			'marker_label_data' => __( 'Marker Label', 'google-maps-builder' ),
			'infowindow_open'   => __( 'Infowindow Opened', 'google-maps-builder' ),
		);

		$fields = apply_filters( 'gmb_csv_fields', $fields );
		asort( $fields );

		$return = '<option value="">' . __( 'Unmapped', 'google-maps-builder' ) . '</option>';

		foreach ( $fields as $field_name => $field_title ) {
			$return .= '<option value="' . $field_name . '"' . $this->map_preset( $parent, $field_name ) . '>' . $field_title . '</option>';
		}

		return $return;
	}


	/**
	 * Handles presetting mapping on submit when errors exist
	 *
	 * @since       2.0
	 * @access      private
	 *
	 * @param       string $parent     the parent element we are checking
	 * @param       string $field_name the value to check against
	 *
	 * @return      string $selected
	 */
	private function map_preset( $parent, $field_name ) {
		// Get mapped fields
		$csv_fields = get_transient( 'csv_fields' );
		$csv_fields = unserialize( $csv_fields );

		if ( isset( $csv_fields[ $parent ] ) && strtolower( $csv_fields[ $parent ] ) == strtolower( $field_name ) ) {
			$selected = ' selected ';
		} else {
			$selected = '';
		}

		return $selected;
	}


	/**
	 * Process import from a CSV file
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function upload() {

		if ( empty( $_POST['gmb_import_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['gmb_import_nonce'], 'gmb_import_nonce' ) ) {
			return;
		}

		if ( ! isset( $_POST['gmb-maps'] ) ) {
			return;
		}

		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$csv = new parseCSV();

		$import_file = $_FILES['import_file']['tmp_name'];


		// Make sure we have a valid CSV
		if ( empty( $import_file ) || ! $this->is_valid_csv( $_FILES['import_file']['name'] ) ) {
			wp_redirect( add_query_arg( array(
				'tab'   => 'import',
				'type'  => 'markers',
				'step'  => '1',
				'errno' => '2'
			), $this->page ) );
			exit;
		}

		// Detect delimiter
		$csv->auto( $import_file );

		// Duplicate the temp file so it doesn't disappear on us
		$destination = trailingslashit( WP_CONTENT_DIR ) . basename( $import_file );
		move_uploaded_file( $import_file, $destination );

		if ( isset( $_POST['has_headers'] ) ) {
			set_transient( 'has_headers', '1' );
			set_transient( 'gmb_csv_headers', $csv->titles );
		}
		set_transient( 'gmb_csv_file', basename( $import_file ) );
		set_transient( 'gmb_marker_map', intval( $_POST['gmb-maps'] ) );

		wp_redirect( add_query_arg( array(
			'tab'  => 'import',
			'type' => 'markers',
			'step' => '2#gmb-marker-import'
		), $this->page ) );
		exit;
	}


	/**
	 * Ensure the uploaded file is a valid CSV
	 *
	 * @since       2.0
	 * @access      private
	 *
	 * @param       string $file the filename of a specified upload
	 *
	 * @return      bool
	 */
	private function is_valid_csv( $file ) {
		// Array of allowed extensions
		$allowed = array( 'csv' );

		// Determine the extension for the uploaded file
		$ext = pathinfo( $file, PATHINFO_EXTENSION );

		// Check if $ext is allowed
		if ( in_array( $ext, $allowed ) ) {
			return true;
		}

		return false;
	}


	/**
	 * Handle mapping of CSV fields to GMB fields
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function map() {
		if ( empty( $_POST['gmb_import_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['gmb_import_nonce'], 'gmb_import_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		// Invert the array... array_flip ftw!
		$fields = array_flip( $_POST['csv_fields'] );

		if ( $this->map_has_duplicates( $_POST['csv_fields'] ) ) {
			wp_redirect( add_query_arg( array(
				'tab'   => 'import',
				'type'  => 'markers',
				'step'  => '2#gmb-marker-import',
				'errno' => '1'
			), $this->page ) );
			exit;
		}

		set_transient( 'csv_fields', serialize( $fields ) );

		$this->process_import();
	}


	/**
	 * Check a given map for duplicates
	 *
	 * @since       2.0
	 * @access      private
	 *
	 * @param       array $fields an array of mapped fields
	 *
	 * @return      bool
	 */
	function map_has_duplicates( $fields ) {
		$duplicates = false;

		foreach ( $fields as $csv => $db ) {
			if ( ! empty( $db ) ) {
				if ( ! isset( $value_{$db} ) ) {
					$value_{$db} = true;
				} else {
					$duplicates |= true;
				}
			}
		}

		return $duplicates;
	}


	/**
	 * Import the mapped data to GMB
	 *
	 * @since       2.0
	 * @access      private
	 * @return      void
	 */
	private function process_import() {

		$defaults = array(
			'title'           => '',
			'description'     => '',
			'reference'       => '',
			'place_id'        => '',
			'latitude'        => '',
			'longitude'       => '',
			'marker_img_id'   => '',
			'marker_img_url'  => '',
			'marker_data'     => '',
			'marker_label'    => '',
			'infowindow_open' => 'closed',
		);

		$defaults = apply_filters( 'gmb_csv_default_fields', $defaults );

		$map_id = get_transient( 'gmb_marker_map' );

		$csv_fields  = maybe_unserialize( get_transient( 'csv_fields' ) );
		$csv_fields  = wp_parse_args( $csv_fields, $defaults );
		$headers     = get_transient( 'gmb_csv_headers' );
		$filename    = get_transient( 'gmb_csv_file' );
		$import_file = trailingslashit( WP_CONTENT_DIR ) . $filename;

		$csv = new parseCSV();

		// Detect delimiter
		$csv->auto( $import_file );

		//Repeater markers data
		$existing_markers_array = maybe_unserialize( get_post_meta( $map_id, 'gmb_markers_group', true ) );
		$new_markers_array      = array();

		// Get the column keys
		$title_key           = array_search( $csv_fields['title'], $headers );
		$description_key     = array_search( $csv_fields['description'], $headers );
		$reference_key       = array_search( $csv_fields['reference'], $headers );
		$place_id_key        = array_search( $csv_fields['place_id'], $headers );
		$marker_lat_key      = array_search( $csv_fields['latitude'], $headers );
		$marker_lng_key      = array_search( $csv_fields['longitude'], $headers );
		$marker_img_id_key   = array_search( $csv_fields['marker_img_id'], $headers );
		$marker_img_url_key  = array_search( $csv_fields['marker_img_url'], $headers );
		$marker_data_key     = array_search( $csv_fields['marker_data'], $headers );
		$marker_label_key    = array_search( $csv_fields['marker_label_data'], $headers );
		$infowindow_open_key = array_search( $csv_fields['infowindow_open'], $headers );

		foreach ( $csv->data as $key => $row ) {
			$new_row = array();
			$i       = 0;
			foreach ( $row as $column ) {
				$new_row[ $i ] = $column;
				$i ++;
			}

			// Set the metadata for this marker's data
			$marker_data = array(
				'title'           => $new_row[ $title_key ],
				'description'     => $new_row[ $description_key ],
				'reference'       => $new_row[ $reference_key ],
				'place_id'        => $new_row[ $place_id_key ],
				'lat'             => $new_row[ $marker_lat_key ],
				'lng'             => $new_row[ $marker_lng_key ],
				'marker_img_id'   => $new_row[ $marker_img_id_key ],
				'marker_img'      => $new_row[ $marker_img_url_key ],
				'marker'          => $new_row[ $marker_data_key ],
				'label'           => $new_row[ $marker_label_key ],
				'infowindow_open' => $new_row[ $infowindow_open_key ],
			);

			$new_markers_array[ $key ] = $marker_data;

		}

		//Update Marker Repeater data with new data
		if ( isset( $existing_markers_array[0] ) && empty( $existing_markers_array[0]['longitude'] ) && empty( $existing_markers_array[0]['latitude'] ) ) {
			$final_marker_array = $new_markers_array;
		} else {
			$final_marker_array = array_merge( $existing_markers_array, $new_markers_array );
		}
		update_post_meta( $map_id, 'gmb_markers_group', $final_marker_array );


		//Error occurred
		if ( ! empty( $file_errors ) ) {
			$file_errors = serialize( $file_errors );
			set_transient( 'gmb_file_errors', $file_errors );

			wp_redirect( add_query_arg( array(
				'tab'   => 'import',
				'type'  => 'markers',
				'step'  => '1',
				'errno' => '3'
			), $this->page ) );
			exit;
		}

		//All good, we imported!
		wp_redirect( add_query_arg( array(
			'tab'   => 'import',
			'type'  => 'markers',
			'step'  => '1',
			'errno' => '0'
		), $this->page ) );
		exit;
	}
}

new GMB_CSV_Marker_Importer();
