<?php
/*
Plugin Name: HeroPress Sponsor Information Widget
Description: Creates a widget that renders info about a sponsor
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

/**
 * Creates a widget that renders info about a sponsor
 *
 * @package Heropress_Sponsor_Widget
 * @since Heropress_Sponsor_Widget 1.0
 * @author Topher
 */

/**
 * Adds the Heropress_Sponsor_Widget
 */
class Heropress_Sponsor_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'heropress_sponsor_widget', // Base ID
			__( 'HeroPress Sponsor Data', 'heropress' ), // Name
			array( 'description' => __( 'Renders data about a specific sponsor', 'heropress' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args		  Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$current_object = get_queried_object();

		// Find connected pages
		$connected = new WP_Query( array(
			'connected_type'  => 'essays_to_sponsors',
			'connected_items' => $current_object,
			'connected_query' => array( 'post_status' => 'any' ),
			'nopaging'        => true,
		) );

		// Display connected pages
		if ( $connected->have_posts() ) :

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo '<h3 class="widget-title">' . esc_attr( $instance['title'] ) . ' </h3>' . "\n";
		}


		?>
		<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>

			<?php $meta = get_post_custom(); ?>
            <?php

                if ( ! empty( $meta['_heropress_sponsor_url'][0] ) ) {
					$url_start = '<a href="' . esc_url( $meta['_heropress_sponsor_url'][0] ) . '?utm_source=heropress&utm_medium=heropress-sponsorship&utm_content=' . $current_object->post_name . '">';
					$url_end = '</a>';
                } else {
					$url_start = '';
					$url_end = '';
				}
			?>


			<?php echo $url_start; ?><?php the_post_thumbnail( 'heropress-sponsor-logo' ); ?><?php echo $url_end; ?>

			<?php echo wpautop( get_the_content() ); ?>

			<?php
				if ( ! empty( $meta['_heropress_sponsor_url'][0] ) ) {
			?>
			<h6><?php echo $url_start; ?><?php _e( 'Visit', 'heropress' ); ?> <?php echo get_the_title(); ?><?php echo $url_end; ?></h6>
			<?php
				}
			?>

		<?php endwhile; ?>

		<?php 
		// Prevent weirdness
		wp_reset_postdata();

		endif;

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {


		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'heropress' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? esc_attr( strip_tags( $new_instance['title'] ) ) : '';

		return $instance;
	}

} // class Heropress_Sponsor_Widget

add_action( 'widgets_init', function() {
	register_widget( 'Heropress_Sponsor_Widget' );
} );
