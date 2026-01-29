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
							<select class="form-select" name="personenids[]" multiple>
								<?php foreach ($personen as $person): ?>
									<?php
									$pid = $person['id'];
									$isSelected = !empty($task_personen_ids) && in_array($pid, $task_personen_ids, true);
									?>
									<option value="<?= esc($pid) ?>" <?= $isSelected ? 'selected' : '' ?>>
										<?= esc(trim(($person['vorname'] ?? '') . ' ' . ($person['nachname'] ?? ''))) ?>
									</option>
								<?php endforeach; ?>
							</select>
							<div class="form-text">Mehrere Personen mit Strg / Cmd auswählen.</div>
						</div>
					</div>

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
