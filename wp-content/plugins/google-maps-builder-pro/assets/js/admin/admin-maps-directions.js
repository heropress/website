/**
 *  Maps Directions
 *
 *  @description: Adds directions functionality to the maps builder
 *  @copyright: http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *  @since: 2.0
 */
var gmb_data;
window.GMB_Directions = (function ( window, document, $, undefined ) {
	'use strict';

	var app = {};
	var directionsDisplay = [];
	var directionsService = new google.maps.DirectionsService();
	var dirs_autocomplete,
		destination,
		destination_lat_field,
		destination_lng_field,
		destination_place_id,
		destination_address,
		destination_count,
		destination_location_marker;

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
		$( window ).on( 'load', app.window_load );
	};

	/**
	 * Kick it off on Window Load
	 */
	app.window_load = function () {

		//Calculate the route here
		app.calc_routes();

		//Setup autocomplete fields on click
		app.$body.on( 'click, focus', '.gmb-directions-autocomplete', app.gmb_setup_autocomplete );

		//Destination row removed
		app.$body.on( 'cmb2_remove_row', '.cmb-type-destination', function ( event, row ) {
			app.calc_routes();
		} );

		//Destination row added
		app.$body.on( 'cmb2_add_row', '.cmb-type-destination', function ( event, row ) {
			//increment hidden iterator so CMB2 repeater works properly
			var destination_fieldset = $( event.currentTarget ).find( '.empty-row .gmb-destination-fieldset' );
			var rows = $( event.currentTarget ).find( '.cmb-repeat-row' ).length;
			var iterator = parseInt( $( destination_fieldset ).data( 'iterator' ) );
			$( destination_fieldset ).attr( 'data-iterator', rows );
			$( destination_fieldset ).data( 'iterator', rows );
			//focus on autocomplete field
			$( event.currentTarget ).find( '.cmb-repeat-row:last .gmb-directions-autocomplete' ).focus();
		} );

		//Travel mode changed
		$( 'body' ).on( 'change', '.gmb-travel-mode', function ( event, row ) {
			app.calc_routes();
		} );

	};


	/**
	 * Setup Directions Autocomplete Field
	 *
	 * @param element
	 * @returns {boolean}
	 */
	app.gmb_setup_autocomplete = function () {

		var element = $( this );

		var dirs_autocomplete = new google.maps.places.Autocomplete( element[0] );
		dirs_autocomplete.bindTo( 'bounds', map );

		//Tame the enter key to not save the post while using the dirs_autocomplete input
		google.maps.event.addDomListener( element[0], 'keydown', function ( e ) {
			if ( e.keyCode == 13 ) {
				e.preventDefault();
			}
		} );

		//Autocomplete event listener
		google.maps.event.addListener( dirs_autocomplete, 'place_changed', function () {

			var rows = element.parents( '.cmb-repeatable-grouping' ).find( '.cmb-repeat-row' ).length;

			//get place information
			destination = dirs_autocomplete.getPlace();

			//Set appropriate field object vars
			destination_lat_field = $( element ).parents( '.gmb-destination-fieldset' ).find( '.gmb-directions-latitude' );
			destination_lng_field = $( element ).parents( '.gmb-destination-fieldset' ).find( '.gmb-directions-longitude' );
			destination_place_id = $( element ).parents( '.gmb-destination-fieldset' ).find( '.gmb-directions-place_id' );
			destination_address = $( element ).parents( '.gmb-destination-fieldset' ).find( '.gmb-directions-address' );

			//set values
			destination_lat_field.val( destination.geometry.location.lat() );
			destination_lng_field.val( destination.geometry.location.lng() );
			destination_place_id.val( destination.place_id );
			destination_address.val( destination.formatted_address );

			if ( !destination.geometry ) {
				alert( 'Error: Place not found!' );
				return;
			}

			//If only 1 row add another (directions need two points)
			if ( rows == 1 ) {
				element.parents( '.cmb-type-destination' ).find( '.cmb-add-row-button' ).trigger( 'click' );
			}

			app.calc_routes();

		} );


	};


	/**
	 * Calculate Route
	 */
	app.calc_routes = function () {

		//Loop through Directions group
		$( '#gmb_directions_group_repeat' ).find( '.cmb-repeatable-grouping' ).each( function ( index, value ) {

			if ( directionsDisplay[index] ) {
				directionsDisplay[index].setMap( null );
			}

			//Setup
			directionsDisplay[index] = new google.maps.DirectionsRenderer();
			directionsDisplay[index].setMap( window.map );
			var repeatable_row = $( this ).find( '.cmb-repeat-row' );

			//Get origin
			var start_lat = repeatable_row.first().find( '.gmb-directions-latitude' ).val();
			var start_lng = repeatable_row.first().find( '.gmb-directions-longitude' ).val();
			var start_address = repeatable_row.first().find( '.gmb-directions-address' ).val();
			var origin;
			if ( start_address ) {
				origin = start_address;
			} else {
				origin = start_lat + ',' + start_lng;
			}

			//Get Destination
			var end_lat = repeatable_row.last().find( '.gmb-directions-latitude' ).val();
			var end_lng = repeatable_row.last().find( '.gmb-directions-longitude' ).val();
			var end_address = repeatable_row.last().find( '.gmb-directions-address' ).val();
			var final_destination;
			if ( end_address && end_address !== start_address ) {
				final_destination = end_address;
			} else if ( end_lat !== start_lat && end_lng !== start_lng ) {
				final_destination = end_lat + ',' + end_lng;
			} else {
				final_destination = '';
			}

			var travel_mode = $( this ).find( '.gmb-travel-mode' ).val();
			var waypts = [];

			//Next Loop through interior destionations (not first or last) to get waypoints
			repeatable_row.not( ':first' ).not( ':last' ).each( function ( index, value ) {

				var waypoint_address = $( this ).find( '.gmb-directions-address' ).val();
				var waypoint_lat = $( this ).find( '.gmb-directions-latitude' ).val();
				var waypoint_lng = $( this ).find( '.gmb-directions-longitude' ).val();
				var waypoint_location;

				if ( waypoint_address ) {
					waypoint_location = waypoint_address;
				} else {
					waypoint_location = waypoint_lat + ',' + waypoint_lng;
				}

				waypts.push( {
					location: waypoint_location,
					stopover: true
				} );

			} );


			//Directions Request
			var request = {
				origin           : origin,
				destination      : final_destination,
				waypoints        : waypts,
				optimizeWaypoints: true,
				travelMode       : google.maps.TravelMode[travel_mode]
			};

			directionsService.route( request, function ( response, status ) {

				if ( status == google.maps.DirectionsStatus.OK ) {

					directionsDisplay[index].setOptions( {preserveViewport: true} ); //ensure users set lat/lng doesn't get all messed u
					directionsDisplay[index].setDirections( response ); //Set dem directions

				}
			} );

		} );
	};


	//Get it started
	$( document ).ready( app.init );

	return app;


})( window, document, jQuery );
