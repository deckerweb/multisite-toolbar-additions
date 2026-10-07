<?php
/** Shared bootstrap protocol 2. Copyright 2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 * This bootstrap remains parseable on PHP 7.4; runtime requirements are checked before include.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! function_exists( 'deckerweb_library_register_v2' ) ) {
 /**
  * Register a runtime candidate without executing its version file.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param array $config Optional host integration configuration.
  * @param string|null $library_dir Absolute embedded directory, or null for this bootstrap directory.
  * @return void No return value.
  */
 function deckerweb_library_register_v2( string $plugin_file, array $config = [], ?string $library_dir = null ): void {
  $library_dir = $library_dir ?: __DIR__;
  $manifest = $library_dir . '/compatibility.json';
  if ( is_readable( $manifest ) ) {
   $data = json_decode( (string) file_get_contents( $manifest ), true );
   $version = is_array( $data ) ? ( $data['version'] ?? '' ) : '';
  } else {
   $file = $library_dir . '/version.php';
   $text = is_readable( $file ) ? file_get_contents( $file, false, null, 0, 8192 ) : '';
   $version = preg_match( "/return\\s+'([0-9]+\\.[0-9]+\\.[0-9]+)'\\s*;/", (string) $text, $match ) ? $match[1] : '';
  }
  if ( ! is_string( $version ) || ! preg_match( '/^\d+\.\d+\.\d+$/D', $version ) ) { $GLOBALS['deckerweb_library_invalid_hosts_v2'] = true; return; }
  $GLOBALS['deckerweb_library_candidates_v1'][] = [ 'version' => $version, 'dir' => $library_dir, 'host' => $plugin_file, 'config' => $config ];
 }
}
if ( ! function_exists( 'deckerweb_library_register' ) ) {
 /**
  * Delegate legacy registration to protocol two when no older function owns it.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param array $config Optional host integration configuration.
  * @param string|null $library_dir Absolute embedded directory, or null for this bootstrap directory.
  * @return void No return value.
  */
 function deckerweb_library_register( string $plugin_file, array $config = [], ?string $library_dir = null ): void {
  deckerweb_library_register_v2( $plugin_file, $config, $library_dir );
 }
}
if ( ! function_exists( 'deckerweb_library_elect_v2' ) ) {
 /**
  * Elect the highest compatible complete runtime before legacy election executes.
  *
  * @return void No return value.
  */
 function deckerweb_library_elect_v2(): void {
  remove_action( 'plugins_loaded', 'deckerweb_library_elect_v1', PHP_INT_MAX );
  if ( ! empty( $GLOBALS['deckerweb_library_runtime_v1'] ) ) { return; }
  if ( ! is_admin() && ! wp_doing_cron() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) { return; }
  global $wp_version;
  $candidates = $GLOBALS['deckerweb_library_candidates_v1'] ?? [];
  usort( $candidates, static function( array $a, array $b ): int {
   $comparison = version_compare( $b['version'], $a['version'] );
   return $comparison ?: strcmp( $a['host'], $b['host'] );
  } );
  foreach ( $candidates as $candidate ) {
   $manifest_file = $candidate['dir'] . '/compatibility.json';
   $manifest = is_file( $manifest_file ) ? json_decode( (string) file_get_contents( $manifest_file ), true ) : null;
   // Legacy 0.1–0.3 copies have the documented PHP 8 / WP 6.4 baseline.
   if ( ! $manifest && in_array( $candidate['version'], [ '0.1.0', '0.2.0', '0.3.0' ], true ) ) { $manifest = [ 'version' => $candidate['version'], 'protocol' => 1, 'requires_php' => '8.0', 'requires_wp' => '6.4', 'files' => [ 'runtime.php', 'src/Catalog.php', 'src/Requirements.php', 'src/Package.php', 'src/Library.php', 'catalog.json' ] ]; }
   if ( ! is_array( $manifest ) || ( $manifest['version'] ?? '' ) !== $candidate['version'] || ! in_array( $manifest['protocol'] ?? 0, [ 1, 2 ], true ) || ! is_array( $manifest['files'] ?? null ) ) { continue; }
   if ( ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $manifest['requires_php'] ?? '' ) || ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $manifest['requires_wp'] ?? '' ) || version_compare( PHP_VERSION, $manifest['requires_php'], '<' ) || version_compare( $wp_version, $manifest['requires_wp'], '<' ) ) { continue; }
   $complete = true;
   foreach ( $manifest['files'] as $file ) { if ( ! is_string( $file ) || strpos( $file, '..' ) !== false || ! preg_match( '~^[a-zA-Z0-9_/.-]+$~D', $file ) || ! is_file( $candidate['dir'] . '/' . $file ) || ! is_readable( $candidate['dir'] . '/' . $file ) ) { $complete = false; break; } }
   if ( ! $complete || ! is_file( $candidate['dir'] . '/runtime.php' ) ) { continue; }
   if ( $manifest['protocol'] === 2 ) {
    if ( ! is_array( $manifest['hashes'] ?? null ) ) { continue; }
    foreach ( $manifest['files'] as $file ) {
     $expected = $manifest['hashes'][$file] ?? '';
     if ( ! is_string( $expected ) || ! preg_match( '/^[a-f0-9]{64}$/D', $expected ) || ! hash_equals( $expected, (string) hash_file( 'sha256', $candidate['dir'] . '/' . $file ) ) ) { $complete = false; break; }
    }
    if ( ! $complete ) { continue; }
   }
   try {
    $factory = require $candidate['dir'] . '/runtime.php';
    if ( ! is_callable( $factory ) ) { break; }
    $GLOBALS['deckerweb_library_runtime_v1'] = $factory( $candidate, $candidates );
    return;
   } catch ( \Throwable $error ) { /* A partial include cannot safely retry the same namespace. */ break; }
  }
  if ( $candidates || ! empty( $GLOBALS['deckerweb_library_invalid_hosts_v2'] ) ) {
   $notice = static function(): void {
    if ( ! current_user_can( 'install_plugins' ) ) { return; }
    $de = strpos( determine_locale(), 'de' ) === 0;
    echo '<div class="notice notice-warning"><p>' . esc_html( $de ? 'Der deckerweb-Katalog konnte nicht geladen werden. Bitte PHP-/WordPress-Anforderungen und die vollständige Library-Einbindung im Host-Plugin prüfen.' : 'The deckerweb catalog could not load. Check platform requirements and the complete Library integration in the host plugin.' ) . '</p></div>';
   };
   add_action( 'admin_notices', $notice ); add_action( 'network_admin_notices', $notice );
  }
 }
}
// Earlier priority prevents a legacy callback from selecting an incompatible copy.
add_action( 'plugins_loaded', 'deckerweb_library_elect_v2', PHP_INT_MAX - 1 );

