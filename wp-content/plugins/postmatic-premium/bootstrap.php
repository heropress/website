<?php
/**
 * Load plugin with PHP 5.3 or greater.
 *
 * @author    Postmatic
 * @license   GPL-2.0+
 * @link      http://gopostmatic.com
 * Copyright 2015 Transitive, Inc.
 */

require_once( path_join( __DIR__, 'vendor/autoload.php' ) );

\Postmatic\Premium\Core::get_instance();

require_once( path_join( __DIR__, 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php' ) );

$checker = PucFactory::buildUpdateChecker(
	'https://plugins.gopostmatic.com/?action=get_metadata&slug=postmatic-premium',
	__DIR__ . '/postmatic-premium.php'
);
