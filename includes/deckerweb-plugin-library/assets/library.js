/* Native modal: keyboard containment, Escape, focus return and progressive fallback. */
(() => {
 'use strict';
 const dialog = document.getElementById('dwl-history');
 const trigger = document.querySelector('[data-dwl-history]');
 if (!dialog || !trigger) return;
 let previous;
 trigger.addEventListener('click', () => {
  previous = document.activeElement;
  if (typeof dialog.showModal === 'function') dialog.showModal();
  else { dialog.setAttribute('open', ''); dialog.querySelector('[data-dwl-close]').focus(); }
 });
 const close = () => {
  if (typeof dialog.close === 'function') dialog.close();
  else { dialog.removeAttribute('open'); if (previous) previous.focus(); }
 };
 dialog.querySelector('[data-dwl-close]').addEventListener('click', close);
 dialog.addEventListener('close', () => { if (previous) previous.focus(); });
 dialog.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') { event.preventDefault(); close(); }
  if (event.key === 'Tab') {
   const items = [...dialog.querySelectorAll('button, a[href], input, select, textarea, [tabindex="0"]')].filter(item => !item.disabled);
   const first = items[0], last = items[items.length - 1];
   if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
   else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
  }
 });
})();
