/* Dependency-free controller tests; browser conflict coverage lives in footer-conflicts.cjs. */
const fs=require('node:fs'),vm=require('node:vm');let checks=0;
const check=(ok,label)=>{checks++;if(!ok)throw Error(label);};
const handlers={};let focused=false,opened=0,closed=0;
class Element {closest(selector){return this.matches(selector)?this:null;}matches(selector){return selector===this.selector;}}
class Dialog extends Element {
 constructor(){super();this.selector='dialog.ddw-document-dialog';this.hidden=true;this.open=false;this.content={scrollTop:99};}
 showModal(){opened++;this.open=true;}
 close(){closed++;this.open=false;handlers.close?.({target:this});}
 removeAttribute(key){if(key==='open')this.open=false;}
 querySelector(){return this.content;}
 getBoundingClientRect(){return {left:10,right:100,top:10,bottom:100};}
}
const dialog=new Dialog(),opener=new Element(),closer=new Element();
opener.selector='[data-ddw-document]';opener.dataset={ddwDocument:'doc'};opener.isConnected=true;opener.focus=()=>{focused=true;};
closer.selector='[data-ddw-close]';closer.closest=s=>s==='[data-ddw-close]'?closer:s==='dialog.ddw-document-dialog'?dialog:null;
const context={Element,WeakMap,window:{HTMLDialogElement:Dialog},document:{getElementById:()=>dialog,addEventListener:(type,fn)=>{handlers[type]=fn;}}};
const source=fs.readFileSync('assets/deckerweb-footer.js','utf8');vm.runInNewContext(source,context);
const click=(target,x=20,y=20)=>{const e={target,clientX:x,clientY:y,preventDefault(){this.prevented=true;},stopPropagation(){this.stopped=true;}};handlers.click(e);return e;};
check(dialog.hidden&&!dialog.open,'Closed initialization');
check(click(opener).prevented&&opened===1&&!dialog.hidden,'Native open');
check(dialog.content.scrollTop===0,'Scroll reset');
dialog.close=()=>{throw Error('foreign method');};
check(click(closer).prevented&&closed===1&&dialog.hidden&&focused,'Native prototype bypasses changed instance method');
click(opener);click(dialog);check(dialog.open,'Inside click stays open');
click(dialog,0,0);check(!dialog.open&&dialog.hidden,'Backdrop close');
click(opener);handlers.cancel({target:dialog,preventDefault(){}});check(!dialog.open&&dialog.hidden,'Escape close');
const handler=handlers.click;vm.runInNewContext(source,context);check(handler===handlers.click,'Duplicate initialization ignored');
Dialog.prototype.showModal=()=>{throw Error('broken open');};check(!click(opener).prevented&&dialog.hidden,'Opening failure preserves link');
console.log('PASS: '+checks+' controller checks');
