<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Matchers;
use Postmatic\Premium\Lists;

/**
 * Filter email footnote content.
 * @since 0.1.0
 */
class Footnote_Content {

	/**
	 * Add subscription switching prompts when appropriate.
	 * @since 0.1.0
	 * @param array $content HTML first, text second
	 * @param \Prompt_Interface_Subscribable $list
	 * @return array HTML first, text second
	 */
	public static function extra_welcome_footnote_content( $content, \Prompt_Interface_Subscribable $list ) {

		$html_parts = array( $content[0] );
		$text_parts = array( $content[1] );

		if ( $list instanceof \Prompt_Site and \Prompt_Core::$options->get( 'enable_digests' ) ) {
			list( $html_parts[], $text_parts[] ) = self::switch_to_digest_content();
		}

		if ( $list instanceof Lists\Digest and \Prompt_Core::$options->get( 'enable_post_delivery' ) ) {
			list( $html_parts[], $text_parts[] ) = self::switch_to_instant_content();
		}

		return array( implode( ' ', $html_parts ), implode( ' ', $text_parts ) );
	}

	/**
	 * Add subscription switching prompts when appropriate.
	 * @since 0.1.0
	 * @param array $content HTML first, text second
	 * @return array HTML first, text second
	 */
	public static function extra_post_footnote_content( $content ) {

		$html_parts = array( $content[0] );
		$text_parts = array( $content[1] );

		if ( \Prompt_Core::$options->get( 'enable_digests' ) ) {
			list( $html_parts[], $text_parts[] ) = self::switch_to_digest_content();
		}

		return array( implode( ' ', $html_parts ), implode( ' ', $text_parts ) );
	}

	/**
	 * @since 0.1.0
	 * @return array HTML and text content
	 */
	protected static function switch_to_instant_content() {

			$site_mailto = sprintf(
				'mailto:{{{reply_to}}}?subject=%s&body=%s',
				rawurlencode( __( 'Switch to instant post delivery', 'postmatic-premium' ) ),
				rawurlencode( \Prompt_Instant_Matcher::target() )
			);

			$site_format = __(
				'To receive new posts as soon as they are published, reply with the word \'%s\'.',
				'postmatic-premium'
			);

			$html = sprintf(
				$site_format,
				"<a href=\"$site_mailto\">" . \Prompt_Instant_Matcher::target() . '</a>'
			);
			$text = sprintf( $site_format, \Prompt_Instant_Matcher::target() );

		return array( $html, $text );
	}

	/**
	 * @since 0.1.0
	 * @return array HTML and text content
	 */
	protected static function switch_to_digest_content() {

		$digest_mailto = sprintf(
			'mailto:{{{reply_to}}}?subject=%s&body=%s',
			rawurlencode( __( 'Switch to digests', 'postmatic-premium' ) ),
			rawurlencode( Matchers\Digest::target() )
		);

		$digest_format = __( 'To receive fewer emails, reply with the word \'%s\'.', 'postmatic-premium' );

		$html = sprintf(
			$digest_format,
			"<a href=\"$digest_mailto\">" . Matchers\Digest::target() . '</a>'
		);

		$text = sprintf( $digest_format, Matchers\Digest::target() );

		return array( $html, $text );
	}
}