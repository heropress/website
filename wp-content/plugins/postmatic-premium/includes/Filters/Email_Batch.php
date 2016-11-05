<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Sidebars;

/**
 * Filter email batch values.
 * @since 0.2.0
 */
class Email_Batch {

	/**
	 * Add widget content to email headers.
	 *
	 * @since 0.2.0
	 * @param string $html
	 * @param string $message_type
	 * @return string
	 */
	public static function header_html( $html, $message_type = '' ) {

		$header_message_types = array(
			\Prompt_Enum_Message_Types::POST,
			\Prompt_Enum_Message_Types::DIGEST,
		);

		if ( ! in_array( $message_type, $header_message_types ) ) {
			return $html;
		}

		return Sidebars\Header::render_html();
	}

	/**
	 * Add widget content to email sidebars.
	 *
	 * @since 0.2.0
	 * @param string $html
	 * @param string $message_type
	 * @return string
	 */
	public static function sidebar_html( $html, $message_type = '' ) {

		if ( \Prompt_Enum_Message_Types::POST != $message_type ) {
			return $html;
		}

		return Sidebars\Sidebar::render_html();
	}

	/**
	 * Add widget content to email footers.
	 *
	 * @since 0.2.0
	 * @param string $html
	 * @param string $message_type
	 * @return string
	 */
	public static function footer_html( $html, $message_type = '' ) {

		if ( \Prompt_Enum_Email_Footer_Types::WIDGETS != \Prompt_Core::$options->get( 'email_footer_type' ) ) {
			return $html;
		}

		if ( \Prompt_Enum_Message_Types::DIGEST == $message_type ) {
			return Sidebars\Digest_Footer::render_html();
		}

		$comment_message_types = array(
			\Prompt_Enum_Message_Types::COMMENT_MODERATION,
			\Prompt_Enum_Message_Types::COMMENT
		);

		if ( in_array( $message_type, $comment_message_types ) ) {
			return Sidebars\Comment_Footer::render_html();
		}

		return Sidebars\Footer::render_html();
	}

	/**
	 * Buffer and return output from the old print styles action.
	 * @since 0.5.0
	 * @param string $css
	 * @return string
	 */
	public static function integration_css( $css ) {
		ob_start();
		do_action( 'prompt/html_email/print_styles' );
		return $css . ob_get_clean() . \Prompt_Core::$options->get( 'custom_css' );
	}
}