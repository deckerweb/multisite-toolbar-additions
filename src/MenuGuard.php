<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Enforce shared-menu ownership at Core permission checks, including REST and AJAX. */
final class MenuGuard {
	private $settings;
	/**
	 * Store the services used by this instance without persistent writes.
	 *
	 * @param Settings $settings Current site/network setting service.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function __construct( Settings $settings ) { $this->settings = $settings; }
	/**
	 * Register Core capability, REST and Customizer shared-menu protection.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'map_meta_cap', [ $this, 'capabilities' ], 10, 4 );
		add_filter( 'rest_pre_dispatch', [ $this, 'rest' ], 10, 3 );
		add_action( 'customize_register', [ $this, 'customizer' ], 100 );
		add_filter( 'customize_dynamic_setting_args', [ $this, 'dynamic_setting' ], 100, 2 );
	}
	/**
	 * Determine whether this user is restricted on the shared source site.
	 *
	 * @param int $user_id User whose permission is being evaluated.
	 * @return bool Result described above; unrelated hook values remain unchanged.
	 */
	private function active( $user_id ) { return is_multisite() && ! is_super_admin( $user_id ) && get_current_blog_id() === $this->settings->source(); }
	/**
	 * Resolve the protected menu identifier, including the legacy location.
	 *
	 * @return int Result described above; unrelated hook values remain unchanged.
	 */
	private function menu() {
		$id = (int) $this->settings->get( 'menu_id' );
		if ( ! $id ) { $locations = get_nav_menu_locations(); $id = (int) ( $locations['mstba_menu'] ?? 0 ); }
		return $id;
	}
	/**
	 * Determine whether a menu item belongs to the shared source menu.
	 *
	 * @param int|string $id Menu, item or setting identifier for this operation.
	 * @return bool Result described above; unrelated hook values remain unchanged.
	 */
	private function item_protected( $id ) {
		if ( 'nav_menu_item' !== get_post_type( $id ) ) { return false; }
		$terms = wp_get_object_terms( absint( $id ), 'nav_menu', [ 'fields' => 'ids' ] );
		return is_array( $terms ) && in_array( $this->menu(), array_map( 'intval', $terms ), true );
	}
	/**
	 * Inspect classic form and JSON payloads for shared-menu changes.
	 *
	 * @param array $params Request parameters to inspect without persisting them.
	 * @return bool Result described above; unrelated hook values remain unchanged.
	 */
	private function request_protected( array $params ) {
		$menu = $this->menu();
		if ( ! $menu ) { return false; }
		foreach ( [ 'menu', 'menu_id', 'nav-menu', 'menus' ] as $key ) {
			foreach ( (array) ( $params[ $key ] ?? [] ) as $id ) { if ( is_scalar( $id ) && absint( $id ) === $menu ) { return true; } }
		}
		foreach ( [ 'menu-item', 'menu-item-db-id', 'id' ] as $key ) {
			foreach ( (array) ( $params[ $key ] ?? [] ) as $id ) {
				if ( is_scalar( $id ) && $this->item_protected( absint( $id ) ) ) { return true; }
				if ( is_array( $id ) && isset( $id['menu-item-db-id'] ) && is_scalar( $id['menu-item-db-id'] ) && $this->item_protected( absint( $id['menu-item-db-id'] ) ) ) { return true; }
			}
		}
		if ( is_array( $params['menu-locations'] ?? null ) && array_key_exists( 'mstba_menu', $params['menu-locations'] ) ) { return true; }
		// Core expands this payload after its initial edit_theme_options check.
		if ( isset( $params['nav-menu-data'] ) && is_string( $params['nav-menu-data'] ) ) {
			$data = json_decode( wp_unslash( $params['nav-menu-data'] ), true );
			foreach ( is_array( $data ) ? $data : [] as $field ) {
				if ( ! is_array( $field ) || ! is_string( $field['name'] ?? null ) || ! is_scalar( $field['value'] ?? null ) ) { continue; }
				if ( 'menu-locations[mstba_menu]' === $field['name'] ) { return true; }
				if ( 'menu' === $field['name'] && absint( $field['value'] ) === $menu ) { return true; }
				if ( preg_match( '/^menu-item-db-id(?:\[\d+\])?$/', $field['name'] ) && $this->item_protected( absint( $field['value'] ) ) ) { return true; }
			}
		}
		return false;
	}
	/**
	 * Attach protection to existing navigation settings in the Customizer.
	 *
	 * @param \WP_Customize_Manager $manager Customizer instance with registered settings.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function customizer( $manager ) {
		foreach ( $manager->settings() as $id => $setting ) { $this->protect_setting( $id ); }
	}
	/**
	 * Attach protection to a dynamically registered navigation setting.
	 *
	 * @param array $args Original hook arguments; unrelated values are preserved.
	 * @param int|string $id Menu, item or setting identifier for this operation.
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function dynamic_setting( $args, $id ) { $this->protect_setting( $id ); return $args; }
	/**
	 * Register one validation callback for a matching navigation setting.
	 *
	 * @param int|string $id Menu, item or setting identifier for this operation.
	 * @return void No value; output or hooks are updated as described.
	 */
	private function protect_setting( $id ) {
		if ( ( preg_match( '/^nav_menu(?:_item)?\[-?\d+\]$/', $id ) || 'nav_menu_locations[mstba_menu]' === $id ) && ! has_filter( 'customize_validate_' . $id, [ $this, 'validate_setting' ] ) ) {
			add_filter( 'customize_validate_' . $id, [ $this, 'validate_setting' ], 10, 3 );
		}
	}
	/**
	 * Add a permission error for unauthorized shared-menu modifications.
	 *
	 * @param \WP_Error $validity Existing Customizer validation result.
	 * @param mixed $value Proposed navigation setting value.
	 * @param \WP_Customize_Setting $setting Navigation setting being validated.
	 * @return \WP_Error Result described above; unrelated hook values remain unchanged.
	 */
	public function validate_setting( $validity, $value, $setting ) {
		if ( ! $this->active( get_current_user_id() ) || ! $this->menu() ) { return $validity; }
		$protected = false;
		if ( 'nav_menu_locations[mstba_menu]' === $setting->id ) { $protected = true; }
		if ( preg_match( '/^nav_menu\[(\d+)\]$/', $setting->id, $match ) ) { $protected = (int) $match[1] === $this->menu(); }
		if ( preg_match( '/^nav_menu_item\[(-?\d+)\]$/', $setting->id, $match ) ) {
			$protected = ( (int) $match[1] > 0 && $this->item_protected( (int) $match[1] ) ) || ( is_array( $value ) && (int) ( $value['nav_menu_term_id'] ?? 0 ) === $this->menu() );
		}
		if ( $protected ) { $validity->add( 'mstba_shared_menu', __( 'Only super administrators may edit the shared toolbar menu.', 'multisite-toolbar-additions' ) ); }
		return $validity;
	}
	/**
	 * Deny only protected menu capabilities, preserving unrelated permissions.
	 *
	 * @param array $caps Mapped primitive capabilities.
	 * @param string $cap Requested capability.
	 * @param int $user_id User whose permission is being evaluated.
	 * @param array $args Objects/IDs supplied for the requested meta capability.
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function capabilities( $caps, $cap, $user_id, $args ) {
		if ( ! $this->active( $user_id ) || ! $this->menu() ) { return $caps; }
		if ( in_array( $cap, [ 'edit_term', 'delete_term', 'assign_term' ], true ) && isset( $args[0] ) && (int) $args[0] === $this->menu() ) { return [ 'do_not_allow' ]; }
		if ( in_array( $cap, [ 'edit_post', 'delete_post' ], true ) && isset( $args[0] ) && $this->item_protected( $args[0] ) ) { return [ 'do_not_allow' ]; }
		if ( 'edit_theme_options' === $cap && $this->request_protected( array_merge( $_GET, $_POST ) ) ) { return [ 'do_not_allow' ]; }
		return $caps;
	}
	/**
	 * Reject unauthorized writes to shared REST menus and menu items.
	 *
	 * @param mixed $result Previous REST short-circuit result.
	 * @param \WP_REST_Server $server REST server supplied by Core.
	 * @param \WP_REST_Request $request REST request with route, method and parameters.
	 * @return mixed Result described above; unrelated hook values remain unchanged.
	 */
	public function rest( $result, $server, $request ) {
		if ( ! $this->active( get_current_user_id() ) || in_array( $request->get_method(), [ 'GET', 'HEAD', 'OPTIONS' ], true ) ) { return $result; }
		$route = $request->get_route();
		if ( ! preg_match( '#^/wp/v2/(menus|menu-items)(?:/|$)#', $route, $matches ) ) { return $result; }
		$params = $request->get_params();
		$protected = $this->request_protected( $params );
		if ( preg_match( '#^/wp/v2/menus/(\d+)#', $route, $id ) ) { $protected = $protected || (int) $id[1] === $this->menu(); }
		if ( preg_match( '#^/wp/v2/menu-items/(\d+)#', $route, $id ) ) { $protected = $protected || $this->item_protected( (int) $id[1] ); }
		return $protected ? new \WP_Error( 'mstba_shared_menu', __( 'Only super administrators may edit the shared toolbar menu.', 'multisite-toolbar-additions' ), [ 'status' => 403 ] ) : $result;
	}
}
