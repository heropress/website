<?php
namespace Postmatic\Premium\Admin\Options_Tabs;

use Postmatic\Premium\Core;
use Postmatic\Premium\Models\Script;

/**
 * @since 0.1.0
 */
class Webhooks extends \Prompt_Admin_Options_Tab {

	

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function name() {
		return __( 'Webhooks', 'postmatic-premium' );
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function slug() {
		return 'webhooks';
	}

	/**
	 * @since 0.1.0
	 * @return string tab HTML
	 */
	public function render() {

		$webhooks_urls = \Prompt_Core::$options->get( 'webhooks_urls' );
		
		$table_entries = array(
			array(
				'title' => __( 'Subscribe Webhook URL:', 'postmatic-premium' ),
				'type' => 'text',
				'name' => 'webhooks_urls[subscribe]',
				'desc' => __( 'Enter the Webhook URL to inform on subscriptions', 'postmatic-premium' ),
				'value' => (isset($webhooks_urls['subscribe']) ? $webhooks_urls['subscribe'] : '')
					
			),
			array(
				'title' => __( 'Unsubscribe Webhook URL:', 'postmatic-premium' ),
				'type' => 'text',
				'name' => 'webhooks_urls[unsubscribe]',
				'desc' => __( 'Enter the Webhook URL to inform when someone unsubscribes', 'postmatic-premium' ),
				'value' => (isset($webhooks_urls['unsubscribe']) ? $webhooks_urls['unsubscribe'] : '')
			),
			array(
				'title' => __( 'Test URLs', 'postmatic-premium' ),
				'type' => 'button',
				'name' => 'webhooks_urls_test',
				'class' => 'button',
				'desc' => __( 'Press the button to send a test Webhook', 'postmatic-premium' ),
				'value' => __( 'Send Test Webhook', 'postmatic-premium')
			)
		);
		
		$welcome_content = html(
			'div class="intro-text" id="webhooks"',
			html( 'h2', __( 'Webhooks', 'postmatic-premium' ) ),
			html( 'P',
				__(
					'Use Webhooks to send notifications of subscribes and unsubscribes to other platforms and services. The quickest way to get started is using a <strong>Catch Hook</strong> webhook via <a href="https://zapier.com/zapbook/webhook/" target="_blank">Zapier</a>. Need some ideas? <a href="https://gopostmatic.com/2016/03/sneak-peek-at-postmatic-2-0-support-for-optinmonster-and-500-other-apps/" target="_blank">Check out this blog post</a>.',
					'postmatic-premium'
				)
			)
		);
		
		return $welcome_content . $this->form_table( $table_entries );
	}

	/**
	 * @since 0.1.0
	 * @param array $new_data
	 * @param array $old_data
	 * @return array valid data
	 */
	function validate( $new_data, $old_data ) {
		
		$valid_data = array();
		
		if ( isset( $new_data['webhooks_urls']['subscribe'] ) ) {
			$valid_data['webhooks_urls']['subscribe'] = sanitize_text_field( $new_data['webhooks_urls']['subscribe'] );
		}
		if ( isset( $new_data['webhooks_urls']['unsubscribe'] ) ) {
			$valid_data['webhooks_urls']['unsubscribe'] = sanitize_text_field( $new_data['webhooks_urls']['unsubscribe'] );
		}

		return $valid_data;
		
	}
	
	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 2.0.0
	 */
	function page_head() {

		$script = new Script( array(
			'handle' => 'postmatic-webhooks-admin',
			'path' => 'js/webhooks-admin.js',
		) );

		$script->enqueue();

		$strings = array(
			'subscribe_hook' => __( 'Subscribe hook', 'postmatic-premium' ),
			'unsubscribe_hook' => __( 'Unsubscribe hook', 'postmatic-premium' ),
			'test_sent' => __( 'test sent', 'postmatic-premium' ),
			'test_failed' => __( 'Test failed', 'postmatic-premium' )
		);

		$script->localize( 'postmatic_premium_admin_functions', $strings );
	}
}