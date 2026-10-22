<?php
/**
 * Integrate the shared deckerweb updater with plugin-scoped safeguards.
 *
 * @package MultisiteToolbarAdditions
 */

namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Keep the shared updater unchanged and isolate plugin-specific behavior. */
final class GitHubUpdates {
	/** Public release repository; never taken from user input. */
	private const REPOSITORY = 'https://github.com/deckerweb/multisite-toolbar-additions';

	/** Register after WordPress initializes translations. @return void */
	public function register(): void {
		add_action( 'init', array( $this, 'boot' ), 20 );
	}

	/** Load the shared versioned class once, including beside other deckerweb plugins. @return void */
	public function boot(): void {
		try {
			$path = MSTBA_PLUGIN_DIR . 'includes/deckerweb-github-release-updater-v2.php';
			if ( ! is_readable( $path ) ) { throw new \RuntimeException( 'Missing updater.' ); }
			$updater_class = require $path;
			if ( ! is_string( $updater_class ) || ! class_exists( $updater_class, false ) ) {
				throw new \RuntimeException( 'Invalid updater implementation.' );
			}
		} catch ( \Throwable $error ) {
			add_action( 'admin_notices', [ $this, 'unavailable_notice' ] );
			add_action( 'network_admin_notices', [ $this, 'unavailable_notice' ] );
			return;
		}
		$options = [];
		if ( defined( $updater_class . '::SUPPORTS_HOST_TRANSLATIONS' ) && is_readable( MSTBA_PLUGIN_DIR . 'includes/updater-translations.php' ) ) {
			$options['translate'] = require MSTBA_PLUGIN_DIR . 'includes/updater-translations.php';
		}
		if ( defined( $updater_class . '::SUPPORTS_CATALOG_PROVIDER' ) && function_exists( 'deckerweb_library_updater_options_v1' ) ) {
			$options = array_merge( $options, deckerweb_library_updater_options_v1( MSTBA_PLUGIN_FILE, self::REPOSITORY ) );
		}
		try {
			$updater = new $updater_class(
				MSTBA_PLUGIN_FILE,
				self::REPOSITORY,
				'Multisite Toolbar Additions',
				__( 'Useful network and site shortcuts, plus a configurable WordPress menu in the Toolbar.', 'multisite-toolbar-additions' ),
				$this->artwork(),
				$options
			);
		} catch ( \InvalidArgumentException $error ) {
			// An unsupported installation directory must not break toolbar rendering.
			add_action( 'admin_notices', [ $this, 'unavailable_notice' ] );
			add_action( 'network_admin_notices', [ $this, 'unavailable_notice' ] );
			return;
		}
		$updater->register();
		add_filter( 'http_request_args', array( $this, 'request_limits' ), 20, 2 );
		add_filter( 'upgrader_source_selection', array( $this, 'validate_source' ), 30, 4 );
	}

	/**
	 * Provide packaged icons and language-appropriate update banners.
	 *
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function artwork(): array {
		$base = plugins_url( 'assets/brand/', MSTBA_PLUGIN_FILE );
		$language = 1 === preg_match( '/^de(?:_|$)/i', determine_locale() ) ? 'de' : 'en';
		return [
			'icons' => [ '1x' => $base . 'icon-128x128.png', '2x' => $base . 'icon-256x256.png', 'svg' => $base . 'icon.svg' ],
			'banners' => [ 'low' => $base . 'banner-' . $language . '-772x250.png', 'high' => $base . 'banner-' . $language . '-1544x500.png' ],
		];
	}
	/**
	 * Bound only this repository's metadata requests; do not change package downloads.
	 *
	 * @param array  $args WordPress HTTP arguments.
	 * @param string $url Requested URL.
	 * @return array
	 */
	public function request_limits( array $args, string $url ): array {
		if ( 'https://api.github.com/repos/deckerweb/multisite-toolbar-additions/releases/latest' === $url ) {
			$args['limit_response_size'] = 512 * 1024;
			$args['timeout']             = 6;
			$args['redirection']         = 0;
			$args['sslverify']           = true;
			$args['reject_unsafe_urls']  = true;
		}
		return $args;
	}

