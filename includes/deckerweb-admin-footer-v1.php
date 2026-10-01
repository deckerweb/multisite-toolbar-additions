<?php
/**
 * DECKERWEB Admin Footer, API v1.
 * Based on the shared Daily Scripture / Brand Admin Schemes footer.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\AdminFooter\V1;

defined( 'ABSPATH' ) || exit;

/** Plugin-neutral footer. Callers supply translated text and trusted local documents. */
final class Footer {
	public static function render( array $config ): void {
		$id = sanitize_html_class( $config['id'] );
		echo '<footer class="ddw-admin-footer" aria-label="' . esc_attr( $config['about'] ) . '"><div><strong>' . esc_html( $config['name'] ) . '</strong> <span>' . esc_html( $config['version_label'] . ' ' . $config['version'] ) . '</span>';
		foreach ( $config['documents'] as $key => $document ) {
			$target = $id . '-document-' . sanitize_html_class( $key );
			echo ' · <a href="' . esc_url( $document['url'] ) . '" data-ddw-document="' . esc_attr( $target ) . '">' . esc_html( $document['label'] ) . '</a>';
		}
		echo '<p>' . esc_html( $config['slogan'] ) . '</p></div><div><span>' . esc_html( $config['copyright'] ) . ' <a href="https://github.com/deckerweb" target="_blank" rel="noopener noreferrer">David Decker – DECKERWEB</a></span><a href="' . esc_url( $config['repository'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $config['website'] ) . '</a></div></footer>';
		foreach ( $config['documents'] as $key => $document ) {
			$target = $id . '-document-' . sanitize_html_class( $key );
			echo '<dialog class="ddw-document-dialog" id="' . esc_attr( $target ) . '" aria-labelledby="' . esc_attr( $target . '-title' ) . '"><div class="ddw-document-header"><h2 id="' . esc_attr( $target . '-title' ) . '">' . esc_html( $document['label'] ) . '</h2><button type="button" class="button" data-ddw-close>' . esc_html( $config['close'] ) . '</button></div><pre tabindex="0">' . esc_html( $document['text'] ) . '</pre></dialog>';
		}
	}
}
