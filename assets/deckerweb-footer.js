/** Local document dialogs: closed by default, delegated controls and native fallback. */
(() => {
 'use strict';
 if (window.ddwDocumentDialogsV1) return;
 window.ddwDocumentDialogsV1 = true;
 const openers = new WeakMap();
 const owned = dialog => dialog?.matches('dialog.ddw-document-dialog');
 /** Close only our dialog and restore its own opener, even after instance-method conflicts. */
 const close = dialog => {
  if (!owned(dialog)) return;
  try {
   const nativeClose = window.HTMLDialogElement?.prototype.close;
   if (dialog.open && typeof nativeClose === 'function') nativeClose.call(dialog);
  } catch (_) { /* Attribute cleanup still hides a damaged dialog. */ }
  dialog.removeAttribute('open');
  dialog.hidden = true;
  const opener = openers.get(dialog);
  if (opener?.isConnected) opener.focus({preventScroll:true});
 };
 // Capture handles our controls before conflicting bubbling listeners; other UI is untouched.
 document.addEventListener('click', event => {
  if (!(event.target instanceof Element)) return;
  const closer = event.target.closest('[data-ddw-close]');
  if (closer) {
   const dialog = closer.closest('dialog.ddw-document-dialog');
   if (!owned(dialog)) return;
   event.preventDefault();
   event.stopPropagation();
   close(dialog);
   return;
  }
  const opener = event.target.closest('[data-ddw-document]');
  if (opener) {
   const dialog = document.getElementById(opener.dataset.ddwDocument);
   const show = window.HTMLDialogElement?.prototype.showModal;
   if (!owned(dialog) || typeof show !== 'function') return;
   try {
    dialog.hidden = false;
    if (!dialog.open) show.call(dialog);
   } catch (_) {
    close(dialog);
    return; // Keep the real documentation link usable if opening fails.
   }
   openers.set(dialog,opener);
   event.preventDefault();
   event.stopPropagation();
   const content = dialog.querySelector('.ddw-document-content');
   if (content) content.scrollTop = 0;
   return;
  }
  if (owned(event.target) && event.target.open) {
   const dialog = event.target, bounds = dialog.getBoundingClientRect();
   if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) close(dialog);
  }
 }, true);
 document.addEventListener('cancel', event => {
  if (!owned(event.target)) return;
  event.preventDefault();
  close(event.target);
 }, true);
 document.addEventListener('close', event => {
  if (!owned(event.target) || event.target.open) return;
  event.target.hidden = true;
  const opener = openers.get(event.target);
  if (opener?.isConnected) opener.focus({preventScroll:true});
 }, true);
})();
