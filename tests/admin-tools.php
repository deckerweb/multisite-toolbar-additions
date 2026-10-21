<?php
/** Verify toolbar integrations against disposable WordPress, without loading premium code. */
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) { exit( "Provide disposable wp-load.php.\n" ); }
$active = ( $argv[2] ?? 'active' ) !== 'inactive';
define( 'WP_ADMIN', ( $argv[3] ?? 'site' ) !== 'frontend' );
if ( ( $argv[3] ?? '' ) === 'network' ) { define( 'WP_NETWORK_ADMIN', true ); }
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/wp-admin/';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . 'wp-includes/class-wp-admin-bar.php';
require_once MSTBA_PLUGIN_DIR . 'src/AdminTools.php';
$checks = 0;
function verify_tools( $condition, $label ) {
 global $checks;
 ++$checks;
 if ( ! $condition ) { throw new RuntimeException( $label ); }
}
function tools_bar() {
 $bar = new WP_Admin_Bar();
 $bar->add_node( [ 'id' => 'site-name', 'title' => 'Website' ] );
 ( new Deckerweb\MultisiteToolbar\AdminTools( $GLOBALS['tools_settings'] ?? null ) )->render( $bar );
 return $bar;
}
wp_set_current_user( 1 );
$before = tools_bar();
verify_tools( ! $before->get_node( 'ddw-mstba-admin-tools' ), 'Inactive plugins do not create an empty group' );
if ( ! $active ) { echo "PASS: $checks inactive-plugin check\n"; exit; }
// Detection markers and page contracts from the supplied versions, not their code.
define( 'DPDEVKIT_URL', 'https://example.test/devkit/' );
define( 'DBTK_DEBUG_TOOLKIT_FILE', '/fixture/wpdebugtoolkit.php' );
define( 'DPLUGINS_AC_ADMIN_SLUG', 'dplugins_admin_cleaner' );
$old = [];
foreach ( [ 'DP_AC_super_admin', 'DP_AC_disable_wpac', 'wpdebugtoolkit_menu_location' ] as $key ) { $old[$key] = get_option( $key, null ); }
try {
 update_option( 'DP_AC_super_admin', 1 );
 update_option( 'DP_AC_disable_wpac', 'no' );
 update_option( 'wpdebugtoolkit_menu_location', 'top-level' );
 $GLOBALS['_registered_pages'] = [];
 foreach ( [ ['devkit',''], ['wpdebugtoolkit',''], ['dplugins_admin_cleaner','tools.php'] ] as [$slug,$parent] ) {
  $GLOBALS['_registered_pages'][get_plugin_page_hookname($slug,$parent)] = true;
 }
 do_action( 'admin_menu' );
 $bar = tools_bar();
 verify_tools( (bool) $bar->get_node( 'ddw-mstba-admin-tools' ), 'Administrator group' );
 foreach ( [ 'devkit', 'debug-toolkit', 'admin-cleaner' ] as $id ) {
  $node = $bar->get_node( 'ddw-mstba-'.$id );
  verify_tools( $node && $node->parent === 'ddw-mstba-admin-tools', 'Grouped '.$id );
  verify_tools( strpos( $node->href, admin_url() ) === 0, 'Site administration URL '.$id );
 }
 verify_tools( strpos( html_entity_decode($bar->get_node('ddw-mstba-devkit-cron')->href), '&module=cron' ) !== false, 'DevKit module route' );
 verify_tools( strpos( html_entity_decode($bar->get_node('ddw-mstba-debug-toolkit-logs')->href), '&tab=logs' ) !== false, 'Toolkit tab route' );
 update_option( 'wpdebugtoolkit_menu_location', 'tools' );
 $GLOBALS['_registered_pages'][get_plugin_page_hookname('wpdebugtoolkit','tools.php')] = true;
 verify_tools( strpos(tools_bar()->get_node('ddw-mstba-debug-toolkit')->href,'tools.php?page=wpdebugtoolkit') !== false, 'Toolkit Tools placement' );
 unset($GLOBALS['_registered_pages'][get_plugin_page_hookname('devkit','')]);
 verify_tools( (bool) tools_bar()->get_node('ddw-mstba-devkit') === ( ! is_admin() || is_network_admin() ), 'Page registration checked only in site administration' );
 update_option('DP_AC_super_admin',999999);
 update_option('DP_AC_disable_wpac','yes');
 verify_tools( ! tools_bar()->get_node('ddw-mstba-admin-cleaner'), 'Cleaner owner restriction respected' );
 $user = wp_get_current_user();
 $roles = $user->roles;
 $caps = $user->allcaps;
 $user->roles = ['editor'];
 $user->allcaps['manage_options'] = true;
 $saved_super_admins = $GLOBALS['super_admins'] ?? null;
 $GLOBALS['super_admins'] = [];
 $user->roles = ['administrator'];
 verify_tools( (bool) tools_bar()->get_node('ddw-mstba-admin-tools'), 'Ordinary site administrator allowed in Multisite' );
 $user->roles = ['editor'];
 verify_tools( ! tools_bar()->get_node('ddw-mstba-admin-tools'), 'Custom non-administrator with manage_options excluded' );
 if ( null === $saved_super_admins ) { unset($GLOBALS['super_admins']); } else { $GLOBALS['super_admins'] = $saved_super_admins; }
 $user->roles = $roles;
 $user->allcaps = $caps;
 $GLOBALS['tools_settings'] = Deckerweb\MultisiteToolbar\Settings::preview(['admin_tools_position'=>'right','admin_tools_label'=>'Ops <Tools>','admin_tools_icon'=>'compass']);
 $right = tools_bar();
 verify_tools($right->get_node('ddw-mstba-admin-tools')->parent === 'top-secondary', 'Right-side parent');
 verify_tools(str_contains($right->get_node('ddw-mstba-admin-tools')->title, 'Ops &lt;Tools&gt;'), 'Custom title escaped');
 verify_tools(str_contains($right->get_node('ddw-mstba-admin-tools')->title, '<circle'), 'Selected original icon');
 $GLOBALS['tools_settings'] = Deckerweb\MultisiteToolbar\Settings::preview(['integrations'=>false]);
 verify_tools(!tools_bar()->get_node('ddw-mstba-admin-tools'), 'Integration switch disables tools');
 unset($GLOBALS['tools_settings']);
 $queries = $wpdb->num_queries;
 tools_bar(); tools_bar();
 verify_tools( $wpdb->num_queries === $queries, 'No repeated queries after options cache warmup' );
 wp_set_current_user(0);
 verify_tools( ! tools_bar()->get_node('ddw-mstba-admin-tools'), 'Logged-out user excluded' );
 wp_set_current_user(1);
 $empty = new WP_Admin_Bar();
 (new Deckerweb\MultisiteToolbar\AdminTools())->render($empty);
 verify_tools( ! $empty->get_node('ddw-mstba-admin-tools'), 'Missing site node does not create orphan group' );
} finally {
 foreach($old as $key=>$value) { if(null===$value){delete_option($key);}else{update_option($key,$value);} }
}
echo "PASS: $checks admin tool contract checks\n";
