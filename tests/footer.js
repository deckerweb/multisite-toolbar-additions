/* Exercise the document controller without browser or screenshot dependencies. */
const fs=require('node:fs');const vm=require('node:vm');let count=0;
function check(value,name){if(!value)throw new Error(name);count++;}
const eventMap={};const closeMap={};let prevented=false, focused=false,closed=0,opened=0;
const content={scrollTop:99};
const closeButton={addEventListener:(name,fn)=>{closeMap[name]=fn;}};
const opener={dataset:{ddwDocument:'test'},addEventListener:(name,fn)=>{eventMap[name]=fn;},focus:()=>{focused=true;}};
const handlers={};const dialog={showModal:()=>{opened++;},close:()=>{closed++;handlers.close();},getBoundingClientRect:()=>({left:10,right:100,top:10,bottom:100}),querySelector:(s)=>s==='[data-ddw-close]'?closeButton:content,addEventListener:(name,fn)=>{handlers[name]=fn;}};
vm.runInNewContext(fs.readFileSync('assets/deckerweb-footer.js','utf8'),{document:{querySelectorAll:(s)=>s==='[data-ddw-document]'?[opener]:[dialog],getElementById:()=>dialog}});
eventMap.click({preventDefault:()=>{prevented=true;}});check(prevented&&opened===1,'Dialog opens locally');check(content.scrollTop===0,'Document scroll resets');
closeMap.click();check(closed===1&&focused,'Close returns focus to opener');
handlers.click({target:dialog,clientX:20,clientY:20});check(closed===1,'Inside click keeps dialog');
handlers.click({target:dialog,clientX:0,clientY:0});check(closed===2,'Backdrop closes dialog');
let fallbackPrevented=false;dialog.showModal=null;eventMap.click({preventDefault:()=>{fallbackPrevented=true;}});check(!fallbackPrevented,'Link fallback remains available');
console.log('PASS: '+count+' document controller checks');
