<?php
/**
 * DECKERWEB Admin Footer, compatible API v1 with structured documents.
 * Based on Daily Scripture / Brand Admin Schemes and the shared changelog renderer.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\AdminFooter\V1;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( StructuredFooter::class, false ) ) {
	/** Render local documents without changing another plugin's older Footer class. */
	final class StructuredFooter {
		/**
		 * Print one footer and its accessible native dialogs.
		 *
		 * @param array $config Host identity, translated labels and local documents.
		 * @return void
		 */
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
				$text = (string) $document['text'];
				$html = 'changelog' === $key ? \Deckerweb_Changelog_Renderer_V1::render( $text ) : self::document( $text );
				echo '<dialog hidden class="ddw-document-dialog" id="' . esc_attr( $target ) . '" aria-labelledby="' . esc_attr( $target . '-title' ) . '"><div class="ddw-document-header"><h2 id="' . esc_attr( $target . '-title' ) . '">' . esc_html( $document['label'] ) . '</h2><form method="dialog" class="ddw-document-close-form"><button type="submit" class="button" data-ddw-close>' . esc_html( $config['close'] ) . '</button></form></div><div class="ddw-document-content" tabindex="0">' . wp_kses_post( $html ) . '</div></dialog>';
			}
		}

		/**
		 * Convert bounded readme text to fixed markup after escaping every source line.
		 *
		 * @param string $text Local readme; no source HTML is accepted.
		 * @return string Escaped document paragraphs, headings and lists.
		 */
		private static function document( string $text ): string {
			if ( strlen( $text ) > 262144 ) { return ''; }
			$html = ''; $list = false;
			foreach ( preg_split( '/\R/', $text ) as $line ) {
				$line = trim( $line );
				$item = preg_match( '/^[*\-] (.+)$/', $line, $match );
				if ( $list && ! $item ) { $html .= '</ul>'; $list = false; }
				if ( '' === $line ) { continue; }
				if ( $item ) {
					if ( ! $list ) { $html .= '<ul>'; $list = true; }
					$html .= '<li>' . esc_html( $match[1] ) . '</li>';
				} elseif ( preg_match( '/^={1,3}\s+(.+?)\s+={1,3}$/', $line, $heading ) ) {
					$html .= '<h3>' . esc_html( $heading[1] ) . '</h3>';
				} else {
					$html .= '<p>' . esc_html( $line ) . '</p>';
				}
			}
			return $html . ( $list ? '</ul>' : '' );
		}
	}
}
if ( ! class_exists( Footer::class, false ) ) {
	class_alias( StructuredFooter::class, Footer::class );
}
