<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** One option per site or network; no writes during public requests. */
final class Settings {
	const OPTION = 'mstba_settings';
	private $values;

	/**
	 * Provide conservative defaults without writing persistent data.
	 *
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public static function defaults() {
		return [
			'enabled' => true, 'source_site' => 0, 'menu_id' => 0, 'context' => 'both',
			'audience' => 'administrators', 'position' => 'last', 'anchor' => 'site-name',
			'child_depth' => 0, 'layout' => 'original', 'label' => '',
			'network_links' => true, 'site_links' => true, 'subsite_links' => true,
			'subsite_limit' => 25, 'menu_edit_links' => true, 'integrations' => true,
			'resources' => true, 'file_editors' => false, 'fullscreen' => true,
			'new_plugins' => true, 'new_themes' => false, 'plugin_zip_submenu' => true, 'theme_zip_submenu' => true, 'upload_menu_defaults' => 1, 'delete_data' => false,
		];
	}

	/**
	 * Build a request-local settings view without saving preview values.
	 * @param array $values Previously validated settings.
	 * @return Settings
	 */
	public static function preview( array $values ): self {
		$instance = new self();
		$instance->values = array_replace( self::defaults(), $values );
		return $instance;
	}

	/**
	 * Determine whether this plugin is activated across the current network.
	 *
	 * @return bool True for network activation; false for a site-only copy.
	 */
	public static function network_active(): bool {
		return is_multisite() && isset( get_site_option( 'active_sitewide_plugins', [] )[ plugin_basename( MSTBA_PLUGIN_FILE ) ] );
	}

	/**
	 * Select the capability required to change the shared settings.
	 *
	 * @return string Result described above; unrelated hook values remain unchanged.
	 */
	public static function capability() {
		return is_multisite() ? 'manage_network_options' : 'manage_options';
	}

	/**
	 * Read and reuse site or network settings for this request.
	 *
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function all() {
		if ( null === $this->values ) {
			$stored = is_multisite() ? get_network_option( get_current_network_id(), self::OPTION, [] ) : get_option( self::OPTION, [] );
			$stored = is_array( $stored ) ? $stored : [];
			// The approved 4.1 preparation replaces the previous hidden-theme default once.
			// Saving records this transition; subsequent explicit user choices remain intact.
			if ( ! isset( $stored['upload_menu_defaults'] ) ) { $stored['theme_zip_submenu'] = true; }
			$this->values = array_replace( self::defaults(), $stored );
		}
		return $this->values;
	}

	/**
	 * Read a setting, honoring the supported legacy constants.
	 *
	 * @param string $key Allowlisted setting key.
	 * @return mixed Result described above; unrelated hook values remain unchanged.
	 */
	public function get( $key ) {
		$values = $this->all();
		$constants = [
			'enabled' => 'MSTBA_SUPER_ADMIN_NAV_MENU', 'network_links' => 'MSTBA_DISPLAY_NETWORK_ITEMS',
			'subsite_links' => 'MSTBA_DISPLAY_SUBSITE_ITEMS', 'site_links' => 'MSTBA_DISPLAY_SITE_GROUP',
			'menu_edit_links' => 'MSTBA_DISPLAY_LIST_EDIT_MENUS', 'resources' => 'MSTBA_DISPLAY_RESOURCES',
		];
		if ( isset( $constants[ $key ] ) && defined( $constants[ $key ] ) ) {
			return (bool) constant( $constants[ $key ] );
		}
		return $values[ $key ] ?? null;
	}

	/**
	 * Resolve the selected source website or the network main site.
	 *
	 * @return int Result described above; unrelated hook values remain unchanged.
	 */
	public function source() {
		$site = (int) $this->get( 'source_site' );
		return $site ?: ( self::network_active() ? get_main_site_id() : get_current_blog_id() );
	}

