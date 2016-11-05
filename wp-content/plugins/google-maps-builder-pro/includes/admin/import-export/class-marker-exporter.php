<?php
/**
 * CSV Marker Exporter
 *
 * @since       2.0
 * @package     Google_Maps_Builder
 * @copyright   Copyright (c) 2015, WordImpress
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class GMB_CSV_Marker_Exporter {

	private $page;

	/**
	 * Run action and filter hooks
	 *
	 * @since       2.0
	 * @access      public
	 * \     */
	public function __construct() {

		$this->page        = 'edit.php?post_type=google_maps&page=gmb_import_export';
		$this->plugin_slug = Google_Maps_Builder()->get_plugin_slug();

		add_action( 'gmb_export_page', array( $this, 'add_metabox' ) );

		// Process export
		add_action( 'gmb_export_csv', array( $this, 'export' ) );
	}


	/**
	 * Add metabox
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function add_metabox() {
		echo '<div class="postbox import-export-metabox" id="gmb-product-export">';
		echo '<h3 class="hndle ui-sortable-handle">' . __( 'Export Map Markers to CSV', $this->plugin_slug ) . '</h3>';
		echo '<div class="inside">';
		echo '<p class="intro">' . __( 'Export markers from your Maps to a .csv file.', $this->plugin_slug ) . '</p>';
		echo '<form method="post" enctype="multipart/form-data" action="' . admin_url( $this->page ) . '">';

		echo '<div class="map-selection">';
		echo '<label>' . __( 'Step 1: Select a map to export markers', $this->plugin_slug ) . '</label>';
		echo Google_Maps_Builder()->html->maps_dropdown();
		echo '</div>';
		echo '<div class="marker-export-submit gmb-hidden">';
		echo '<input type="hidden" name="gmb_action" value="export_csv" />';
		submit_button( __( 'Export', $this->plugin_slug ), 'secondary', 'submit', false );
		echo '</div>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}


	/**
	 * Export products to a CSV file
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function export() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have permission to export data.', $this->plugin_slug ), __( 'Error', $this->plugin_slug ) );
		}

		$map_id = isset( $_POST['gmb-maps'] ) ? $_POST['gmb-maps'] : '';

		if ( empty( $map_id ) ) {
			wp_die( __( 'You need to select a map in order to export map data.', $this->plugin_slug ), __( 'Error', $this->plugin_slug ) );

		}

		// Set CSV header row data
		$headers = array(
			'title',
			'description',
			'reference',
			'place_id',
			'latitude',
			'longitude',
			'marker_img_id',
			'marker_img_url',
			'marker_data',
			'marker_label_data',
			'infowindow_open'
		);

		$headers = apply_filters( 'gmb_csv_marker_export_headers', $headers );

		$data[] = $headers;

		//Get Markers for this Map
		$markers = maybe_unserialize( get_post_meta( $map_id, 'gmb_markers_group', true ) );

		//Loop through an fill our data array
		foreach ( $markers as $marker ) {

			$title             = isset( $marker['title'] ) ? $marker['title'] : '';
			$description       = isset( $marker['description'] ) ? $marker['description'] : '';
			$reference         = isset( $marker['reference'] ) ? $marker['reference'] : '';
			$place_id          = isset( $marker['place_id'] ) ? $marker['place_id'] : '';
			$latitude          = isset( $marker['lat'] ) ? $marker['lat'] : '';
			$longitude         = isset( $marker['lng'] ) ? $marker['lng'] : '';
			$marker_img_id     = isset( $marker['marker_img_id'] ) ? $marker['marker_img_id'] : '';
			$marker_img_url    = isset( $marker['marker_img'] ) ? $marker['marker_img'] : '';
			$marker_data       = isset( $marker['marker'] ) ? $marker['marker'] : '';
			$marker_label_data = isset( $marker['label'] ) ? $marker['label'] : '';
			$infowindow_open   = isset( $marker['infowindow_open'] ) ? $marker['infowindow_open'] : '';

			$row = array(
				$title,
				$description,
				$reference,
				$place_id,
				$latitude,
				$longitude,
				$marker_img_id,
				$marker_img_url,
				$marker_data,
				$marker_label_data,
				$infowindow_open
			);
			$row = apply_filters( 'gmb_csv_marker_export_row', $row );

			$data[] = $row;

		} //end foreach

		$this->set_csv_download_headers();

		// Output data to CSV
		$csv = fopen( 'php://output', 'w' );

		foreach ( $data as $fields ) {
			fputcsv( $csv, $fields );
		}

		fclose( $csv );

		// Exit needed to prevent 'junk' in CSV output
		exit;

	}


	/**
	 * Set headers for ZIP downloads
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function set_zip_download_headers() {
		ignore_user_abort( true );

		if ( ! gmb_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			set_time_limit( 0 );
		}

		nocache_headers();

		header( 'Content-type: application/octet-stream' );
		header( 'Content-disposition: attachment; filename=' . apply_filters( 'gmb_products_export_zip_filename', 'gmb-export-product-backup-' . date( 'm-d-y' ) ) . '.zip' );
		header( 'Expires: -1' );
	}


	/**
	 * Set headers for CSV export
	 *
	 * @since       2.0
	 * @access      public
	 * @return      void
	 */
	public function set_csv_download_headers() {
		ignore_user_abort( true );

		if ( ! gmb_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			set_time_limit( 0 );
		}

		nocache_headers();

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . apply_filters( 'gmb_products_export_filename', 'gmb-export-products-' . date( 'm-d-y' ) ) . '.csv' );
		header( 'Expires: 0' );
	}
}

new GMB_CSV_Marker_Exporter();
