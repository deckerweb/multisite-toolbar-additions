<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

final class ToolbarMenu {
	private $settings;
	private $menus;
	private $roots = [];
	public function __construct( Settings $settings, MenuRepository $menus ) { $this->settings = $settings; $this->menus = $menus; }

	public function register() {
		add_action( 'admin_bar_menu', [ $this, 'render' ], 9999 );
		add_action( 'wp_before_admin_bar_render', [ $this, 'position' ], PHP_INT_MAX );
		add_action( 'wp_enqueue_scripts', [ $this, 'assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
	}
	public function assets() {
		if ( $this->visible() ) { wp_enqueue_style( 'mstba-toolbar', plugins_url( 'assets/toolbar.css', MSTBA_PLUGIN_FILE ), [ 'admin-bar' ], MSTBA_PLUGIN_VERSION ); }
	}

	public function visible() {
		if ( ! $this->settings->get( 'enabled' ) || ! is_user_logged_in() || ! is_admin_bar_showing() ) { return false; }
		$context = $this->settings->get( 'context' );
		if ( ( 'admin' === $context && ! is_admin() ) || ( 'frontend' === $context && is_admin() ) ) { return false; }
		if ( is_multisite() && 'administrators' === $this->settings->get( 'audience' ) ) { return is_super_admin(); }
		return current_user_can( 'manage_options' ) || ( is_multisite() && is_super_admin() );
	}

	/** Iterative traversal: linear cost, skips orphans and cycles without recursion. */
	public static function tree( array $items, $child_depth ) {
		$children = [];
		foreach ( $items as $item ) {
			if ( ! is_object( $item ) || empty( $item->ID ) ) { continue; }
			$children[ absint( $item->menu_item_parent ?? 0 ) ][] = $item;
		}
		$queue = [];
		foreach ( $children[0] ?? [] as $item ) { $queue[] = [ $item, 0 ]; }
		$out = []; $seen = [];
		for ( $i = 0; $i < count( $queue ); ++$i ) {
			[ $item, $depth ] = $queue[ $i ];
			$id = absint( $item->ID );
			if ( isset( $seen[ $id ] ) ) { continue; }
			$seen[ $id ] = true;
			$out[] = [ $item, $depth ];
			if ( 0 === (int) $child_depth || $depth < $child_depth ) {
				foreach ( $children[ $id ] ?? [] as $child ) { $queue[] = [ $child, $depth + 1 ]; }
			}
		}
		return $out;
	}

	public function render( $bar ) {
		$this->roots = [];
		if ( ! $this->visible() ) { return; }
		$items = self::tree( $this->menus->items(), (int) $this->settings->get( 'child_depth' ) );
		if ( ! $items ) { return; }
		$grouped = 'grouped' === $this->settings->get( 'layout' );
		$right = 'right' === $this->settings->get( 'position' );
		if ( $grouped ) {
			$bar->add_node( [ 'id' => 'mstba-menu', 'parent' => $right ? 'top-secondary' : false, 'title' => esc_html( $this->settings->get( 'label' ) ?: $this->menus->name() ), 'meta' => [ 'class' => 'mstba-menu mstba-root' ] ] );
			$this->roots[] = 'mstba-menu';
		}
		foreach ( $items as [ $item, $depth ] ) {
			$id = 'mstba_' . absint( $item->ID );
			$parent = $depth ? 'mstba_' . absint( $item->menu_item_parent ) : ( $grouped ? 'mstba-menu' : ( $right ? 'top-secondary' : false ) );
			$classes = array_filter( array_map( 'sanitize_html_class', (array) ( $item->classes ?? [] ) ) );
			$target = '_blank' === ( $item->target ?? '' ) ? '_blank' : '';
			$rel = preg_split( '/\s+/', (string) ( $item->xfn ?? '' ), -1, PREG_SPLIT_NO_EMPTY );
			$rel = array_map( 'sanitize_key', $rel );
			if ( $target ) { $rel = array_merge( $rel, [ 'noopener', 'noreferrer' ] ); }
			$bar->add_node( [
				'id' => $id, 'parent' => $parent, 'title' => esc_html( $item->title ), 'href' => esc_url( $item->url ),
				'meta' => [ 'target' => $target, 'rel' => implode( ' ', array_unique( $rel ) ), 'title' => (string) ( $item->attr_title ?? '' ), 'class' => 'mstba ' . ( ! $depth && ! $grouped ? 'mstba-root ' : '' ) . implode( ' ', $classes ) ],
			] );
			if ( ! $depth && ! $grouped ) { $this->roots[] = $id; }
		}
	}

	/** Reinsert public nodes in the desired order; never depend on Core's private tree. */
	public function position() {
		global $wp_admin_bar;
		if ( ! $this->roots || ! $wp_admin_bar ) { return; }
		$position = $this->settings->get( 'position' );
		if ( 'last' === $position || 'right' === $position ) { return; }
		$nodes = (array) $wp_admin_bar->get_nodes();
		$top = []; $custom = [];
		foreach ( $nodes as $id => $node ) {
			if ( in_array( $id, $this->roots, true ) ) { $custom[ $id ] = $node; }
			elseif ( empty( $node->parent ) && empty( $node->group ) ) { $top[ $id ] = $node; }
		}
		$ordered = []; $inserted = false;
		if ( 'first' === $position ) { $ordered = $custom; $inserted = true; }
		foreach ( $top as $id => $node ) {
			if ( $id === $this->settings->get( 'anchor' ) && 'before' === $position ) { $ordered += $custom; $inserted = true; }
			$ordered[ $id ] = $node;
			if ( $id === $this->settings->get( 'anchor' ) && 'after' === $position ) { $ordered += $custom; $inserted = true; }
		}
		if ( ! $inserted ) { $ordered += $custom; }
		foreach ( array_keys( $ordered ) as $id ) { $wp_admin_bar->remove_node( $id ); }
		foreach ( $ordered as $node ) { $wp_admin_bar->add_node( (array) $node ); }
	}
}
