<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** WordPress owns menu storage and object caching; no stale cross-user HTML cache. */
final class MenuRepository {
	private $settings;
	private $items;
	private $name = '';
	public function __construct( Settings $settings ) { $this->settings = $settings; }

	public static function on_site( $site, callable $callback ) {
		$switched = is_multisite() && (int) $site !== get_current_blog_id();
		if ( $switched ) { switch_to_blog( $site ); }
		try { return $callback(); }
		finally { if ( $switched ) { restore_current_blog(); } }
	}

	public function name() {
		$this->items();
		return $this->name;
	}

	public function items() {
		if ( null !== $this->items ) { return $this->items; }
		$source = $this->settings->source();
		if ( is_multisite() ) {
			$site = get_site( $source );
			if ( ! $site || (int) $site->network_id !== get_current_network_id() || $site->deleted || $site->archived || $site->spam ) { return $this->items = []; }
		}
		return $this->items = self::on_site( $source, function () {
			$id = (int) $this->settings->get( 'menu_id' );
			// Upgrade fallback: the old theme location keeps working until a menu is explicitly selected.
			if ( ! $id ) {
				$locations = get_nav_menu_locations();
				$id = (int) ( $locations['mstba_menu'] ?? 0 );
			}
			$menu = $id ? wp_get_nav_menu_object( $id ) : false;
			if ( ! $menu || is_wp_error( $menu ) ) { return []; }
			$this->name = (string) $menu->name;
			$items = wp_get_nav_menu_items( $menu->term_id );
			return is_array( $items ) ? $items : [];
		} );
	}
}
