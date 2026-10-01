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
