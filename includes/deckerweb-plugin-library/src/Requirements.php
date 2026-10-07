<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V0_6_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Used both when rendering cards and immediately before install/activation. */
final class Requirements {
	/**
	 * Report platform, active dependency and network-scope requirements without installing prerequisites.
	 *
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @param array|null $plugins Installed plugin metadata; null reads the current installation.
	 * @param bool|null $network Network activation context; null derives it from the current admin scope.
	 * @return array Result of the operation; errors are returned or rejected as documented by the caller.
	 */
	public static function check( array $entry, ?array $plugins = null, ?bool $network = null ): array {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$plugins = $plugins ?? get_plugins();
		$network = $network ?? ( is_multisite() && is_network_admin() );
		$issues = [];
		if ( ! empty( $entry['requires_multisite'] ) && ! is_multisite() ) { $issues[] = Library::t( 'Requires a WordPress Multisite network.' ); }
		if ( ! empty( $entry['network_only'] ) && is_multisite() && ! $network ) { $issues[] = Library::t( 'Install and activate this plugin in the network admin.' ); }
		if ( $network && isset( $entry['network_activation'] ) && ! $entry['network_activation'] ) { $issues[] = sprintf( Library::t( '%s supports activation per site only.' ), $entry['name'] ); }
		global $wp_version;
		if ( version_compare( $wp_version, $entry['requires_wp'], '<' ) ) { $issues[] = sprintf( Library::t( 'Requires WordPress %s or newer.' ), $entry['requires_wp'] ); }
		if ( version_compare( PHP_VERSION, $entry['requires_php'], '<' ) ) { $issues[] = sprintf( Library::t( 'Requires PHP %s or newer.' ), $entry['requires_php'] ); }
		foreach ( $entry['dependencies'] as $dep ) {
			$file = $dep['plugin_file'];
			$present = isset( $plugins[$file] );
			$active = $network ? is_plugin_active_for_network( $file ) : is_plugin_active( $file );
			$version = $plugins[$file]['Version'] ?? '';
			// Official Breakdance constant also detects installations in a renamed folder.
			// It is only sufficient for site activation, never for a network-wide activation.
			if ( ! $network && ( $dep['detector'] ?? '' ) === 'breakdance' && defined( '__BREAKDANCE_VERSION' ) ) {
				$present = true; $active = true; $version = (string) constant( '__BREAKDANCE_VERSION' );
			}

			$detector = $dep['detector'] ?? '';
			if ( $detector === 'bricks' ) {
				if ( $network ) {
					$issues[] = Library::t( 'Activate Bricks QuickNav per site after selecting the Bricks parent or child theme.' );
					continue;
				}
				$theme = wp_get_theme( get_template() );
				$present = $theme->exists() && $theme->get( 'Name' ) === 'Bricks';
				$active = $present && defined( 'BRICKS_VERSION' ) && function_exists( 'bricks_is_builder' );
				$version = $theme->get( 'Version' );
			}
			if ( $detector === 'oxygen' || $detector === 'advanced_scripts' ) {
				$loaded = $detector === 'oxygen'
					? ( defined( 'BREAKDANCE_MODE' ) && constant( 'BREAKDANCE_MODE' ) === 'oxygen' && defined( '__BREAKDANCE_VERSION' ) )
					: ( defined( 'EPXADVSC_VER' ) && function_exists( 'cpas_scripts_manager' ) );
				// Runtime markers also support renamed plugin directories. On a network,
				// a matching active network plugin is required in addition to the marker.
				foreach ( $plugins as $candidate => $info ) {
					$expected = $detector === 'oxygen' ? 'Oxygen' : 'Advanced Scripts';
					if ( isset( $info['Name'] ) && $info['Name'] === $expected ) {
						$present = true;
						if ( $network && is_plugin_active_for_network( $candidate ) ) { $active = true; }
					}
				}
				if ( ! $network && $loaded ) { $present = true; $active = true; }
				$active = $active && $loaded;
				if ( $loaded ) { $version = (string) constant( $detector === 'oxygen' ? '__BREAKDANCE_VERSION' : 'EPXADVSC_VER' ); }
			}
			if ( ! $present ) { $issues[] = sprintf( Library::t( '%s is missing. Install and activate it first.' ), $dep['name'] ); }
			elseif ( ! $active ) { $issues[] = sprintf( $network ? Library::t( '%s must be network activated first.' ) : Library::t( '%s is installed but inactive. Activate it first.' ), $dep['name'] ); }
			elseif ( $dep['min_version'] !== '' && ( $version === '' || version_compare( $version, $dep['min_version'], '<' ) ) ) { $issues[] = sprintf( Library::t( 'Update %1$s to version %2$s or newer.' ), $dep['name'], $dep['min_version'] ); }
		}
		return $issues;
	}
}
