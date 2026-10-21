<?php
/**
 * Read-only shortcuts to the embedded, shared deckerweb Library.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Resolve existing administration destinations without loading the Library on the frontend. */
final class LibraryLinks {
	/**
	 * Resolve destinations only for a complete registered host in the target scope.
	 *
	 * A Multisite destination requires a network-active host because site-only
	 * plugins do not load in Network Admin. No remote request or persistent write.
	 *
	 * @return array Permitted settings/catalog URLs, or an empty array when unavailable.
	 */
	public static function destinations(): array {
		$capability = is_multisite() ? 'manage_network_options' : 'manage_options';
		if ( ! current_user_can( $capability ) ) { return []; }
		$network_hosts = is_multisite() ? (array) get_site_option( 'active_sitewide_plugins', [] ) : [];
		$available = false;
		foreach ( (array) ( $GLOBALS['deckerweb_library_candidates_v1'] ?? [] ) as $candidate ) {
			if ( ! is_string( $candidate['host'] ?? null ) || ! is_string( $candidate['dir'] ?? null ) ) { continue; }
			if ( is_multisite() && ! isset( $network_hosts[ plugin_basename( $candidate['host'] ) ] ) ) { continue; }
			if ( ! is_readable( $candidate['dir'] . '/runtime.php' ) || ! is_readable( $candidate['dir'] . '/src/Library.php' ) ) { continue; }
			$available = true;
			break;
		}
		// In administration, election must have succeeded. Frontend election is
		// deliberately skipped by the component; its registered local host suffices.
		if ( ! $available || ( is_admin() && ! is_object( $GLOBALS['deckerweb_library_runtime_v1'] ?? null ) ) ) { return []; }
		$settings = (array) get_site_option( 'deckerweb_library_settings_v1', [] );
		$urls = [ 'settings' => is_multisite() ? network_admin_url( 'settings.php?page=deckerweb-library' ) : admin_url( 'options-general.php?page=deckerweb-library' ) ];
		if ( current_user_can( 'install_plugins' ) && ( ! isset( $settings['enabled'] ) || ! empty( $settings['enabled'] ) ) ) {
			$urls['catalog'] = is_multisite() ? network_admin_url( 'plugin-install.php?tab=deckerweb' ) : admin_url( 'plugin-install.php?tab=deckerweb' );
		}
		return $urls;
	}

	/**
	 * Add available links under the host settings entry and the native New group.
	 *
	 * @param \WP_Admin_Bar $bar Current toolbar; absent parents remain absent.
	 * @return void Adds escaped navigation only; never enables a hidden catalog.
	 */
	public static function render( $bar ): void {
		$urls = self::destinations();
		$labels = [ 'catalog' => __( 'deckerweb Plugin Catalog', 'multisite-toolbar-additions' ), 'settings' => __( 'Library Settings', 'multisite-toolbar-additions' ) ];
		foreach ( [ 'catalog', 'settings' ] as $key ) {
			if ( isset( $urls[ $key ] ) && $bar->get_node( 'ddw-mstba-settings' ) ) {
				$bar->add_node( [ 'id' => 'ddw-mstba-library-' . $key, 'parent' => 'ddw-mstba-settings', 'title' => esc_html( $labels[ $key ] ), 'href' => esc_url( $urls[ $key ] ) ] );
			}
		}
		if ( isset( $urls['catalog'] ) && $bar->get_node( 'new-content' ) ) {
			$bar->add_node( [ 'id' => 'ddw-mstba-new-library', 'parent' => 'new-content', 'title' => esc_html( $labels['catalog'] ), 'href' => esc_url( $urls['catalog'] ) ] );
		}
	}
}
