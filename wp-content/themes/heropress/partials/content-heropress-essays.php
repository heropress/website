<?php
/**
 * @package Make
 */

$meta = get_post_custom();

$thumb_key    = 'layout-' . ttfmake_get_view() . '-featured-images';
$thumb_option = ttfmake_sanitize_choice( get_theme_mod( $thumb_key, ttfmake_get_default( $thumb_key ) ), $thumb_key );

// Header
ob_start();
get_template_part( 'partials/entry', 'sticky' );
if ( 'post-header' === $thumb_option ) :
	get_template_part( 'partials/entry', 'thumbnail' );
endif;
get_template_part( 'partials/entry', 'title' );
get_template_part( 'partials/entry', 'meta-top' );
get_template_part( 'partials/entry', 'meta-before-content' );
$entry_header = trim( ob_get_clean() );

// Footer
//ob_start();
//get_template_part( 'partials/entry', 'meta-post-footer' );
//get_template_part( 'partials/entry', 'taxonomy' );
//get_template_part( 'partials/entry', 'sharing' );
//$entry_footer = trim( ob_get_clean() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
$related = p2p_type( 'essays_to_contributors' )->get_related( $post );
$contributor_id = $related->query['connected_items'][0];
?>
<a href="<?php the_permalink(); ?>">
<?php
	$contributor_image_attr = array(
		'class' => 'alignleft',
	);
	echo get_the_post_thumbnail( $contributor_id, array( 150, 150 ), $contributor_image_attr );
?>
</a>
	<?php if ( $entry_header ) : ?>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<p>
		<?php _e( 'Contributor', 'heropress' ); ?>: <?php echo get_the_title( $contributor_id ); ?>
		</p>
		<time class="entry-date published" datetime="<?php the_time( 'c' ); ?>"><?php _e( 'Published', 'heropress' ); ?>: <?php echo get_the_date(); ?></time>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php if ( 'thumbnail' === $thumb_option ) : ?>
			<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
		<?php endif; ?>
		<?php if ( is_post_type_archive( 'heropress-essays' ) ) { ?> 
			<?php get_template_part( 'partials/essays-entry', 'content' ); ?>
		<?php } else { ?>
			<?php get_template_part( 'partials/entry', 'content' ); ?>
		<?php } ?>
	</div>

	<?php if ( $entry_footer ) : ?>
	<footer class="entry-footer">
		<?php echo $entry_footer; ?>
	</footer>
	<?php endif; ?>
</article>
