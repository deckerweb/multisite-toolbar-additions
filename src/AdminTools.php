<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Provide read-only shortcuts to detected administration tools without loading their code. */
final class AdminTools {
	private Settings $settings;

	/**
	 * Use the current site/network settings or a supplied validated preview.
	 *
	 * @param Settings|null $settings Settings service; null loads the current scope.
	 * @return void
	 */
	public function __construct( ?Settings $settings = null ) {
		$this->settings = $settings ?? new Settings();
	}

	/**
	 * Enqueue local icon/mobile styles only for an eligible right-hand tools menu.
	 *
	 * @return void
	 */
	public function assets(): void {
		$user = wp_get_current_user();
		if ( ! $this->settings->get( 'integrations' ) || 'right' !== $this->settings->get( 'admin_tools_position' ) || ! is_admin_bar_showing() || ! current_user_can( 'manage_options' ) ) { return; }
		if ( ! in_array( 'administrator', (array) $user->roles, true ) && ! ( is_multisite() && is_super_admin() ) ) { return; }
		if ( ! defined( 'DPDEVKIT_URL' ) && ! defined( 'DBTK_DEBUG_TOOLKIT_FILE' ) && ! defined( 'DPLUGINS_AC_ADMIN_SLUG' ) ) { return; }
		wp_enqueue_style( 'mstba-toolbar', plugins_url( 'assets/toolbar.css', MSTBA_PLUGIN_FILE ), [ 'admin-bar' ], PageChrome::asset_version( 'toolbar.css' ) );
	}

	/**
	 * Render an original decorative SVG from a fixed, non-user-provided selection.
	 *
	 * @param string $key Allowlisted icon key; unknown values use the toolbox.
	 * @return string Trusted decorative SVG markup with no scripts or external URLs.
	 */
	public static function icon( string $key ): string {
		$paths = [
			'toolbox' => '<path d="M8 7V4h8v3M3 8h18v12H3zM3 12h18M10 11h4v4h-4z"/>',
			'compass' => '<circle cx="12" cy="12" r="9"/><path d="m16 8-3 5-5 3 3-5zM12 1v2M12 21v2"/>',
			'sliders' => '<path d="M4 3v18M12 3v18M20 3v18"/><path d="M1 7h6v4H1zM9 14h6v4H9zM17 5h6v4h-6z"/>',
		];
		return '<svg class="mstba-tool-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . ( $paths[ $key ] ?? $paths['toolbox'] ) . '</svg>';
	}

	/**
	 * Permit only the plugin's fixed decorative vector attributes at HTML sinks.
	 * @return array SVG element and attribute allowlist; no links, scripts or event handlers.
	 */
	public static function icon_tags(): array {
		return [ 'svg' => array_fill_keys( [ 'class', 'xmlns', 'width', 'height', 'viewbox', 'fill', 'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin', 'aria-hidden', 'focusable' ], true ), 'path' => [ 'd' => true ], 'circle' => [ 'cx' => true, 'cy' => true, 'r' => true ] ];
	}

