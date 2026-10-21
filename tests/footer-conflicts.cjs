/** Real browser tests against actual PHP-rendered footer markup. */
const fs=require('fs');const {chromium}=require('playwright');
(async()=>{if(!process.argv[2])throw Error('Provide rendered local HTML fixture');const browser=await chromium.launch({headless:true,executablePath:process.env.DDW_TEST_BROWSER||'/Applications/Microsoft Edge.app/Contents/MacOS/Microsoft Edge'});let checks=0;const check=(ok,label)=>{checks++;if(!ok)throw Error(label);};try{
const page=await browser.newPage({viewport:{width:1200,height:900}});await page.route('**/*',r=>r.abort());
await page.setContent(fs.readFileSync(process.argv[2],'utf8'));await page.addStyleTag({content:fs.readFileSync('assets/deckerweb-footer.css','utf8')});
await page.addStyleTag({content:'dialog { display:block !important; }'});
const dialog=page.locator('.ddw-document-dialog').first(),open=page.locator('[data-ddw-document]').first();
check(!(await dialog.isVisible()),'Foreign CSS cannot reveal closed dialog without JS');
// Native method=dialog must close an already-open dialog even if our controller never ran.
await dialog.evaluate(d=>{d.hidden=false;d.showModal();});await dialog.locator('[data-ddw-close]').click();check(!(await dialog.isVisible()),'Native close works without controller');
await page.addScriptTag({content:fs.readFileSync('assets/deckerweb-footer.js','utf8')});
await page.evaluate(()=>document.querySelector('[data-ddw-document]').addEventListener('click',e=>e.stopImmediatePropagation()));
await open.click();check(await dialog.isVisible(),'Capture opens despite blocked target click');
await dialog.evaluate(d=>{d.close=()=>{throw Error('foreign close');};d.querySelector('[data-ddw-close]').addEventListener('click',e=>e.stopImmediatePropagation());});
await dialog.locator('[data-ddw-close]').click();check(!(await dialog.isVisible()),'Capture and native prototype close despite target/instance conflict');
check(await open.evaluate(e=>document.activeElement===e),'Focus restored');
await open.click();await page.keyboard.press('Escape');check(!(await dialog.isVisible()),'Escape closes');
await page.addScriptTag({content:fs.readFileSync('assets/deckerweb-footer.js','utf8')});await open.click();check(await dialog.evaluate(d=>d.open),'Duplicate script still opens once');
await page.mouse.click(3,3);check(!(await dialog.isVisible()),'Backdrop closes');
check(await dialog.locator('form[method=dialog] button[type=submit]').count()===1,'Actual PHP markup has native fallback');
await page.evaluate(()=>{HTMLDialogElement.prototype.showModal=()=>{throw Error('conflict');};});
const prevented=await open.evaluate(e=>!e.dispatchEvent(new MouseEvent('click',{bubbles:true,cancelable:true})));check(!prevented&&!(await dialog.isVisible()),'Broken showModal retains external link fallback');
console.log('PASS: '+checks+' real browser modal conflict checks');
}finally{await browser.close();}})().catch(e=>{console.error(e);process.exit(1)});
