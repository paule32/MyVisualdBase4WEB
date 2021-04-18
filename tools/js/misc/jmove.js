window.onload = function()
{
	for (const el of document.querySelectorAll('div[data-moveable]')) {
		addDnDListeners('window1',el.id);
	};
}

function addDnDListeners(_p,_s)
{
	const container = document.getElementById(_p);
	const source    = document.getElementById(_s);
	
	source.addEventListener('mousedown', e => {
		const xoffset = source.offsetLeft;
		const yoffset = source.offsetTop;
		
		const xpos = e.clientX - source.offsetLeft;
		const ypos = e.clientY - source.offsetTop;

		function move(evt) {
			source.style.left = Math.max(0, Math.min(container.offsetWidth  - source.offsetWidth , evt.clientX - xpos)) + 'px';
			source.style.top  = Math.max(0, Math.min(container.offsetHeight - source.offsetHeight, evt.clientY - ypos)) + 'px';
		}

		window.addEventListener('mousemove', move);

		function stop(evt) {
			window.removeEventListener('mousemove', move  );
			window.removeEventListener('mouseup'  , stop  );
			window.removeEventListener('keydown'  , cancel);
		}

		function cancel(evt) {
			if (evt.key !== 'Escape') return;
			
			window.removeEventListener('mousemove', move);
			window.removeEventListener('keydown', cancel);
			window.removeEventListener('mouseup', stop);
			
			source.style.left = xoffset + 'px';
			source.style.top = yoffset + 'px';
		}

		window.addEventListener('mouseup', stop);
		window.addEventListener('keydown', cancel);
	});
}
