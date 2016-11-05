<?php
namespace Postmatic\Premium\Actions;

use Postmatic\Premium\Core;
use Postmatic\Premium\Models\Script;
use Postmatic\Premium\Widgets\Subscribers_Chart;

/**
 * Dashboard Widgets actions
 * @since 0.5.0
 */
class Dashboard_Widgets {

	/**
	 * enqueue
	 * @since 0.5.0
	 */
	public static function enqueue( $page ) {

		// Include scripts for admin only
		if ( current_user_can( 'manage_options' ) && $page == 'index.php' ) {

			wp_enqueue_style(
				'premium-admin-dashboard-css',
				Core::get_instance()->url( 'css/admin-dashboard.css' )
			);

			wp_enqueue_script( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js' );

			$data = Subscribers_Chart::get_data();
			$script = new Script( array(
				'handle' => 'subscribers-dashboard-widget',
				'path' => 'js/subscribers-dashboard-widget.js',
			) );
			$script->enqueue();
			$script->localize( 'chart_data', $data );
		}
	}

	/**
	 * Add Dashboard Widget
	 * @since 0.5.0
	 */
	public static function setup_widget() {

		if ( current_user_can( 'manage_options' ) ) {
			wp_add_dashboard_widget(
				'postmatic-subscribers',
				__( 'Postmatic Subscribers', 'postmatic-premium' ) . " " . html( 'span class="labs"', __( 'Labs Feature', 'postmatic-premium' ) ),
				array( "Postmatic\Premium\Widgets\Subscribers_Chart", "render" )
			);
		}

	}


}