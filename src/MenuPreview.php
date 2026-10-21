<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Read-only menu inspection, scoped to authorized settings users. */
final class MenuPreview {
	/**
	 * Provide localized progressive-enhancement labels and a preview-only nonce.
	 * @return array
	 */
	public static function config(): array {
		return [ 'url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'mstba_menu_preview' ), 'labels' => [
			'draft' => __( 'Preview of unsaved settings. Save changes to apply them.', 'multisite-toolbar-additions' ),
			'busy' => __( 'Updating preview…', 'multisite-toolbar-additions' ),
			'error' => __( 'The preview could not be updated. Your settings have not been changed.', 'multisite-toolbar-additions' ),
			'anchor' => __( 'The reference item is missing on this page. The menu will appear last on the left here.', 'multisite-toolbar-additions' ),
			'anchorScope' => __( 'Position checks describe this page only. Frontend and other admin pages can have different toolbar items.', 'multisite-toolbar-additions' ),
			/* translators: Placeholder values are the displayed count, website identifier or formatted upload size. */
			'level' => __( 'Level %d', 'multisite-toolbar-additions' ),
			'saved' => __( 'All changes saved', 'multisite-toolbar-additions' ),
			'unsaved' => __( 'Unsaved changes', 'multisite-toolbar-additions' ),
			'discard' => __( 'Discard unsaved changes and reload the page?', 'multisite-toolbar-additions' ),
			'preview' => __( 'Toolbar preview', 'multisite-toolbar-additions' ),
			'summary' => __( 'Effective settings', 'multisite-toolbar-additions' ),
			'model' => __( 'Simplified toolbar preview. Expand entries to explore their children; destination links are not opened.', 'multisite-toolbar-additions' ),
		] ];
	}
	/**
	 * Build a bounded, content-only view using the same traversal and source rules as the toolbar.
	 * @param Settings $settings Saved or validated temporary settings.
	 * @return array
	 */
	public static function snapshot( Settings $settings ): array {
		$warnings = [];
		$source = $settings->source();
		if ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) ) { $warnings[] = __( 'A legacy constant controls whether this menu is enabled. Changing the checkbox cannot override it.', 'multisite-toolbar-additions' ); }
		$valid = true;
		if ( is_multisite() ) {
			$site = get_site( $source );
			$valid = $site && (int) $site->network_id === get_current_network_id() && ! $site->deleted && ! $site->archived && ! $site->spam;
			if ( ! $valid ) { $warnings[] = __( 'The saved source website is unavailable. Load the menus of an active website and save a new source.', 'multisite-toolbar-additions' ); }
			elseif ( ! Settings::network_active() && ! in_array( plugin_basename( MSTBA_PLUGIN_FILE ), (array) get_blog_option( $source, 'active_plugins', [] ), true ) ) { $warnings[] = __( 'The plugin is inactive on the source website. Activate it there or network-wide to use this menu.', 'multisite-toolbar-additions' ); }
		}
		$repository = new MenuRepository( $settings );
		$items = $valid ? $repository->items() : [];
		$name = $valid ? $repository->name() : '';
		if ( $valid && '' === $name ) { $warnings[] = __( 'No source menu is available. Choose an existing menu, or assign one to the legacy toolbar location.', 'multisite-toolbar-additions' ); }
		elseif ( $valid && ! $items ) { $warnings[] = __( 'The selected menu has no published entries. Add menu items before using it in the toolbar.', 'multisite-toolbar-additions' ); }
		$tree = ToolbarMenu::tree( $items, (int) $settings->get( 'child_depth' ) );
		if ( $items && ! $tree ) { $warnings[] = __( 'No reachable root entries exist. Check the parent relationships in the WordPress menu.', 'multisite-toolbar-additions' ); }
		$children = [];
		foreach ( $tree as $entry ) { $children[ (int) $entry[0]->menu_item_parent ][] = $entry; }
		$stack = array_reverse( $children[0] ?? [] ); $rows = [];
		while ( $stack && count( $rows ) < 200 ) {
			[ $item, $depth ] = array_pop( $stack );
			$rows[] = [ 'title' => wp_html_excerpt( wp_strip_all_tags( (string) $item->title ), 500, '…' ), 'depth' => (int) $depth ];
			foreach ( array_reverse( $children[ (int) $item->ID ] ?? [] ) as $child ) { $stack[] = $child; }
		}
		if ( count( $tree ) > 200 ) { $warnings[] = __( 'The preview shows the first 200 entries. The toolbar continues to use the full menu and your configured depth.', 'multisite-toolbar-additions' ); }
		$contexts = [ 'both' => __( 'Frontend and administration', 'multisite-toolbar-additions' ), 'admin' => __( 'Administration only', 'multisite-toolbar-additions' ), 'frontend' => __( 'Frontend only', 'multisite-toolbar-additions' ) ];
		$positions = [ 'first' => __( 'First on the left', 'multisite-toolbar-additions' ), 'last' => __( 'Last on the left', 'multisite-toolbar-additions' ), 'right' => __( 'On the right, beside the account menu', 'multisite-toolbar-additions' ), 'before' => __( 'Before the following item', 'multisite-toolbar-additions' ), 'after' => __( 'After the following item', 'multisite-toolbar-additions' ) ];
		$summary = [
			__( 'Custom menu', 'multisite-toolbar-additions' ) => $settings->get( 'enabled' ) ? __( 'Enabled', 'multisite-toolbar-additions' ) : __( 'Disabled', 'multisite-toolbar-additions' ),
			__( 'Source website', 'multisite-toolbar-additions' ) => ( is_multisite() ? ( $valid ? $site->domain . $site->path : __( 'Unavailable', 'multisite-toolbar-additions' ) ) : wp_strip_all_tags( get_bloginfo( 'name' ) ) ) . ' · #' . $source,
			__( 'WordPress menu', 'multisite-toolbar-additions' ) => $name ?: __( 'Unavailable', 'multisite-toolbar-additions' ),
			__( 'Show in', 'multisite-toolbar-additions' ) => $contexts[ $settings->get( 'context' ) ] ?? '',
			__( 'Visible to', 'multisite-toolbar-additions' ) => is_multisite() && 'administrators' === $settings->get( 'audience' ) ? __( 'Super administrators only', 'multisite-toolbar-additions' ) : ( is_multisite() ? __( 'Super administrators and website administrators', 'multisite-toolbar-additions' ) : __( 'Administrators', 'multisite-toolbar-additions' ) ),
			__( 'Position', 'multisite-toolbar-additions' ) => ( $positions[ $settings->get( 'position' ) ] ?? '' ) . ( in_array( $settings->get( 'position' ), [ 'before', 'after' ], true ) ? ' · ' . $settings->get( 'anchor' ) : '' ),
			__( 'Child levels', 'multisite-toolbar-additions' ) => $settings->get( 'child_depth' ) ? (string) $settings->get( 'child_depth' ) : __( 'All levels', 'multisite-toolbar-additions' ),
			__( 'Layout', 'multisite-toolbar-additions' ) => 'grouped' === $settings->get( 'layout' ) ? __( 'Everything under one toolbar item', 'multisite-toolbar-additions' ) : __( 'Each root item in the toolbar', 'multisite-toolbar-additions' ),
		];
		$summary[ __( 'ZIP submenu links', 'multisite-toolbar-additions' ) ] = 'Plugin: ' . ( $settings->get( 'plugin_zip_submenu' ) ? __( 'Enabled', 'multisite-toolbar-additions' ) : __( 'Disabled', 'multisite-toolbar-additions' ) ) . ' · Theme: ' . ( $settings->get( 'theme_zip_submenu' ) ? __( 'Enabled', 'multisite-toolbar-additions' ) : __( 'Disabled', 'multisite-toolbar-additions' ) );
		$summary[ __( 'Additions under New', 'multisite-toolbar-additions' ) ] = 'Plugin: ' . ( $settings->get( 'new_plugins' ) ? __( 'Enabled', 'multisite-toolbar-additions' ) : __( 'Disabled', 'multisite-toolbar-additions' ) ) . ' · Theme: ' . ( $settings->get( 'new_themes' ) ? __( 'Enabled', 'multisite-toolbar-additions' ) : __( 'Disabled', 'multisite-toolbar-additions' ) );
		foreach ( [ 'plugin', 'theme' ] as $type ) {
			$summary[ self::uploader_label( $type ) ] = ! Uploads::allowed( $type ) ? __( 'Unavailable for your account', 'multisite-toolbar-additions' ) : ( Uploads::leitstand( $type ) ? __( 'Shared uploader', 'multisite-toolbar-additions' ) : 'Multisite Toolbar Additions' );
		}
		return [ 'rows' => $rows, 'summary' => $summary, 'warnings' => $warnings, 'group' => 'grouped' === $settings->get( 'layout' ) ? ( $settings->get( 'label' ) ?: $name ) : '', 'position' => $settings->get( 'position' ), 'anchor' => $settings->get( 'anchor' ) ];
	}
	/**
	 * Return a translated summary label for each uploader provider.
	 * @param string $type Package type.
	 * @return string
	 */
	private static function uploader_label( string $type ): string {
		return 'plugin' === $type ? __( 'Plugin uploader', 'multisite-toolbar-additions' ) : __( 'Theme uploader', 'multisite-toolbar-additions' );
	}
	/**
	 * Print the saved state even without JavaScript; previews contain no actionable destination links.
	 * @param Settings $settings Saved settings.
	 * @return void
	 */
	public static function render( Settings $settings ): void {
		if ( ! current_user_can( Settings::capability() ) ) { return; }
		$data = self::snapshot( $settings );
		echo '<section class="mstba-panel" id="mstba-preview" aria-labelledby="mstba-preview-heading"><h2 id="mstba-preview-heading">' . esc_html__( 'Menu preview and effective settings', 'multisite-toolbar-additions' ) . '</h2><p class="description">' . esc_html__( 'This view describes the saved settings. The preview does not change your menu, grant access to destinations, or override personal toolbar visibility.', 'multisite-toolbar-additions' ) . '</p><p id="mstba-preview-status" role="status" aria-live="polite"></p><div id="mstba-preview-content">';
		echo '<h3>' . esc_html__( 'Toolbar preview', 'multisite-toolbar-additions' ) . '</h3>';
		self::model( $data );
		echo '<ul class="mstba-preview-warnings">';
		foreach ( $data['warnings'] as $warning ) { echo '<li>' . esc_html( $warning ) . '</li>'; }
		echo '</ul><h3>' . esc_html__( 'Effective settings', 'multisite-toolbar-additions' ) . '</h3><dl class="mstba-summary">';
		foreach ( $data['summary'] as $label => $value ) { echo '<dt>' . esc_html( $label ) . '</dt><dd>' . esc_html( $value ) . '</dd>'; }
		echo '</dl></div><p id="mstba-anchor-status"></p><p class="description">' . esc_html__( 'Position checks describe this page only. Frontend and other admin pages can have different toolbar items.', 'multisite-toolbar-additions' ) . '</p></section>';
		wp_add_inline_script( 'mstba-settings', 'window.mstbaSavedPreview = ' . wp_json_encode( [ 'position' => $data['position'], 'anchor' => $data['anchor'] ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . ';', 'before' );
	}
	/**
	 * Print a keyboard-accessible native-looking toolbar model without destination links.
	 * @param array $data Validated snapshot rows and grouping label.
	 * @return void
	 */
	private static function model( array $data ): void {
		echo '<div class="mstba-toolbar-model' . ( 'right' === $data['position'] ? ' mstba-model-right' : '' ) . '"><p class="mstba-model-note">' . esc_html__( 'Simplified toolbar preview. Expand entries to explore their children; destination links are not opened.', 'multisite-toolbar-additions' ) . '</p>';
		if ( $data['group'] ) { echo '<details class="mstba-model-group" open><summary>' . esc_html( $data['group'] ) . '</summary>'; }
		echo '<ul class="mstba-preview-tree' . ( $data['group'] ? '' : ' mstba-model-roots' ) . '">';
		$stack = [];
		foreach ( $data['rows'] as $index => $row ) {
			while ( $stack && end( $stack ) >= $row['depth'] ) { array_pop( $stack ); echo '</ul></details></li>'; }
			$has_children = isset( $data['rows'][ $index + 1 ] ) && $data['rows'][ $index + 1 ]['depth'] > $row['depth'];
			echo '<li class="mstba-level-' . esc_attr( min( 4, $row['depth'] ) ) . '">';
			/* translators: Placeholder values are the displayed count, website identifier or formatted upload size. */
			$title = esc_html( $row['title'] ) . '<span class="screen-reader-text"> · ' . esc_html( sprintf( __( 'Level %d', 'multisite-toolbar-additions' ), $row['depth'] ) ) . '</span>';
			if ( $has_children ) { echo '<details open><summary>' . wp_kses( $title, [ 'span' => [ 'class' => true ] ] ) . '</summary><ul>'; $stack[] = $row['depth']; }
			else { echo '<span class="mstba-model-label">' . wp_kses( $title, [ 'span' => [ 'class' => true ] ] ) . '</span></li>'; }
		}
		while ( $stack ) { array_pop( $stack ); echo '</ul></details></li>'; }
		echo '</ul>';
		if ( $data['group'] ) { echo '</details>'; }
		echo '</div>';
	}

	/**
	 * Validate a signed read-only POST and return a transient preview without saving settings.
	 * @return void
	 */
	public static function action(): void {
		if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) || ! current_user_can( Settings::capability() ) ) { wp_send_json_error( [ 'message' => __( 'Access denied.', 'multisite-toolbar-additions' ) ], 403 ); }
		check_ajax_referer( 'mstba_menu_preview', 'nonce' );
		$settings = new Settings();
		$values = $settings->sanitize( isset( $_POST['mstba'] ) ? map_deep( wp_unslash( $_POST['mstba'] ), 'sanitize_text_field' ) : [] );
		if ( is_wp_error( $values ) ) { wp_send_json_error( [ 'message' => $values->get_error_message() ], 400 ); }
		wp_send_json_success( self::snapshot( Settings::preview( $values ) ) );
	}
}
