<?php
/**
 * Template variables in scope:
 * @var WP_Query $digest_query Query of the posts to be included in the digest
 * @var string $introduction User-crafted introduction content
 * @var Postmatic\Premium\Rendering_Contexts\Digest $context
 */
?>

<div>
	<?php echo $introduction; ?>
</div>

-----

<?php while ( $digest_query->have_posts() ) : $digest_query->the_post(); ?>

	<h2><?php the_time( 'F j, Y h:i a' ); ?> | <?php the_title(); ?> | <?php the_author(); ?></h2>

	<div><?php the_excerpt(); ?></div>


	<?php if ( $context->get_digest_list()->get_include_full_post_requests() ) : ?>
		<p>
			<?php _e( 'Send to me', 'Postmatic' ); ?>:
			 mailto:{{{mail_post_<?php the_ID(); ?>_to_me}}}?subject=<?php
				echo rawurlencode( __( 'Send me the full post', 'Postmatic' ) );
				?>&body=<?php
				echo rawurlencode( 'send me post ' . get_the_ID() . "\n\n" );
				echo rawurlencode( __( 'Press send to confirm.', 'Postmatic' ) );
			?>
		</p>
	<?php endif; ?>

	<p>
		<?php _e( 'Read online', 'Postmatic' ); ?>:
		<?php the_permalink(); ?>
	</p>

	<p><?php comments_number(); ?></p>

<?php endwhile; ?>