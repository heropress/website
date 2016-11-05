<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package HeroPress Simple
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
/*
		<div class="container">
			<p class="lead pad-left-5 pad-right-5">HeroPress, a new product of <a href="https://xwp.co/">XWP</a>, will soon be releasing an exciting announcement for everyone within (or adjacent to) the WordPress community. </p>

			<p class="lead pad-left-5 pad-right-5">Hint: Think TED for WordPress, with a multinational twist.</p>

			<p class="lead pad-left-5 pad-right-5">Sign up to learn more about our plan to develop the periphery of WordPress!</p>
			<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 2 ); } ?>
		</div>
*/
?>
			<?php  while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					//if ( comments_open() || get_comments_number() ) :
					//	comments_template();
					//endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
