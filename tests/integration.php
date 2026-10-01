<?php
/** Run only against a disposable WordPress installation: php tests/integration.php /path/to/wp-load.php */
if (empty($argv[1]) || !is_file($argv[1])) {fwrite(STDERR,"Provide a disposable wp-load.php path.\n");exit(1);}
$_SERVER['HTTP_HOST']='localhost'; $_SERVER['REQUEST_URI']='/';
require $argv[1];
require_once ABSPATH.'wp-admin/includes/admin.php';
require_once ABSPATH.'wp-includes/class-wp-admin-bar.php';
use Deckerweb\MultisiteToolbar\Settings;
use Deckerweb\MultisiteToolbar\MenuRepository;
use Deckerweb\MultisiteToolbar\ToolbarMenu;
use Deckerweb\MultisiteToolbar\Shortcuts;
use Deckerweb\MultisiteToolbar\Admin;

$checks=0;
function verify($condition,$label) {global $checks; ++$checks;if(!$condition){throw new RuntimeException($label);} }
function need($value) { if(is_wp_error($value)){throw new RuntimeException($value->get_error_message());}return $value; }
function configure($changes=[]) {
 // Each scenario represents a fresh request after a settings save.
 global $wp_filter;
 foreach (['map_meta_cap','rest_pre_dispatch','customize_register','customize_dynamic_setting_args'] as $hook) {
  foreach (($wp_filter[$hook]->callbacks ?? []) as $priority=>$callbacks) {
   foreach($callbacks as $entry) {
    $callback=$entry['function'];
    if(is_array($callback) && $callback[0] instanceof Deckerweb\MultisiteToolbar\MenuGuard) {remove_filter($hook,$callback,$priority);}
   }
  }
 }
 $s=new Settings();$s->save(array_replace(Settings::defaults(),$changes));
 (new Deckerweb\MultisiteToolbar\MenuGuard($s))->register();
 return $s;
}
function bar() {
 $bar=new WP_Admin_Bar();
 foreach(['wp-logo','my-sites','site-name','updates','comments','new-content'] as $id){$bar->add_node(['id'=>$id,'title'=>$id]);}
 $bar->add_group(['id'=>'top-secondary']);$bar->add_node(['id'=>'my-account','parent'=>'top-secondary','title'=>'Account']);
 return $bar;
}
wp_set_current_user(1);show_admin_bar(true);
$settings=configure();
$menu=need(wp_create_nav_menu('Toolbar test '.wp_generate_uuid4()));
$root=need(wp_update_nav_menu_item($menu,0,['menu-item-title'=>'<script>alert(1)</script>Root','menu-item-url'=>'https://example.com/','menu-item-type'=>'custom','menu-item-status'=>'publish','menu-item-target'=>'_blank']));
$child=need(wp_update_nav_menu_item($menu,0,['menu-item-title'=>'Child','menu-item-url'=>'https://example.com/child','menu-item-type'=>'custom','menu-item-status'=>'publish','menu-item-parent-id'=>$root]));
$grandchild=need(wp_update_nav_menu_item($menu,0,['menu-item-title'=>'Grandchild','menu-item-url'=>'https://example.com/grandchild','menu-item-type'=>'custom','menu-item-status'=>'publish','menu-item-parent-id'=>$child]));
$settings=configure(['menu_id'=>$menu,'child_depth'=>1]);
$repo=new MenuRepository($settings);$toolbar=new ToolbarMenu($settings,$repo);$bar=bar();$toolbar->render($bar);
verify((bool)$bar->get_node('mstba_'.$root),'Root displayed');verify((bool)$bar->get_node('mstba_'.$child),'Child displayed');verify(!$bar->get_node('mstba_'.$grandchild),'Grandchild hidden at depth 1');
verify(strpos($bar->get_node('mstba_'.$root)->title,'<script>')===false,'Escaped title');
verify(strpos($bar->get_node('mstba_'.$root)->meta['rel'],'noopener')!==false,'External window protection');
$queries=$wpdb->num_queries;$repo->items();$repo->items();verify($wpdb->num_queries===$queries,'No repeated menu queries within one request');
foreach(['first','before','after','last','right'] as $position){
 $s=configure(['menu_id'=>$menu,'position'=>$position,'anchor'=>'site-name']);$t=new ToolbarMenu($s,new MenuRepository($s));$GLOBALS['wp_admin_bar']=bar();$t->render($GLOBALS['wp_admin_bar']);$t->position();
 $nodes=array_values(array_filter((array)$GLOBALS['wp_admin_bar']->get_nodes(),static function($n){return !$n->parent && !$n->group;}));$ids=array_column($nodes,'id');
 if($position==='first'){verify($ids[0]==='mstba_'.$root,'First position');}
 elseif($position==='before'){verify(array_search('mstba_'.$root,$ids,true)+1===array_search('site-name',$ids,true),'Before anchor');}
 elseif($position==='after'){verify(array_search('mstba_'.$root,$ids,true)===array_search('site-name',$ids,true)+1,'After anchor');}
 elseif($position==='last'){verify(end($ids)==='mstba_'.$root,'Last position');}
 else {verify($GLOBALS['wp_admin_bar']->get_node('mstba_'.$root)->parent==='top-secondary','Right position');}
}
$s=configure(['menu_id'=>$menu,'position'=>'after','anchor'=>'missing']);$t=new ToolbarMenu($s,new MenuRepository($s));$GLOBALS['wp_admin_bar']=bar();$t->render($GLOBALS['wp_admin_bar']);$t->position();$nodes=(array)$GLOBALS['wp_admin_bar']->get_nodes();verify(array_key_last($nodes)==='mstba_'.$root,'Missing anchor fallback');
$s=configure(['menu_id'=>$menu,'layout'=>'grouped']);$t=new ToolbarMenu($s,new MenuRepository($s));$b=bar();$t->render($b);verify($b->get_node('mstba-menu')->title===esc_html(wp_get_nav_menu_object($menu)->name),'Default group label is menu name');
$s=configure(['menu_id'=>$menu,'layout'=>'grouped','label'=>'<b>Tools</b>']);$t=new ToolbarMenu($s,new MenuRepository($s));$b=bar();$t->render($b);verify($b->get_node('mstba_'.$root)->parent==='mstba-menu','Grouped root');verify($b->get_node('mstba-menu')->title==='&lt;b&gt;Tools&lt;/b&gt;','Escaped group label');
$s=configure(['enabled'=>false,'menu_id'=>$menu]);$b=bar();(new ToolbarMenu($s,new MenuRepository($s)))->render($b);verify(!$b->get_node('mstba_'.$root),'Disabled menu');
$s=configure(['menu_id'=>$menu,'context'=>'admin']);verify(!(new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Admin-only hidden on frontend');
set_current_screen('dashboard');verify((new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Admin-only visible in admin');
$s=configure(['menu_id'=>$menu,'context'=>'frontend']);verify(!(new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Frontend-only hidden in admin');
set_current_screen('front');$GLOBALS['current_screen']=null;
$s=configure(['menu_id'=>$menu]);$clean=$s->sanitize(['enabled'=>'1','menu_id'=>$menu,'child_depth'=>999,'subsite_limit'=>999,'label'=>'<b>Safe</b>','position'=>'garbage','unknown'=>'injected']);
verify(!is_wp_error($clean) && $clean['child_depth']===10 && $clean['subsite_limit']===100,'Numeric bounds');verify($clean['label']==='Safe' && $clean['position']==='last' && !isset($clean['unknown']),'Allowlisted settings');
verify(!is_wp_error($s->sanitize(['menu_id'=>[],'label'=>[],'source_site'=>[],'position'=>[]])),'Malformed arrays handled');
verify(is_wp_error($s->sanitize(['menu_id'=>999999])),'Invalid menu rejected');
$editor=need(wp_insert_user(['user_login'=>'editor-'.wp_generate_uuid4(),'user_pass'=>wp_generate_password(),'role'=>'editor']));
wp_set_current_user($editor);verify(!(new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Editor cannot see toolbar menu');
wp_set_current_user(0);verify(!(new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Anonymous user cannot see toolbar menu');wp_set_current_user(1);
if(is_multisite()) {
 $subsite=need(wp_insert_site(['domain'=>'localhost','path'=>'/mstba-'.wp_generate_password(6,false).'/', 'network_id'=>get_current_network_id()]));
 add_user_to_blog($subsite,1,'administrator');
 $source_menu=MenuRepository::on_site($subsite,static function(){return need(wp_create_nav_menu('Central'));});
 $source_item=MenuRepository::on_site($subsite,static function()use($source_menu){return need(wp_update_nav_menu_item($source_menu,0,['menu-item-title'=>'Central link','menu-item-url'=>'https://example.com/central','menu-item-type'=>'custom','menu-item-status'=>'publish']));});
 $s=configure(['menu_id'=>$source_menu,'source_site'=>$subsite]);$repo=new MenuRepository($s);verify(count($repo->items())===1 && get_current_blog_id()===1,'Cross-site menu and restoration');
 $localadmin=need(wp_insert_user(['user_login'=>'siteadmin-'.wp_generate_uuid4(),'user_pass'=>wp_generate_password()]));add_user_to_blog($subsite,$localadmin,'administrator');
 switch_to_blog($subsite);wp_set_current_user($localadmin);
 verify(!current_user_can(Settings::capability()),'Website admin cannot save network settings');
 verify(!current_user_can('edit_post',$source_item),'Shared item edit denied');verify(!current_user_can('delete_post',$source_item),'Shared item delete denied');verify(!current_user_can('delete_term',$source_menu),'Shared menu deletion denied');
 $_POST=['menu'=>$source_menu,'action'=>'update'];verify(!current_user_can('edit_theme_options'),'Classic POST update denied');$_POST=['menu'=>$source_menu,'action'=>'add-menu-item'];verify(!current_user_can('edit_theme_options'),'AJAX add-menu-item denied');$_POST=['nav-menu-data'=>wp_slash(wp_json_encode([['name'=>'menu-item-db-id['.$source_item.']','value'=>$source_item]]))];verify(!current_user_can('edit_theme_options'),'Classic JSON item update denied');
 $_POST=['menu-locations'=>['mstba_menu'=>0]];verify(!current_user_can('edit_theme_options'),'Legacy location reassignment denied');$_POST=[];
 $other=need(wp_create_nav_menu('Ordinary '.wp_generate_uuid4()));$other_item=need(wp_update_nav_menu_item($other,0,['menu-item-title'=>'Ordinary','menu-item-url'=>'https://example.com/ordinary','menu-item-type'=>'custom','menu-item-status'=>'publish']));
 verify(current_user_can('edit_post',$other_item) && current_user_can('edit_theme_options'),'Other menus and theme options remain editable');
 $request=new WP_REST_Request('POST','/wp/v2/menus/'.$source_menu);$request->set_param('name','Forbidden');$response=rest_do_request($request);verify($response->get_status()===403,'REST menu update denied');
 $request=new WP_REST_Request('POST','/wp/v2/menu-items/'.$source_item);$request->set_param('title','Forbidden');verify(rest_do_request($request)->get_status()===403,'REST existing item update denied');
 $request=new WP_REST_Request('POST','/wp/v2/menu-items');$request->set_param('menus',$source_menu);$request->set_param('title','Forbidden');$request->set_param('type','custom');$request->set_param('url','https://example.com/');verify(rest_do_request($request)->get_status()===403,'REST item creation denied');
 $request=new WP_REST_Request('POST','/wp/v2/menu-items/'.$other_item);$request->set_param('title','Allowed');verify(rest_do_request($request)->get_status()===200,'REST ordinary item update allowed');
 $guard=new Deckerweb\MultisiteToolbar\MenuGuard(new Settings());$setting=(object)['id'=>'nav_menu_item[-1]'];$validity=$guard->validate_setting(new WP_Error(),['nav_menu_term_id'=>$source_menu],$setting);verify($validity->has_errors(),'Customizer new item validation denied');
 $s=configure(['menu_id'=>$source_menu,'source_site'=>$subsite,'audience'=>'site_administrators']);show_admin_bar(true);verify((new ToolbarMenu($s,new MenuRepository($s)))->visible(),'Website administrators can opt into viewing');
 wp_set_current_user(1);verify(current_user_can('edit_post',$source_item),'Super admin retains edit access');restore_current_blog();
 verify(is_wp_error($s->sanitize(['source_site'=>999999])),'Missing source rejected');
 $s=configure(['menu_id'=>$menu,'subsite_limit'=>1]);$b=bar();$b->add_node(['id'=>'blog-1','parent'=>'my-sites','title'=>'Main']);$b->add_node(['id'=>'blog-'.$subsite,'parent'=>'my-sites','title'=>'Second']);(new Shortcuts($s))->render($b);verify((bool)$b->get_node('ddw-mstba-blog-1-settings') && !$b->get_node('ddw-mstba-blog-'.$subsite.'-settings'),'Subsite expansion limit');verify(get_current_blog_id()===1,'Shortcuts restore site');
}
wp_set_current_user(1);set_current_screen('dashboard');
$s=configure(['menu_id'=>$menu,'new_themes'=>true,'theme_zip_submenu'=>true]);$b=bar();(new Shortcuts($s))->render($b);verify((bool)$b->get_node('ddw-mstba-site-editor'),'Block theme Site Editor shortcut');verify(!$b->get_node('ddw-mstba-customizer'),'No classic Customizer for block theme');verify((bool)$b->get_node('ddw-mstba-site-health'),'Site Health shortcut');verify(!$b->get_node('ddw-mstba-editthemes'),'File editors disabled by default');
$original_theme=get_stylesheet();$widget_support=current_theme_supports('widgets');
$classic=get_theme_root().'/mstba-classic-test';if(!is_dir($classic)){mkdir($classic);}
foreach(['style.css','index.php','functions.php'] as $file){copy(__DIR__.'/fixtures/classic-theme/'.$file,$classic.'/'.$file);}
wp_clean_themes_cache();switch_theme('mstba-classic-test');add_theme_support('widgets');
$b=bar();(new Shortcuts($s))->render($b);verify((bool)$b->get_node('ddw-mstba-customizer'),'Classic theme Customizer shortcut');verify((bool)$b->get_node('ddw-mstba-widgets'),'Classic theme Widgets shortcut');verify(!$b->get_node('ddw-mstba-site-editor'),'No Site Editor on classic theme');
$s=configure(['menu_id'=>$menu,'file_editors'=>true,'new_themes'=>true,'theme_zip_submenu'=>true]);$b=bar();(new Shortcuts($s))->render($b);verify((bool)$b->get_node('ddw-mstba-editthemes'),'File editor opt-in');
define('DISALLOW_FILE_EDIT',true);$b=bar();(new Shortcuts($s))->render($b);verify(!$b->get_node('ddw-mstba-editthemes') && !$b->get_node('ddw-mstba-editplugins'),'Core file editing restriction respected');
switch_theme($original_theme);if(!$widget_support){remove_theme_support('widgets');}
ob_start();(new Admin($s))->render();$html=ob_get_clean();verify(strpos($html,'mstba_save')!==false && strpos($html,'_wpnonce')!==false,'Settings page and save nonce');verify(strpos($html,'Child levels')!==false,'Depth control rendered');verify(strpos($html,'ddw-admin-footer')!==false && strpos($html,'mstba-document-documentation')!==false && strpos($html,'= 4.0.0')!==false,'Shared footer and local release documentation');verify(strpos($html,'assets/brand/icon.svg')!==false && strpos($html,'dashicons-admin-multisite')===false,'Own settings icon replaces Dashicon');
$b=bar();(new Shortcuts($s))->render($b);verify($b->get_node('ddw-mstba-addnew_theme-upload')->href===Admin::upload_url('theme'),'Theme upload uses dedicated page URL');
$old_page=$GLOBALS['pagenow']??null;$_GET['upload']='1';$GLOBALS['pagenow']='theme-install.php';verify(strpos((new Admin($s))->upload_view(''),'show-upload-view')!==false,'Native theme upload view enabled');$GLOBALS['pagenow']='options-general.php';verify((new Admin($s))->upload_view('')==='','Upload view scoped to theme installer');unset($_GET['upload']);$GLOBALS['pagenow']=$old_page;
// Dedicated upload page uses Core's signed installer and network destination.
$admin=new Admin($s);$saved_submenu=$GLOBALS['submenu']??[];$GLOBALS['submenu']=[];
set_current_screen('dashboard');$admin->uploads();
verify(in_array(Admin::upload_url('plugin'),array_column($GLOBALS['submenu']['plugins.php']??[],2),true),'Plugin ZIP submenu available in site dashboard');
verify(in_array(is_multisite()?Admin::upload_url('theme'):'mstba-theme-upload',array_column($GLOBALS['submenu']['themes.php']??[],2),true),'Theme ZIP submenu available in site dashboard');
set_current_screen(is_multisite()?'themes-network':'themes');$GLOBALS['submenu']=[];$admin->uploads();
verify(in_array('mstba-theme-upload',array_column($GLOBALS['submenu']['themes.php']??[],2),true),'Dedicated theme upload page registered in installation admin');
ob_start();$admin->theme_upload();$upload=ob_get_clean();
verify(strpos($upload,esc_url(self_admin_url('update.php?action=upload-theme')))!==false,'Theme upload posts to correct Core installer');
verify(strpos($upload,'name="themezip"')!==false && strpos($upload,wp_create_nonce('theme-upload'))!==false,'Theme ZIP form includes Core field and nonce');
wp_set_current_user($editor);$GLOBALS['submenu']=[];$admin->uploads();verify(empty($GLOBALS['submenu']),'Upload submenus hidden without installation capabilities');
$die_filter=static function(){return static function(){throw new RuntimeException('upload-denied');};};add_filter('wp_die_handler',$die_filter);
try{$admin->theme_upload();verify(false,'Unauthorized upload page must reject access');}catch(RuntimeException $e){verify($e->getMessage()==='upload-denied','Unauthorized upload page access rejected');}finally{remove_filter('wp_die_handler',$die_filter);}
wp_set_current_user(1);set_current_screen('dashboard');$GLOBALS['submenu']=$saved_submenu;
$s=configure();$b=bar();$shortcuts=new Shortcuts($s);$shortcuts->render($b);
verify((bool)$b->get_node('ddw-mstba-addnew_plugin') && !$b->get_node('ddw-mstba-addnew_theme'),'New defaults: plugins on, themes off');
$GLOBALS['submenu']=[];(new Admin($s))->uploads();verify(in_array(Admin::upload_url('plugin'),array_column($GLOBALS['submenu']['plugins.php']??[],2),true) && !in_array('mstba-theme-upload',array_column($GLOBALS['submenu']['themes.php']??[],2),true),'ZIP submenu defaults: plugins on, themes off');
$s=configure(['new_plugins'=>true,'new_themes'=>true,'site_links'=>false]);$b=bar();$shortcuts=new Shortcuts($s);$shortcuts->render($b);$b->add_node(['id'=>'late-custom-type','parent'=>'new-content','title'=>'Late content type']);$GLOBALS['wp_admin_bar']=$b;$shortcuts->new_last();$new_ids=[];foreach($b->get_nodes() as $node){if($node->parent==='new-content'){$new_ids[]=$node->id;}}
verify(array_slice($new_ids,-2)===['ddw-mstba-addnew_plugin','ddw-mstba-addnew_theme'],'Plugin and theme entries follow late content types');verify((bool)$b->get_node('ddw-mstba-addnew_theme-upload'),'Reordering retains ZIP child links');
$s=configure(['new_plugins'=>false,'new_themes'=>false,'plugin_zip_submenu'=>false,'theme_zip_submenu'=>false]);$b=bar();(new Shortcuts($s))->render($b);verify(!$b->get_node('ddw-mstba-addnew_plugin') && !$b->get_node('ddw-mstba-addnew_theme'),'Both New additions can be disabled');$GLOBALS['submenu']=[];(new Admin($s))->uploads();verify(empty($GLOBALS['submenu']['plugins.php']) && empty($GLOBALS['submenu']['themes.php']),'Both ZIP submenus can be disabled');$GLOBALS['submenu']=$saved_submenu;
$defaults=configure();$defaultbar=bar();(new ToolbarMenu($defaults,new MenuRepository($defaults)))->render($defaultbar);verify(!$defaultbar->get_node('mstba_'.$root),'Unassigned menu handled without warnings');
echo "PASS: $checks integration checks on WordPress $wp_version / PHP ".PHP_VERSION.' / '.(is_multisite()?'Multisite':'Single site')."\n";
