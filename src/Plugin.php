<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

final class Plugin {
	public function register() {
		$settings = new Settings();
		$menus = new MenuRepository( $settings );
		( new ToolbarMenu( $settings, $menus ) )->register();
		( new Shortcuts( $settings ) )->register();
		( new MenuGuard( $settings ) )->register();
		( new GitHubUpdates() )->register();
		if ( is_admin() ) { ( new Admin( $settings ) )->register(); }
		add_action( 'init', static function () {
			load_plugin_textdomain( 'multisite-toolbar-additions', false, dirname( plugin_basename( MSTBA_PLUGIN_FILE ) ) . '/languages' );
			// The legacy location is retained solely as an upgrade fallback.
			if ( ! is_multisite() || is_super_admin() ) {
				register_nav_menu( 'mstba_menu', __( 'Toolbar Menu (legacy location)', 'multisite-toolbar-additions' ) );
			}
		} );
		add_action( 'enqueue_block_editor_assets', static function () use ( $settings ) {
			if ( $settings->get( 'fullscreen' ) && is_admin_bar_showing() ) {
				wp_enqueue_style( 'mstba-editor', plugins_url( 'assets/editor.css', MSTBA_PLUGIN_FILE ), [], MSTBA_PLUGIN_VERSION );
			}
		} );
	}
}
