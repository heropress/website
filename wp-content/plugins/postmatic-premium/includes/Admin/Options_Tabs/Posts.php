<?php
namespace Postmatic\Premium\Admin\Options_Tabs;

/**
 * Add custom post types to the standard post options.
 * @since 0.5.0
 */
class Posts extends \Prompt_Admin_Post_Options_Tab {

	/**
	 * @since 0.5.0
	 * @param array $new_data
	 * @param array $old_data
	 * @return array
	 */
	public function validate( $new_data, $old_data ) {
		$valid_data = parent::validate( $new_data, $old_data );

		$post_types = isset( $new_data['site_subscription_post_types'] ) ? $new_data['site_subscription_post_types'] : array();

		if ( $post_types != $old_data['site_subscription_post_types'] ) {
			$valid_data['site_subscription_post_types'] = $this->sanitize_post_types( $post_types );
		}

		return $valid_data;
	}

	/**
	 * @since 0.5.0
	 * @return array
	 */
	protected function table_entries() {
		$table_entries = parent::table_entries();

		$table_entries[] = array(
			'title' => __( 'Post Types', 'postmatic-premium' ),
			'type' => 'checkbox',
			'name' => 'site_subscription_post_types',
			'choices' => $this->post_type_options(),
			'desc' => html( 'p',
				__( 'New posts of checked types will be sent to subscribers.', 'postmatic-premium' )
			),
		);

		$this->override_entries( $table_entries );

		return $table_entries;
	}

	/**
	 * @since 0.5.0
	 * @return array
	 */
	protected function post_type_options() {
		$post_types = get_post_types( array( 'show_ui' => true ), 'objects' );
		$post_type_options = array();

		foreach ( $post_types as $post_type ) {
			$post_type_options[$post_type->name] = $post_type->labels->name;
		}

		return $post_type_options;
	}

	/**
	 * @since 0.5.0
	 * @param $types
	 * @return array
	 */
	protected function sanitize_post_types( $types ) {
		$registered_types = array_keys( $this->post_type_options() );
		$valid_types = array();
		foreach ( $types as $type ) {
			if ( in_array( $type, $registered_types ) ) {
				$valid_types[] = $type;
			}
		}

		return $valid_types;
	}

}
