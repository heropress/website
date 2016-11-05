<?php
/**
 *  CMB2 Custom Select field for CPTs
 *
 * @description:
 * @author     :  Devin Walker
 * @copyright  : http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      : 2.0
 */
//render multicheck-posttype
add_action( 'cmb2_render_select_posttype', 'gmb_cmb_render_select_posttype', 10, 5 );

function gmb_cmb_render_select_posttype( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$cpts = get_post_types();
	$options = '';

	unset( $cpts['nav_menu_item'] );
	unset( $cpts['revision'] );
	unset( $cpts['edd_log'] );
	unset( $cpts['edd_discount'] );
	unset( $cpts['deprecated_log'] );

	if ( $cpts ) {
		foreach ( $cpts as $cpt ) {

			$cpt_object = get_post_type_object( $cpt );

			$options .= $field_type_object->select_option( array(
				'label'   => $cpt_object->labels->name . ' (' . $cpt . ')',
				'value'   => $cpt,
				'checked' => $escaped_value == $cpt,
			) );
		}
	}

	echo $field_type_object->select( array( 'options' => $options ) );

}
