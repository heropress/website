<?php

function hp_contributor_data() {

	$output = '';

	// Find connected pages
	$connected = new WP_Query( array(
	  'connected_type' => 'essays_to_contributors',
	  'connected_items' => get_queried_object(),
	  'nopaging' => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :
	?>
	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>

		<?php $meta = get_post_custom(); ?>

		<div class="contributor_data">

		<?php the_post_thumbnail( 'medium', array( 'alt' => 'Photo of ' . get_the_title() ) ); ?>
		<h4 class="author_name"><?php the_title(); ?></h4>
		<ul>
		<?php
			if ( isset( $meta['_heropress_contributor_url'][0] ) && '' != $meta['_heropress_contributor_url'][0] ) {
		?>
		<li><a href="<?php echo esc_url( $meta['_heropress_contributor_url'][0] ); ?>"><?php echo esc_url( $meta['_heropress_contributor_url'][0] ); ?></a></li>
		<?php
			}
			if ( isset( $meta['_heropress_contributor_twitter'][0] ) && '' != $meta['_heropress_contributor_twitter'][0] ) {
		?>
		<li><a href="<?php echo esc_url( 'http://twitter.com/' . $meta['_heropress_contributor_twitter'][0] ); ?>">@<?php echo esc_html( $meta['_heropress_contributor_twitter'][0] ); ?></a></li>
		<?php
			}
			if ( isset( $meta['_heropress_contributor_facebook'][0] ) && '' != $meta['_heropress_contributor_facebook'][0] ) {
		?>
		<li><a href="<?php echo esc_url( $meta['_heropress_contributor_facebook'][0] ); ?>">Facebook</a></li>
		<?php
			}
			if ( isset( $meta['_heropress_contributor_github'][0] ) && '' != $meta['_heropress_contributor_github'][0] ) {
		?>
		<li><span><a href="<?php echo esc_url( $meta['_heropress_contributor_github'][0] ); ?>">GitHub</a></span></li>
		<?php
			}
			if ( isset( $meta['_heropress_contributor_wptv'][0] ) && '' != $meta['_heropress_contributor_wptv'][0] ) {
		?>
		<li><span><a href="<?php echo esc_url( $meta['_heropress_contributor_wptv'][0] ); ?>">WordPress.tv</a></span></li>
		<?php
			}
		?>
		</ul>

		</div>

	<?php endwhile; ?>

	<?php
	// Prevent weirdness
	wp_reset_postdata();

	endif;

}
