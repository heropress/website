<?php
namespace Postmatic\Premium\Admin\Options_Tabs;

use Postmatic\Premium\Models;

/**
 * Email template options for labs and premium
 * @since 0.5.0
 */
class Email_Template extends \Prompt_Admin_Email_Options_Tab {

	/**
	 * @since 0.5.0
	 */
	public function page_head() {
		parent::page_head();

		$script = new Models\Script( array(
			'handle' => 'postmatic-email-options-tab',
			'path' => 'js/email-options-tab.js',
			'dependencies' => array( 'jquery' ),
		) );

		$script->enqueue();

		$script->localize(
			'postmatic_email_options_env',
			array( 'email_header_image_prompt' => __( 'Choose an email header image', 'postmatic-premium' ) )
		);
	}

	/**
	 * @since 0.5.0
	 * @param array $new_data
	 * @param array $old_data
	 * @return array
	 */
	public function validate( $new_data, $old_data ) {

		$valid_data = parent::validate( $new_data, $old_data ); 
		$valid_data = $this->validate_checkbox_fields( $new_data, $valid_data, array( 'email_footer_credit' ) );

		if ( isset( $new_data['custom_css'] ) and $new_data['custom_css'] != $old_data['custom_css'] ) {
			$valid_data['custom_css'] = wp_filter_kses( $new_data['custom_css'] );
		}
		
		$header_type_reflect = new \ReflectionClass( 'Prompt_Enum_Email_Header_Types' );
		$header_types = array_values( $header_type_reflect->getConstants() );

		if ( isset( $new_data['email_header_type'] ) and in_array( $new_data['email_header_type'], $header_types ) ) {
			$valid_data['email_header_type'] = $new_data['email_header_type'];
		}

		if ( isset( $new_data['email_header_image'] ) ) {
			$valid_data['email_header_image'] = absint( $new_data['email_header_image'] );
		}

		$footer_type_reflect = new \ReflectionClass( 'Prompt_Enum_Email_Footer_Types' );
		$footer_types = array_values( $footer_type_reflect->getConstants() );

		if ( isset( $new_data['email_footer_type'] ) and in_array( $new_data['email_footer_type'], $footer_types ) ) {
			$valid_data['email_footer_type'] = $new_data['email_footer_type'];
		}

		return $valid_data;
	}

	/**
	 * @since 0.5.0
	 * @return array
	 */
	protected function get_rows() {
		$rows = parent::get_rows();

		if ( !\Prompt_Core::$options->is_api_transport() ) {
			return $rows;
		}

		return array(
			$rows[0],
			$this->custom_css_row(),
			$this->header_type_row(),
			$this->header_image_row(),
			$rows[1],
			$this->site_icon_row(),
			$this->footer_type_row(),
			$this->configure_widgets_row(),
			$this->footer_credit_row(),
			$rows[2],
			$rows[3]
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function custom_css_row() {
		return html(
			'tr',
			html( 
				'th scope="row"',
				__( 'Custom CSS', 'postmatic-premium' ),
				'<br/>',
				html( 
					'small',
					sprintf(
						__( 
							'You can add your own CSS to the email template. We have <a href="%s">an online guide</a> to selectors.', 
							'postmatic-premium' 
						),
						'http://docs.gopostmatic.com/article/230-how-to-add-custom-css-to-your-postmatic-template'
					)
				)
			),
			html(
				'td',
				$this->input(
					array(
						'type' => 'textarea',
						'name' => 'custom_css',
						'extra' => array( 'rows' => 5, 'cols' => 72 ),
					),
					$this->options->get
				)
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function header_type_row() {
		return $this->row_wrap(
			__( 'Email header type', 'postmatic-premium' ),
			$this->input(
				array(
					'type' => 'radio',
					'name' => 'email_header_type',
					'choices' => array(
						\Prompt_Enum_Email_Header_Types::IMAGE => __( 'Image', 'postmatic-premium' ),
						\Prompt_Enum_Email_Header_Types::TEXT => __( 'Text', 'postmatic-premium' ),
					),
				),
				$this->options->get()
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function header_image_row() {

		$email_header_image = new \Prompt_Attachment_Image( $this->options->get( 'email_header_image' ) );

		return html(
			'tr class="email-header-image"',
			html( 'th scope="row"',
				__( 'Email header image', 'postmatic-premium' ),
				'<br/>',
				html( 'small',
					__(
						'Choose a header image to be used when sending new posts, digests, letters, invitations, and subscription confirmations. Will be displayed at half the size of your uploaded image to support retina displays. The ideal width to fill the full header area is 1440px wide.',
						'postmatic-premium'
					)
				)
			),
			html(
				'td',
				html(
					'img',
					array(
						'src' => $email_header_image->url(),
						'width' => $email_header_image->width() / 2,
						'height' => $email_header_image->height() / 2,
						'class' => 'alignleft',
					)
				),
				html(
					'div class="uploader"',
					$this->input(
						array( 'name' => 'email_header_image', 'type' => 'hidden' ),
						$this->options->get()
					),
					html(
						'input class="button" type="button" name="email_header_image_button"',
						array( 'value' => __( 'Change', 'postmatic-premium' ) )
					)
				)
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function site_icon_row() {
		return html(
			'tr class="site-icon"',
			html( 'th scope="row"',
				__( 'Site icon', 'postmatic-premium' ),
				'<br/>',
				html( 'small',
					__(
						'This is based on your site\'s favicon, and used in comment notifications in place of the header image.',
						'postmatic-premium'
					)
				)
			),
			html(
				'td',
				html(
					'img',
					array(
						'src' => \Prompt_Site_Icon::url(),
						'width' => 32,
						'height' => 32,
						'class' => 'alignleft',
					)
				),
				html(
					'div',
					html(
						'a',
						array( 'href' => admin_url( 'customize.php?autofocus[control]=site_icon' ) ),
						__( 'Change in the customizer', 'postmatic-premium' )
					)
				)
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function footer_type_row() {
		return $this->row_wrap(
			__( 'Enable Widgets', 'postmatic-premium' ),
			$this->input(
				array(
					'type' => 'radio',
					'name' => 'email_footer_type',
					'choices' => array(
						\Prompt_Enum_Email_Footer_Types::WIDGETS => __( 'Yes, use widgets in my Postmatic template', 'postmatic-premium' ),
						\Prompt_Enum_Email_Header_Types::TEXT => __( 'No widgets', 'postmatic-premium' )
					),
				),
				$this->options->get()
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function configure_widgets_row() {
		return html(
			'tr class="email-footer-widgets"',
			html( 'th scope="row"', __( 'Configure Widgets', 'postmatic-premium' ) ),
			html(
				'td',
				__( 'You can define widgets for your footer at ', 'postmatic-premium' ),
				html(
					'a',
					array( 'href' => admin_url( 'widgets.php' ) ),
					__( 'Appearance > Widgets', 'postmatic-premium' )
				)
			)
		);
	}

	/**
	 * @since 0.5.0
	 * @return string
	 */
	protected function footer_credit_row() {
		return html(
			'tr class="email-footer-credit"',
			html( 'th scope="row"', __( 'Share the love?', 'postmatic-premium' ) ),
			html(
				'td',
				$this->input(
					array(
						'name' => 'email_footer_credit',
						'type' => 'checkbox',
						'desc' => __( 'Include "Delivered by Postmatic" in the footer area. We appreciate it!', 'postmatic-premium' ),
						'extra' => 'class=last-submit',
					),
					$this->options->get()
				)
			)
		);
	}

}
