<?php
/** Integration checks for the embedded shared library. */
define('WP_ADMIN', true);
$_SERVER['HTTP_HOST']='localhost';
require $argv[1];
require_once ABSPATH.'wp-admin/includes/plugin.php';
use Deckerweb\PluginLibrary\V0_2_0\Library;
use Deckerweb\PluginLibrary\V0_2_0\Catalog;
$checks=0;
function check_library($ok,$name){global $checks;++$checks;if(!$ok){throw new RuntimeException($name);}}
$runtime=$GLOBALS['deckerweb_library_runtime_v1']??null;
check_library($runtime instanceof Library,'Library elected on real plugin bootstrap');
check_library(Library::VERSION==='0.2.0','Expected shared runtime version');
check_library(has_filter('install_plugins_tabs',[$runtime,'tabs'])!==false,'Installer integration registered');
$previous=get_site_option(Library::OPTION,null);
try {
 delete_site_option(Library::OPTION);
 check_library(Library::settings()===['enabled'=>true,'online'=>false,'catalog_url'=>''],'Local catalog default');
 wp_set_current_user(1);
 $tabs=$runtime->tabs(['featured'=>'Featured']);
 check_library(isset($tabs['featured'],$tabs['deckerweb']),'Native installer preserved, discovery added');
 $id=wp_insert_user(['user_login'=>'mstba-library-reader-'.uniqid(),'user_pass'=>wp_generate_password(),'role'=>'subscriber']);
 wp_set_current_user($id);check_library(!isset($runtime->tabs([])['deckerweb']),'Discovery protected by installer capability');
 wp_set_current_user(1);update_site_option(Library::OPTION,['enabled'=>false]);
 check_library(!isset($runtime->tabs([])['deckerweb']),'Discovery can be disabled');
 $catalog=json_decode(file_get_contents(MSTBA_PLUGIN_DIR.'includes/deckerweb-plugin-library/catalog.json'),true);
 $valid=Catalog::validate($catalog);
 check_library(!is_wp_error($valid)&&count($valid)===9,'Nine pinned catalog entries pass validation');
 $bad=$catalog;$bad['plugins'][0]['sha256']='invalid';check_library(is_wp_error(Catalog::validate($bad)),'Malformed digest rejected');
 $bad=$catalog;$bad['plugins'][0]['download_url']='https://evil.example/plugin.zip';check_library(is_wp_error(Catalog::validate($bad)),'Unapproved download origin rejected');
 check_library(!Catalog::trusted_source('http://deckerweb.de/catalog.json'),'Online catalog requires HTTPS');
 check_library(!Catalog::trusted_source('https://evil.example/catalog.json'),'Online catalog origin restricted');
 $before=$GLOBALS['deckerweb_library_runtime_v1'];deckerweb_library_elect_v1();check_library($before===$GLOBALS['deckerweb_library_runtime_v1'],'Repeated election keeps single runtime');
 ob_start();Deckerweb\MultisiteToolbar\PageChrome::footer();$footer=ob_get_clean();
 check_library(strpos($footer,'3.1')!==false&&strpos($footer,'4.0.0')!==false,'Footer includes complete release history');
} finally {
 if($previous===null){delete_site_option(Library::OPTION);}else{update_site_option(Library::OPTION,$previous);}
 if(isset($id)&&!is_wp_error($id)){if(is_multisite()){require_once ABSPATH.'wp-admin/includes/ms.php';wpmu_delete_user($id);}else{require_once ABSPATH.'wp-admin/includes/user.php';wp_delete_user($id);}}
}
echo "PASS: $checks shared-library integration checks / ".(is_multisite()?'Multisite':'Single site')."\n";
