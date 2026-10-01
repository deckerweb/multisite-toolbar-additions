<?php
/**
 * Plugin Name: Multisite Toolbar Additions
 * Plugin URI: https://github.com/deckerweb/multisite-toolbar-additions
 * Description: Useful network and site shortcuts, plus a configurable WordPress menu in the Toolbar.
 * Version: 4.0.0
 * Author: David Decker - DECKERWEB
 * Author URI: https://deckerweb.de/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: multisite-toolbar-additions
 * Domain Path: /languages/
 * Network: true
 * Requires at least: 6.7
 * Requires PHP: 8.2
 * Update URI: https://github.com/deckerweb/multisite-toolbar-additions
 * GitHub Plugin URI: https://github.com/deckerweb/multisite-toolbar-additions
 * GitHub Branch: master
 */

defined( 'ABSPATH' ) || exit;
define( 'MSTBA_PLUGIN_VERSION', '4.0.0' );
define( 'MSTBA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MSTBA_PLUGIN_FILE', __FILE__ );

spl_autoload_register( static function ( $class ) {
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
require_once MSTBA_PLUGIN_DIR . 'includes/deckerweb-plugin-library/bootstrap.php';
deckerweb_library_register( MSTBA_PLUGIN_FILE, [], MSTBA_PLUGIN_DIR . 'includes/deckerweb-plugin-library' );

add_action( 'plugins_loaded', static function () {
	( new Deckerweb\MultisiteToolbar\Plugin() )->register();
} );
