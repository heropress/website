<?php
/**
 * Plugin Name:		  HeroPress Contributor Map
 * Plugin URI:		  http://heropress.com/
 * Description:		  Renders a map of contributors
 * Version:			  1.0
 * Author:			  Topher
 * Author URI:		  http://topher1kenobe.com/
 * Text Domain:		  contributor-map
 * License:			  GPL-2.0+
 * License URI:		  http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:		  /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function heropress_get_map_points() {

	$args = [
		'post_type'   => 'hp-contributors',
		'nopaging'    => true,
		'post_status' => 'publish',
	];

	// The Query
	$the_query = new WP_Query( $args );

	p2p_type( 'essays_to_contributors' )->each_connected( $the_query );

	$contributors = [];

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$post = $the_query->post;

			$meta = get_post_custom( $post->ID );

			$connected_post = $post->connected[0];

			$contributors[ $meta['_gmb_place_id'][0] ]['lat']  = $meta['_gmb_lat'][0];
			$contributors[ $meta['_gmb_place_id'][0] ]['lng']  = $meta['_gmb_lng'][0];
			$contributors[ $meta['_gmb_place_id'][0] ]['city'] = $meta['_gmb_address'][0];

			// get the image thumbnail src
			$thumbail_data = wp_get_attachment_image_src( get_post_thumbnail_id() );

			$contributors[ $meta['_gmb_place_id'][0] ]['contributors'][ get_the_id() ] = [
				'name'        => get_the_title(),
				'essay_title' => get_the_title( $connected_post->ID ),
				'essay_url'   => get_the_permalink( $connected_post->ID ),
				'thumbnail'   => $thumbail_data[0],
			];

		}
		/* Restore original Post Data */
		wp_reset_postdata();
	}

	return $contributors;
}

function contributor_map() {

	$locations = heropress_get_map_points();

	ob_start();
?>
    <style>
#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}

.info_content .contributor {
	min-width: 300px;
	clear: left;
}
.info_content img {
	margin: 6px 6px 6px 0;
	float: left;
}
.info_content h4 {
	margin: 0;
	padding: 0;
	clear: none;
}
.info_content h5 {
	text-transform: none;
	letter-spacing: 0;
	margin: 0 0 4px 0;
	clear: none;
}
.info_content p {
	margin: 0;
	clear: none;
}
    </style>
<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>
<script>
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?sensor=false&callback=initialize&key=AIzaSyBCBvv8XViSQ1LCqZsYPuHvy2S9wMCnve4";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);

        
    // Multiple Markers
    var markers = [
<?php
		foreach ( $locations as $location ) {
			echo "['" . $location['city'] . "', " . $location['lat'] . "," . $location['lng'] . "]," . "\n";
		}
?>
    ];
                        
    // Info Window Content
    var infoWindowContent = [
<?php

		foreach ( $locations as $location ) {
			echo "['<div class=\"info_content\">' +";

			echo "'<h4>" . $location['city'] . "</h4>' +" . "\n";

			foreach ( $location['contributors'] as $key => $contributor ) {

				echo "'<div class=\"contributor\">' +" . "\n";
				echo "'<a href=\"" . $contributor['essay_url'] . "\"><img src=\"" . $contributor['thumbnail'] . "\" alt=\"Photo of " . $contributor['name'] . "\" width=\"50\"></a>' +" . "\n";
				echo "'<h5><a href=\"" . $contributor['essay_url'] . "\">" . $contributor['name'] . "</h5>' +" . "\n";
				echo "'<p><a href=\"" . $contributor['essay_url'] . "\">" . $contributor['essay_title'] . "</p>' +" . "\n";
				echo "'</div>' +" . "\n";

			}
			echo "'</div>']," . "\n";
		}

?>
        ['<div class="info_content">' +
        '<h3>London Eye</h3>' +
        '<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' +        '</div>'],
        ['<div class="info_content">' +
        '<h3>Palace of Westminster</h3>' +
        '<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
        '</div>']
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
			icon: '<?php echo plugin_dir_url( __FILE__ ); ?>heropress-google-map-pin.png'
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));



    }

 	map.setZoom(1); 
	map.setCenter(new google.maps.LatLng(24, -1));
}
    </script>
<?php
	$output = trim( ob_get_clean() );

	return $output;
}
add_shortcode( 'contributor_map', 'contributor_map' );

function gmp_dequeue_script() {
	wp_dequeue_script( 'google-maps-builder-gmaps' );
	wp_dequeue_script( 'google-maps-builder-plugin-script' );
	wp_dequeue_script( 'google-maps-builder-maps-icons' );
	wp_dequeue_script( 'google-maps-builder-clusterer' );
	wp_dequeue_script( 'google-maps-builder-infobubble' );
}
add_action( 'wp_print_scripts', 'gmp_dequeue_script', 100 );
