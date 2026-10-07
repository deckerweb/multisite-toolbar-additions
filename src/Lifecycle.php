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
		$cache = 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/multisite-toolbar-additions' ), 0, 24 );
		if ( ! is_multisite() ) {
			delete_site_transient( $cache );
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
				delete_network_option( $network, '_site_transient_' . $cache );
				delete_network_option( $network, '_site_transient_timeout_' . $cache );
				wp_cache_delete( $cache, 'site-transient' );
				$settings = get_network_option( $network, 'mstba_settings', [] );
				if ( is_array( $settings ) && ! empty( $settings['delete_data'] ) ) {
					delete_network_option( $network, 'mstba_settings' );
				}
			}
			$offset += 100;
		} while ( count( $networks ) === 100 );
	}
}
