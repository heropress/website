<?php
/**
 * Template variables in scope:
 * @var WP_Query $digest_query Query of the posts to be included in the digest
 * @var string $introduction User-crafted introduction content
 * @var Postmatic\Premium\Rendering_Contexts\Digest $context
 */
?>

<div class="padded digest postmatic-content">
	<div class="digest-introduction">
		<?php echo $introduction; ?>
	</div>

	<div class="digest-posts context">
		<div class="title"><?php echo $context->get_digest_list()->subscription_object_label(); ?></div>
		<?php while ( $digest_query->have_posts() ) : $digest_query->the_post(); ?>

			<div class="digest-loop<?php echo has_post_thumbnail() ? ' thumb' : ''; ?>">

				<?php if ( has_post_thumbnail() ) : ?>
					<?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'prompt-post-thumbnail' ); ?>
					<a href="<?php the_permalink(); ?>"><img class="featured-image" src="<?php echo $thumbnail_src[0]; ?>"
					     width="<?php echo intval( $thumbnail_src[1] / 2 ); ?>"
						/></a>
				<?php endif; ?>

				<div class="digest-copy">
					<div class="digest-cats">
						<?php echo implode( ' &bull; ', wp_list_pluck( get_the_category(), 'name' ) ); ?>
					</div>
					<div class="digest-author">
						<?php /* translators: <post title> by <post author> */ ?>
						<span><?php _e( ' by ', 'postmatic-premium' ); ?></span>
						<?php the_author(); ?>
					</div>
					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>

					<div class="date"><?php the_time( 'F j, Y h:i a' ); ?>
						<span class="comment-count">
							<a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' ); ?></a>
							<strong><?php $context->the_comments_by_line(); ?></strong>
						</span>
					</div>
					<div class="excerpt"><?php the_excerpt(); ?></div>
					<ul class="actions">
						<?php if ( $context->get_digest_list()->get_include_full_post_requests() ) : ?>
							<li class="actions-email"><a href="mailto:{{{mail_post_<?php the_ID(); ?>_to_me}}}?subject=<?php
								/* translators: %s is the post title */
								echo rawurlencode(
									sprintf(
										__( 'I would like a copy of %s', 'postmatic-premium' ),
										get_the_title()
									)
								);
								?>&body=<?php
								/* translators: %s is the post title */
								echo rawurlencode(
									sprintf(
										__(
											'Ready to go. To receive a copy of %s just press send. We will send you a copy along with the full conversation. You should receive it in about half a minute.',
											'postmatic-premium'
										),
										get_the_title()
									)
								);
								?>">
									<img src="<?php echo Prompt_Core::$url_path . '/media/download.png'; ?>" width="10"
										 height="10" align="left"
										 style="float: left; margin-right: 7px; margin-top: 3px; width: 10px; height: auto;"/>
									<?php _e( 'Add to my inbox', 'postmatic-premium' ); ?></a>
							</li>
						<?php endif; ?>
						<li class="actions-online"><a href="<?php the_permalink(); ?>"><img
									src="<?php echo Prompt_Core::$url_path . '/media/external.png'; ?>" width="10"
									height="10" align="left"
									style="float: left; margin-right: 7px; margin-top: 3px; width: 10px; height: auto;"/><?php _e( 'Read it online', 'postmatic-premium' ); ?>
							</a></li>
					</ul>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
</div>