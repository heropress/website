<?php
namespace Postmatic\Premium\Admin\Metaboxes;

use Postmatic\Premium\Lists;

/**
 * Digest post metabox
 * @since 0.3.0
 */
class Digest extends \scbPostMetabox {

	/**
	 * @since 0.3.0
	 * @var string
	 */
	protected static $exclude_name = 'postmatic_exclude_from_digests';

	/** @var Lists\Posts\Post */
	protected $post;

	/**
	 * Only show when digests are enabled.
	 * @since 0.3.0
	 * @return bool
	 */
	public function condition() {
		return \Prompt_Core::$options->get( 'enable_digests' );
	}

	/**
	 * @since 0.3.0
	 * @param object $post
	 */
	public function display( $post ) {
		$this->set_post( $post );
		echo $this->render_form();
	}

	/**
	 * @since 0.3.0
	 * @return string
	 */
	public function render_form() {
		$form_html = '';

		$form_html .= html( 'p',
			\scbForms::input(
				array(
					'type' => 'checkbox',
					'name' => static::$exclude_name,
					'desc' => __( 'Do not include this post in digests', 'postmatic-premium' ),
					'checked' => $this->post->get_exclude_from_digests(),
				)
			)
		);

		return $form_html;
	}

	/**
	 * @since 0.3.0
	 * @param int $post_id
	 */
	protected function save( $post_id ) {
		$this->set_post( $post_id );
		$this->post->set_exclude_from_digests( isset( $_POST[static::$exclude_name] ) );
	}

	/**
	 * @since 0.3.0
	 * @param $post
	 */
	protected function set_post( $post ) {
		$this->post = new Lists\Posts\Post( $post );
	}

}
