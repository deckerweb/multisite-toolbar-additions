/* Copyright © 2026 David Decker – DECKERWEB. GPL-2.0-or-later. */
(() => {
 'use strict';
 const config = window.mstbaUpload;
 if (!config) return;
 const labels = config.labels;
 document.querySelectorAll('.mstba-upload-drop').forEach(zone => {
  const input = zone.querySelector('input'), form = input.form, status = zone.querySelector('[role=status]');
  const submit = form.querySelector('[type=submit]'), panel = form.querySelector('.mstba-upload-preview');
  const remove = document.createElement('button');
  remove.type = 'button'; remove.className = 'button'; remove.textContent = labels.remove; remove.hidden = true; zone.append(remove);
  const actionAnchor = document.createComment('ZIP check action'); submit.before(actionAnchor);
  let controller = null, revision = 0, reviewedFile = null, review = null, bypass = false, wrongType = false;
  const reset = () => {
   revision++; controller?.abort(); controller = null; reviewedFile = null; review = null; bypass = false; wrongType = false;
   actionAnchor.after(submit); panel.replaceChildren(); panel.hidden = true; panel.removeAttribute('aria-busy'); submit.disabled = false; submit.hidden = false; submit.textContent = labels.check;
  };
  const valid = () => {
   const files = input.files;
   const ok = files.length === 1 && /\.zip$/i.test(files[0].name) && files[0].size > 0 && files[0].size <= Number(zone.dataset.limit);
   input.setCustomValidity(ok || !files.length ? '' : labels.invalid);
   status.textContent = files.length ? (ok ? files[0].name + ' · ' + new Intl.NumberFormat(document.documentElement.lang || undefined).format(files[0].size) + ' B' : labels.invalid) : '';
   remove.hidden = !files.length; return ok;
  };
  input.addEventListener('change', () => { reset(); submit.disabled = !valid(); });
  remove.addEventListener('click', () => { input.value = ''; input.dispatchEvent(new Event('change')); input.focus(); });
  zone.addEventListener('dragover', event => { event.preventDefault(); zone.classList.add('is-dragging'); });
  zone.addEventListener('dragleave', () => zone.classList.remove('is-dragging'));
  zone.addEventListener('drop', event => {
   event.preventDefault(); zone.classList.remove('is-dragging'); reset();
   try {
    if (event.dataTransfer.files.length !== 1) throw new Error('count');
    input.files = event.dataTransfer.files; input.dispatchEvent(new Event('change'));
   } catch (_) { input.value = ''; input.setCustomValidity(labels.invalid); status.textContent = labels.invalid; remove.hidden = true; }
  });
  form.addEventListener('reset', event => queueMicrotask(() => { if (!event.defaultPrevented) { reset(); valid(); } }));
  const focusPanel = () => { panel.hidden = false; panel.tabIndex = -1; panel.focus(); };
  const fallback = message => {
   actionAnchor.after(submit); submit.disabled = false; panel.replaceChildren(); const p = document.createElement('p'); p.textContent = message || labels.failure; panel.append(p);
   const button = document.createElement('button'); button.type = 'button'; button.className = 'button'; button.textContent = labels.native;
   button.addEventListener('click', () => { bypass = true; if (review) review.required = false; form.requestSubmit(submit); }); panel.append(button); focusPanel();
  };
  submit.textContent = labels.check; submit.disabled = !valid();
  form.addEventListener('submit', async event => {
   if (event.defaultPrevented) return;
   if (!valid()) { event.preventDefault(); input.reportValidity(); return; }
   if (bypass) return;
   const file = input.files[0];
   if (reviewedFile === file && review?.checked) return;
   event.preventDefault();
   if (reviewedFile === file && review) { review.reportValidity(); return; }
   if (submit.disabled) return;
   if (!window.fetch || !window.FormData || !window.AbortController) { fallback(labels.failure); return; }
   reset(); const current = revision; controller = new AbortController(); submit.disabled = true; submit.textContent = labels.busy;
   panel.hidden = false; panel.setAttribute('aria-busy', 'true'); status.textContent = labels.busy;
   const body = new FormData(); body.append('action', 'mstba_zip_preview'); body.append('nonce', config.nonce); body.append('type', config.type); body.append('package', file);
   const timeout = setTimeout(() => { if (revision === current) controller?.abort(); }, 30000);
   try {
    const response = await fetch(config.ajax, { method: 'POST', credentials: 'same-origin', body, signal: controller.signal });
    const payload = await response.json();
    if (revision !== current || input.files[0] !== file) return;
    if (!response.ok || !payload.success) {
     if (payload.data?.code === 'wrong_type') {
      wrongType = true; submit.hidden = true; panel.replaceChildren();
      const note = document.createElement('p'); note.className = 'mstba-upload-type-note'; note.textContent = payload.data.message; panel.append(note);
      if (payload.data.destination) {
       const target = new URL(payload.data.destination,window.location.href);
       if (['http:','https:'].includes(target.protocol)) { const link = document.createElement('a'); link.href=target.href; link.textContent=payload.data.link_label; panel.append(link); }
      }
      focusPanel();
     } else fallback(payload.data?.message);
     return;
    }
    const rows = payload.data?.rows;
    if (!rows || typeof rows !== 'object' || Array.isArray(rows) || Object.keys(rows).length > 12) throw new Error('response');
    const dl = document.createElement('dl');
    for (const [key, value] of Object.entries(rows)) {
     if (typeof value !== 'string') throw new Error('value');
     const dt = document.createElement('dt'), dd = document.createElement('dd'); dt.textContent = key; dd.textContent = value || '—'; dl.append(dt, dd);
    }
    const heading = document.createElement('h2'); heading.textContent = labels.result;
    const ready = document.createElement('p'); ready.className = 'mstba-upload-ready'; ready.textContent = labels.ready;
    const next = document.createElement('p'); next.textContent = labels.next;
    panel.replaceChildren(heading,ready,dl,next); review = document.createElement('input'); review.type = 'checkbox'; review.required = true;
    const label = document.createElement('label'); label.className = 'mstba-upload-confirm'; label.append(review, document.createTextNode(' ' + labels.review)); panel.append(label);
    review.addEventListener('change',()=>{submit.disabled=!review.checked;}); panel.append(submit);
    reviewedFile = file; submit.textContent = labels.install; status.textContent = ''; focusPanel();
   } catch (_) { if (revision === current) fallback(labels.failure); }
   finally { clearTimeout(timeout); if (revision === current) { panel.removeAttribute('aria-busy'); submit.disabled = wrongType || (reviewedFile ? !review.checked : false); if (!reviewedFile) submit.textContent = labels.check; } }
  });
 });
})();
