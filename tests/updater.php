<?php
/** Integration checks against disposable WordPress; all GitHub responses are mocked. */
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) { exit( "Provide a disposable wp-load.php path.\n" ); }
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

use Deckerweb\MultisiteToolbar\GitHubUpdates;
use Deckerweb\GitHubReleaseUpdater\V2\Updater;

$checks = 0;
function check_update( $value, $label ) { global $checks; ++$checks; if ( ! $value ) { throw new RuntimeException( $label ); } }
$repo = 'https://github.com/deckerweb/multisite-toolbar-additions';
$api = 'https://api.github.com/repos/deckerweb/multisite-toolbar-additions/releases/latest';
$cache = 'ddw_ghru_' . substr( md5( $repo ), 0, 24 );
$before = get_site_transient( $cache );
$updater = new Updater( MSTBA_PLUGIN_FILE, $repo, 'Multisite Toolbar Additions', 'Description', $guard_artwork = (new GitHubUpdates())->artwork() );
$guard = new GitHubUpdates();
$requests = 0;
$data = [ 'tag_name' => 'v4.0.1', 'body' => '<script>unsafe</script>', 'assets' => [ [ 'name' => 'multisite-toolbar-additions-4.0.1.zip', 'state' => 'uploaded', 'browser_download_url' => $repo . '/releases/download/v4.0.1/multisite-toolbar-additions-4.0.1.zip' ] ] ];
$mock = static function ( $pre, $args, $url ) use ( &$requests, &$data, $api ) {
	if ( $url !== $api ) { return new WP_Error( 'unexpected_http', 'Tests must not access the network.' ); }
	++$requests;
	check_update( $args['sslverify'] && $args['redirection'] === 0 && $args['limit_response_size'] === 512 * 1024, 'Bounded HTTPS metadata request' );
	return [ 'response' => [ 'code' => 200 ], 'body' => wp_json_encode( $data ), 'headers' => [] ];
};
add_filter( 'pre_http_request', $mock, 10, 3 );
$file = plugin_basename( MSTBA_PLUGIN_FILE );
$headers = get_plugin_data( MSTBA_PLUGIN_FILE, false, false );
delete_site_transient( $cache );
check_update( $updater->update( false, $headers, 'other/other.php', [] ) === false && $requests === 0, 'Other plugins do not trigger requests' );
$offer = $updater->update( false, $headers, $file, [] );
check_update( $offer['version'] === '4.0.1' && str_contains( $offer['package'], '/releases/download/' ), 'Stable installable release asset offered' );
$updater->update( false, $headers, $file, [] );
check_update( $requests === 1, 'Release metadata reused from cache' );
$info = $updater->information( false, 'plugin_information', (object) [ 'slug' => 'multisite-toolbar-additions' ] );
check_update( str_contains( $info->sections['changelog'], '&lt;script&gt;' ), 'Release notes escaped' );
$branded = $info;
check_update( str_contains( $branded->icons['svg'], '/assets/brand/icon.svg' ) && str_contains( $branded->banners['high'], '1544x500.png' ), 'Own icon and banners in plugin details' );
check_update( $updater->information( false, 'plugin_information', (object) [ 'slug' => 'other' ] ) === false, 'Other plugin artwork untouched' );
check_update( isset( $offer['icons']['svg'] ), 'Update offer contains own artwork' );
$data['prerelease'] = true; delete_site_transient( $cache );
check_update( $updater->update( false, $headers, $file, [] ) === false, 'Prereleases excluded' );
unset( $data['prerelease'] ); $data['assets'][0]['browser_download_url'] = 'https://untrusted.example/update.zip'; delete_site_transient( $cache );
check_update( $updater->update( false, $headers, $file, [] ) === false, 'Untrusted package URL rejected' );
$data['tag_name'] = 'v3.9.0'; $data['assets'] = []; $data['zipball_url'] = 'https://api.github.com/repos/deckerweb/multisite-toolbar-additions/zipball/v3.9.0'; delete_site_transient( $cache );
check_update( $updater->update( false, $headers, $file, [] ) === false, 'Older releases cannot downgrade the plugin' );
$args = $guard->request_limits( [], $api );
check_update( $args['timeout'] === 6 && $args['reject_unsafe_urls'], 'Repository request limits' );
check_update( $guard->request_limits( [ 'timeout' => 42 ], 'https://example.com/' ) === [ 'timeout' => 42 ], 'Other HTTP requests untouched' );

