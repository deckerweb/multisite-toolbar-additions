<?php
/** Test the shared bootstrap election using isolated, bounded component candidates. */
define( 'ABSPATH', __DIR__ );
$GLOBALS['wp_version'] = '6.7';
function is_admin() { return true; }
function wp_doing_cron() { return false; }
function add_action( $hook, $callback, $priority = 10 ) { $GLOBALS['actions'][$hook][$priority][] = $callback; }
function remove_action( $hook, $callback, $priority = 10 ) { return true; }
$root = dirname( __DIR__ ) . '/includes/deckerweb-plugin-library/bootstrap.php';
if ( 'old-first' === ( $argv[1] ?? '' ) ) { require $argv[2]; }
require $root;
if ( 'new-first' === ( $argv[1] ?? '' ) ) { require $argv[2]; }
$checks = 0;
$temps = [];
function election_check( $ok, $label ) { global $checks; ++$checks; if ( ! $ok ) { throw new RuntimeException( $label ); } }
function candidate( $version, $host, $php = '8.0', $wp = '6.4', $corrupt = false ) {
 global $temps;
 $dir = sys_get_temp_dir() . '/mstba-election-' . bin2hex( random_bytes( 8 ) ); mkdir( $dir ); $temps[] = $dir;
 $code = "<?php return static function(\$chosen,\$all){return (object)['chosen'=>\$chosen,'count'=>count(\$all)];};";
 file_put_contents( $dir . '/runtime.php', $code );
 file_put_contents( $dir . '/version.php', "<?php return '$version';" );
 $manifest = [ 'protocol' => 2, 'version' => $version, 'requires_php' => $php, 'requires_wp' => $wp, 'files' => ['runtime.php'], 'hashes' => ['runtime.php' => hash( 'sha256', $code )] ];
 file_put_contents( $dir . '/compatibility.json', json_encode( $manifest ) );
 if ( $corrupt ) { file_put_contents( $dir . '/runtime.php', $code . ' // Changed candidate.' ); }
 return [ 'version' => $version, 'dir' => $dir, 'host' => $host, 'config' => [] ];
}
function choose( $candidates ) {
 unset( $GLOBALS['deckerweb_library_runtime_v1'] );
 $GLOBALS['deckerweb_library_candidates_v1'] = $candidates;
 deckerweb_library_elect_v2();
 return $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
}
try {
 $old = candidate( '0.2.0', '/plugins/old/old.php' ); $new = candidate( '0.6.0', '/plugins/multisite-toolbar-additions/multisite-toolbar-additions.php' );
 election_check( choose( [$old,$new] )->chosen['version'] === '0.6.0', 'Highest compatible copy elected' );
 election_check( choose( [$new,$old] )->chosen['version'] === '0.6.0', 'Host load order does not change election' );
 $bad = candidate( '0.7.0', '/plugins/broken/broken.php', '8.0', '6.4', true );
 election_check( choose( [$bad,$new] )->chosen['version'] === '0.6.0', 'Corrupt newer copy cannot win' );
 election_check( choose( [candidate('0.8.0','/newer.php','99.0'),$new] )->chosen['version'] === '0.6.0', 'Incompatible PHP candidate skipped before include' );
 election_check( choose( [candidate('0.8.0','/newer.php','8.0','99.0'),$new] )->chosen['version'] === '0.6.0', 'Incompatible WordPress candidate skipped before include' );
 $equal = candidate( '0.6.0', '/plugins/aaa/aaa.php' );
 election_check( choose( [$new,$equal] )->chosen['host'] === '/plugins/aaa/aaa.php', 'Equal-version election uses deterministic basename' );
 $runtime = $GLOBALS['deckerweb_library_runtime_v1']; deckerweb_library_elect_v2();
 election_check( $runtime === $GLOBALS['deckerweb_library_runtime_v1'], 'Repeated election does not add a second runtime' );
 unset( $GLOBALS['deckerweb_library_runtime_v1'] ); $GLOBALS['deckerweb_library_candidates_v1'] = [];
 deckerweb_library_register_v2( $new['host'], [], $new['dir'] ); deckerweb_library_elect_v2();
 election_check( $GLOBALS['deckerweb_library_runtime_v1']->chosen['version'] === '0.6.0', 'Explicit v2 registration works beside a legacy function' );
 election_check( choose( [$bad] ) === null, 'All invalid candidates fail safely without loading code' );
} finally { foreach ( $temps as $dir ) { foreach ( glob( $dir . '/*' ) as $file ) { unlink( $file ); } rmdir( $dir ); } }
echo "PASS: $checks Library election checks / " . ($argv[1] ?? 'current') . "\n";
