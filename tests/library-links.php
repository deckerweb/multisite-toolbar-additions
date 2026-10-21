<?php
/** Read-only Library shortcut contracts against an isolated package installation. */
define( 'WP_ADMIN', true );
$_SERVER['HTTP_HOST'] = 'localhost'; $_SERVER['REQUEST_URI'] = '/wp-admin/';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/admin.php';
require_once ABSPATH . 'wp-includes/class-wp-admin-bar.php';
use Deckerweb\MultisiteToolbar\LibraryLinks;
use Deckerweb\MultisiteToolbar\Settings;
use Deckerweb\MultisiteToolbar\Shortcuts;
$count = 0;
function ll_check( $ok, $name ) { global $count; ++$count; if ( ! $ok ) { throw new RuntimeException( $name ); } }
wp_set_current_user(1); show_admin_bar(true);
$old = get_site_option('deckerweb_library_settings_v1',null);
$runtime = $GLOBALS['deckerweb_library_runtime_v1'];
$candidates = $GLOBALS['deckerweb_library_candidates_v1'];
$active = get_site_option('active_sitewide_plugins',[]);
try {
 update_site_option('deckerweb_library_settings_v1',['enabled'=>true,'online'=>false]);
 $links=LibraryLinks::destinations();
 ll_check(isset($links['settings'],$links['catalog']),'Both available for installer');
 ll_check(str_contains($links['catalog'],'plugin-install.php?tab=deckerweb'),'Native catalog tab');
 ll_check(str_contains($links['settings'],is_multisite()?'/network/settings.php':'/options-general.php'),'Correct administration scope');
 $bar=new WP_Admin_Bar();$bar->add_node(['id'=>'ddw-mstba-settings','title'=>'Settings']);$bar->add_node(['id'=>'new-content','title'=>'New']);
 LibraryLinks::render($bar);
 ll_check($bar->get_node('ddw-mstba-library-settings')->parent==='ddw-mstba-settings','Settings nested beneath host entry');
 ll_check($bar->get_node('ddw-mstba-new-library')->parent==='new-content','Catalog beneath New');
 $bar->add_node(['id'=>'ddw-mstba-addnew_plugin','parent'=>'new-content','title'=>'Plugin']);$bar->add_node(['id'=>'ddw-mstba-addnew_theme','parent'=>'new-content','title'=>'Theme']);$bar->add_node(['id'=>'late-peer','parent'=>'new-content','title'=>'Peer']);
 $GLOBALS['wp_admin_bar']=$bar;(new Shortcuts(new Settings()))->new_last();$ids=array_keys($bar->get_nodes());
 ll_check(array_slice($ids,-2)===['ddw-mstba-addnew_plugin','ddw-mstba-addnew_theme'],'Plugin and theme additions remain last');
 update_site_option('deckerweb_library_settings_v1',['enabled'=>false]);$links=LibraryLinks::destinations();
 ll_check(isset($links['settings'])&&!isset($links['catalog']),'Hidden catalog stays hidden while settings remain available');
 $GLOBALS['deckerweb_library_runtime_v1']=null;ll_check(LibraryLinks::destinations()===[],'Failed runtime has no admin shortcuts');$GLOBALS['deckerweb_library_runtime_v1']=$runtime;
 $GLOBALS['deckerweb_library_candidates_v1']=[];ll_check(LibraryLinks::destinations()===[],'No registered host has no links');$GLOBALS['deckerweb_library_candidates_v1']=$candidates;
 if(is_multisite()){update_site_option('active_sitewide_plugins',[]);ll_check(LibraryLinks::destinations()===[],'Site-only host has no unavailable network links');update_site_option('active_sitewide_plugins',$active);}
 $user=wp_insert_user(['user_login'=>'ll-subscriber-'.wp_generate_uuid4(),'user_pass'=>wp_generate_password(),'role'=>'subscriber']);wp_set_current_user($user);
 ll_check(LibraryLinks::destinations()===[],'Subscriber cannot see Library destinations');
 echo "PASS: $count Library shortcut contracts / ".(is_multisite()?'Multisite':'Single site')."\n";
} finally {
 wp_set_current_user(1);$GLOBALS['deckerweb_library_runtime_v1']=$runtime;$GLOBALS['deckerweb_library_candidates_v1']=$candidates;
 if(is_multisite())update_site_option('active_sitewide_plugins',$active);
 if($old===null)delete_site_option('deckerweb_library_settings_v1');else update_site_option('deckerweb_library_settings_v1',$old);
}
