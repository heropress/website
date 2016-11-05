/**
 *  Admin Mashup Functionality
 *
 *  @description: Adds directions functionality to the maps builder
 *  @copyright: http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *  @since: 2.0
 */
var gmb_mashup;

window.GMB_Mashups = (function ( window, document, $, undefined ) {
	'use strict';

	var app = {};
	var title;
	var address;
	var lat;
	var lng;
	var info_bubble;
	var load_log;
	var ajax_spinner;
	var featured_img;
	var markers = [];

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

		//Post Type select on Change
		app.$body.on( 'change', '.gmb-mashup-post-type-field select', app.toggle_mashup_taxonomies );
		app.$body.on( 'change', '.cmb-type-select-taxonomies select', app.toggle_mashup_terms );
		app.$body.on( 'click', '.gmb-load-mashup', app.toggle_mashup_loading );
		app.$body.on( 'click', '.gmb-set-mashup-marker', app.set_mashup_marker_icon );

		//Refresh load mashups button when any other field is clicked in mashup group
		app.$body.on( 'change, click', '#gmb_mashup_group_repeat .cmb-repeatable-grouping select, #gmb_mashup_group_repeat .cmb-repeatable-grouping input:not(hidden), #gmb_mashup_group_repeat .cmb-repeatable-grouping .cmb-multicheck-toggle', function () {
			$( this ).parents( '.cmb-repeatable-grouping' ).find( '.gmb-load-mashup' ).addClass( 'button-primary' ).removeAttr( 'disabled' ).text( gmb_mashup.i18n.load_markers );
		} );

		//Load Mashups already configured on window load
		$( window ).on( 'load', function () {
			google.maps.event.addListenerOnce( map, 'idle', app.load_configured_mashups );
		} );

		//New Mashup Group Added
		app.$body.find( '#gmb_mashup_group_repeat' ).on( 'cmb2_add_row', app.configure_new_mashup_group );


	};

	/**
	 * Configure New Group
	 */
	app.configure_new_mashup_group = function () {

		//Hop to the last group
		var last_group = $( '#gmb_mashup_group_repeat' ).find( '.cmb-repeatable-grouping' ).last();

		//Ensure Load Markers button is setup
		last_group.find( '.gmb-load-mashup' ).removeAttr( 'disabled' ).addClass( 'button-primary' ).text( gmb_mashup.i18n.load_markers );

		//Trigger field refresh
		last_group.find( '.gmb-mashup-post-type-field select' ).trigger( 'change' );

	};

	/**
	 * Loads Mashups
	 * @description: When the map loads it will load mashups that have been already configured
	 */
	app.load_configured_mashups = function () {

		//InfoBubble - Contains the place's information and content
		info_bubble = new google.maps.InfoWindow( {
			maxWidth: 315
		} );

		//Loop through mashup groups
		$( '#gmb_mashup_group_repeat' ).find( '.cmb-repeatable-grouping' ).each( function ( index, value ) {

			//Determine if mashup is configured
			var configured = $( this ).find( '#mashup_configured' ).val();
			ajax_spinner = $( this ).find( '.gmb-mashups-loading' );

			//It's configured, proceed to lead
			if ( configured == 'true' ) {

				var repeater_index = $( this ).data( 'iterator' );

				var data = app.setup_marker_ajax_request( repeater_index );

				app.load_mashup( data );

			}

		} );


	};

	/**
	 * Set Up AJAX Request
	 *
	 * @description One place to handle ajax data
	 * @param index
	 */
	app.setup_marker_ajax_request = function ( index ) {

		//Setup our vars
		var post_type = $( '#gmb_mashup_group_' + index + '_post_type' ).val();
		var taxonomy = $( '#gmb_mashup_group_' + index + '_taxonomy' ).val();
		var lat_field = $( '#gmb_mashup_group_' + index + '_latitude' ).val();
		var lng_field = $( '#gmb_mashup_group_' + index + '_longitude' ).val();
		var terms = [];
		$( 'input[id^=gmb_mashup_group_' + index + '_terms]:checked' ).each( function ( i ) {
			terms[i] = $( this ).val();
		} );

		return {
			action   : 'get_mashup_markers',
			post_type: post_type,
			taxonomy : taxonomy,
			terms    : terms,
			index    : index,
			lat_field: lat_field,
			lng_field: lng_field
		};

	};

	/**
	 * Toggle Mashup Taxonomies
	 *
	 * @description Fires when the post types select is toggled
	 */
	app.toggle_mashup_taxonomies = function () {

		var select = $( this );
		var this_value = select.val();
		var repeater_index = select.parents( '.cmb-repeatable-grouping' ).data( 'iterator' );
		var taxonomy_filter_wrap = $( this ).parents( '.gmb-mashup-post-type-field' ).next( '.gmb-taxonomy-select-field' );
		var taxonomy_filter = taxonomy_filter_wrap.find( 'select' );
		var terms_filter_wrap = select.parents( '.cmb-repeatable-grouping' ).find( '.gmb-terms-multicheck-field' );
		var meta_keys_filter_wrap = select.parents( '.cmb-repeatable-grouping' ).find( '.cmb-type-select-custom-meta' );
		var load_status = select.parents( '.cmb-repeatable-grouping' ).find( '.mashup-load-status ol' );

		//Hide terms filter
		taxonomy_filter_wrap.hide();
		terms_filter_wrap.hide();
		meta_keys_filter_wrap.hide();
		load_status.empty(); //empty load status

		//AJAX data to send to and trigger PHP
		var data = {
			action   : 'get_post_types_taxonomies',
			post_type: this_value,
			index    : repeater_index
		};
		//Go AJAX go
		jQuery.post( ajaxurl, data, function ( response ) {

			//We expect JSON back
			var json_response = jQuery.parseJSON( response );
			//Update taxonomy filter dropdown with our new options
			taxonomy_filter.empty().html( json_response.taxonomy_options );
			//show taxonomy field
			taxonomy_filter_wrap.show();
			//Show meta keys field (regardless of whether or not there are terms
			meta_keys_filter_wrap.show();

			//Update meta_keys & set a default value
			meta_keys_filter_wrap.find( 'select' ).empty().html( json_response.meta_key_options );
			$( '#gmb_mashup_group_' + repeater_index + '_latitude' ).val( '_gmb_lat' );
			$( '#gmb_mashup_group_' + repeater_index + '_longitude' ).val( '_gmb_lng' );

			//Show taxonomy's terms
			if ( json_response.status !== 'none' ) {

				terms_filter_wrap.find( '.cmb2-checkbox-list' ).empty().html( json_response.terms_checklist );
				terms_filter_wrap.show();

			}

		} );

	};

	/**
	 * Toggle Mashup Terms
	 *
	 * @description Fires when the taxonomies select is toggled
	 */
	app.toggle_mashup_terms = function () {

		//Taxonomy Filter
		var select = $( this );
		var this_value = select.val();
		var repeater_index = select.parents( '.cmb-repeatable-grouping' ).data( 'iterator' );
		var terms_filter_wrap = $( this ).parents( '.cmb-repeatable-grouping' ).find( '.gmb-terms-multicheck-field' );

		//Hide terms wrap
		terms_filter_wrap.hide();

		//If value is none bounce
		if ( this_value === 'none' ) {
			return false;
		}

		var data = {
			action  : 'get_taxonomy_terms',
			taxonomy: this_value,
			index   : repeater_index
		};

		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post( ajaxurl, data, function ( response ) {

			//Check that there's terms for this tax
			if ( response.status !== 'none' ) {
				terms_filter_wrap.find( '.cmb-td' ).empty().html( response.terms_checklist );

			} else {
				//No terms for this tax
				terms_filter_wrap.find( '.cmb-td' ).empty().html( response.terms_checklist );
			}

			//Reset terms checklist
			terms_filter_wrap.show();

		}, 'json' );


	};

	/**
	 * Marker Loading
	 *
	 * @param e event
	 */
	app.toggle_mashup_loading = function ( e ) {

		e.preventDefault();

		var submit_button = $( this );
		var repeater_index = submit_button.parents( '.cmb-repeatable-grouping' ).data( 'iterator' );
		ajax_spinner = submit_button.parents( '.cmb-repeatable-grouping' ).find( '.gmb-mashups-loading' );
		ajax_spinner.show();

		//Get our AJAX data
		var data = app.setup_marker_ajax_request( repeater_index );

		//First clear markers
		app.clear_mashup_markers( data.index );

		//Now load up the markers
		app.load_mashup( data );

	};

	/**
	 * AJAX Load Mashup Markers
	 *
	 * @param data
	 */
	app.load_mashup = function ( data ) {

		jQuery.post( ajaxurl, data, function ( response ) {

			//Setup Load Log
			var load_panel = $( '.cmb-repeatable-grouping[data-iterator="' + data.index + '"]' ).find( '.cmb-type-mashups-load-panel' );
			load_log = load_panel.find( '.mashup-load-status > ol' );
			load_log.empty();

			//Sanity check
			if ( typeof response.error !== 'undefined' ) {
				load_log.html( '<li class="gmb-error">' + response.error + '</li>' );
				ajax_spinner.hide(); //hide spinner
				return false; //bounce
			}

			//First clear markers
			app.clear_mashup_markers( data.index );
			//Then create new index for this array
			markers[data.index] = [];
			featured_img = $( '#gmb_mashup_group_' + data.index + '_featured_img1' ).prop( 'checked' );

			//Loop through marker data
			$.each( response, function ( index, value ) {
				app.set_mashup_marker( data.index, value );
			} );

			//Set mashup as configured
			load_panel.find( '#mashup_configured' ).val( true ); //hidden field
			load_panel.find( 'button' ).removeClass( 'button-primary' ).attr( 'disabled', 'disabled' ).text( gmb_mashup.i18n.mashup_configured ); //button
			ajax_spinner.hide(); //hide spinner

		}, 'json' );

	};

	/**
	 * Set Mashup Marker
	 *
	 * @description: Used in foreach loop to place markers
	 * @param mashup_index
	 * @param marker_data
	 * @param loop_index
	 */
	app.set_mashup_marker = function ( mashup_index, marker_data, loop_index ) {

		title = (typeof marker_data.title !== 'undefined' ? marker_data.title : '');
		address = (typeof marker_data.address !== 'undefined' ? marker_data.address : '');
		lat = (typeof marker_data.latitude !== 'undefined' ? marker_data.latitude : '');
		lng = (typeof marker_data.longitude !== 'undefined' ? marker_data.longitude : '');
		var marker_position = new google.maps.LatLng( lat, lng );

		if ( !lat || !lng ) {
			var error = '<li class="gmb-marker-status gmb-error"><strong>Marker Error:</strong> ' + title + ' - No latitude or longitude values found for this post.</li>';
			load_log.html( load_log.html() + error );
			return; //this is equivalent of 'continue' for jQuery loop
		} else if ( typeof lat !== 'string' || typeof lng !== 'string' ) {
			error = '<li class="gmb-marker-status gmb-error"><strong>Marker Error:</strong> ' + title + ' - Improperly formatted latitude or longitude field data detected.</li>';
			load_log.html( load_log.html() + error );
			return; //this is equivalent of 'continue' for jQuery loop
		}

		var marker_icon = gmb_data.default_marker;
		var marker_label = '';

		//check for custom marker and label data
		var custom_marker_icon = $( '#gmb_mashup_group_' + mashup_index + '_marker' ).val();
		var custom_marker_img = $( '#gmb_mashup_group_' + mashup_index + '_marker_img' ).val();

		if ( custom_marker_img ) {
			marker_icon = custom_marker_img;
		} else if ( custom_marker_icon.length > 0 && custom_marker_icon.length > 0 ) {
			var custom_label = $( '#gmb_mashup_group_' + mashup_index + '_label' ).val();
			marker_icon = eval( "(" + custom_marker_icon + ")" );
			marker_label = custom_label;
		}

		// make and place map maker.
		var marker = new Marker( {
			map         : window.map,
			position    : marker_position,
			marker_data : marker_data,
			featured_img: featured_img,
			icon        : marker_icon,
			custom_label: marker_label
		} );

		//Update status
		if ( marker ) {
			var status = '<li class="gmb-marker-status gmb-loaded"><strong>Marker Loaded:</strong> ' + title + ' - Lat: ' + lat + ' Lng: ' + lng + '</liv>';
			load_log.html( load_log.html() + status );
		}

		//Set click action for marker to open infowindow
		google.maps.event.addListener( marker, 'click', function () {
			app.get_infowindow_content( marker );
		} );

		markers[mashup_index].push( marker ); //Add to markers array

	};

	/**
	 * Get Mashup Infowindow Content
	 * @description: Retrieves the marker content via AJAX request
	 *
	 */
	app.get_infowindow_content = function ( marker ) {

		info_bubble.setContent( '<div id="infobubble-content" class="loading"></div>' );

		info_bubble.open( map, marker );

		var data = {
			action      : 'get_mashup_marker_infowindow',
			marker_data : marker.marker_data,
			featured_img: marker.featured_img
		};

		jQuery.post( ajaxurl, data, function ( response ) {

			info_bubble.setContent( response.infowindow );

		}, 'json' );


	};


	/**
	 * Clear Mashup Markers
	 *
	 * @param mashup_index
	 */
	app.clear_mashup_markers = function ( mashup_index ) {

		//Only clear if there are markers
		if ( typeof markers[mashup_index] === 'undefined' ) {
			return;
		}

		//Loop through and clear
		for ( var i = 0; i < markers[mashup_index].length; i++ ) {
			markers[mashup_index][i].setMap( null );
		}

	};

	/**
	 * Set Mashup Marker Icon
	 * @description: Configures a mashup group's marker icon
	 */
	app.set_mashup_marker_icon = function () {

		//Get this marker index
		var index = $( this ).parents( '.cmb-repeatable-grouping' ).data( 'iterator' );

		$( 'body' ).find( '.save-marker-button' ).attr( 'data-marker-index', index ).on( 'click', function ( e ) {

			//Set marker fields in mashup group
			//@TODO: This is the same as admin-google-maps.js Line ~700 - CLEAN IT UP!
			e.preventDefault();
			var marker_icon = $( this ).data( 'marker' );
			var marker_icon_color = $( this ).data( 'marker-color' );
			var label_color = $( this ).data( 'label-color' );
			var marker_icon_data;

			//Inline style for marker to set
			var marker_label_inline_style = 'color:' + label_color + '; ';
			if ( marker_icon === 'MAP_PIN' ) {
				marker_label_inline_style += 'font-size: 20px;position: relative; top: -3px;'; //position: relative; top: -44px; font-size: 24px;
			} else if ( marker_icon == 'SQUARE_PIN' ) {
				marker_label_inline_style += 'font-size: 20px;position: relative; top: 12px;';
			}

			//collect marker data from submit button
			var marker_label_data = '<i class="' + $( this ).data( 'label' ) + '" style="' + marker_label_inline_style + '"></i>';

			//Determine which type of marker to place
			if ( marker_icon == 'mapicons' || marker_icon == 'upload' || marker_icon == 'default' ) {
				marker_icon_data = $( this ).data( 'marker-image' );
				marker_label_data = ''; //no label here (img marker)
				$( '#gmb_mashup_group_' + index + '_marker_img' ).val( marker_icon_data ); //set marker image field
				$( '#gmb_mashup_group_' + index + '_marker', '#gmb_mashup_group_' + index + '_label' ).val( '' ); //clear other marker data
			}
			//custom SVG markers
			else if ( marker_icon == 'MAP_PIN' || marker_icon == 'SQUARE_PIN' ) {
				//maps-icon
				marker_icon_data = '{ path : ' + marker_icon + ', fillColor : "' + marker_icon_color + '", fillOpacity : 1, strokeColor : "", strokeWeight: 0, scale : 1 / 3 }';
				//Update fields with necessary data
				$( '#gmb_mashup_group_' + index + '_marker' ).val( marker_icon_data );
				$( '#gmb_mashup_group_' + index + '_label' ).val( marker_label_data );
				marker_icon_data = eval( '(' + marker_icon_data + ')' );
				$( '#gmb_mashup_group_' + index + '_marker_img' ).val( '' ); //set marker image field
			}

			//Clear map icons
			app.clear_mashup_markers( index );

			//Get our AJAX data
			var data = app.setup_marker_ajax_request( index );

			//Now load up the markers
			app.load_mashup( data );

			//Clean up modal and close
			$( '.icon, .marker-item' ).removeClass( 'marker-item-selected' ); //reset modal
			$( '.marker-icon-row, .save-marker-icon' ).hide(); //reset modal
			$( this ).removeData( 'marker' ); //Remove data
			$( this ).removeData( 'marker-color' ); //Remove data
			$( this ).removeData( 'marker-img' ); //Remove data
			$( this ).removeData( 'label' ); //Remove data
			$( this ).removeData( 'label-color' ); //Remove data
			if ( $( '.magnific-builder' ).length === 0 ) {
				$.magnificPopup.close(); // Close popup that is currently opened (shorthand)
			} else {
				$( '.gmb-modal-close' ).trigger( 'click' );
			}

		} );

		return false;

	};


	//Get it started
	$( document ).ready( app.init );

	return app;

})( window, document, jQuery );
