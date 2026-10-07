<?php
/**
 * Generate native PHP translation catalogs using Core's MO parser.
 * Run only against a disposable WordPress installation after languages.py.
 *
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) { exit( "Provide a disposable wp-load.php path.\n" ); }
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/';
require $argv[1];
foreach ( [ 'de_DE', 'de_DE_formal' ] as $locale ) {
 $base = dirname( __DIR__ ) . '/languages/multisite-toolbar-additions-' . $locale;
 $resource = WP_Translation_File::create( $base . '.mo' );
 if ( ! $resource ) { throw new RuntimeException( 'Invalid compiled translation resource.' ); }
 $text = "<?php\n// Generated from the accompanying PO catalog.\nreturn " . var_export( array_merge( $resource->headers(), [ 'messages' => $resource->entries() ] ), true ) . ";\n";
 $text = preg_replace( '/[\t ]+$/m', '', $text );
 file_put_contents( $base . '.l10n.php', $text );
}
echo "Native host translation catalogs generated.\n";