	/**
	 * Validate the actual candidate before WordPress removes the installed plugin.
	 * Requirements in installed headers cannot describe a future release reliably.
	 *
	 * @param mixed $source Normalized directory or WP_Error from the shared updater.
	 * @param mixed $remote_source Unused extraction root.
	 * @param mixed $upgrader Unused WordPress upgrader instance.
	 * @param array $hook_extra Upgrade context.
	 * @return mixed Original source or localized WP_Error.
	 */
	public function validate_source( $source, $remote_source, $upgrader, array $hook_extra ) {
		if ( ! $this->update_context( $upgrader, $hook_extra ) ) {
			return $source;
		}
		if ( is_wp_error( $source ) ) {
			$messages = array(
				'ddw_ghru_filesystem' => __( 'The update filesystem is unavailable. Please try again.', 'multisite-toolbar-additions' ),
				'ddw_ghru_archive'    => __( 'The GitHub package does not contain the Multisite Toolbar Additions plugin file.', 'multisite-toolbar-additions' ),
				'ddw_ghru_rename'     => __( 'The GitHub package could not be prepared. The installed version has been kept.', 'multisite-toolbar-additions' ),
			);
			$code     = $source->get_error_code();
			return isset( $messages[ $code ] ) ? new \WP_Error( $code, $messages[ $code ], $source->get_error_data( $code ) ) : $source;
		}
		global $wp_filesystem;
		if ( ! is_string( $source ) || ! $wp_filesystem ) {
			return new \WP_Error( 'mstba_update_source', __( 'The update package could not be checked.', 'multisite-toolbar-additions' ) );
		}
		$main = trailingslashit( $source ) . basename( MSTBA_PLUGIN_FILE );
		if ( ! $wp_filesystem->is_file( $main ) || $wp_filesystem->size( $main ) > 1024 * 1024 ) {
			return new \WP_Error( 'mstba_update_source', __( 'The update package could not be checked.', 'multisite-toolbar-additions' ) );
		}
		$text = $wp_filesystem->get_contents( $main );
		if ( ! is_string( $text ) ) {
			return new \WP_Error( 'mstba_update_source', __( 'The update package could not be checked.', 'multisite-toolbar-additions' ) );
		}
		$headers = array();
		foreach ( array( 'Plugin Name', 'Version', 'Update URI', 'Requires PHP', 'Requires at least' ) as $header ) {
			$headers[ $header ] = preg_match( '/^[ \t\/*#@]*' . preg_quote( $header, '/' ) . ':(.*)$/mi', str_replace( "\r", "\n", substr( $text, 0, 8192 ) ), $match ) ? trim( $match[1] ) : '';
		}
		if ( 'Multisite Toolbar Additions' !== $headers['Plugin Name'] || self::REPOSITORY !== $headers['Update URI'] || ! preg_match( '/^\d+\.\d+\.\d+$/D', $headers['Version'] ) || version_compare( $headers['Version'], MSTBA_PLUGIN_VERSION, '<=' ) ) {
			return new \WP_Error( 'mstba_update_identity', __( 'The package identity or version does not match a newer Multisite Toolbar Additions release.', 'multisite-toolbar-additions' ) );
		}
		$current  = get_site_transient( 'update_plugins' );
		$expected = is_object( $current ) ? ( $current->response[ plugin_basename( MSTBA_PLUGIN_FILE ) ]->new_version ?? '' ) : '';
		if ( ! is_string( $expected ) || '' === $expected || $headers['Version'] !== $expected ) {
			return new \WP_Error( 'mstba_update_version', __( 'The package version differs from the offered update. Please check for updates again.', 'multisite-toolbar-additions' ) );
		}
		foreach ( array( 'Requires PHP', 'Requires at least' ) as $header ) {
			if ( ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $headers[ $header ] ) ) {
				return new \WP_Error( 'mstba_update_requirements', __( 'The update package has missing or invalid WordPress/PHP requirements.', 'multisite-toolbar-additions' ) );
			}
		}
		if ( ! is_php_version_compatible( $headers['Requires PHP'] ) || ! is_wp_version_compatible( $headers['Requires at least'] ) ) {
			return new \WP_Error( 'mstba_update_compatibility', __( 'This release requires a newer WordPress or PHP version. The installed version has been kept.', 'multisite-toolbar-additions' ) );
		}
		return $source;
	}
	/**
	 * Match this plugin's individual, automatic or Core bulk update context.
	 *
	 * @param mixed $upgrader Current upgrader; bulk requires Plugin_Upgrader.
	 * @param array $context Hook context; conflicting type/action are rejected.
	 * @return bool Whether candidate validation belongs to this plugin update.
	 */
	public function update_context( $upgrader, array $context ): bool {
		if ( ( $context['plugin'] ?? '' ) !== plugin_basename( MSTBA_PLUGIN_FILE )
			|| ( isset( $context['type'] ) && 'plugin' !== $context['type'] )
			|| ( isset( $context['action'] ) && 'update' !== $context['action'] ) ) {
			return false;
		}
		return isset( $context['type'], $context['action'] )
			|| ( $upgrader instanceof \Plugin_Upgrader && true === $upgrader->bulk );
	}

	/**
	 * Explain an incomplete updater to users who can repair plugin installations.
	 *
	 * @return void
	 */
	public function unavailable_notice(): void {
		if ( ! current_user_can( 'update_plugins' ) ) { return; }
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Toolbar features remain available. Reinstall the complete plugin package to restore GitHub updates.', 'multisite-toolbar-additions' ) . '</p></div>';
	}

}
