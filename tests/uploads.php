<?php
/** Exercise upload ownership and bounded package inspection on disposable WordPress. */
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/';
require $argv[1]; require_once ABSPATH . 'wp-admin/includes/admin.php';
use Deckerweb\MultisiteToolbar\Uploads;
use Deckerweb\MultisiteToolbar\Settings;
$checks = 0;
function upload_check( $ok, $label ) { global $checks; ++$checks; if ( ! $ok ) { throw new RuntimeException( $label ); } }
wp_set_current_user( 1 ); set_current_screen( is_multisite() ? 'plugins-network' : 'plugins' );
$settings = new Settings(); $saved = $settings->all();
$settings->save( array_replace( Settings::defaults(), [ 'plugin_zip_submenu' => true, 'theme_zip_submenu' => true ] ) );
$temp = tempnam( sys_get_temp_dir(), 'mstba-zip-' );
function package_fixture( $path, $files ) { $z = new ZipArchive(); $z->open( $path, ZipArchive::CREATE | ZipArchive::OVERWRITE ); foreach ( $files as $name => $data ) { $z->addFromString( $name, $data ); } $z->close(); }
try {
 foreach ( [ 'plugin', 'theme' ] as $type ) {
  upload_check( str_contains( Uploads::url( $type ), 'page=mstba-' . $type . '-upload' ), 'Own URL: ' . $type );
  ob_start(); Uploads::screen( $type ); $html = ob_get_clean();
  upload_check( str_contains( $html, 'name="' . $type . 'zip"' ) && str_contains( $html, wp_create_nonce( $type . '-upload' ) ), 'Native field and nonce: ' . $type );
  upload_check( str_contains( $html, esc_url( is_multisite() ? network_admin_url( 'update.php?action=upload-' . $type ) : admin_url( 'update.php?action=upload-' . $type ) ) ), 'Authorized Core action: ' . $type );
 }
 $GLOBALS['submenu'] = []; Uploads::menu( $settings );
 upload_check( in_array( 'mstba-plugin-upload', array_column( $GLOBALS['submenu']['plugins.php'], 2 ), true ), 'Own plugin page' );
 $_GET['page'] = 'unrelated'; Uploads::assets(); upload_check( ! wp_script_is( 'mstba-upload', 'enqueued' ), 'No unrelated assets' );
 $_GET['page'] = 'mstba-plugin-upload'; Uploads::assets(); upload_check( wp_script_is( 'mstba-upload', 'enqueued' ), 'Own scoped assets' ); unset( $_GET['page'] );
 package_fixture( $temp, [ 'sample/sample.php' => "<?php\n/* Plugin Name: <script>Bad</script>Sample\nVersion: 1.2.3\nRequires PHP: 99.0\n*/" ] );
 $result = Uploads::inspect( $temp, 'plugin' );
 upload_check( ! is_wp_error( $result ) && ! str_contains( implode( '', $result['rows'] ), '<script>' ), 'Header sanitized' );
 upload_check( str_contains( implode( '', $result['rows'] ), 'Requirement not met' ), 'Platform mismatch displayed' );
 foreach ( [ 'traversal' => [ '../bad.php' => 'bad' ], 'absolute' => [ '/bad.php' => 'bad' ], 'multiple' => [ 'a/a.php' => 'Plugin Name: A', 'b/b.php' => 'Plugin Name: B' ], 'ambiguous' => [ 'a/a.php' => 'Plugin Name: A', 'a/b.php' => 'Plugin Name: B' ], 'wrong-type' => [ 'a/style.css' => 'Theme Name: A' ], 'windows' => [ 'C:/bad.php' => 'bad' ] ] as $label => $files ) {
  package_fixture( $temp, $files ); upload_check( is_wp_error( Uploads::inspect( $temp, 'plugin' ) ), 'Reject ' . $label );
 }
 package_fixture( $temp, [ 'sample/style.css' => "/* Theme Name: Sample\nVersion: 2.0\nTemplate: twentytwentyfour\n*/" ] );
 upload_check( ! is_wp_error( Uploads::inspect( $temp, 'theme' ) ), 'Child theme metadata' );
 $user = wp_insert_user( [ 'user_login' => 'upload-editor-' . wp_generate_uuid4(), 'user_pass' => wp_generate_password(), 'role' => 'editor' ] );
 wp_set_current_user( $user ); upload_check( ! Uploads::allowed( 'plugin' ) && is_wp_error( Uploads::inspect( $temp, 'theme' ) ), 'Unauthorized inspection rejected' ); wp_set_current_user( 1 );
 // A request-local mock covers ownership and exclusions without copying private implementation.
 eval( 'namespace Deckerweb\\Leitstand; class ThemeUpload { public static $access = true; public static function allowed($type) { return self::$access; } public static function url($network, $type) { return $network ? network_admin_url($type."s.php?page=leitstand-".$type."-upload") : admin_url($type."s.php?page=leitstand-".$type."-upload"); } }' );
 define( 'LEITSTAND_FILE', '/mock/leitstand.php' );
 $active_saved = get_option('active_plugins'); update_option('active_plugins', array_merge((array)$active_saved,[plugin_basename(LEITSTAND_FILE)]));
 upload_check( str_contains( Uploads::url( 'plugin' ), 'leitstand-plugin-upload' ), 'Active provider URL' );
 $GLOBALS['submenu'] = [ 'plugins.php' => [ [ 'Provider', 'upload_plugins', 'leitstand-plugin-upload' ] ] ]; Uploads::menu( $settings );
 upload_check( count( $GLOBALS['submenu']['plugins.php'] ) === 1, 'No duplicate provider link' );
 upload_check( ! in_array( 'mstba-theme-upload', array_column( $GLOBALS['submenu']['themes.php'] ?? [], 2 ), true ), 'No own provider page' );
 \Deckerweb\Leitstand\ThemeUpload::$access = false;
 upload_check( ! Uploads::allowed( 'plugin' ), 'Respect provider user exclusions' );
 $GLOBALS['submenu'] = []; Uploads::menu( $settings ); upload_check( empty( $GLOBALS['submenu'] ), 'Excluded user gets no fallback menus' );
 echo "PASS: $checks upload checks / " . ( is_multisite() ? 'Multisite' : 'Single site' ) . "\n";
} finally { unlink( $temp ); $settings->save( $saved ); if (isset($active_saved)) update_option('active_plugins',$active_saved); }
