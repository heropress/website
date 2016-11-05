<?php
namespace Postmatic\Premium\Admin\Options_Tabs;

/**
 * @since 0.1.0
 */
class Skimlinks extends \Prompt_Admin_Options_Tab {

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function name() {
		return __( 'Configure Skimlinks', 'postmatic-premium' );
	}

	/**
	 * @since 0.1.0
	 * @return string
	 */
	public function slug() {
		return 'skimlinks';
	}

	/**
	 * @since 0.1.0
	 * @return string tab HTML
	 */
	public function render() {

		$table_entries = array(
			array(
				'title' => __( 'Enter your Skimlinks publication ID:', 'postmatic-premium' ),
				'type' => 'text',
				'name' => 'skimlinks_publisher_id',
				'desc' => sprintf(
					__( 'This can be found in your Skimlinks <a href="%s" target="_blank">Publisher Hub</a> in <em>account settings</em>.', 'postmatic-premium' ),
					'https://hub.skimlinks.com/account'
				),
			)
		);

		$welcome_content = html(
			'div class="intro-text" id="skimlinks"',
			html( 'span',
				__(
					'<img src="https://s3-us-west-2.amazonaws.com/postmatic/assets/admin-ui/skimlinks.gif">',
					'postmatic-premium'
				)
			),
			html( 'h2', __( 'Make Money on Your Content Without Selling Out', 'postmatic-premium' ) ),
			html( 'P',
				__(
					'We have wandered the depths of the internet for an affiliate-marketing solution that treats everyone fairly - and are happy to recommend <a href="http://go.skimlinks.com/?id=84105X1536110&xs=1&url=http://skimlinks.com">Skimlinks</a>.',
					'postmatic-premium'
				)
			),
			html( 'h3',
				__(
					'What is Skimlinks?',
					'postmatic-premium'
				)
			),
			html( 'P',
				__(
					'Skimlinks is a free service which makes it easy to generate income from your blog content. They convert links to products and services which you may be writing about into affiiliate links which you earn a commission on. It all happens automatically.',
					'postmatic-premium'
				)
			),
			html( 'P',
				__(
					'When using Skimlinks with Postmatic your affiliate links will be enabled in the emailed version of each post. If a reader clicks a link from your email and makes a purchase down the line, you\'ll get a part of that sale. Find out more  <a href="http://go.skimlinks.com/?id=84105X1536110&xs=1&url=http://skimlinks.com">by visiting Skimlinks</a>.',
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

		if ( ! empty( $new_data['skimlinks_publisher_id'] ) ) {
			$valid_data['skimlinks_publisher_id'] = sanitize_text_field( $new_data['skimlinks_publisher_id'] );
		}

		return $valid_data;
	}
}
