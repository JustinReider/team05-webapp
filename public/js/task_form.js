document.addEventListener('DOMContentLoaded', function() {
	const originalSelect = document.getElementById('personenids-original');
	const searchInput = document.getElementById('person-search');
	const personList = document.getElementById('person-list');
	const selectedPersons = document.getElementById('selected-persons');
	const selectionCount = document.getElementById('selection-count');
	const resultCount = document.getElementById('result-count');
	const dropdownBtn = document.getElementById('personDropdownBtn');
	const dropdownMenu = document.querySelector('#personDropdownBtn + .dropdown-menu');

	let persons = [];
	let selectedIds = new Set();

	function loadPersons() {
		persons = Array.from(originalSelect.options).map(option => ({
			id: option.value,
			name: option.text.trim(),
			selected: option.selected
		}));
		persons.forEach(person => {
			if (person.selected) {
				selectedIds.add(person.id);
			}
		});
		console.log('Geladene Personen:', persons.length);
		console.log('Vorausgewählte Personen:', selectedIds.size);
	}

	function renderDropdown(filter = '') {
		const filtered = persons.filter(p =>
			p.name.toLowerCase().includes(filter.toLowerCase())
		);
		resultCount.textContent = `${filtered.length} ${filtered.length === 1 ? 'Person' : 'Personen'}`;
		if (filtered.length === 0) {
			personList.innerHTML = `
				<div class="text-center py-4 text-muted">
					<div class="mb-2">🔍</div>
					<small>Keine Personen gefunden</small>
				</div>
			`;
			return;
		}
		personList.innerHTML = filtered.map(person => `
			<div class="person-item px-3 py-2 border-bottom cursor-pointer ${selectedIds.has(person.id) ? 'selected' : ''}" 
				 data-id="${person.id}"
				 style="cursor: pointer;">
				<div class="d-flex justify-content-between align-items-center">
					<span>
						👤 ${person.name}
					</span>
					${selectedIds.has(person.id) ? '<span class="badge bg-primary">✓</span>' : ''}
				</div>
			</div>
		`).join('');
		personList.querySelectorAll('.person-item').forEach(item => {
			item.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				togglePerson(item.dataset.id);
			});
		});
	}

	function togglePerson(personId) {
		if (selectedIds.has(personId)) {
			removePerson(personId);
		} else {
			addPerson(personId);
		}
	}

	function addPerson(personId) {
		const person = persons.find(p => p.id === personId);
		if (!person) return;
		selectedIds.add(personId);
		updateOriginalSelect();
		renderSelectedChips();
		renderDropdown(searchInput.value);
		updateCount();
	}

	function removePerson(personId) {
		selectedIds.delete(personId);
		updateOriginalSelect();
		renderSelectedChips();
		renderDropdown(searchInput.value);
		updateCount();
	}

	function renderSelectedChips() {
		const selected = persons.filter(p => selectedIds.has(p.id));
		if (selected.length === 0) {
			selectedPersons.innerHTML = '';
			return;
		}
		selectedPersons.innerHTML = selected.map(person => `
			<span class="badge bg-primary d-inline-flex align-items-center gap-2 py-2 px-3 person-badge-enter" 
				  data-id="${person.id}" style="font-size: 0.85rem;">
				👤 ${person.name}
				<button type="button" 
					class="btn-close btn-close-white" 
					style="font-size: 0.65rem; opacity: 0.8;"
					data-id="${person.id}" 
					aria-label="Entfernen"></button>
			</span>
		`).join('');
		selectedPersons.querySelectorAll('.btn-close').forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.stopPropagation();
				removePerson(btn.dataset.id);
			});
		});
	}

	function updateOriginalSelect() {
		Array.from(originalSelect.options).forEach(option => {
			option.selected = selectedIds.has(option.value);
		});
	}

	function updateCount() {
		selectionCount.textContent = selectedIds.size;
	}

	searchInput.addEventListener('input', (e) => {
		renderDropdown(e.target.value);
	});

dropdownBtn.addEventListener('shown.bs.dropdown', function() {
	searchInput.value = '';
	renderDropdown();
	setTimeout(() => searchInput.focus(), 100);
	const btnWidth = dropdownBtn.offsetWidth;
	dropdownMenu.style.width = btnWidth + 'px';
});

searchInput.addEventListener('click', (e) => {
	e.stopPropagation();
});

dropdownMenu.addEventListener('click', (e) => {
	if (!e.target.closest('.person-item')) {
		e.stopPropagation();
	}
});

	loadPersons();
	renderSelectedChips();
	renderDropdown();
	updateCount();
});
