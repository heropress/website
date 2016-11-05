<?php
/**
 * @package Make
 */

$meta = get_post_custom();

$thumb_key    = 'layout-' . ttfmake_get_view() . '-featured-images';
$thumb_option = ttfmake_sanitize_choice( get_theme_mod( $thumb_key, ttfmake_get_default( $thumb_key ) ), $thumb_key );

// Footer
ob_start();
get_template_part( 'partials/entry', 'taxonomy' );
get_template_part( 'partials/entry', 'sharing' );
$entry_footer = trim( ob_get_clean() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php

// Find connected pages
$connected = new WP_Query( array(
  'connected_type' => 'essays_to_contributors',
  'connected_items' => get_post( get_the_ID() ),
  'nopaging' => true,
) );

// Display connected pages
if ( $connected->have_posts() ) :
?>
<?php while ( $connected->have_posts() ) : $connected->the_post();
	$essay_title = get_the_title();	
	$essay_url   = get_the_permalink();	
endwhile; ?>

<?php 
// Prevent weirdness
wp_reset_postdata();

endif;
?>
	<header class="entry-header">
		<a href="<?php echo esc_url( $essay_url ); ?>" alt="Photo of <?php the_title(); ?>">
		<?php
			if ( has_post_thumbnail() ) {

				$size = [260,260];

				$default_attr = array(
					'class' => 'alignleft',
					'alt'   => trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ) ),
				);

				the_post_thumbnail( $size, $default_attr );

			}
		?>
		</a>
		<?php the_title( '<h3>', '</h3>' ); ?>
	</header>

	<div class="entry-content">

		<h4><a href="<?php echo esc_url( $essay_url ); ?>"><?php echo esc_html( $essay_title ); ?></a></h4>

		<?php get_template_part( 'partials/entry', 'pagination' ); ?>
	</div>

	<?php if ( $entry_footer ) : ?>
	<footer class="entry-footer">
		<?php echo $entry_footer; ?>
	</footer>
	<?php endif; ?>
</article>
