<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Resolve one uploader provider; retain native WordPress installation and replacement checks. */
final class Uploads {
	/**
	 * Register request-scoped assets and authenticated preview processing.
	 * @return void
	 */
	public static function register(): void {
		add_action( 'admin_init', [ self::class, 'redirect' ], 20 );
		add_action( 'admin_enqueue_scripts', [ self::class, 'assets' ] );
		add_action( 'wp_ajax_mstba_zip_preview', [ self::class, 'preview' ] );
	}
	/**
	 * Keep saved own-page bookmarks useful when the provider or activation scope changes.
	 * @return void
	 */
	public static function redirect(): void {
		if ( 'GET' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) { return; }
		$page = isset( $_GET['page'] ) && is_string( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
		if ( ! in_array( $page, [ 'mstba-plugin-upload', 'mstba-theme-upload' ], true ) ) { return; }
		$type = 'mstba-theme-upload' === $page ? 'theme' : 'plugin';
		if ( self::allowed( $type ) && ( self::leitstand( $type ) || ( Settings::network_active() && ! is_network_admin() ) ) ) {
			wp_safe_redirect( self::url( $type ) ); exit;
		}
	}

	/**
	 * Confirm activation in this site's scope before using a loaded provider.
	 * @return bool
	 */
	private static function provider_active(): bool {
		if ( ! defined( 'LEITSTAND_FILE' ) ) { return false; }
		$basename = plugin_basename( LEITSTAND_FILE );
		return in_array( $basename, (array) get_option( 'active_plugins', [] ), true ) || ( is_multisite() && isset( ( (array) get_site_option( 'active_sitewide_plugins', [] ) )[ $basename ] ) );
	}

	/**
	 * Require both installation and upload privileges, including network restrictions.
	 * @param string $type Package type.
	 * @return bool
	 */
	public static function allowed( string $type ): bool {
		$provider = '\\Deckerweb\\Leitstand\\ThemeUpload';
		if ( self::provider_active() && is_callable( [ $provider, 'allowed' ] ) && ! $provider::allowed( $type ) ) { return false; }
		return in_array( $type, [ 'plugin', 'theme' ], true ) && current_user_can( 'install_' . $type . 's' ) && current_user_can( 'upload_' . $type . 's' );
	}
	/**
	 * Use only a loaded and callable Leitstand uploader accessible to this user.
	 * @param string $type Package type.
	 * @return bool
	 */
	public static function leitstand( string $type ): bool {
		$class = '\\Deckerweb\\Leitstand\\ThemeUpload';
		return self::provider_active() && is_callable( [ $class, 'allowed' ] ) && is_callable( [ $class, 'url' ] ) && $class::allowed( $type );
	}
	/**
	 * Resolve the effective page, including site-only activation in Multisite.
	 * @param string $type Package type.
	 * @return string
	 */
	public static function url( string $type ): string {
		$type = 'theme' === $type ? 'theme' : 'plugin';
		if ( self::leitstand( $type ) ) { return \Deckerweb\Leitstand\ThemeUpload::url( is_multisite(), $type ); }
		$path = $type . 's.php?page=mstba-' . $type . '-upload';
		return Settings::network_active() ? network_admin_url( $path ) : admin_url( $path );
	}
	/**
	 * Register own pages or add only a missing link to the active external provider.
	 * @param Settings $settings Existing independent submenu preferences.
	 * @return void
	 */
	public static function menu( Settings $settings ): void {
		foreach ( [ 'plugin', 'theme' ] as $type ) {
			if ( ! self::allowed( $type ) ) { continue; }
			$parent = $type . 's.php';
			$slug = 'mstba-' . $type . '-upload';
			$title = self::title( $type );
			$external = self::leitstand( $type );
			$remote = $external || ( Settings::network_active() && ! is_network_admin() );
			if ( $remote ) {
				if ( ! $settings->get( $type . '_zip_submenu' ) ) { continue; }
				$external_slug = 'leitstand-' . $type . '-upload';
				$found = false;
				foreach ( $GLOBALS['submenu'][ $parent ] ?? [] as $item ) {
					if ( in_array( $item[2] ?? '', [ $external_slug, self::url( $type ) ], true ) ) { $found = true; break; }
				}
				if ( ! $found ) { add_submenu_page( $parent, $title, $title, 'upload_' . $type . 's', self::url( $type ) ); }
				continue;
			}
			add_submenu_page( $parent, $title, $title, 'upload_' . $type . 's', $slug, /**
			 * Render the authorized package page.
			 * @return void
			 */
			static function () use ( $type ) { self::screen( $type ); } );
			if ( ! $settings->get( $type . '_zip_submenu' ) ) { remove_submenu_page( $parent, $slug ); }
		}
	}
	/**
	 * Return the shared navigation label.
	 * @param string $type Package type.
	 * @return string
	 */
	public static function title( string $type ): string {
		return 'theme' === $type ? __( 'Upload theme ZIP', 'multisite-toolbar-additions' ) : __( 'Upload plugin ZIP', 'multisite-toolbar-additions' );
	}
	/**
	 * Load uploader resources exclusively on an authorized own screen.
	 * @return void
	 */
	public static function assets(): void {
		$page = isset( $_GET['page'] ) && is_string( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
		$type = 'mstba-theme-upload' === $page ? 'theme' : 'plugin';
		if ( ! in_array( $page, [ 'mstba-plugin-upload', 'mstba-theme-upload' ], true ) || ! self::allowed( $type ) || self::leitstand( $type ) ) { return; }
		wp_enqueue_style( 'mstba-admin-footer', plugins_url( 'assets/deckerweb-footer.css', MSTBA_PLUGIN_FILE ), [], PageChrome::asset_version( 'deckerweb-footer.css' ) );
		wp_enqueue_script( 'mstba-admin-footer', plugins_url( 'assets/deckerweb-footer.js', MSTBA_PLUGIN_FILE ), [], PageChrome::asset_version( 'deckerweb-footer.js' ), true );
		wp_enqueue_style( 'mstba-upload', plugins_url( 'assets/upload.css', MSTBA_PLUGIN_FILE ), [], PageChrome::asset_version( 'upload.css' ) );
		wp_enqueue_script( 'mstba-upload', plugins_url( 'assets/upload.js', MSTBA_PLUGIN_FILE ), [], PageChrome::asset_version( 'upload.js' ), true );
		wp_localize_script( 'mstba-upload', 'mstbaUpload', [ 'ajax' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'mstba_zip_preview' ), 'type' => $type, 'labels' => [
			'invalid' => __( 'Choose one non-empty ZIP file within the upload limit.', 'multisite-toolbar-additions' ),
			'check' => __( 'Check ZIP', 'multisite-toolbar-additions' ), 'busy' => __( 'Checking ZIP…', 'multisite-toolbar-additions' ),
			'install' => 'plugin' === $type ? __( 'Install plugin now', 'multisite-toolbar-additions' ) : __( 'Install theme now', 'multisite-toolbar-additions' ), 'remove' => __( 'Remove selected file', 'multisite-toolbar-additions' ),
			'failure' => __( 'The preview is unavailable. No files have been installed.', 'multisite-toolbar-additions' ),
			'native' => __( 'Continue with native WordPress checks', 'multisite-toolbar-additions' ),
			'review' => __( 'I checked these package details and want to install this ZIP.', 'multisite-toolbar-additions' ),
			'ready' => __( 'Package preview ready. Nothing has been installed yet.', 'multisite-toolbar-additions' ),
			'next' => __( 'Confirm the package below, then choose Install now.', 'multisite-toolbar-additions' ),
			'result' => __( '2. Review the package', 'multisite-toolbar-additions' ),
		] ] );
	}
	/**
	 * Render an accessible form posting directly to the authorized Core installer.
	 * @param string $type Package type.
	 * @return void
	 */
	public static function screen( string $type ): void {
		if ( ! self::allowed( $type ) || ( Settings::network_active() && ! is_network_admin() ) ) { wp_die( esc_html__( 'Access denied.', 'multisite-toolbar-additions' ), '', [ 'response' => 403 ] ); }
		if ( self::leitstand( $type ) ) { wp_safe_redirect( self::url( $type ) ); exit; }
		$action = is_multisite() ? network_admin_url( 'update.php?action=upload-' . $type ) : admin_url( 'update.php?action=upload-' . $type );
		echo '<div class="wrap mstba-upload"><h1>' . esc_html( self::title( $type ) ) . '</h1><section class="mstba-upload-card">';
		echo '<p>' . esc_html__( 'Choose the installable ZIP from the provider. WordPress checks the package and confirms replacement of an existing version.', 'multisite-toolbar-additions' ) . '</p>';
		if ( is_multisite() ) { echo '<p>' . esc_html__( 'Files are shared by the entire Multisite installation. Replacing them can affect every website and network using this extension.', 'multisite-toolbar-additions' ) . '</p>'; }
		echo '<details class="mstba-upload-help"><summary>' . esc_html__( 'What is checked before installation?', 'multisite-toolbar-additions' ) . '</summary><p>' . esc_html__( 'The preview reads package metadata without extracting or running files. It is not a malware scan or compatibility guarantee. Installation sends the selected file to WordPress again.', 'multisite-toolbar-additions' ) . '</p></details>';
		echo '<div class="mstba-step-line"><strong>' . esc_html__( 'Steps:', 'multisite-toolbar-additions' ) . '</strong><ol class="mstba-upload-steps" role="list"><li><span class="mstba-step-number" aria-hidden="true">1</span>' . esc_html__( 'Choose ZIP', 'multisite-toolbar-additions' ) . '</li><li><span class="mstba-step-number" aria-hidden="true">2</span>' . esc_html__( 'Review package', 'multisite-toolbar-additions' ) . '</li><li><span class="mstba-step-number" aria-hidden="true">3</span>' . esc_html__( 'Install', 'multisite-toolbar-additions' ) . '</li></ol></div>';
		echo '<form method="post" enctype="multipart/form-data" action="' . esc_url( $action ) . '">';
		wp_nonce_field( $type . '-upload' );
		echo '<div class="mstba-upload-drop" data-limit="' . esc_attr( wp_max_upload_size() ) . '"><label for="mstba-package"><strong>' . esc_html__( 'Drop one ZIP file here', 'multisite-toolbar-additions' ) . '</strong></label><input id="mstba-package" type="file" name="' . esc_attr( $type . 'zip' ) . '" accept=".zip" required aria-describedby="mstba-upload-limit mstba-upload-status"><p id="mstba-upload-status" role="status" aria-live="polite"></p></div>';
		/* translators: Placeholder values are the displayed count, website identifier or formatted upload size. */
		echo '<p id="mstba-upload-limit">' . esc_html( sprintf( __( 'Maximum file size: %s. One ZIP package per upload.', 'multisite-toolbar-additions' ), size_format( wp_max_upload_size() ) ) ) . '</p><button class="button button-primary" type="submit" name="install-' . esc_attr( $type ) . '-submit">' . esc_html( 'plugin' === $type ? __( 'Install plugin now', 'multisite-toolbar-additions' ) : __( 'Install theme now', 'multisite-toolbar-additions' ) ) . '</button><section class="mstba-upload-preview" hidden aria-live="polite"></section></form>';
		echo '<noscript><p>' . esc_html__( 'Without JavaScript, WordPress performs the upload and its native checks directly.', 'multisite-toolbar-additions' ) . '</p></noscript><p><a href="' . esc_url( is_multisite() ? network_admin_url( $type . 's.php' ) : admin_url( $type . 's.php' ) ) . '">' . esc_html__( 'Manage installed extensions', 'multisite-toolbar-additions' ) . '</a></p></section>';
		$other = 'plugin' === $type ? 'theme' : 'plugin';
		if ( self::allowed( $other ) ) { echo '<p class="mstba-upload-switch">' . esc_html__( 'Need the other uploader?', 'multisite-toolbar-additions' ) . ' <a href="' . esc_url( self::url( $other ) ) . '">' . esc_html( 'theme' === $other ? __( 'Switch to theme uploader', 'multisite-toolbar-additions' ) : __( 'Switch to plugin uploader', 'multisite-toolbar-additions' ) ) . '</a></p>'; }
		PageChrome::footer();
		echo '</div>';
	}
	/**
	 * Handle a signed temporary upload; never store, extract or execute the package.
	 * @return void
	 */
	public static function preview(): void {
		$type = isset( $_POST['type'] ) && is_string( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
		if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) || ! self::allowed( $type ) ) { wp_send_json_error( [ 'message' => __( 'Access denied.', 'multisite-toolbar-additions' ) ], 403 ); }
		check_ajax_referer( 'mstba_zip_preview', 'nonce' );
		$file = $_FILES['package'] ?? [];
		if ( ! is_array( $file ) || ( $file['error'] ?? -1 ) !== UPLOAD_ERR_OK || ! is_string( $file['name'] ?? null ) || ! preg_match( '/\.zip$/iD', $file['name'] ) || ! is_string( $file['tmp_name'] ?? null ) || ! is_uploaded_file( $file['tmp_name'] ) ) { wp_send_json_error( [ 'message' => __( 'Choose one non-empty ZIP file within the upload limit.', 'multisite-toolbar-additions' ) ], 400 ); }
		$result = self::inspect( $file['tmp_name'], $type );
		if ( is_wp_error( $result ) ) {
			$response = [ 'message' => $result->get_error_message(), 'code' => $result->get_error_code() ];
			if ( 'wrong_type' === $result->get_error_code() ) {
				$other = 'plugin' === $type ? 'theme' : 'plugin';
				$response['destination'] = self::allowed( $other ) ? self::url( $other ) : '';
				$response['link_label'] = 'theme' === $other ? __( 'Switch to theme uploader', 'multisite-toolbar-additions' ) : __( 'Switch to plugin uploader', 'multisite-toolbar-additions' );
			}
			wp_send_json_error( $response, 422 );
		}
		wp_send_json_success( $result );
	}
	/**
	 * Inspect bounded archive headers with no extraction, execution or persistent writes.
	 * @param string $path Temporary package path.
	 * @param string $type Package type.
	 * @return array|\WP_Error
	 */
	public static function inspect( string $path, string $type ) {
		if ( ! self::allowed( $type ) ) { return new \WP_Error( 'denied', __( 'Access denied.', 'multisite-toolbar-additions' ) ); }
		$error = __( 'The package cannot be previewed safely. Use the provider installation ZIP or continue with native WordPress checks.', 'multisite-toolbar-additions' );
		if ( ! class_exists( '\ZipArchive' ) || ! is_file( $path ) || filesize( $path ) < 1 || filesize( $path ) > min( wp_max_upload_size(), 100 * MB_IN_BYTES ) ) { return new \WP_Error( 'package', $error ); }
		$archive = new \ZipArchive();
		if ( true !== $archive->open( $path ) ) { return new \WP_Error( 'package', $error ); }
		try {
			if ( $archive->numFiles > 10000 ) { return new \WP_Error( 'package', $error ); }
			$roots = []; $seen = []; $headers = []; $opposite = []; $bytes = 0; $candidates = 0; $start = microtime( true );
			for ( $i = 0; $i < $archive->numFiles; ++$i ) {
				$entry = $archive->statIndex( $i );
				if ( ! is_array( $entry ) || microtime( true ) - $start > 5 ) { return new \WP_Error( 'package', $error ); }
				$name = $entry['name'];
				if ( ! is_string( $name ) || str_contains( $name, "\0" ) || str_contains( $name, '\\' ) || preg_match( '~^(?:/|[A-Za-z]:)|(?:^|/)\.{1,2}(?:/|$)~', $name ) || ! empty( $entry['encryption_method'] ) ) { return new \WP_Error( 'package', $error ); }
				if ( isset( $seen[ $name ] ) || ! is_int( $entry['size'] ?? null ) || $entry['size'] < 0 ) { return new \WP_Error( 'package', $error ); }
				$seen[ $name ] = true;
				$system = 0; $attributes = 0;
				if ( $archive->getExternalAttributesIndex( $i, $system, $attributes ) && 3 === $system && 0120000 === ( ( $attributes >> 16 ) & 0170000 ) ) { return new \WP_Error( 'package', $error ); }
				$bytes += $entry['size'];
				if ( $bytes > 512 * MB_IN_BYTES ) { return new \WP_Error( 'package', $error ); }
				if ( str_starts_with( $name, '__MACOSX/' ) || '.DS_Store' === basename( $name ) ) { continue; }
				$parts = explode( '/', rtrim( $name, '/' ) ); $roots[ $parts[0] ] = true;
				if ( count( $parts ) !== 2 || str_ends_with( $name, '/' ) || ( 'style.css' !== $parts[1] && 'php' !== strtolower( pathinfo( $name, PATHINFO_EXTENSION ) ) ) ) { continue; }
				if ( ++$candidates > 32 ) { return new \WP_Error( 'package', $error ); }
				$text = $archive->getFromIndex( $i, 8192 );
				if ( ! is_string( $text ) ) { return new \WP_Error( 'package', $error ); }
				$entry_type = 'style.css' === $parts[1] ? 'theme' : 'plugin';
				$data = [];
				foreach ( [ 'name' => 'theme' === $entry_type ? 'Theme Name' : 'Plugin Name', 'version' => 'Version', 'wp' => 'Requires at least', 'php' => 'Requires PHP', 'parent' => 'Template', 'dependencies' => 'Requires Plugins' ] as $key => $label ) {
					$data[ $key ] = preg_match( '/^[ \t\/*#@]*' . preg_quote( $label, '/' ) . ':([^\r\n]*)/mi', $text, $match ) ? wp_html_excerpt( sanitize_text_field( preg_replace( '~\s*\*/.*~', '', $match[1] ) ), 200 ) : '';
				}
				if ( $data['name'] !== '' ) {
					$data['file'] = $name;
					if ( $entry_type === $type ) { $headers[] = $data; } else { $opposite[] = $data; }
				}
			}
			if ( count( $roots ) === 1 && preg_match( '/^[A-Za-z0-9_-][A-Za-z0-9_.-]*$/D', (string) key( $roots ) ) && ! $headers && count( $opposite ) === 1 ) {
				return new \WP_Error( 'wrong_type', 'plugin' === $type ? __( 'This ZIP was identified as a theme. Please use the theme uploader.', 'multisite-toolbar-additions' ) : __( 'This ZIP was identified as a plugin. Please use the plugin uploader.', 'multisite-toolbar-additions' ) );
			}
			if ( count( $roots ) !== 1 || count( $headers ) !== 1 || $opposite || ! preg_match( '/^[A-Za-z0-9_-][A-Za-z0-9_.-]*$/D', (string) key( $roots ) ) ) { return new \WP_Error( 'package', $error ); }
			$data = $headers[0]; $data['slug'] = (string) key( $roots );
		} catch ( \Throwable $exception ) { return new \WP_Error( 'package', $error ); }
		finally { $archive->close(); }
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$installed = (string) ( 'theme' === $type ? wp_get_theme( $data['slug'] )->get( 'Version' ) : ( get_plugins()[ $data['file'] ]['Version'] ?? '' ) );
		$rows = [ __( 'Package name', 'multisite-toolbar-additions' ) => $data['name'], __( 'Target folder', 'multisite-toolbar-additions' ) => $data['slug'], __( 'ZIP version', 'multisite-toolbar-additions' ) => $data['version'], __( 'Installed version', 'multisite-toolbar-additions' ) => $installed ?: __( 'Not installed', 'multisite-toolbar-additions' ) ];
		foreach ( [ 'wp' => get_bloginfo( 'version' ), 'php' => PHP_VERSION ] as $key => $current ) {
			$required = $data[ $key ];
			$state = $required && preg_match( '/^[0-9]+(?:\.[0-9]+){0,3}$/D', $required ) ? ( version_compare( $current, $required, '>=' ) ? __( 'Requirement met', 'multisite-toolbar-additions' ) : __( 'Requirement not met', 'multisite-toolbar-additions' ) ) : __( 'Unknown / not declared', 'multisite-toolbar-additions' );
			/* translators: Placeholder values are the displayed count, website identifier or formatted upload size. */
			$rows[ 'wp' === $key ? 'WordPress' : 'PHP' ] = sprintf( __( 'Required: %1$s · Current: %2$s · %3$s', 'multisite-toolbar-additions' ), $required ?: __( 'Unknown / not declared', 'multisite-toolbar-additions' ), $current, $state );
		}
		if ( $installed && $data['version'] && preg_match( '/^[0-9]+(?:\.[0-9]+){0,3}$/D', $installed ) && preg_match( '/^[0-9]+(?:\.[0-9]+){0,3}$/D', $data['version'] ) ) {
			$rows[ __( 'Version comparison', 'multisite-toolbar-additions' ) ] = version_compare( $data['version'], $installed, '<' ) ? __( 'Lower version — possible downgrade', 'multisite-toolbar-additions' ) : ( version_compare( $data['version'], $installed, '=' ) ? __( 'Same version — files may still differ', 'multisite-toolbar-additions' ) : __( 'Higher version', 'multisite-toolbar-additions' ) );
		}
		if ( 'theme' === $type && $data['parent'] ) { $rows[ __( 'Parent theme', 'multisite-toolbar-additions' ) ] = $data['parent'] . ' · ' . ( preg_match( '/^[A-Za-z0-9_-][A-Za-z0-9_.-]*$/D', $data['parent'] ) && wp_get_theme( $data['parent'] )->exists() ? __( 'Installed', 'multisite-toolbar-additions' ) : __( 'Not installed', 'multisite-toolbar-additions' ) ); }
		if ( 'plugin' === $type && $data['dependencies'] ) { $rows[ __( 'Declared plugin dependencies', 'multisite-toolbar-additions' ) ] = $data['dependencies']; }
		return [ 'rows' => $rows ];
	}
}
