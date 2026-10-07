<?php
/** Current host-domain, documentation, asset-scope and footer security checks. */
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) { exit( "Provide a disposable wp-load.php path.\n" ); }
define( 'WP_ADMIN', true );
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . 'wp-includes/class-wp-admin-bar.php';
$checks = 0;
function compliance_check( $ok, $label ) { global $checks; ++$checks; if ( ! $ok ) { throw new RuntimeException( $label ); } }
$domain = 'multisite-toolbar-additions';
$messages = json_decode( file_get_contents( dirname( __DIR__ ) . '/languages/messages.json' ), true );
$current_locale = determine_locale();
$forced_locale = 'en_US';
$locale_filter = static function () use ( &$forced_locale ) { return $forced_locale; };
add_filter( 'determine_locale', $locale_filter, PHP_INT_MAX );
try {
 foreach ( [ 'de_DE', 'de_DE_formal' ] as $locale ) {
  $forced_locale = $locale;
  WP_Translation_Controller::get_instance()->set_locale( $locale );
  unload_textdomain( $domain, true );
  compliance_check( load_textdomain( $domain, MSTBA_PLUGIN_DIR . 'languages/' . $domain . '-' . $locale . '.mo', $locale ), 'Host catalog loads for ' . $locale );
  foreach ( $messages as $source => $translation ) {
   compliance_check( __( $source, $domain ) === $translation[$locale], 'Translated message in ' . $locale . ': ' . $source );
  }
  compliance_check( Deckerweb\PluginLibrary\V0_6_0\Library::t( 'Only approved releases' ) === $messages['Only approved releases'][$locale], 'Library shares host domain in ' . $locale );
  $translator = require MSTBA_PLUGIN_DIR . 'includes/updater-translations.php';
  compliance_check( $translator( 'See the release on GitHub.' ) === $messages['See the release on GitHub.'][$locale], 'Updater uses host callback in ' . $locale );
  ob_start(); Deckerweb\MultisiteToolbar\PageChrome::footer(); $html = ob_get_clean();
  compliance_check( str_contains( $html, 'ddw-changelog-release' ) && ! str_contains( $html, '<pre' ), 'Structured footer in ' . $locale );
  compliance_check( str_contains( $html, '>Neu</span>' ) && ! str_contains( $html, '>New</span>' ), 'Translated footer category in ' . $locale );
  compliance_check( ! str_contains( $html, '= 4.0.0' ), 'No raw WordPress changelog markers' );
  compliance_check( substr_count( $html, 'class="ddw-changelog-release"' ) === 7, 'Exactly seven recent release sections' );
 }
} finally {
 remove_filter( 'determine_locale', $locale_filter, PHP_INT_MAX );
 WP_Translation_Controller::get_instance()->set_locale( $current_locale );
 unload_textdomain( $domain, true );
}
$bad = '= 9.9.9 · 2026-10-07 =' . "\n* Fixed: <script>alert(1)</script> `code`";
$rendered = Deckerweb_Changelog_Renderer_V1::render( $bad );
compliance_check( ! str_contains( $rendered, '<script>' ) && str_contains( $rendered, '&lt;script&gt;' ), 'Changelog source HTML escaped' );
compliance_check( str_contains( $rendered, '<code>code</code>' ), 'Safe literal code spans retained' );
compliance_check( '' === Deckerweb_Changelog_Renderer_V1::render( str_repeat( 'x', 262145 ) ), 'Oversized changelog input rejected' );
wp_set_current_user( 1 ); show_admin_bar( true );
$settings = new Deckerweb\MultisiteToolbar\Settings();
$admin = new Deckerweb\MultisiteToolbar\Admin( $settings );
$hook_property = new ReflectionProperty( $admin, 'hook' ); $hook_property->setValue( $admin, 'mstba-test-screen' );
$admin->assets( 'other-screen' );
compliance_check( ! wp_script_is( 'mstba-settings', 'enqueued' ), 'Settings JS not loaded on unrelated screen' );
$admin->assets( 'mstba-test-screen' );
compliance_check( wp_script_is( 'mstba-settings', 'enqueued' ) && wp_style_is( 'mstba-settings', 'enqueued' ), 'Settings assets load on their own screen' );
// A peer can register a root after admin_bar_menu; last-position must still win.
$menu = wp_create_nav_menu( 'Late position ' . wp_generate_uuid4() );
$item = wp_update_nav_menu_item( $menu, 0, [ 'menu-item-title' => 'Toolbar', 'menu-item-url' => 'https://example.com/', 'menu-item-type' => 'custom', 'menu-item-status' => 'publish' ] );
$previous = $settings->all();
try {
 $settings->save( array_replace( Deckerweb\MultisiteToolbar\Settings::defaults(), [ 'menu_id' => $menu, 'source_site' => get_current_blog_id(), 'position' => 'last' ] ) );
 $toolbar = new Deckerweb\MultisiteToolbar\ToolbarMenu( $settings, new Deckerweb\MultisiteToolbar\MenuRepository( $settings ) );
 $GLOBALS['wp_admin_bar'] = new WP_Admin_Bar();
 $GLOBALS['wp_admin_bar']->add_node( [ 'id' => 'site-name', 'title' => 'Site' ] );
 $toolbar->render( $GLOBALS['wp_admin_bar'] );
 $GLOBALS['wp_admin_bar']->add_node( [ 'id' => 'late-peer', 'title' => 'Late peer' ] );
 $toolbar->position();
 $nodes = $GLOBALS['wp_admin_bar']->get_nodes();
 compliance_check( array_key_last( $nodes ) === 'mstba_' . $item, 'Last position survives late third-party root registration' );
} finally { wp_delete_nav_menu( $menu ); $settings->save( $previous ); }
// Host documentation coverage is independent of the component's historical reports.
foreach ( glob( MSTBA_PLUGIN_DIR . 'src/*.php' ) as $path ) {
 $class = 'Deckerweb\\MultisiteToolbar\\' . basename( $path, '.php' );
 $reflection = new ReflectionClass( $class );
 compliance_check( false !== $reflection->getDocComment(), 'Class purpose documented: ' . $class );
 foreach ( $reflection->getMethods() as $method ) {
  $doc = $method->getDocComment();
  compliance_check( is_string( $doc ) && str_contains( $doc, '@return' ), 'Return documented: ' . $class . '::' . $method->name );
  preg_match_all( '/@param\s+\S+\s+\$(\w+)/', $doc, $matches );
  compliance_check( $matches[1] === array_map( static fn( $p ) => $p->name, $method->getParameters() ), 'Ordered parameters documented: ' . $class . '::' . $method->name );
 }
}
echo "PASS: $checks compliance checks / " . ( is_multisite() ? 'Multisite' : 'Single site' ) . "\n";
