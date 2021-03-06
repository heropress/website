var jQuery, postmatic_email_options_env;

(function($) {
	
	$( init_email_tab );
	
	function init_email_tab() {
		var prompt_media_frame;

		$( 'input[name="email_header_image_button"]' ).on( 'click',  open_media_frame );

		var $email_header_types = $( 'input[name="email_header_type"]' ).on( 'change', show_email_header_type );
		show_email_header_type();

		var $email_footer_types = $( 'input[name="email_footer_type"]' ).on( 'change', show_email_footer_type );
		show_email_footer_type();

		function show_email_header_type() {
			var $radio_button = $email_header_types.filter(':checked' ),
				$image_row = $( 'tr.email-header-image' );

			if ( 'image' === $radio_button.val() ) {
				$image_row.show();
			} else {
				$image_row.hide();
			}
		}

		function show_email_footer_type() {
			var $radio_button = $email_footer_types.filter(':checked' ),
				$widgets_row = $( 'tr.email-footer-widgets' ),
				$text_row = $( 'tr.email-footer-text' );

			if ( 'widgets' === $radio_button.val() ) {
				$widgets_row.show();
				$text_row.hide();
			} else {
				$widgets_row.hide();
				$text_row.show();
			}
		}

		function init_media_frame() {
			return wp.media.frames.prompt_media_frame = wp.media( {
				title: postmatic_email_options_env.email_header_image_prompt,
				multiple: false,
				library: { type: 'image' }
			} ).on( 'select', set_email_header_image );
		}

		function open_media_frame( e ) {
			e.preventDefault();

			if ( !prompt_media_frame )
				prompt_media_frame = init_media_frame();

			prompt_media_frame.open();
		}

		function set_email_header_image() {
			var attachment = prompt_media_frame.state().get( 'selection' ).first().toJSON();
			$( 'input[name="email_header_image"]' ).val( attachment.id );
			$( 'tr.email-header-image img' ).attr( {
				src: attachment.url,
				height: attachment.height / 2,
				width: attachment.width / 2
			} );
		}
	}
	
}( jQuery ));