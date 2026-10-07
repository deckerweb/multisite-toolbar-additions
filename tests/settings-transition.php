<?php
/** The approved theme-menu default changes once; later explicit choices remain effective. */
$_SERVER['HTTP_HOST']='localhost';$_SERVER['REQUEST_URI']='/';require $argv[1];
use Deckerweb\MultisiteToolbar\Settings;
$old=is_multisite()?get_network_option(get_current_network_id(),Settings::OPTION):get_option(Settings::OPTION);
function raw_write($value){if(is_multisite())update_network_option(get_current_network_id(),Settings::OPTION,$value);else update_option(Settings::OPTION,$value,false);}
try{
 $legacy=Settings::defaults();unset($legacy['upload_menu_defaults']);$legacy['theme_zip_submenu']=false;raw_write($legacy);
 $s=new Settings();if(!$s->get('theme_zip_submenu'))throw new RuntimeException('Legacy hidden default did not transition');
 $raw=is_multisite()?get_network_option(get_current_network_id(),Settings::OPTION):get_option(Settings::OPTION);if($raw!==$legacy)throw new RuntimeException('Reading must not persist migration');
 $values=$s->sanitize(['source_site'=>get_current_blog_id(),'enabled'=>'1','plugin_zip_submenu'=>'1']);if(is_wp_error($values))throw new RuntimeException('Invalid fixture');$s->save($values);
 if((new Settings())->get('theme_zip_submenu'))throw new RuntimeException('New explicit hidden choice not respected');
 if(!(new Settings())->get('plugin_zip_submenu'))throw new RuntimeException('Plugin preference changed');
 if(Settings::defaults()['new_themes']!==false)throw new RuntimeException('Separate New preference changed');
 echo 'PASS: 5 theme default transition checks / '.(is_multisite()?'Multisite':'Single site')."\n";
}finally{raw_write($old);}
