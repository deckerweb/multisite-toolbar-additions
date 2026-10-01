<?php
// Dependency-free algorithm tests. Run: php tests/unit.php
namespace {
 define('ABSPATH', __DIR__);
 function absint($v) { return abs((int)$v); }
 function is_multisite() { return $GLOBALS['multi'] ?? true; }
 function get_current_blog_id() { return $GLOBALS['blog'] ?? 1; }
 function switch_to_blog($id) { $GLOBALS['stack'][]=get_current_blog_id(); $GLOBALS['blog']=(int)$id; }
 function restore_current_blog() { $GLOBALS['blog']=array_pop($GLOBALS['stack']); }
 require dirname(__DIR__).'/src/Settings.php';
 require dirname(__DIR__).'/src/MenuRepository.php';
 require dirname(__DIR__).'/src/ToolbarMenu.php';
 $checks=0;
 function check($condition,$label) { global $checks; ++$checks; if(!$condition){throw new \RuntimeException($label);} }
 function item($id,$parent=0) { return (object)['ID'=>$id,'menu_item_parent'=>$parent]; }
 $items=[item(4,3),item(2,1),item(1),item(3,2),item(5),item(6,999),item(7,8),item(8,7)];
 $tree=\Deckerweb\MultisiteToolbar\ToolbarMenu::tree($items,1);
 check(array_map(static function($v){return $v[0]->ID;},$tree)===[1,5,2],'Depth one includes roots and children; skips orphans/cycles');
 check(count(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree($items,2))===4,'Depth two');
 check(count(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree($items,0))===5,'All levels');
 check(count(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree([item(1),item(1)],0))===1,'Duplicate IDs');
 check(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree([],0)===[],'Empty tree');
 $chain=[];for($i=1;$i<=10000;++$i){$chain[]=item($i,$i-1);}
 $start=microtime(true);
 check(count(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree($chain,0))===10000,'Deep chain without recursion');
 $milliseconds=(microtime(true)-$start)*1000;
 check(count(\Deckerweb\MultisiteToolbar\ToolbarMenu::tree($chain,2))===3,'Deep chain limit');
 $GLOBALS['blog']=1;
 $result=\Deckerweb\MultisiteToolbar\MenuRepository::on_site(2,static function(){return get_current_blog_id();});
 check($result===2 && get_current_blog_id()===1,'Restored site after successful lookup');
 try { \Deckerweb\MultisiteToolbar\MenuRepository::on_site(3,static function(){throw new \RuntimeException('expected');}); } catch(\RuntimeException $e){}
 check(get_current_blog_id()===1 && empty($GLOBALS['stack']),'Restored site after exception');
 \Deckerweb\MultisiteToolbar\MenuRepository::on_site(2,static function(){\Deckerweb\MultisiteToolbar\MenuRepository::on_site(3,static function(){check(get_current_blog_id()===3,'Nested lookup');});check(get_current_blog_id()===2,'Nested restoration');});
 check(get_current_blog_id()===1,'Outer restoration');
 printf("PASS: %d checks; 10,000-node traversal %.2f ms (algorithm only)\n",$checks,$milliseconds);
}
