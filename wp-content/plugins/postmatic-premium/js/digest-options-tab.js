var jQuery;

(function( $ ) {

	$( function() {

		$( '#digest-start-time' ).find( 'input' ).datetimepicker( {
			minDate: 0,
			format: 'M j, Y g:i a',
			formatTime: 'g:i a',
			step: 30,
		} );

		init_digests_tab();

	} );

	function init_digests_tab() {
		var $radio_inputs = $( '#prompt-settings-digests' ).find( 'input[name="digest_theme_slug"]' );
		$radio_inputs.change( update_active_theme );
		update_active_theme();

		function update_active_theme() {
			$radio_inputs.parent( 'label' ).removeClass( 'active' );
			$radio_inputs.filter( ':checked' ).parent( 'label' ).addClass( 'active' );
		}
	}

}( jQuery ) );
