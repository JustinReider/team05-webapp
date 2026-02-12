document.addEventListener('DOMContentLoaded', function() {
	var containers = Array.from(
		document.querySelectorAll('[data-spalten-id]')
	);

	if (containers.length === 0) {
		return;
	}

	var drake = dragula(containers, {
		moves: function(el, source, handle, sibling) {
			if (handle.closest('.btn-task-menu') ||
				handle.closest('.dropdown') ||
				handle.closest('button') ||
				handle.closest('a') ||
				handle.closest('.badge') ||
				handle.closest('form')) {
				return false;
			}
			return el.classList.contains('task-card');
		},
		accepts: function(el, target, source, sibling) {
			return target.hasAttribute('data-spalten-id');
		},
		invalid: function(el, handle) {
			return el.tagName === 'A' ||
				el.tagName === 'BUTTON' ||
				el.tagName === 'I';
		},
		direction: 'vertical',
		copy: false,
		revertOnSpill: true,
		removeOnSpill: false,
		mirrorContainer: document.body,
		ignoreInputTextSelection: true
	});

	// Drag Start - Body Cursor ändern
	drake.on('drag', function(el, source) {
		document.body.classList.add('is-dragging');
	});

	// Over Container
	drake.on('over', function(el, container, source) {
		container.classList.add('drag-over');
	});

	// Out of Container
	drake.on('out', function(el, container, source) {
		container.classList.remove('drag-over');
	});

	// Drop - mit Wobble-Animation
	drake.on('drop', function(el, target, source, sibling) {
		target.classList.remove('drag-over');

		// Wobble-Animation beim Droppen
		el.classList.add('dropping');
		setTimeout(function() {
			el.classList.remove('dropping');
		}, 500);

		var taskId = el.getAttribute('data-task-id');
		var newSpaltenId = target.getAttribute('data-spalten-id');
		var allTasksInTarget = target.querySelectorAll('.task-card');
		var positions = Array.from(allTasksInTarget).map(function(card) {
			return card.getAttribute('data-task-id');
		});

		saveTaskPosition(taskId, newSpaltenId, positions);
	});

	// Drag End - Cleanup
	drake.on('dragend', function(el) {
		document.body.classList.remove('is-dragging');
		containers.forEach(function(container) {
			container.classList.remove('drag-over');
		});
	});

	// AJAX: Position an Server senden
	function saveTaskPosition(taskId, spaltenId, positions) {
		var baseUrl = getBaseUrl();
		var url = baseUrl + '/public/tasks/updatePosition';

		fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-Requested-With': 'XMLHttpRequest'
			},
			body: JSON.stringify({
				taskId: taskId,
				newSpaltenId: spaltenId,
				positions: positions
			})
		})
			.then(function(response) {
				if (!response.ok) {
					throw new Error('HTTP ' + response.status);
				}
				return response.json();
			})
			.then(function(data) {
				if (!data.success) {
					throw new Error(data.message || 'Unbekannter Fehler');
				}
			})
			.catch(function(error) {
				alert('Fehler beim Speichern: ' + error.message);
				window.location.reload();
			});
	}

	// Base URL aus dem meta-Tag lesen
	function getBaseUrl() {
		var meta = document.querySelector('meta[name="base-url"]');
		if (meta) {
			return meta.getAttribute('content').replace(/\/$/, '');
		}
		return window.location.origin;
	}
});
