<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Coordinate the plugin services and their WordPress hooks. */
final class Plugin {
	/**
	 * Register toolbar, settings, menu protection and updater services.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function register() {
		add_action( 'admin_notices', [ $this, 'library_notice' ] );
		add_action( 'network_admin_notices', [ $this, 'library_notice' ] );
		$settings = new Settings();
		$menus = new MenuRepository( $settings );
		( new ToolbarMenu( $settings, $menus ) )->register();
		( new Shortcuts( $settings ) )->register();
		( new MenuGuard( $settings ) )->register();
		( new GitHubUpdates() )->register();
		Uploads::register();
		if ( is_admin() ) { ( new Admin( $settings ) )->register(); }
		add_action( 'init', /** Run the scoped WordPress callback without persisting settings.
 * @return void No return value.
 */
static function () {
			load_plugin_textdomain( 'multisite-toolbar-additions', false, dirname( plugin_basename( MSTBA_PLUGIN_FILE ) ) . '/languages' );
			// The legacy location is retained solely as an upgrade fallback.
			if ( ! is_multisite() || is_super_admin() ) {
				register_nav_menu( 'mstba_menu', __( 'Toolbar Menu (legacy location)', 'multisite-toolbar-additions' ) );
			}
		} );
		add_action( 'enqueue_block_editor_assets', /** Run the scoped WordPress callback without persisting settings.
 * @return void No return value.
 */
static function () use ( $settings ) {
			if ( $settings->get( 'fullscreen' ) && is_admin_bar_showing() ) {
				wp_enqueue_style( 'mstba-editor', plugins_url( 'assets/editor.css', MSTBA_PLUGIN_FILE ), [], MSTBA_PLUGIN_VERSION );
			}
		} );
	}
	/**
	 * Explain an incomplete embedded Library only to authorized installers.
	 *
	 * @return void
	 */
	public function library_notice(): void {
		if ( empty( $GLOBALS['mstba_library_unavailable'] ) || ! current_user_can( 'install_plugins' ) ) { return; }
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Reinstall the complete plugin package to restore the shared Library. Toolbar features remain available.', 'multisite-toolbar-additions' ) . '</p></div>';
	}

}
