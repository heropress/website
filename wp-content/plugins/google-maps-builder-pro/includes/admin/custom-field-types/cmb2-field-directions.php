<?php
/**
 * Render 'destination' custom field type
 *
 * @since 2.0
 *
 * @param array  $field              The passed in `CMB2_Field` object
 * @param mixed  $value              The value of this field escaped.
 *                                   It defaults to `sanitize_text_field`.
 *                                   If you need the unescaped value, you can access it
 *                                   via `$field->value()`
 * @param int    $object_id          The ID of the current object
 * @param string $object_type        The type of object you are working with.
 *                                   Most commonly, `post` (this applies to all post-types),
 *                                   but could also be `comment`, `user` or `options-page`.
 * @param object $field_type_object  The `CMB2_Types` object
 */
function gmb_cmb2_render_destination_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	// can override via the field options param
	// make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
		'destination' => '',
		'latitude'    => '',
		'longitude'   => '',
		'place_id'    => '',
		'address'     => ''
	) );

	$letters = array(
		0  => 'A',
		1  => 'B',
		2  => 'C',
		3  => 'D',
		4  => 'E',
		5  => 'F',
		6  => 'G',
		7  => 'H',
		8  => 'I',
		9  => 'J',
		10 => 'K',
		11 => 'L',
		12 => 'M'
	);
	?>
	<div class="gmb-destination-fieldset clear" data-iterator="<?php echo $field_type_object->iterator; ?>">
		<?php
		//Show default pin when setting new directions row
		if ( empty( $value['destination'] ) ) { ?>
			<img src="<?php echo GMB_PLUGIN_URL . 'assets/img/spotlight-poi.png' ?>" class="gmb-directions-marker">
		<?php } //if set show marker with "A", "B", destination points
		else { ?>
			<img src="https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-waypoint-b.png&text=<?php echo( isset( $letters[ $field_type_object->iterator ] ) ? $letters[ $field_type_object->iterator ] : '' ); ?>&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1" class="gmb-directions-marker">
		<?php } ?>

		<div class="destination-autocomplete">
			<?php echo $field_type_object->input( array(
				'class'       => 'gmb-directions-autocomplete',
				'name'        => $field_type_object->_name( '[destination]' ),
				'id'          => $field_type_object->_id( '_destination' ),
				'value'       => $value['destination'],
				'placeholder' => __( 'Enter a location', Google_Maps_Builder()->get_plugin_slug() )
			) ); ?>
		</div>
		<div class="destination-longitude">
			<?php echo $field_type_object->input( array(
				'class'       => 'gmb-directions-longitude',
				'name'        => $field_type_object->_name( '[longitude]' ),
				'id'          => $field_type_object->_id( '_longitude' ),
				'value'       => $value['longitude'],
				'readonly'    => 'readonly',
				'placeholder' => __( 'Longitude', Google_Maps_Builder()->get_plugin_slug() ),
			) ); ?>
		</div>
		<div class="destination-latitude">
			<?php echo $field_type_object->input( array(
				'class'       => 'gmb-directions-latitude',
				'name'        => $field_type_object->_name( '[latitude]' ),
				'id'          => $field_type_object->_id( '_latitude' ),
				'value'       => $value['latitude'],
				'readonly'    => 'readonly',
				'placeholder' => __( 'Latitude', Google_Maps_Builder()->get_plugin_slug() ),
			) ); ?>
		</div>
		<div class="destination-place-id">
			<?php echo $field_type_object->input( array(
				'class'    => 'gmb-directions-place_id',
				'name'     => $field_type_object->_name( '[place_id]' ),
				'id'       => $field_type_object->_id( '_place_id' ),
				'value'    => $value['place_id'],
				'readonly' => 'readonly',
			) ); ?>
		</div>
		<div class="destination-address">
			<?php echo $field_type_object->input( array(
				'class'       => 'gmb-directions-address',
				'name'        => $field_type_object->_name( '[address]' ),
				'id'          => $field_type_object->_id( '_address' ),
				'value'       => $value['address'],
				'type'        => 'text',
				'readonly'    => 'readonly',
				'placeholder' => __( 'No Address Set', Google_Maps_Builder()->get_plugin_slug() ),
			) ); ?>
		</div>
	</div>
	<?php
	//	echo $field_type_object->_desc( true );

}

add_filter( 'cmb2_render_destination', 'gmb_cmb2_render_destination_field_callback', 10, 5 );


/**
 * The following snippets are required for allowing the address field
 * to work as a repeatable field, or in a repeatable group
 */
function cmb2_sanitize_destination_field( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {

	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		if ( '' == $val['destination'] ) {
			unset( $meta_value[ $key ] );
		} else {
			$meta_value[ $key ] = array_map( 'sanitize_text_field', $val );
		}
	}

	return $meta_value;
}

add_filter( 'cmb2_sanitize_destination', 'cmb2_sanitize_destination_field', 10, 5 );

function cmb2_types_esc_destination_field( $check, $meta_value, $field_args, $field_object ) {
	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		$meta_value[ $key ] = array_map( 'esc_attr', $val );
	}

	return $meta_value;
}

add_filter( 'cmb2_types_esc_destination', 'cmb2_types_esc_destination_field', 10, 4 );
