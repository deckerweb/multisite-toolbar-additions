<?php
/**
 * Remove temporary data and honor each site's or network's deletion preference.
 *
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
require_once __DIR__ . '/src/Lifecycle.php';
\Deckerweb\MultisiteToolbar\Lifecycle::uninstall();
if ( is_readable( __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php' ) ) {
	require_once __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php';
	if ( function_exists( 'deckerweb_library_uninstall_v3' ) ) { deckerweb_library_uninstall_v3( __DIR__ . '/multisite-toolbar-additions.php' ); }
}
