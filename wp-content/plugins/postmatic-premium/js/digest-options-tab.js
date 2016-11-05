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

(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/m2mvuw7l';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()