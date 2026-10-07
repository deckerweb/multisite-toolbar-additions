<?php
/** Shared deckerweb footer standard: escaped, structured release history. GPL-2.0-or-later. */
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Deckerweb_Changelog_Renderer_V1', false ) ) {
	/** Render categorized local release history with no source HTML execution. */
	final class Deckerweb_Changelog_Renderer_V1 {
		/**
		 * Render bounded release headings and categorized items after escaping source text.
		 *
		 * @param string $text Local WordPress-format release history.
		 * @return string Structured escaped headings, badges and release lists.
		 */
		public static function render( string $text ): string {
			if ( strlen( $text ) > 262144 ) { return ''; }
			if ( preg_match( '/^== Changelog ==\s*\R(.*?)(?=^== [^\r\n]+ ==\s*$|\z)/ms', $text, $match ) ) { $text = $match[1]; }
			$releases = []; $current = null;
			foreach ( preg_split( '/\R/', $text ) as $line ) {
				$line = trim( $line );
				if ( preg_match( '/^= (.+) =$/', $line, $heading ) ) {
					$releases[] = [ 'heading' => $heading[1], 'items' => [] ]; $current = count( $releases ) - 1;
				} elseif ( null !== $current && preg_match( '/^[*\-] (.+)$/', $line, $item ) ) { $releases[$current]['items'][] = $item[1]; }
			}
			$html = '';
			$categories = [ 'New' => 'new', 'Neu' => 'new', 'Improved' => 'improved', 'Verbessert' => 'improved', 'Fixed' => 'fixed', 'Behoben' => 'fixed', 'Misc' => 'misc', 'Sonstiges' => 'misc' ];
			foreach ( $releases as $release ) {
				$parts = array_map( 'trim', explode( '·', $release['heading'], 2 ) );
				$html .= '<section class="ddw-changelog-release"><header class="ddw-changelog-version"><h3>' . esc_html( $parts[0] ) . '</h3>' . ( isset( $parts[1] ) ? '<span>' . esc_html( $parts[1] ) . '</span>' : '' ) . '</header><ul class="ddw-changelog-entries">';
				foreach ( $release['items'] as $item ) {
					$prefix = ''; $category = 'misc'; $body = $item;
					if ( preg_match( '/^([^:]+):\s*(.*)$/', $item, $entry ) && isset( $categories[$entry[1]] ) ) { $prefix = $entry[1]; $category = $categories[$prefix]; $body = $entry[2]; }
					$html .= '<li>' . ( $prefix ? '<span class="ddw-changelog-badge ddw-changelog-' . $category . '">' . esc_html( $prefix ) . '</span>' : '' ) . '<span>' . self::inline( $body ) . '</span></li>';
				}
				$html .= '</ul></section>';
			}
			return $html;
		}
		/**
		 * Preserve literal code spans only after escaping all source characters.
		 *
		 * @param string $text Item body without its category prefix.
		 * @return string Safe inline text with optional fixed code markup.
		 */
		private static function inline( string $text ): string {
			// Escape first; only literal code spans become fixed markup.
			return preg_replace( '/`([^`]+)`/', '<code>$1</code>', esc_html( $text ) );
		}
	}
}
