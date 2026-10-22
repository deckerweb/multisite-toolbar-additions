<?php
/**
 * Plugin-owned uninstall data; shared Library data has its own lifecycle.
 *
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Clean exact plugin keys without deleting menus, content or foreign data. */
final class Lifecycle {

	/**
	 * Clean the physical plugin's data across networks in bounded batches.
	 *
	 * Settings remain unless that scope explicitly opted in. No deactivation
	 * hook calls this method. Core must authorize the exact uninstall basename.
	 *
	 * @return void
	 */
	public static function uninstall(): void {
		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || 'multisite-toolbar-additions/multisite-toolbar-additions.php' !== WP_UNINSTALL_PLUGIN ) {
			return;
		}
		$repository = 'https://github.com/deckerweb/multisite-toolbar-additions';
		$cache = 'ddw_ghru_' . substr( md5( $repository ), 0, 24 );
		$caches = [ $cache, $cache . '_private' ];
		$runtime = dirname( __DIR__ ) . '/includes/deckerweb-github-release-updater-v2.php';
		if ( is_readable( $runtime ) ) {
			$updater_class = require $runtime;
			if ( is_string( $updater_class ) && method_exists( $updater_class, 'clear_repository_cache' ) ) {
				$updater_class::clear_repository_cache( $repository );
				$versioned = 'ddw_ghru_' . substr( md5( $repository . '|' . $updater_class::IMPLEMENTATION_VERSION ), 0, 24 );
				$caches[] = $versioned;
				$caches[] = $versioned . '_private';
			}
		}
		if ( ! is_multisite() ) {
			foreach ( $caches as $key ) { delete_site_transient( $key ); }
			$settings = get_option( 'mstba_settings', [] );
			if ( is_array( $settings ) && ! empty( $settings['delete_data'] ) ) {
				delete_option( 'mstba_settings' );
			}
			return;
		}
		$offset = 0;
		do {
			$networks = get_networks( [ 'number' => 100, 'offset' => $offset, 'fields' => 'ids', 'orderby' => 'id', 'order' => 'ASC' ] );
			foreach ( $networks as $network ) {
				foreach ( $caches as $key ) {
					delete_network_option( $network, '_site_transient_' . $key );
					delete_network_option( $network, '_site_transient_timeout_' . $key );
					wp_cache_delete( $key, 'site-transient' );
				}
				$settings = get_network_option( $network, 'mstba_settings', [] );
				if ( is_array( $settings ) && ! empty( $settings['delete_data'] ) ) {
					delete_network_option( $network, 'mstba_settings' );
				}
			}
			$offset += 100;
		} while ( count( $networks ) === 100 );
	}
}
