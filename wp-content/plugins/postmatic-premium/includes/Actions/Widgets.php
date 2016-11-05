<?php
namespace Postmatic\Premium\Actions;

use Postmatic\Premium\Sidebars;

/**
 * Widgets and sidebar actions
 * @since 0.2.0
 */
class Widgets {

	/**
	 * Register widgets and sidebars.
	 * @since 0.2.0
	 */
	public static function init() {

		if ( \Prompt_Core::$options->get( 'enable_post_delivery' ) or \Prompt_Core::$options->get( 'enable_digests' ) ) {
			Sidebars\Header::register();
		}

		if ( \Prompt_Core::$options->get( 'enable_post_delivery' ) ) {
			Sidebars\Sidebar::register();
		}

		$is_widget_footer = ( \Prompt_Enum_Email_Footer_Types::WIDGETS == \Prompt_Core::$options->get( 'email_footer_type' ) );

		if ( $is_widget_footer ) {
			Sidebars\Footer::register();
		}

		if ( $is_widget_footer and \Prompt_Core::$options->get( 'enable_comment_delivery' ) ) {
			Sidebars\Comment_Footer::register();
		}

		if ( $is_widget_footer and \Prompt_Core::$options->get( 'enable_digests' ) ) {
			Sidebars\Digest_Footer::register();
		}

		$bsa_options = \Prompt_Core::$options->get( 'buy_sell_ads_options' );

		if ( \Prompt_Core::$options->get( 'enable_buy_sell_ads' ) and ! empty( $bsa_options['site_key'] ) ) {
			register_widget( 'Postmatic\Premium\Widgets\Buy_Sell_Ads' );
		}
	}

}