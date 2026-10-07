<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Provide localized branding, navigation and local settings documentation. */
final class PageChrome {
	/**
	 * Print the localized settings identity and in-page section navigation.
	 *
	 * @param string $section Optional translated context label; empty uses toolbar settings.
	 * @param bool $navigation Whether settings-section anchors are appropriate on this page.
	 * @return void
	 */
	public static function header( string $section = '', bool $navigation = true ): void {
		echo '<header class="mstba-header"><picture class="mstba-brand-icon"><source type="image/svg+xml" srcset="' . esc_url( plugins_url( 'assets/brand/icon.svg', MSTBA_PLUGIN_FILE ) ) . '"><img src="' . esc_url( plugins_url( 'assets/brand/icon-128x128.png', MSTBA_PLUGIN_FILE ) ) . '" width="72" height="72" alt=""></picture><div><p class="mstba-eyebrow">DECKERWEB · ' . ( '' === $section ? esc_html__( 'Toolbar settings', 'multisite-toolbar-additions' ) : esc_html( $section ) ) . '</p><h1>Multisite Toolbar Additions</h1><p>' . esc_html__( 'Many sites. One move.', 'multisite-toolbar-additions' ) . '</p></div></header><hr class="wp-header-end">';
		if ( $navigation ) { echo '<nav class="mstba-nav" aria-label="' . esc_attr__( 'Settings sections', 'multisite-toolbar-additions' ) . '"><a href="#mstba-menu-panel">' . esc_html__( 'Your toolbar menu', 'multisite-toolbar-additions' ) . '</a><a href="#mstba-shortcuts-panel">' . esc_html__( 'Useful shortcuts', 'multisite-toolbar-additions' ) . '</a></nav>'; }
	}
	/**
	 * Print local documentation and recent release history in accessible dialogs.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public static function footer(): void {
		if ( ! class_exists( '\Deckerweb\AdminFooter\V1\Footer' ) ) { require_once MSTBA_PLUGIN_DIR . 'includes/deckerweb-admin-footer-v1.php'; }
		require_once MSTBA_PLUGIN_DIR . 'includes/deckerweb-changelog-v1.php';
		$repo = 'https://github.com/deckerweb/multisite-toolbar-additions';
		$file = determine_locale() === 'de_DE' || determine_locale() === 'de_DE_formal' ? 'readme-de.txt' : 'readme.txt';
		$path = MSTBA_PLUGIN_DIR . $file;
		$text = is_readable( $path ) ? file_get_contents( $path ) : '';
		$text = is_string( $text ) ? $text : '';
		$changelog_file = $file === 'readme-de.txt' ? 'docs/changelog-de.txt' : 'docs/changelog.txt';
		$changelog_path = MSTBA_PLUGIN_DIR . $changelog_file;
		$full_changes = is_readable( $changelog_path ) ? file_get_contents( $changelog_path ) : '';
		$changes = preg_match( '/^== Changelog ==\s*\R(.*?)(?=^== [^\r\n]+ ==\s*$|\z)/ms', $text, $match ) ? trim( $match[1] ) : '';
		if ( is_string( $full_changes ) && $full_changes !== '' ) { $changes = trim( $full_changes ); }
		$guide = $file === 'readme-de.txt' ? 'Deutsch' : 'English';
		\Deckerweb\AdminFooter\V1\StructuredFooter::render( [
			'id' => 'mstba', 'name' => 'Multisite Toolbar Additions', 'version' => MSTBA_PLUGIN_VERSION,
			'version_label' => __( 'Version', 'multisite-toolbar-additions' ), 'about' => __( 'Plugin information', 'multisite-toolbar-additions' ),
			'slogan' => __( 'Many sites. One move.', 'multisite-toolbar-additions' ), 'copyright' => '© 2012–2026',
			'repository' => $repo, 'website' => __( 'Plugin website', 'multisite-toolbar-additions' ), 'close' => __( 'Close', 'multisite-toolbar-additions' ),
			'documents' => [
				'changelog' => [ 'label' => __( 'Changelog', 'multisite-toolbar-additions' ), 'url' => $repo . '/wiki/Changelog-' . ( $guide === 'Deutsch' ? 'Deutsch' : 'English' ), 'text' => $changes ],
				'documentation' => [ 'label' => __( 'Documentation', 'multisite-toolbar-additions' ), 'url' => $repo . '/wiki/' . $guide, 'text' => $text ],
			],
		] );
	}
}
