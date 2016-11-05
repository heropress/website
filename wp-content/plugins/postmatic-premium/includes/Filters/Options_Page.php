<?php
namespace Postmatic\Premium\Filters;

use Postmatic\Premium\Admin\Options_Tabs;

/**
 * Filter basic options page items.
 * @since 0.5.0
 */
class Options_Page {

	/**
	 * Add premium tabs to the basic ones in hard-coded order.
	 *
	 * @since 0.5.0
	 * @param \Prompt_Admin_Options_Tab[] $tabs
	 * @return \Prompt_Admin_Options_Tab[]
	 */
	public static function tabs( $tabs ) {

		$new_tabs = array();

		foreach( $tabs as $tab ) {
			$new_tabs[] = $tab;
			static::maybe_append_tab( $new_tabs );
		}

		return $new_tabs;
	}

	/**
	 * Look at the last tab in a list and decide whether to replace it or add our tabs after it. May change the passed array.
	 * @since 0.5.0
	 * @param \Prompt_Admin_Options_Tab[] $tabs
	 */
	protected static function maybe_append_tab( &$tabs ) {

		$last_tab = $tabs[count($tabs)-1];

		if ( $last_tab instanceof \Prompt_Admin_Email_Options_Tab and \Prompt_Core::$options->is_api_transport() ) {
			array_pop( $tabs );
			$tabs[] = new Options_Tabs\Email_Template( \Prompt_Core::$options );
		}
		
		if ( $last_tab instanceof \Prompt_Admin_Comment_Options_Tab and \Prompt_Core::$options->is_api_transport() ) {
			array_pop( $tabs );
			$tabs[] = new Options_Tabs\Comments( \Prompt_Core::$options );
		}
		
		if ( $last_tab instanceof \Prompt_Admin_Email_Options_Tab  ) {
			$tabs[] = new Options_Tabs\Invite( \Prompt_Core::$options );
		}

		if ( $last_tab instanceof \Prompt_Admin_Post_Options_Tab and static::on_digest_plan() ) {
			array_pop( $tabs );
			$tabs[] = new Options_Tabs\Posts( \Prompt_Core::$options );
		}

		if ( $last_tab instanceof \Prompt_Admin_Post_Options_Tab ) {
			$tabs[] = new Options_Tabs\Digest( \Prompt_Core::$options );
		}

		if ( $last_tab instanceof \Prompt_Admin_Comment_Options_Tab ) {
			$tabs[] = new Options_Tabs\Webhooks( \Prompt_Core::$options );
			$tabs[] = new Options_Tabs\Skimlinks( \Prompt_Core::$options );
		}
	}

	/**
	 * @since 0.5.0
	 * @return bool
	 */
	protected static function on_digest_plan() {
		return in_array( \Prompt_Enum_Message_Types::DIGEST, \Prompt_Core::$options->get( 'enabled_message_types' ) );
	}
}