$cached_offer = (object) [ 'last_checked' => 123, 'response' => [ $file => (object) [ 'new_version' => '4.0.1' ], 'other/plugin.php' => (object) [ 'new_version' => '2.0.0' ] ] ];
$decorated = $updater->cached_icons( $cached_offer );
check_update( isset( $decorated->response[$file]->icons['svg'] ) && !isset($cached_offer->response[$file]->icons) && $decorated->last_checked===123, 'V2 repairs cached icons without mutating the stored offer' );
check_update( $decorated->response['other/plugin.php'] === $cached_offer->response['other/plugin.php'], 'Other cached offers remain untouched' );

$old_fs = $GLOBALS['wp_filesystem'] ?? null;
$GLOBALS['wp_filesystem'] = new WP_Filesystem_Direct( null );
$directory = sys_get_temp_dir() . '/mstba-package-' . wp_generate_uuid4(); mkdir( $directory );
$main = $directory . '/' . basename( MSTBA_PLUGIN_FILE );
$candidate = "<?php\n/*\nPlugin Name: Multisite Toolbar Additions\nVersion: 4.0.1\nUpdate URI: $repo\nRequires PHP: 8.2\nRequires at least: 6.7\n*/\n";
$context = [ 'plugin' => $file, 'type' => 'plugin', 'action' => 'update' ];
$old_updates = get_site_transient( 'update_plugins' );
set_site_transient( 'update_plugins', (object) [ 'response' => [ $file => (object) [ 'new_version' => '4.0.1' ] ] ] );
file_put_contents( $main, $candidate );
check_update( $guard->validate_source( $directory, '', null, $context ) === $directory, 'Matching compatible candidate accepted' );
file_put_contents( $main, str_replace( 'Version: 4.0.1', 'Version: 4.0.2', $candidate ) );
check_update( $guard->validate_source( $directory, '', null, $context )->get_error_code() === 'mstba_update_version', 'Version must match the offered update' );
file_put_contents( $main, str_replace( 'Requires PHP: 8.2', 'Requires PHP: 99.0', $candidate ) );
check_update( $guard->validate_source( $directory, '', null, $context )->get_error_code() === 'mstba_update_compatibility', 'Incompatible PHP candidate rejected' );
file_put_contents( $main, str_replace( 'Requires at least: 6.7', 'Requires at least: invalid', $candidate ) );
check_update( $guard->validate_source( $directory, '', null, $context )->get_error_code() === 'mstba_update_requirements', 'Malformed requirements rejected' );
file_put_contents( $main, str_replace( 'Plugin Name: Multisite Toolbar Additions', 'Plugin Name: Other', $candidate ) );
check_update( $guard->validate_source( $directory, '', null, $context )->get_error_code() === 'mstba_update_identity', 'Wrong plugin identity rejected' );
check_update( $guard->validate_source( $directory, '', null, [ 'plugin' => 'other/other.php' ] ) === $directory, 'Other plugin packages untouched' );
unlink( $main ); rmdir( $directory ); $GLOBALS['wp_filesystem'] = $old_fs;
if ( false === $old_updates ) { delete_site_transient( 'update_plugins' ); } else { set_site_transient( 'update_plugins', $old_updates ); }
if ( false === $before ) { delete_site_transient( $cache ); } else { set_site_transient( $cache, $before ); }
remove_filter( 'pre_http_request', $mock, 10 );
echo "PASS: $checks updater checks / PHP " . PHP_VERSION . ' / ' . ( is_multisite() ? 'Multisite' : 'Single site' ) . "\n";
