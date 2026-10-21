<?php
/** Exercise activation and data retention only on a disposable WordPress fixture. */
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) { exit( "Provide a disposable wp-load.php path.\n" ); }
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/admin.php';
use Deckerweb\MultisiteToolbar\Lifecycle;
use Deckerweb\MultisiteToolbar\Settings;
use Deckerweb\MultisiteToolbar\Admin;
$checks = 0;
function lifecycle_check( $ok, $label ) { global $checks; ++$checks; if ( ! $ok ) { throw new RuntimeException( $label ); } }
wp_set_current_user( 1 );
$file = plugin_basename( MSTBA_PLUGIN_FILE );
define( 'WP_UNINSTALL_PLUGIN', $file );
$active = get_option( 'active_plugins', [] );
$network_active = get_site_option( 'active_sitewide_plugins', [] );
$original = is_multisite() ? get_network_option( get_current_network_id(), Settings::OPTION, null ) : get_option( Settings::OPTION, null );
$shared = get_site_option( 'deckerweb_library_settings_v1', null );
$records = get_site_option( 'deckerweb_library_installed_v1', null );
$cache = 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/multisite-toolbar-additions' ), 0, 24 );
$previous_cache = get_site_transient( $cache );
$other_network = null;
$peer_dir = WP_PLUGIN_DIR . '/mstba-lifecycle-peer';
if ( file_exists( $peer_dir ) ) { throw new RuntimeException( 'Peer fixture directory already exists.' ); }
try {
 $settings = new Settings(); $settings->save( array_replace( Settings::defaults(), [ 'label' => 'Retained settings' ] ) );
 lifecycle_check( ! Settings::defaults()['delete_data'], 'Host deletion preference defaults off' );
 deactivate_plugins( $file, false, is_multisite() );
 lifecycle_check( ( new Settings() )->get( 'label' ) === 'Retained settings', 'Actual deactivation preserves settings' );
 $result = activate_plugin( $file, '', false, true );
 lifecycle_check( ! is_wp_error( $result ), 'Site activation succeeds with existing platform minimums' );
 lifecycle_check( ! Settings::network_active(), 'Site activation does not become network activation' );
 lifecycle_check( str_contains( Admin::url(), 'options-general.php?page=mstba' ), 'Site-activated super admin has local settings entry' );
 if ( is_multisite() ) {
  set_current_screen( 'themes' );
  lifecycle_check( !str_contains( Admin::upload_url( 'theme' ), '/network/' ), 'Site-only theme upload page is served by the active site' );
  ob_start(); (new Admin( new Settings() ))->theme_upload(); $form=ob_get_clean();
  lifecycle_check( str_contains( $form, esc_url( network_admin_url( 'update.php?action=upload-theme' ) ) ), 'Site-only upload form still posts to native network installer' );
  lifecycle_check( str_contains( $form, wp_create_nonce( 'theme-upload' ) ), 'Site-only upload retains Core nonce' );
  $inactive=wp_insert_site(['domain'=>'localhost','path'=>'/mstba-inactive-' . wp_generate_uuid4() . '/', 'network_id'=>get_current_network_id()]);
  if ( !is_wp_error($inactive) ) {
   lifecycle_check( is_wp_error((new Settings())->sanitize(['source_site'=>$inactive])), 'Inactive source rejected in site activation' );
   wp_delete_site($inactive);
  }
  deactivate_plugins( $file, true, false );
  $result = activate_plugin( $file, '', true, true );
  lifecycle_check( ! is_wp_error( $result ) && Settings::network_active(), 'Network activation succeeds' );
  lifecycle_check( str_contains( Admin::url(), '/network/settings.php?page=mstba' ), 'Network activation retains network settings route' );
  lifecycle_check( ( new Settings() )->get( 'label' ) === 'Retained settings', 'Activation modes preserve network configuration' );
  $site = wp_insert_site( [ 'domain' => 'localhost', 'path' => '/mstba-lifecycle-' . wp_generate_uuid4() . '/', 'network_id' => get_current_network_id() ] );
  lifecycle_check( ! is_wp_error( $site ), 'New website created for inheritance check' );
  switch_to_blog( $site );
  try { lifecycle_check( ( new Settings() )->get( 'label' ) === 'Retained settings', 'New website inherits network settings' ); }
  finally { restore_current_blog(); wp_delete_site( $site ); }
 }
 set_site_transient( $cache, [ 'test' => true ], 300 );
 update_option( 'mstba_lifecycle_foreign', 'preserve' );
 Lifecycle::uninstall();
 lifecycle_check( ( new Settings() )->get( 'label' ) === 'Retained settings', 'Default uninstall preserves toolbar settings' );
 lifecycle_check( false === get_site_transient( $cache ), 'Uninstall removes own temporary updater cache' );
 lifecycle_check( 'preserve' === get_option( 'mstba_lifecycle_foreign' ), 'Foreign data is never deleted' );
 $settings->save( array_replace( Settings::defaults(), [ 'delete_data' => true ] ) );
 if ( is_multisite() ) {
  global $wpdb;
  $wpdb->insert( $wpdb->site, [ 'domain' => 'mstba-lifecycle.invalid', 'path' => '/' ] );
  $other_network = (int) $wpdb->insert_id; clean_network_cache( $other_network );
  update_network_option( $other_network, Settings::OPTION, [ 'delete_data' => false, 'label' => 'Other network' ] );
 }
 Lifecycle::uninstall();
 $remaining = is_multisite() ? get_network_option( get_current_network_id(), Settings::OPTION, null ) : get_option( Settings::OPTION, null );
 lifecycle_check( null === $remaining, 'Explicit deletion removes only opted-in toolbar settings' );
 if ( $other_network ) { lifecycle_check( get_network_option( $other_network, Settings::OPTION )['label'] === 'Other network', 'Another network’s opt-out is respected' ); }
 require_once MSTBA_PLUGIN_DIR . 'includes/deckerweb-plugin-library/lifecycle.php';
 mkdir( $peer_dir . '/includes/deckerweb-plugin-library', 0777, true );
 file_put_contents( $peer_dir . '/mstba-lifecycle-peer.php', "<?php\n/* Plugin Name: Inactive lifecycle peer */\n" );
 file_put_contents( $peer_dir . '/includes/deckerweb-plugin-library/bootstrap.php', "<?php // Installed inactive Library host.\n" );
 update_site_option( 'deckerweb_library_settings_v1', [ 'delete_settings' => true, 'online' => false ] );
 update_site_option( 'deckerweb_library_installed_v1', [ 'foreign-plugin' => 'Retain installed plugin record' ] );
 lifecycle_check( ! deckerweb_library_uninstall_v3( MSTBA_PLUGIN_FILE ), 'Inactive installed peer prevents final-host cleanup' );
 lifecycle_check( false !== get_site_option( 'deckerweb_library_settings_v1', false ), 'Shared preferences retained for inactive peer' );
 unlink( $peer_dir . '/includes/deckerweb-plugin-library/bootstrap.php' );
 unlink( $peer_dir . '/mstba-lifecycle-peer.php' );
 rmdir( $peer_dir . '/includes/deckerweb-plugin-library' ); rmdir( $peer_dir . '/includes' ); rmdir( $peer_dir );
 update_site_option( 'deckerweb_library_settings_v1', [ 'delete_settings' => false ] );
 $lib_cache = 'dwl_catalog_' . md5( 'https://raw.githubusercontent.com/deckerweb/example/main/catalog.json' );
 set_site_transient( $lib_cache, [ 'test' => true ], 300 );
 update_site_option( 'deckerweb_library_cache_keys_v2', [ $lib_cache ] );
 lifecycle_check( deckerweb_library_uninstall_v3( MSTBA_PLUGIN_FILE ), 'Last installed host cleanup runs' );
 lifecycle_check( false === get_site_transient( $lib_cache ), 'Final-host cleanup removes tracked Library cache' );
 lifecycle_check( false !== get_site_option( 'deckerweb_library_settings_v1', false ), 'Library preferences retained by default' );
 lifecycle_check( false !== get_site_option( 'deckerweb_library_installed_v1', false ), 'Library install records retained by default' );
 update_site_option( 'deckerweb_library_settings_v1', [ 'delete_settings' => true ] );
 lifecycle_check( deckerweb_library_uninstall_v3( MSTBA_PLUGIN_FILE ), 'Explicit Library deletion runs only for final host' );
 lifecycle_check( false === get_site_option( 'deckerweb_library_settings_v1', false ), 'Explicit Library deletion removes own preferences' );
 lifecycle_check( false === get_site_option( 'deckerweb_library_installed_v1', false ), 'Explicit Library deletion removes own install records' );
 lifecycle_check( is_file( MSTBA_PLUGIN_FILE ), 'No installed host or plugin content is removed by cleanup' );
} finally {
 update_option( 'active_plugins', $active );
 update_site_option( 'active_sitewide_plugins', $network_active );
 if ( is_multisite() ) {
  if ( null === $original ) { delete_network_option( get_current_network_id(), Settings::OPTION ); }
  else { update_network_option( get_current_network_id(), Settings::OPTION, $original ); }
 } elseif ( null === $original ) { delete_option( Settings::OPTION ); }
 else { update_option( Settings::OPTION, $original, false ); }
 foreach ( [ 'deckerweb_library_settings_v1' => $shared, 'deckerweb_library_installed_v1' => $records ] as $key => $value ) {
  if ( null === $value ) { delete_site_option( $key ); } else { update_site_option( $key, $value ); }
 }
 if ( false !== $previous_cache ) { set_site_transient( $cache, $previous_cache ); }
 delete_option( 'mstba_lifecycle_foreign' );
 if ( $other_network ) { delete_network_option( $other_network, Settings::OPTION ); $wpdb->delete( $wpdb->site, [ 'id' => $other_network ] ); clean_network_cache( $other_network ); }
}
echo "PASS: $checks lifecycle checks / " . ( is_multisite() ? 'Multisite' : 'Single site' ) . "\n";
