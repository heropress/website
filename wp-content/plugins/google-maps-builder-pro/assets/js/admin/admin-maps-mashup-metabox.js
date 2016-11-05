/**
 *  Admin Mashups Metabox
 *
 *  @description: Adds functionality to the maps builder mashups metabox which appears on various post types as set by the user
 *  @copyright: http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *  @since: 2.0
 */

window.GMB_Mashups_Metabox = (function ( window, document, $, undefined ) {
	'use strict';

	var app = {};

	/**
	 * Cache
	 */
	app.cache = function () {

		app.$body = $( 'body' );

	};

	/**
	 * Initialize
	 */
	app.init = function () {

		app.cache();
		app.set_mashup_autocomplete();
		app.set_toggle_fields();

		$( '.gmb-reset-autocomplete' ).on( 'click', app.reset_metabox );
	};


	/**
	 * Set Mashup Autcomplete FIeld
	 * @returns {{}}
	 */
	app.set_mashup_autocomplete = function () {

		var input = $( '#_gmb_mashup_autocomplete' ).get( 0 );

		var location_autocomplete = new google.maps.places.Autocomplete( input );
		//location_autocomplete.bindTo( 'bounds', map );

		google.maps.event.addListener( location_autocomplete, 'place_changed', function () {

			var place = location_autocomplete.getPlace();
			if ( !place.geometry ) {
				window.alert( "Autocomplete's returned place contains no geometry" );
				return false;
			}

			//Set field vars
			if ( place.geometry ) {
				$( '#_gmb_lat' ).val( place.geometry.location.lat() );
				$( '#_gmb_lng' ).val( place.geometry.location.lng() );
			}
			if ( place.formatted_address ) {
				$( '#_gmb_address' ).val( place.formatted_address );
			}
			if ( place.place_id ) {
				$( '#_gmb_place_id' ).val( place.place_id );
			}

			//Set trigger field
			$( '.search-autocomplete-set' ).val( '1' );
			//Slide down locations panel
			$( '.gmb-toggle' ).show();
			//Hide autocomplete & show reset btn
			$( '.autocomplete-wrap' ).hide();
			$( '.gmb-autocomplete-notice' ).show();

		} );

		//Tame the enter key to not save the widget while using the autocomplete input
		google.maps.event.addDomListener( input, 'keydown', function ( e ) {
			if ( e.keyCode == 13 ) {
				e.preventDefault();
			}
		} );

	};

	/**
	 * Set Toggle Fields
	 */
	app.set_toggle_fields = function () {

		$( '.gmb-toggle-fields' ).on( 'click', function ( e ) {

			e.preventDefault();
			$( '.gmb-toggle' ).slideToggle();
			$( this ).find( '.dashicons' ).toggleClass( 'dashicons-arrow-down' );
			$( this ).find( '.dashicons' ).toggleClass( 'dashicons-arrow-up' );

		} );

	};


	/**
	 * Reset Metabox
	 */
	app.reset_metabox = function () {

		$( '.autocomplete-wrap' ).show();
		$( this ).parents( '.gmb-autocomplete-notice' ).hide();
		$('.search-autocomplete' ).val(' ' ).focus();
		//Clear fields
		$( '.search-autocomplete-set' ).val( '' );
		$( '#_gmb_lat' ).val( '' );
		$( '#_gmb_lng' ).val( '' );
		$( '#_gmb_address' ).val( '' );
		$( '#_gmb_place_id' ).val( '' );
		return false;

	};

	//Get it started
	$( document ).ready( app.init );

	return app;


})( window, document, jQuery );