if ( ! function_exists( 'deckerweb_library_updater_options_v1' ) ) {
 /**
  * Provide lazy public catalog callbacks without changing host updater ownership.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param string $repository Exact public GitHub repository URL.
  * @return array Result of the operation; errors are returned or rejected as documented by the caller.
  */
 function deckerweb_library_updater_options_v1( string $plugin_file, string $repository ): array {
  $file = plugin_basename( $plugin_file );
  return [
   'release_provider' => static function( string $repo, string $basename, bool $fresh = false ) use ( $repository, $file ) {
    $runtime = $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
    if ( $repo !== $repository || $basename !== $file ) { return null; }
    return is_object( $runtime ) && method_exists( $runtime, 'updater_release' ) ? $runtime->updater_release( $repo, $basename, $fresh ) : false;
   },
   'package_provider' => static function( string $repo, string $basename, string $package ) use ( $repository, $file ) {
    $runtime = $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
    if ( $repo !== $repository || $basename !== $file || ! is_object( $runtime ) || ! method_exists( $runtime, 'updater_package' ) ) { return new \WP_Error( 'dwl_offline', strpos( determine_locale(), 'de' ) === 0 ? 'Das freigegebene Paket konnte nicht geprüft werden.' : 'The approved package could not be verified.' ); }
    return $runtime->updater_package( $repo, $basename, $package );
   },
  ];
 }
}
