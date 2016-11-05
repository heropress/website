<?php
/*
Plugin Name: HeroPress Recent Contributor Widget
Description: Creates a widget that renders info about a contributor
Author: Topher, XWP
Version: 1.0
Author URI: http://xwp.co
*/

/**
 * Creates a widget that renders info about a contributor
 *
 * @package Heropress_Recent_Essays_Widget
 * @since Heropress_Recent_Essays_Widget 1.0
 * @author Topher
 */



/**
 * Adds the Heropress_Recent_Essays_Widget
 */
class Heropress_Recent_Essays_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'heropress_recent_essays_widget', // Base ID
			__( 'HeroPress Recent Essays', 'heropress' ), // Name
			array( 'description' => __( 'Renders a list of recent Essays', 'heropress' ), ) // Args
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

		echo wp_kses_post( $args['before_widget'] );


		if ( ! empty( $instance['title'] ) ) {
			echo '<h3 class="widget-title">' . esc_attr( $instance['title'] ) . ' </h3>' . "\n";
		}

		// Let's go get the essays
		$essay_args = array(
			'post_type'      => 'heropress-essays',
			'post_status'    => 'publish',
			'posts_per_page' => 8,
		);

		// The Query
		$the_query = new WP_Query( $essay_args );

		// The Loop
		if ( $the_query->have_posts() ) {

			// Find connected contributors (for all essays)
			p2p_type( 'essays_to_contributors' )->each_connected( $the_query );

			echo '<ul class="contributor_list">' . "\n";

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				// set up connected posts
				$connected_posts = $the_query->post->connected;


				echo '<li>';

				echo '<a href="' . esc_url( get_permalink() ) . '">' . get_the_post_thumbnail( $connected_posts[0]->ID, array( 64, 64 ) ) . '</a>';

				echo '<h4 class="essay_title"><a href="' . esc_url( get_permalink() ) . '">';
				echo esc_html( get_the_title() );
				echo '</a></h4>';

				// get the info for all contributors
				foreach ( $connected_posts as $post ) : setup_postdata( $post );

					// get the meta info for all contributors
					echo '<p class="essay_author">' . __( 'by', 'heropress' ) , ' ' . get_the_title( $post->ID ) . '</p>';

				endforeach;
				echo '</li>' . "\n";;
			}
			echo '</ul>' . "\n\n";;
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();

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

} // class Heropress_Recent_Essays_Widget

add_action( 'widgets_init', function() {
	register_widget( 'Heropress_Recent_Essays_Widget' );
} );
