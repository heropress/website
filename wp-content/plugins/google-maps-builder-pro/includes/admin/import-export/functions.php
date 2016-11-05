<?php
/**
 * Functions
 *
 * @since       2.0
 * @package     GMB_CSV Manager
 * @subpackage  Functions
 * @copyright   Copyright (c) 2015, WordImpress
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Handle errors
 *
 * @since       2.0
 *
 * @param       int   $errno The specific errorcode to handle
 * @param       mixed $data  Arbitrary data that may need to be handled
 *
 * @return      void
 */
function gmb_csv_error_handler( $errno ) {
	$data  = '';
	$class = 'error';

	switch ( $errno ) {
		case '0':
			$class = 'updated';
			$error = __( 'Import completed successfully!', 'google-maps-builder' );
			break;
		case '1':
			$error = __( 'You cannot assign multiple columns to the same db field!', 'google-maps-builder' );
			break;
		case '2':
			$error = __( 'You must specify a valid CSV file to import!', 'google-maps-builder' );
			break;
		case '3':
			$error       = __( 'One or more files failed to import!', 'google-maps-builder' );
			$file_errors = get_transient( 'gmb_file_errors' );
			if ( $file_errors ) {
				$file_errors = maybe_unserialize( $file_errors );

				foreach ( $file_errors as $row => $file ) {
					$data .= sprintf( __( '<br />&middot; The file %s cannot be found on line %s.', 'google-maps-builder' ), $file['file'], $file['row'] );
				}
			}
			delete_transient( 'gmb_file_errors' );
			break;
		case '4':
			$error        = __( 'Error adding image attachment!', 'google-maps-builder' );
			$image_errors = get_transient( 'gmb_image_errors' );
			if ( $image_errors ) {
				$image_errors = maybe_unserialize( $image_errors );

				foreach ( $image_errors as $image ) {
					$data .= sprintf( __( '<br />&middot; The image %s could not be attached!', 'google-maps-builder' ), $image['file'] );
				}
			}
			delete_transient( 'gmb_image_errors' );
			break;
		case '5':
			$error        = __( 'Featured image has invalid permissions!', 'google-maps-builder' );
			$image_errors = get_transient( 'gmb_image_perms_errors' );
			if ( $image_errors ) {
				$image_errors = maybe_unserialize( $image_errors );

				foreach ( $image_errors as $image ) {
					$data .= sprintf( __( '<br />&middot; The image %s has invalid permissions!', 'edd-csv-manater' ), $image['file'] );
				}
			}
			delete_transient( 'gmb_image_perms_errors' );
			break;
		case '6':
			$error           = __( 'One or more items failed to import!', 'google-maps-builder' );
			$download_errors = get_transient( 'gmb_download_errors' );
			if ( $download_errors ) {
				$download_errors = maybe_unserialize( $download_errors );

				foreach ( $download_errors as $row => $download ) {
					$data .= sprintf( __( '<br />&middot; The product %s cannot be found on line %s.', 'google-maps-builder' ), $download['product'], $download['row'] );
				}
			}
			delete_transient( 'gmb_download_errors' );
			break;
	}

	echo '<div class="' . $class . '"><p>' . $error . '</p>' . $data . '</div>';
}
