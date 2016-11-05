<?php
namespace Postmatic\Premium\Filters;

/**
 * Filter new post email template data.
 * @since 0.2.0
 */
class Post_Email_Batch {

	/**
	 * Add extra content like featured image.
	 * @since 0.2.0
	 * @param array $data
	 * @param \Prompt_Post_Rendering_Context $context
	 * @return array Modified template data
	 */
	public static function template_data( $data, \Prompt_Post_Rendering_Context $context ) {

		if ( \Prompt_Enum_Email_Transports::LOCAL == \Prompt_Core::$options->get( 'email_transport' ) ) {
			return $data;
		}

		$featured_image_src = $context->get_the_featured_image_src();

		if ( $featured_image_src ) {
			$data['after_title_content'] .= sprintf(
				'<img src="%1$s" width="%2$d" alt="featured image" class="aligncenter featured"/>',
				$featured_image_src[0],
				$featured_image_src[1] / 2
			);
		}

		$data['after_post_content'] = '';

		return $data;
	}
}