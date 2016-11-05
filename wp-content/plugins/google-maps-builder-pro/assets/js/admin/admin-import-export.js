/**
 * Google Maps CPT Handling
 *
 *
 */

(function ( $ ) {

	"use strict";


	$( document ).on( 'ready', function () {

		//Import Markers
		$( '#gmb_maps' ).on( 'change', function () {
			var map_value = $( this ).val();
			var next_hidden = $( this ).parent().next( '.gmb-hidden' );
			if ( map_value !== '0' ) {
				next_hidden.show();
			} else {
				next_hidden.hide();
			}
		} );


	} );


}( jQuery ));

