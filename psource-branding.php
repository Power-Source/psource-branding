<?php
/*
Plugin Name: PSOURCE Toolkit
Plugin URI: https://psource.eimen.net/wiki/psource-toolkit-dokumentation/
Description: Eine komplette White-Label- und Branding-Lösung für Multisite. Adminbar, Loginsreens, Wartungsmodus, Favicons, Entfernen von ClassicPress-Links und Branding und vielem mehr.
Author: PSOURCE
Version: 1.0.5
Author URI: https://psource.eimen.net
Text Domain: ub
Domain Path: /languages

Copyright 2020-2026 PSOURCE (https://psource.eimen.net)


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.
*/

/**
 * PSOURCE CP Toolkit Version
 */

$ub_version = null;

$pstoolkit_plugin_dir = dirname( __FILE__ );

$pstoolkit_build_file = $pstoolkit_plugin_dir . '/build.php';
if ( file_exists( $pstoolkit_build_file ) ) {
	require_once $pstoolkit_build_file;
} elseif ( ! defined( 'PSTOOLKIT_BUILD_TYPE' ) ) {
	// Fallback for incomplete deployments where build.php is missing.
	define( 'PSTOOLKIT_BUILD_TYPE', 'pro' );
}

// Include the configuration library.
require_once $pstoolkit_plugin_dir . '/etc/config.php';
// Include the functions library.
if ( file_exists( $pstoolkit_plugin_dir . '/inc/deprecated-functions.php' ) ) {
	require_once $pstoolkit_plugin_dir . '/inc/deprecated-functions.php';
}
require_once $pstoolkit_plugin_dir . '/inc/functions.php';
require_once $pstoolkit_plugin_dir . '/inc/class-pstoolkit-helper.php';

// Set up my location.
set_pstoolkit( __FILE__ );

/**
 * Set ub Version.
 */
function pstoolkit_set_ub_version() {
	global $ub_version;
	$data       = get_plugin_data( __FILE__, false, false );
	$ub_version = $data['Version'];
}

if ( ! defined( 'PSTOOLKIT_SUI_VERSION' ) ) {
	define( 'PSTOOLKIT_SUI_VERSION', '2.9.6' );
}

register_activation_hook( __FILE__, 'pstoolkit_register_activation_hook' );
register_deactivation_hook( __FILE__, 'pstoolkit_register_deactivation_hook' );
register_uninstall_hook( __FILE__, 'pstoolkit_register_uninstall_hook' );

