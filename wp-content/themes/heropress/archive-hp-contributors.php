<?php
/**
 * @package Make
 */

get_header();
global $post;
?>

<?php ttfmake_maybe_show_sidebar( 'left' ); ?>

<main id="site-main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>

	<header class="section-header">
		<?php get_template_part( 'partials/contributors-section', 'title' ); ?>
		<?php get_template_part( 'partials/contributors-section', 'description' ); ?>
	</header>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		/**
		 * Allow for changing the template partial.
		 *
		 * @since 1.2.3.
		 *
		 * @param string     $type    The default template type to use.
		 * @param WP_Post    $post    The post object for the current post.
		 */
		$content_type = get_post_type( $post );

		if ( 'heropress-essays' == $content_type ) {
			$template_type = $content_type;
			} else {
			$template_type = apply_filters( 'make_template_content_archive', 'archive', $post );
		}

		if ( $content_type == 'hp-contributors' ) {
			$connected = do_shortcode( '[p2p_connected type=essays_to_contributors mode=inline]' );
			if ( ! empty( $connected ) ) {
				$template_type = $content_type;
			} else {
				$template_type = '';
			}
		}

		get_template_part( 'partials/content', $template_type );
		?>
	<?php endwhile; ?>

	<?php get_template_part( 'partials/nav', 'paging' ); ?>

<?php else : ?>
	<?php get_template_part( 'partials/content', 'none' ); ?>
<?php endif; ?>
</main>

<?php ttfmake_maybe_show_sidebar( 'right' ); ?>

<?php get_footer(); ?>
