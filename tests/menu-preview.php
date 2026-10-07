<?php
/** Verify read-only preview uses toolbar depth/source rules without changing settings. */
$_SERVER['HTTP_HOST']='localhost';$_SERVER['REQUEST_URI']='/';require $argv[1];require_once ABSPATH.'wp-admin/includes/admin.php';
use Deckerweb\MultisiteToolbar\Settings;
use Deckerweb\MultisiteToolbar\MenuPreview;
$checks=0;function preview_check($ok,$label){global $checks;++$checks;if(!$ok)throw new RuntimeException($label);}
wp_set_current_user(1);$settings=new Settings();$saved=$settings->all();$before=is_multisite()?get_network_option(get_current_network_id(),Settings::OPTION):get_option(Settings::OPTION);
$menu=wp_create_nav_menu('Preview '.wp_generate_uuid4());
function preview_item($menu,$title,$parent=0){return wp_update_nav_menu_item($menu,0,['menu-item-title'=>$title,'menu-item-type'=>'custom','menu-item-url'=>'https://example.com/','menu-item-status'=>'publish','menu-item-parent-id'=>$parent]);}
try{
 $a=preview_item($menu,'<script>Unsafe</script> A');$b=preview_item($menu,'Root B');$child=preview_item($menu,'Child A',$a);$deep=preview_item($menu,'Grandchild',$child);
 $draft=Settings::preview(array_replace(Settings::defaults(),['menu_id'=>$menu,'source_site'=>get_current_blog_id(),'child_depth'=>1,'layout'=>'grouped']));
 $data=MenuPreview::snapshot($draft);
 preview_check(count($data['rows'])===3,'Configured depth matches toolbar');
 preview_check($data['rows'][1]['title']==='Child A'&&$data['rows'][2]['title']==='Root B','Children grouped beneath their actual root');
 preview_check(!str_contains($data['rows'][0]['title'],'<script>'),'Titles stripped for preview');
 preview_check($data['group']===$draft->get('label')||str_starts_with($data['group'],'Preview '),'Default group uses menu name');
 preview_check(get_current_blog_id()===$draft->source(),'Site context restored');
 ob_start();MenuPreview::render($draft);$html=ob_get_clean();preview_check(str_contains($html,'mstba-preview')&&!str_contains($html,'<script>Unsafe'),'Escaped no-JavaScript saved view');
 preview_check(str_contains($html,'Plugin uploader')&&str_contains($html,'Theme uploader'),'Both providers summarized');
 $data=MenuPreview::snapshot(Settings::preview(array_replace(Settings::defaults(),['source_site'=>get_current_blog_id(),'menu_id'=>999999999])));
 preview_check(!empty($data['warnings'])&&empty($data['rows']),'Removed menu diagnostic');
 $empty=wp_create_nav_menu('Empty '.wp_generate_uuid4());$data=MenuPreview::snapshot(Settings::preview(array_replace(Settings::defaults(),['source_site'=>get_current_blog_id(),'menu_id'=>$empty])));preview_check(!empty($data['warnings']),'Empty menu diagnostic');wp_delete_nav_menu($empty);
 for($i=0;$i<205;$i++)preview_item($menu,'Extra '.$i);
 $data=MenuPreview::snapshot($draft);preview_check(count($data['rows'])===200&&!empty($data['warnings']),'Bounded large preview');
 $after=is_multisite()?get_network_option(get_current_network_id(),Settings::OPTION):get_option(Settings::OPTION);preview_check($after===$before,'Inspection never saves draft settings');
 if(is_multisite()){
  $data=MenuPreview::snapshot(Settings::preview(array_replace(Settings::defaults(),['source_site'=>999999999,'menu_id'=>$menu])));preview_check(empty($data['rows'])&&!empty($data['warnings']),'Missing source diagnostic');
  $settings->save(array_replace(Settings::defaults(),['source_site'=>999999999,'menu_id'=>$menu]));
  ob_start();(new Deckerweb\MultisiteToolbar\Admin($settings))->render();$html=ob_get_clean();preview_check(str_contains($html,'mstba-preview')&&str_contains($html,'mstba-source'),'Invalid saved source keeps recovery settings accessible');$settings->save($saved);
 }
 $editor=wp_insert_user(['user_login'=>'preview-editor-'.wp_generate_uuid4(),'user_pass'=>wp_generate_password(),'role'=>'editor']);wp_set_current_user($editor);ob_start();MenuPreview::render($draft);$html=ob_get_clean();preview_check($html==='','Unauthorized account sees no menu data');wp_set_current_user(1);
 echo "PASS: $checks menu preview checks / ".(is_multisite()?'Multisite':'Single site')."\n";
}finally{wp_delete_nav_menu($menu);$settings->save($saved);}
