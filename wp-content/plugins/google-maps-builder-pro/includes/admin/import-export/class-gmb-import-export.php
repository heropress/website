<?php
/**
 * Maps Builder CSV Import/Export
 *
 * @since: 2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class GMB_CSV_Manager {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	protected static $key = 'gmb_import_export';


	public $options_page;

	/**
	 * Class constructor
	 *
	 * @since         2.0
	 * @access        public
	 */
	public function __construct() {

		$this->plugin_slug = Google_Maps_Builder()->get_plugin_slug();

		//			$this->setup_constants();
		$this->includes();
		//			$this->product_exporter();
		//			$this->product_importer();
		add_action( 'admin_menu', array( $this, 'add_page' ) );

	}


	/**
	 * Include required files
	 *
	 * @since       2.0
	 * @access      private
	 * @return      void
	 */
	private function includes() {

		if ( ! class_exists( 'parseCSV' ) ) {
			require_once GMB_PLUGIN_PATH . 'includes/admin/import-export/parsecsv.lib.php';
		}
		require_once GMB_PLUGIN_PATH . 'includes/admin/import-export/functions.php';
		require_once GMB_PLUGIN_PATH . 'includes/admin/import-export/class-marker-importer.php';
		require_once GMB_PLUGIN_PATH . 'includes/admin/import-export/class-marker-exporter.php';
		//			require_once GMB_CSV_MANAGER_DIR . 'includes/class.product-importer.php';
		//			require_once GMB_CSV_MANAGER_DIR . 'includes/class.payment-history-exporter.php';
		//			require_once GMB_CSV_MANAGER_DIR . 'includes/class.payment-history-importer.php';
	}

	/**
	 * Add menu options page
	 * @since 2.0
	 */
	public function add_page() {

		$this->options_page = add_submenu_page(
			'edit.php?post_type=google_maps',
			__( 'Maps Builder Settings', $this->plugin_slug ),
			__( 'Import/Export', $this->plugin_slug ),
			'manage_options',
			self::$key,
			array( $this, 'import_export_page_display' )
		);

	}

	/**
	 * Get the Import/Export Page
	 */
	public function import_export_page_display() { ?>


		<div class="wrap">

			<?php
			/**
			 * Option tabs
			 *
			 * Better organize our options in tabs
			 *
			 * @see: http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971
			 */
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'import';
			?>
			<h2 class="nav-tab-wrapper">
				<a href="?post_type=google_maps&page=<?php echo self::$key; ?>" class="nav-tab <?php echo $active_tab == 'import' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Import', $this->plugin_slug ); ?></a>
				<a href="?post_type=google_maps&page=<?php echo self::$key; ?>&tab=export" class="nav-tab <?php echo $active_tab == 'export' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Export', $this->plugin_slug ); ?></a>
			</h2>

			<?php
			/**
			 * Get the appropriate tab
			 */
			switch ( $active_tab ) {
				case 'import':
					do_action('gmb_import_page');
					break;
				case 'export':
					do_action('gmb_export_page');
					break;
			}
			?>
		</div> <?php

	}

}

new GMB_CSV_Manager();
