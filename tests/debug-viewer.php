<?php
/** Contract tests for the public viewer service; never execute premium plugin code. */
namespace DebugToolkit {
 final class Core {
  public static $viewer;
  public static function get_service($id) { if(self::$viewer instanceof \Throwable){throw self::$viewer;} return self::$viewer; }
 }
}
namespace {
 if(empty($argv[1])||!is_file($argv[1])){exit("Provide disposable wp-load.php.\n");}
 $_SERVER['HTTP_HOST']='localhost';$_SERVER['REQUEST_URI']='/';require $argv[1];
 require_once ABSPATH.'wp-admin/includes/admin.php';
 require_once ABSPATH.'wp-includes/class-wp-admin-bar.php';
 require_once MSTBA_PLUGIN_DIR.'src/AdminTools.php';
 define('DBTK_DEBUG_TOOLKIT_FILE','/fixture/wpdebugtoolkit.php');
 wp_set_current_user(1);
 $checks=0;
 function viewer_check($value,$label){global $checks;++$checks;if(!$value){throw new RuntimeException($label);}}
 function viewer_bar(){ $bar=new WP_Admin_Bar();$bar->add_node(['id'=>'site-name','title'=>'Website']);(new Deckerweb\MultisiteToolbar\AdminTools())->render($bar);return $bar; }
 $manager=new class {
  public $installed=true;
  public $slug='wpdebugtoolkit';
  public function is_installed(){return $this->installed;}
  public function get_viewer_url(){return $this->slug;}
 };
 \DebugToolkit\Core::$viewer=$manager;
 foreach(['wpdebugtoolkit','my-debug','private_logs'] as $slug){
  $manager->slug=$slug;$bar=viewer_bar();$url=home_url('/'.$slug.'/');
  viewer_check($bar->get_node('ddw-mstba-debug-toolkit')->href===esc_url($url),'Main entry opens current viewer slug');
  viewer_check($bar->get_node('ddw-mstba-debug-toolkit-open-viewer')->href===esc_url($url),'First submenu opens viewer');
  $children=array_values(array_filter((array)$bar->get_nodes(),static fn($node)=>$node->parent==='ddw-mstba-debug-toolkit'));
  viewer_check($children[0]->id==='ddw-mstba-debug-toolkit-open-viewer'&&$children[1]->id==='ddw-mstba-debug-toolkit-settings','Viewer precedes settings');
 }
 foreach(['../private','https://example.com','a/b','',str_repeat('a',51),['bad']] as $slug){
  $manager->slug=$slug;viewer_check(!viewer_bar()->get_node('ddw-mstba-debug-toolkit-open-viewer'),'Invalid slug ignored');
 }
 $manager->slug='wpdebugtoolkit';$manager->installed=false;$bar=viewer_bar();
 viewer_check(!$bar->get_node('ddw-mstba-debug-toolkit-open-viewer')&&strpos($bar->get_node('ddw-mstba-debug-toolkit')->href,'page=wpdebugtoolkit')!==false,'Missing viewer retains settings');
 \DebugToolkit\Core::$viewer=new RuntimeException('Unavailable');
 viewer_check(!viewer_bar()->get_node('ddw-mstba-debug-toolkit-open-viewer'),'Service failure handled');
 echo "PASS: $checks viewer contract checks / ".(is_multisite()?'Multisite':'Single site')."\n";
}