	/**
	 * Add a compact site tools section for administrators and super administrators.
	 *
	 * All destinations belong to the current website, including in network admin.
	 * No actions, license checks, external requests or settings writes are performed.
	 *
	 * @param \WP_Admin_Bar $bar Toolbar receiving escaped destinations.
	 * @return void
	 */
	public function render( $bar ): void {
		if ( ! $this->settings->get( 'integrations' ) ) { return; }
		$right = 'right' === $this->settings->get( 'admin_tools_position' );
		$user = wp_get_current_user();
		$administrator = in_array( 'administrator', (array) $user->roles, true );
		if ( ! current_user_can( 'manage_options' ) || ( ! $administrator && ! ( is_multisite() && is_super_admin() ) ) ) { return; }
		if ( ! $right && ( ! $bar->get_node( 'site-name' ) || ( defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) && ! MSTBA_DISPLAY_SITE_EXTEND_GROUP ) ) ) { return; }
		$tools = [];
		if ( defined( 'DPDEVKIT_URL' ) && $this->page_available( 'devkit', '' ) ) {
			$children = [
				[ 'error-log', __( 'Error Log', 'multisite-toolbar-additions' ), 'module=error-log&sub=viewer' ],
				[ 'cron', __( 'Cron Inspector', 'multisite-toolbar-additions' ), 'module=cron' ],
				[ 'files', __( 'File Manager', 'multisite-toolbar-additions' ), 'module=file-manager' ],
				[ 'performance', __( 'Performance', 'multisite-toolbar-additions' ), 'module=performance&sub=quick-scan' ],
			];
			$tools[] = [ 'devkit', 'DevKit Pro', 'admin.php?page=devkit', $children ];
		}
		if ( defined( 'DBTK_DEBUG_TOOLKIT_FILE' ) ) {
			$parent = 'tools' === get_option( 'wpdebugtoolkit_menu_location', 'top-level' ) ? 'tools.php' : '';
			if ( $this->page_available( 'wpdebugtoolkit', $parent ) ) {
				$viewer_url = $this->debug_viewer_url();
				$tools[] = [ 'debug-toolkit', 'WP Debug Toolkit', ( $parent ?: 'admin.php' ) . '?page=wpdebugtoolkit', [
					[ 'viewer', __( 'Debug Viewer Settings', 'multisite-toolbar-additions' ), 'tab=viewer' ],
					[ 'php', __( 'PHP Settings', 'multisite-toolbar-additions' ), 'tab=php' ],
					[ 'logs', __( 'Log Settings', 'multisite-toolbar-additions' ), 'tab=logs' ],
					[ 'notifications', __( 'Error Notifications', 'multisite-toolbar-additions' ), 'tab=notifications' ],
				], $viewer_url ];
				if ( $viewer_url ) {
					$last = array_key_last( $tools );
					array_unshift( $tools[ $last ][3],
						[ 'open-viewer', __( 'Open Debug Viewer', 'multisite-toolbar-additions' ), $viewer_url, true ],
						[ 'settings', __( 'Plugin Settings', 'multisite-toolbar-additions' ), '' ]
					);
				}
			}
		}
		if ( defined( 'DPLUGINS_AC_ADMIN_SLUG' ) && $this->cleaner_available( $administrator, (int) $user->ID ) && $this->page_available( 'dplugins_admin_cleaner', 'tools.php' ) ) {
			$tools[] = [ 'admin-cleaner', 'WP Admin Cleaner', 'tools.php?page=dplugins_admin_cleaner', [] ];
		}
		if ( ! $tools ) { return; }
		$label = trim( (string) $this->settings->get( 'admin_tools_label' ) );
		$label = '' !== $label ? $label : __( 'Admin Tools', 'multisite-toolbar-additions' );
		$title = esc_html( $label );
		if ( $right ) {
			if ( ! $bar->get_node( 'top-secondary' ) ) { $bar->add_group( [ 'id' => 'top-secondary' ] ); }
			$title = '<span class="ab-icon">' . self::icon( (string) $this->settings->get( 'admin_tools_icon' ) ) . '</span><span class="mstba-tools-label">' . $title . '</span>';
			$parent = 'top-secondary';
		} else {
			$bar->add_group( [ 'id' => 'ddw-mstba-admintoolsgroup', 'parent' => 'site-name' ] );
			$parent = 'ddw-mstba-admintoolsgroup';
		}
		$bar->add_node( [ 'id' => 'ddw-mstba-admin-tools', 'parent' => $parent, 'title' => $title, 'meta' => [ 'class' => $right ? 'mstba-tools-root' : '', 'title' => $label, 'menu_title' => $label ] ] );
		foreach ( $tools as $tool ) {
			[ $id, $label, $path, $children ] = $tool;
			$node = 'ddw-mstba-' . $id;
			$bar->add_node( [ 'id' => $node, 'parent' => 'ddw-mstba-admin-tools', 'title' => esc_html( $label ), 'href' => esc_url( $tool[4] ?? admin_url( $path ) ) ] );
			foreach ( $children as $destination ) {
				[ $child, $title, $query ] = $destination;
				$url = ! empty( $destination[3] ) ? $query : admin_url( $path . ( '' !== $query ? '&' . $query : '' ) );
				$bar->add_node( [ 'id' => $node . '-' . $child, 'parent' => $node, 'title' => esc_html( $title ), 'href' => esc_url( $url ) ] );
			}
		}
	}

	/**
	 * Obtain an installed debug viewer through the target plugin's public service.
	 *
	 * Use its current validated slug and public website base, without reading auth
	 * files or creating login tokens. A missing or incompatible service fails closed.
	 *
	 * @return string|null Viewer URL, or null when unavailable or invalid.
	 */
	private function debug_viewer_url(): ?string {
		if ( ! class_exists( '\DebugToolkit\Core', false ) || ! is_callable( [ '\DebugToolkit\Core', 'get_service' ] ) ) { return null; }
		try {
			$viewer = \DebugToolkit\Core::get_service( 'viewer_manager' );
			if ( ! is_object( $viewer ) || ! is_callable( [ $viewer, 'is_installed' ] ) || ! is_callable( [ $viewer, 'get_viewer_url' ] ) || ! $viewer->is_installed() ) { return null; }
			$slug = $viewer->get_viewer_url();
			if ( ! is_string( $slug ) || ! preg_match( '/\A[a-zA-Z0-9_-]{1,50}\z/', $slug ) ) { return null; }
			return home_url( '/' . $slug . '/' );
		} catch ( \Throwable $error ) {
			return null;
		}
	}

	/**
	 * Check an already registered site admin page without invoking plugin callbacks.
	 *
	 * Frontend and network requests do not run the site admin_menu hook; use loaded
	 * plugin detection there. Site admin requests additionally honor removed pages.
	 *
	 * @param string $slug Verified plugin page slug.
	 * @param string $parent Core parent filename or empty string for top-level pages.
	 * @return bool Whether the destination is available in this request context.
	 */
	private function page_available( string $slug, string $parent ): bool {
		if ( ! is_admin() || is_network_admin() || ! did_action( 'admin_menu' ) ) { return true; }
		return isset( $GLOBALS['_registered_pages'][ get_plugin_page_hookname( $slug, $parent ) ] );
	}

	/**
	 * Honor WP Admin Cleaner's owner, role and hidden-settings restrictions.
	 *
	 * @param bool $administrator Whether the current user holds the administrator role.
	 * @param int $user_id Current authenticated user's ID.
	 * @return bool Whether the plugin permits this user's settings entry.
	 */
	private function cleaner_available( bool $administrator, int $user_id ): bool {
		if ( $administrator ) {
			$owner = (int) get_option( 'DP_AC_super_admin', 0 );
			return ! $owner || $owner === $user_id || 'no' === ( get_option( 'DP_AC_disable_wpac', 'no' ) ?: 'no' );
		}
		$roles = get_option( 'DP_AC_roles', [] );
		return is_array( $roles ) && (bool) array_intersect( (array) wp_get_current_user()->roles, $roles ) && current_user_can( 'DP_AC_cap' );
	}
}
