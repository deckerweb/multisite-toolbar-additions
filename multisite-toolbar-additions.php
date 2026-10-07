<?php
/**
 * Plugin Name: Multisite Toolbar Additions
 * Plugin URI: https://github.com/deckerweb/multisite-toolbar-additions
 * Description: Configurable WordPress toolbar menus and practical shortcuts for single sites and Multisite networks.
 * Version: 4.1.0
 * Requires at least: 6.7
 * Requires PHP: 8.2
 * Author: David Decker – DECKERWEB
 * Author URI: https://github.com/deckerweb
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: multisite-toolbar-additions
 * Domain Path: /languages/
 * Update URI: https://github.com/deckerweb/multisite-toolbar-additions
 * GitHub Plugin URI: https://github.com/deckerweb/multisite-toolbar-additions
 *
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;
define( 'MSTBA_PLUGIN_VERSION', '4.1.0' );
define( 'MSTBA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MSTBA_PLUGIN_FILE', __FILE__ );

spl_autoload_register( /** Autoload only one valid class from the plugin’s fixed source directory.
 * @param string $class Requested fully qualified class name.
 * @return void No return value.
 */
static function ( $class ) {
	$prefix = 'Deckerweb\\MultisiteToolbar\\';
	if ( 0 !== strpos( $class, $prefix ) ) {
		return;
	}
	$name = substr( $class, strlen( $prefix ) );
	if ( preg_match( '/^[A-Za-z]+$/', $name ) ) {
		$file = MSTBA_PLUGIN_DIR . 'src/' . $name . '.php';
		if ( is_file( $file ) ) {
			require_once $file;
		}
	}
} );
// Shared library elects one implementation after every selected host has loaded.
try {
	$mstba_library_bootstrap = MSTBA_PLUGIN_DIR . 'includes/deckerweb-plugin-library/bootstrap.php';
	if ( ! is_readable( $mstba_library_bootstrap ) ) { throw new \RuntimeException( 'Missing Library bootstrap.' ); }
	require_once $mstba_library_bootstrap;
	if ( ! function_exists( 'deckerweb_library_register_v2' ) ) { throw new \RuntimeException( 'Missing Library registration.' ); }
	deckerweb_library_register_v2( MSTBA_PLUGIN_FILE, [], MSTBA_PLUGIN_DIR . 'includes/deckerweb-plugin-library' );
} catch ( \Throwable $error ) {
	$GLOBALS['mstba_library_unavailable'] = true;
}

add_action( 'plugins_loaded', /** Run the scoped WordPress callback without persisting settings.
 * @return void No return value.
 */
static function () {
	( new Deckerweb\MultisiteToolbar\Plugin() )->register();
} );
