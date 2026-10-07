/* Progressive enhancement: all controls remain usable without JavaScript. */
(() => {
	const position = document.getElementById('mstba-position');
	const layout = document.getElementById('mstba-layout');
	const refresh = () => {
		document.getElementById('mstba-row-anchor').hidden = !['before', 'after'].includes(position.value);
		document.getElementById('mstba-row-label').hidden = layout.value !== 'grouped';
	};
	if (position && layout) {
		position.addEventListener('change', refresh);
		layout.addEventListener('change', refresh);
		refresh();
	}
})();

/* Read-only preview; the server validates the same settings without persisting them. */
(() => {
 'use strict';
 const config = window.mstbaMenuPreview, panel = document.getElementById('mstba-preview');
 const form = document.querySelector('form input[name="action"][value="mstba_save"]')?.form;
 if (!config || !panel || !form) return;
 const status = document.getElementById('mstba-preview-status'), content = document.getElementById('mstba-preview-content');
 const anchorStatus = document.getElementById('mstba-anchor-status');
 const anchors = value => {
  const missing = ['before','after'].includes(value.position) && !document.getElementById('wp-admin-bar-' + value.anchor);
  anchorStatus.textContent = missing ? config.labels.anchor : '';
 };
 anchors(window.mstbaSavedPreview || {});
 let timer = null, controller = null, revision = 0;
 const element = (tag, text) => { const node = document.createElement(tag); if (text !== undefined) node.textContent = text; return node; };
 const update = async () => {
  const current = revision;
  if (!window.fetch || !window.AbortController || !window.FormData) return;
  controller = new AbortController(); const active = controller;
  panel.setAttribute('aria-busy', 'true'); status.textContent = config.labels.busy;
  const data = new FormData(form); data.set('action', 'mstba_menu_preview'); data.set('nonce', config.nonce);
  const timeout = setTimeout(() => active.abort(), 15000);
  try {
   const response = await fetch(config.url, {method:'POST', credentials:'same-origin', body:data, signal:active.signal});
   const payload = await response.json();
   if (current !== revision) return;
   if (!response.ok || !payload.success) { status.textContent = payload.data?.message || config.labels.error; return; }
   const result = payload.data;
   if (!Array.isArray(result.rows) || result.rows.length > 200 || !Array.isArray(result.warnings) || !result.summary) throw new Error('preview');
   const fragment = document.createDocumentFragment(), summary = element('dl'); summary.className = 'mstba-summary';
   for (const [key,value] of Object.entries(result.summary)) summary.append(element('dt',key),element('dd',value));
   fragment.append(summary);
   const warnings = element('ul'); warnings.className = 'mstba-preview-warnings';
   for (const warning of result.warnings) warnings.append(element('li',warning)); fragment.append(warnings);
   if (result.group) fragment.append(element('h3',result.group));
   const tree = element('ul'); tree.className = 'mstba-preview-tree';
   for (const row of result.rows) {
    const li = element('li'); li.style.setProperty('--mstba-level', String(Math.min(4, Math.max(0, Number(row.depth) || 0))));
    li.append(element('span',row.title), document.createTextNode(' '), element('small',config.labels.level.replace('%d',String(row.depth)))); tree.append(li);
   }
   fragment.append(tree); content.replaceChildren(fragment); anchors(result); status.textContent = config.labels.draft;
  } catch (_) { if (current === revision) status.textContent = config.labels.error; }
  finally { clearTimeout(timeout); if (current === revision) panel.removeAttribute('aria-busy'); }
 };
 const schedule = () => {
  revision++; controller?.abort(); clearTimeout(timer); panel.removeAttribute('aria-busy');
  status.textContent = config.labels.draft; timer = setTimeout(update, 300);
 };
 const keys = ['enabled','menu_id','source_site','context','audience','position','anchor','child_depth','layout','label','plugin_zip_submenu','theme_zip_submenu','new_plugins','new_themes'];
 form.addEventListener('input',event => { if (keys.some(key => event.target.name === 'mstba[' + key + ']')) schedule(); });
 form.addEventListener('change',event => { if (keys.some(key => event.target.name === 'mstba[' + key + ']')) schedule(); });
 form.addEventListener('reset',event => queueMicrotask(() => { if (!event.defaultPrevented) schedule(); }));
 form.addEventListener('submit', () => { revision++; controller?.abort(); clearTimeout(timer); });
})();
