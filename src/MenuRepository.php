<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** WordPress owns menu storage and object caching; no stale cross-user HTML cache. */
final class MenuRepository {
	private $settings;
	private $items;
	private $name = '';
	/**
	 * Store the services used by this instance without persistent writes.
	 *
	 * @param Settings $settings Current site/network setting service.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function __construct( Settings $settings ) { $this->settings = $settings; }

	/**
	 * Run a callback on a source site and restore the original site in finally.
	 *
	 * @param int $site Source website ID.
	 * @param callable $callback Callback to run in the selected site context.
	 * @return mixed Result described above; unrelated hook values remain unchanged.
	 */
	public static function on_site( $site, callable $callback ) {
		$switched = is_multisite() && (int) $site !== get_current_blog_id();
		if ( $switched ) { switch_to_blog( $site ); }
		try { return $callback(); }
		finally { if ( $switched ) { restore_current_blog(); } }
	}

	/**
	 * Return the selected menu name, loading its items once if needed.
	 *
	 * @return string Result described above; unrelated hook values remain unchanged.
	 */
	public function name() {
		$this->items();
		return $this->name;
	}

	/**
	 * Load a valid source menu once; retain the legacy location as fallback.
	 *
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function items() {
		if ( null !== $this->items ) { return $this->items; }
		$source = $this->settings->source();
		if ( is_multisite() && ! Settings::network_active() && ! in_array( plugin_basename( MSTBA_PLUGIN_FILE ), (array) get_blog_option( $source, 'active_plugins', [] ), true ) ) { return $this->items = []; }
		if ( is_multisite() ) {
			$site = get_site( $source );
			if ( ! $site || (int) $site->network_id !== get_current_network_id() || $site->deleted || $site->archived || $site->spam ) { return $this->items = []; }
		}
		return $this->items = self::on_site( $source, /** Resolve and load the selected source menu within its website context.
 * @return array Result described above.
 */
function () {
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
