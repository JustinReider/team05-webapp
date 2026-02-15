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
	<link rel="stylesheet" href="<?= base_url('css/task_form.css') ?>">
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
					<?= view('templates/form_components/_form_input', [
						'label' => 'Tasks',
						'type' => 'text',
						'name' => 'tasks',
						'placeholder' => 'Task-Bezeichnung eingeben',
						'value' => $task['tasks'] ?? '',

					]) ?>
					<!-- Taskbeschreibung -->
					<?= view('templates/form_components/_form_textarea', [
						'label' => 'Notizen',
						'name' => 'notizen',
						'value' => $task['notizen'] ?? '',
						'placeholder' => 'Notizen zum Task',
					]) ?>
					<!-- Taskart -->
					<?= view('templates/form_components/_form_select', [
						'label' => 'Taskart auswählen',
						'name' => 'taskartenid',
						'options' => array_map(fn($t) => ['value' => $t['id'], 'label' => $t['taskart'] . ' ' . $t['taskartenicon']], $taskarten),
						'selected' => $task['taskartenid'] ?? '',
						'placeholder' => 'Taskart auswählen',
					]) ?>
					<!-- Sortid -->
					<?= view('templates/form_components/_form_input', [
						'label' => 'Sortid',
						'type' => 'number',
						'name' => 'sortid',
						'placeholder' => 'Sortierreihenfolge angeben',
						'value' => $task['sortid'] ?? '',
					]) ?>
					<!-- Spalte auswählen -->
					<?= view('templates/form_components/_form_select', [
						'label' => 'Spalte auswählen',
						'name' => 'spaltenid',
						'options' => array_map(fn($s) => ['value' => $s['id'], 'label' => $s['spalte']], $spalten),
						'selected' => $task['spaltenid'] ?? '',
						'placeholder' => 'Spalte auswählen',
					]) ?>


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

					<!-- Erinnerungsdatum -->
					<?= view('templates/form_components/_form_date', [
						'label' => 'Erinnerungsdatum',
						'name' => 'erinnerungsdatum',
						'value' => isset($task['erinnerungsdatum']) && $task['erinnerungsdatum'] ? date('Y-m-d', strtotime($task['erinnerungsdatum'])) : ''
					]) ?>
					<!-- Erinnerung -->
					<?= view('templates/form_components/_form_checkbox', [
						'label' => 'Erinnerung',
						'name' => 'erinnerung',
						'checked' => !empty($task['erinnerung'] ?? false)
					]) ?>
					<!-- Buttons -->
					<?= view('templates/form_components/_form_buttons', [
						'submitLabel' => 'Aktualisieren',
						'cancelUrl' => isset($origin) ? $origin : (isset($_SERVER['HTTP_REFERER']) ? esc($_SERVER['HTTP_REFERER']) : base_url('tasks')),
						'cancelLabel' => 'Abbrechen'
					]) ?>

				</form>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>
	<script src="<?= base_url('js/task_form.js') ?>"></script>
</body>

</html>
