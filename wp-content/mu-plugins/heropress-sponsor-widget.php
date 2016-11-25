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

		// add "subscription" to class list
		$args['before_widget'] = str_replace( 'widget_heropress_sponsor_widget', 'widget_heropress_sponsor_widget subscription', $args['before_widget'] );

		echo wp_kses_post( $args['before_widget'] );


		if ( ! empty( $instance['title'] ) ) {
			echo '<h3 class="widget-title">' . esc_attr( $instance['title'] ) . ' </h3>' . "\n";
		}


		// Find connected pages
		$connected = new WP_Query( array(
			'connected_type'  => 'essays_to_sponsors',
			'connected_items' => get_queried_object(),
			'connected_query' => array( 'post_status' => 'any' ),
			'nopaging'        => true,
		) );

		// Display connected pages
		if ( $connected->have_posts() ) :
		?>
		<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>

			<?php $meta = get_post_custom(); ?>

			<?php the_post_thumbnail(); ?>

			<h4><?php the_title(); ?></h5>
			<ul>
			<?php
				if ( isset( $meta['_heropress_sponsor_url'][0] ) && '' != $meta['_heropress_sponsor_url'][0] ) {
			?>
			<li><a href="<?php echo esc_url( $meta['_heropress_sponsor_url'][0] ); ?>"><?php echo esc_url( $meta['_heropress_sponsor_url'][0] ); ?></a></li>
			<?php
				}
				if ( isset( $meta['_heropress_sponsor_twitter'][0] ) && '' != $meta['_heropress_sponsor_twitter'][0] ) {
			?>
			<li><a href="<?php echo esc_url( 'http://twitter.com/' . $meta['_heropress_sponsor_twitter'][0] ); ?>">@<?php echo esc_html( $meta['_heropress_sponsor_twitter'][0] ); ?></a></li>
			<?php
				}
				if ( isset( $meta['_heropress_sponsor_facebook'][0] ) && '' != $meta['_heropress_sponsor_facebook'][0] ) {
			?>
			<li><a href="<?php echo esc_url( $meta['_heropress_sponsor_facebook'][0] ); ?>">Facebook</a></li>
			<?php
				}
				if ( isset( $meta['_heropress_sponsor_github'][0] ) && '' != $meta['_heropress_sponsor_github'][0] ) {
			?>
			<li><span><a href="<?php echo esc_url( $meta['_heropress_sponsor_github'][0] ); ?>">GitHub</a></span></li>
			<?php
				}
				if ( isset( $meta['_heropress_sponsor_wptv'][0] ) && '' != $meta['_heropress_sponsor_wptv'][0] ) {
			?>
			<li><span><a href="<?php echo esc_url( $meta['_heropress_sponsor_wptv'][0] ); ?>">WordPress.tv</a></span></li>
			<?php
				}
				if ( isset( $meta['_heropress_sponsor_dot_org'][0] ) && '' != $meta['_heropress_sponsor_dot_org'][0] ) {
			?>
			<li><span><a href="<?php echo esc_url( $meta['_heropress_sponsor_dot_org'][0] ); ?>">WordPress.org Profile</a></span></li>
			<?php
				}
			?>
			</ul>
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
