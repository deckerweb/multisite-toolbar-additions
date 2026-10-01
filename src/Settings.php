<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** One option per site or network; no writes during public requests. */
final class Settings {
	const OPTION = 'mstba_settings';
	private $values;

	public static function defaults() {
		return [
			'enabled' => true, 'source_site' => 0, 'menu_id' => 0, 'context' => 'both',
			'audience' => 'administrators', 'position' => 'last', 'anchor' => 'site-name',
			'child_depth' => 0, 'layout' => 'original', 'label' => '',
			'network_links' => true, 'site_links' => true, 'subsite_links' => true,
			'subsite_limit' => 25, 'menu_edit_links' => true, 'integrations' => true,
			'resources' => true, 'file_editors' => false, 'fullscreen' => true,
			'new_plugins' => true, 'new_themes' => false, 'plugin_zip_submenu' => true, 'theme_zip_submenu' => false,
		];
	}

	public static function capability() {
		return is_multisite() ? 'manage_network_options' : 'manage_options';
	}

	public function all() {
		if ( null === $this->values ) {
			$stored = is_multisite() ? get_network_option( get_current_network_id(), self::OPTION, [] ) : get_option( self::OPTION, [] );
			$this->values = array_replace( self::defaults(), is_array( $stored ) ? $stored : [] );
		}
		return $this->values;
	}

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

	public function source() {
		$site = (int) $this->get( 'source_site' );
		return $site ?: ( is_multisite() ? get_main_site_id() : get_current_blog_id() );
	}

	/** Reject malformed input; never allow posted values to select another network. */
	public function sanitize( $input ) {
		$input = is_array( $input ) ? $input : [];
		$out = self::defaults();
		foreach ( [ 'enabled', 'network_links', 'site_links', 'subsite_links', 'menu_edit_links', 'integrations', 'resources', 'file_editors', 'fullscreen', 'new_plugins', 'new_themes', 'plugin_zip_submenu', 'theme_zip_submenu' ] as $key ) {
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
		$source = $out['source_site'] ?: ( is_multisite() ? get_main_site_id() : get_current_blog_id() );
		$valid = MenuRepository::on_site( $source, static function () use ( $out ) {
			return ! $out['menu_id'] || (bool) wp_get_nav_menu_object( $out['menu_id'] );
		} );
		if ( ! $valid ) {
			return new \WP_Error( 'invalid_menu', __( 'The selected menu does not exist on the source website. Load its menus and choose again.', 'multisite-toolbar-additions' ) );
		}
		return $out;
	}

	public function save( array $values ) {
		if ( is_multisite() ) {
			update_network_option( get_current_network_id(), self::OPTION, $values );
		} else {
			update_option( self::OPTION, $values, false );
		}
		$this->values = $values;
	}
}
