<?php
/**
 * @package   Postmatic\Premium
 * @author    Postmatic
 * @license   GPL-2.0+
 * @link      http://gopostmatic.com
 *
 * Copyright 2016 Transitive, Inc.
 *
 * @wordpress-plugin
 *
 * Plugin Name: Postmatic & Postmatic Labs
 * Version: 2.0.14
 * Plugin URI:  http://gopostmatic.com/
 * Description:
 * Author:      Postmatic
 * Author URI:  https://gopostmatic.com/
 * Text Domain: postmatic-premium
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Finish loading early so others may assume we're loaded at the default priority (10)
add_action( 'plugins_loaded', array( 'Postmatic_Premium_Loader', 'load_or_reprimand' ), 5 );

register_activation_hook( __FILE__, array( 'Postmatic_Premium_Loader', 'set_activation_transient' ) );

if ( class_exists( 'Postmatic_Premium_Loader' ) ) {
	return;
}

/**
 * Make sure the minimum dependencies are met before loading.
 * @since 0.1
 */
class Postmatic_Premium_Loader {

	/**
	 * @since 0.1
	 * @var string
	 */
	protected static $required_php_version = '5.3.0';
	/**
	 * @since 0.1
	 * @var string
	 */
	protected static $notice;

	/**
	 * Make sure the minimum dependencies are met before loading.
	 * @since 0.1
	 */
	public static function load_or_reprimand() {

		if ( is_admin() or defined( 'DOING_AJAX' ) and DOING_AJAX ) {
			// load dissmissable notice resources
			include_once( path_join(
				plugin_dir_path( __FILE__ ),
				'vendor/calderawp/dismissible-notice/src/functions.php'
			) );
		}

		if ( version_compare( PHP_VERSION, self::$required_php_version, '>=' ) ) {
			// load away
			require_once( path_join( plugin_dir_path( __FILE__ ), 'bootstrap.php' ) );

			return;
		}

		self::$notice = caldera_warnings_dismissible_notice(
			sprintf(
				__(
					'Postmatic Premium requires PHP version %1s or later. Current version is %2s. Your web host should be able to help you fix this.',
					'postmatic-premium'
				),
				self::$required_php_version,
				PHP_VERSION
			)
		);

		add_action( 'admin_notices', array( 'Postmatic_Premium_Loader', 'reprimand' ) );
	}

	/**
	 * Display the reprimand.
	 * @since 0.1
	 */
	public static function reprimand() {
		echo self::$notice;
	}

	/**
	 * Record activation time.
	 * @since 0.3.0
	 */
	public static function set_activation_transient() {
		set_transient( 'postmatic-premium-activated', time(), 10 );
	}
}

