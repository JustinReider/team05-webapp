<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task bearbeiten</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>



<body class="d-flex flex-column min-vh-100">
	<script
		src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
	</script>

	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-4 flex-fill">
		<div class="card">
			<div class="card-header">
				<h2 class="card-title"><?= esc($title) ?></h2>
			</div>
			<div class="card-body">
				<?php if (isset($validation)): ?>
					<div class="alert alert-danger">
						<?= $validation->listErrors() ?>
					</div>
				<?php endif; ?>
				<form method="POST" action="<?= base_url('public/tasks/save' . (isset($task['id']) ? '/' . $task['id'] : '')) ?>">
					<?= csrf_field() ?>
					<!-- Task-Bezeichnung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Tasks</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="tasks" placeholder="Task-Bezeichnung eingeben" required value="<?= esc(($task['tasks']) ?? '') ?>">
						</div>
					</div>
					<!-- Taskbeschreibung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Notizen</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="notizen" rows="4" placeholder="Notizen zum Task" required><?= esc($task['notizen'] ?? '') ?></textarea>
						</div>
					</div>
					<!-- Taskart -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Taskart auswählen</label>
						<div class="col-sm-10">
							<select class="form-select" name="taskartenid" required>
								<option value="">Taskart auswählen</option>
								<?php foreach (
									$taskarten as $taskart
								): ?>
									<option value="<?= esc($taskart['id']) ?>" <?= (isset($task['taskartenid']) && $task['taskartenid'] == $taskart['id']) ? 'selected' : '' ?>>
										<?= esc($taskart['taskart'] . ' ' . $taskart['taskartenicon']) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<!-- Sortid -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Sortid</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" name="sortid" placeholder="Sortierreihenfolge angeben" min="1" step="1" required value="<?= esc($task['sortid'] ?? '') ?>">
						</div>
					</div>
					<!-- Spalte auswählen -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Spalte auswählen</label>
						<div class="col-sm-10">
							<select class="form-select" name="spaltenid" required>
								<option value="">Spalte auswählen</option>
								<?php foreach ($spalten as $spalte): ?>
									<option value="<?= esc($spalte['id']) ?>" <?= (isset($task['spaltenid']) && $task['spaltenid'] == $spalte['id']) ? 'selected' : '' ?>>
										<?= esc($spalte['spalte']) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<!-- Verantwortliche auswählen  -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Verantwortliche</label>
						<div class="col-sm-10">
							<!-- Verstecktes Original-Select für Formular-Submission -->
							<select class="form-select d-none" name="personenids[]" multiple id="personenids-original">
								<?php foreach ($personen as $person): ?>
									<?php
									$pid = $person['id'];
									$isSelected = !empty($task_personen_ids) && in_array($pid, $task_personen_ids, true);
									$fullName = esc(trim(($person['vorname'] ?? '') . ' ' . ($person['name'] ?? '')));
									?>
									<option value="<?= esc($pid) ?>" <?= $isSelected ? 'selected' : '' ?>>
										<?= $fullName ?>
									</option>
								<?php endforeach; ?>
							</select>

							<!-- Ausgewählte Personen als Bootstrap Badges -->
							<div class="d-flex flex-wrap gap-2 mb-2" id="selected-persons"></div>

							<!-- Dropdown Button -->
							<div class="dropdown">
								<button class="btn btn-outline-secondary dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
									type="button"
									id="personDropdownBtn"
									data-bs-toggle="dropdown"
									data-bs-auto-close="outside"
									aria-expanded="false">
									<span>Person auswählen...</span>
								</button>

								<div class="dropdown-menu w-100 p-0" style="max-height: 400px;">
									<!-- Suchfeld im Dropdown -->
									<div class="p-2 border-bottom sticky-top bg-body">
										<input type="text"
											class="form-control form-control-sm"
											id="person-search"
											placeholder="Suchen..."
											autocomplete="off">
									</div>

									<!-- Personenliste -->
									<div class="overflow-auto" id="person-list-container" style="max-height: 300px;">
										<div id="person-list"></div>
									</div>

									<!-- Footer mit Info -->
									<div class="p-2 border-top bg-body-secondary">
										<small class="text-muted">
											<span id="result-count"></span> |
											<span class="" id="selection-count">0</span> ausgewählt
										</small>
									</div>
								</div>
							</div>
						</div>
					</div>

					<style>
						.person-badge-enter {
							animation: badgeFadeIn 0.2s ease;
						}

						@keyframes badgeFadeIn {
							from {
								opacity: 0;
								transform: scale(0.9);
							}

							to {
								opacity: 1;
								transform: scale(1);
							}
						}

						.person-item:hover {
							background-color: var(--bs-tertiary-bg);
						}

						.person-item.selected {
							background-color: var(--bs-primary-bg-subtle);
							border-left: 3px solid var(--bs-primary);
						}
					</style>

					<script>
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
					</script>

					<!-- Erinnerungsdatum -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Erinnerungsdatum</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" name="erinnerungsdatum" value="<?= esc($task['erinnerungsdatum'] ?? false ? date('Y-m-d', strtotime($task['erinnerungsdatum'])) : '') ?>">
						</div>
					</div>
					<!-- Erinnerung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Erinnerung</label>
						<div class="col-sm-10 d-flex align-items-center">
							<input type="checkbox" class="form-check-input me-2" name="erinnerung" <?= !empty($task['erinnerung'] ?? false) ? 'checked' : '' ?>>
						</div>
					</div>
					<!-- Buttons -->
					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-success">Aktualisieren</button>
						<a href="<?= isset($origin) ? $origin : (isset($_SERVER['HTTP_REFERER']) ? esc($_SERVER['HTTP_REFERER']) : base_url('tasks')) ?>" class="btn btn-secondary">Abbrechen</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>
</body>

</html>