	/**
	 * Validate allowlisted form values and menu ownership in this network.
	 *
	 * @param mixed $input Untrusted settings form values.
	 * @return array|\WP_Error Result described above; unrelated hook values remain unchanged.
	 */
	public function sanitize( $input ) {
		$input = is_array( $input ) ? $input : [];
		$out = self::defaults();
		foreach ( [ 'enabled', 'network_links', 'site_links', 'subsite_links', 'menu_edit_links', 'integrations', 'resources', 'file_editors', 'fullscreen', 'new_plugins', 'new_themes', 'plugin_zip_submenu', 'theme_zip_submenu', 'delete_data' ] as $key ) {
			$out[ $key ] = isset( $input[ $key ] ) && in_array( $input[ $key ], [ '1', 1, true ], true );
		}
		foreach ( [ 'context' => [ 'both', 'admin', 'frontend' ], 'audience' => [ 'administrators', 'site_administrators' ], 'position' => [ 'first', 'last', 'before', 'after', 'right' ], 'anchor' => [ 'wp-logo', 'my-sites', 'site-name', 'updates', 'new-content', 'comments' ], 'layout' => [ 'original', 'grouped' ] ] as $key => $allowed ) {
			if ( isset( $input[ $key ] ) && is_string( $input[ $key ] ) && in_array( $input[ $key ], $allowed, true ) ) {
				$out[ $key ] = $input[ $key ];
			}
		}
		foreach ( [ 'source_site', 'menu_id', 'child_depth', 'subsite_limit' ] as $key ) {
			if ( isset( $input[ $key ] ) && is_scalar( $input[ $key ] ) ) {
				$out[ $key ] = absint( $input[ $key ] );
			}
		}
		$out['child_depth'] = min( 10, $out['child_depth'] );
		$out['subsite_limit'] = max( 1, min( 100, $out['subsite_limit'] ) );
		$out['label'] = isset( $input['label'] ) && is_string( $input['label'] ) ? sanitize_text_field( $input['label'] ) : $out['label'];
		$out['label'] = wp_html_excerpt( $out['label'], 80, '' );
		if ( '' === $out['label'] ) {
			$out['label'] = self::defaults()['label'];
		}
		if ( is_multisite() && $out['source_site'] ) {
			$site = get_site( $out['source_site'] );
			if ( ! $site || (int) $site->network_id !== get_current_network_id() || $site->deleted || $site->archived || $site->spam ) {
				return new \WP_Error( 'invalid_source', __( 'Choose an active website in this network.', 'multisite-toolbar-additions' ) );
			}
		} elseif ( ! is_multisite() ) {
			$out['source_site'] = get_current_blog_id();
		}
		$source = $out['source_site'] ?: ( self::network_active() ? get_main_site_id() : get_current_blog_id() );
		if ( is_multisite() && ! self::network_active() && ! in_array( plugin_basename( MSTBA_PLUGIN_FILE ), (array) get_blog_option( $source, 'active_plugins', [] ), true ) ) {
			return new \WP_Error( 'inactive_source', __( 'Network-activate this plugin or activate it on the source website before selecting that menu.', 'multisite-toolbar-additions' ) );
		}
		$valid = MenuRepository::on_site( $source, /** Check that the selected menu exists in the proposed source site.
 * @return bool Result described above.
 */
static function () use ( $out ) {
			return ! $out['menu_id'] || (bool) wp_get_nav_menu_object( $out['menu_id'] );
		} );
		if ( ! $valid ) {
			return new \WP_Error( 'invalid_menu', __( 'The selected menu does not exist on the source website. Load its menus and choose again.', 'multisite-toolbar-additions' ) );
		}
		return $out;
	}

	/**
	 * Persist validated values in the site or current network scope.
	 *
	 * @param array $values Previously validated settings to persist.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function save( array $values ) {
		if ( is_multisite() ) {
			update_network_option( get_current_network_id(), self::OPTION, $values );
		} else {
			update_option( self::OPTION, $values, false );
		}
		$this->values = $values;
	}
}
