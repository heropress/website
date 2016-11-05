<?php
namespace Postmatic\Premium\Matchers;

/**
 * Determine if text is considered a digest subscribe request.
 * @since 0.1.0
 */
class Digest extends \Prompt_Matcher {
	/**
	 * @since 0.1.0
	 * @return string
	 */
	public static function target() {
		/* translators: this is the word used to switch to or select a digest subscription via email reply */
		return __( 'digest', 'postmatic-premium' );
	}

	/**
	 * @since 0.1.0
	 * @return boolean  Whether the text matches a subscribe request
	 */
	public function matches() {

		$pattern = '/^[\s\*\_]*(' . self::target() . '|geidst|digset)[\s\*\_]*/i';

		return (bool) preg_match( $pattern, $this->text );
	}

}