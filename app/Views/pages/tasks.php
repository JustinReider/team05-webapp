<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tasks</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<script
	src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-4 flex-fill">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					<h2>Tasks</h2>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<a href="tasks/new">
						<button type="button" class="btn btn-primary">
							<i class="fas"></i>Neu
						</button>
					</a>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" id="boardDropdown" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo ($boardName); ?>
						</button>
						<ul class="dropdown-menu" aria-labelledby="boardDropdown">
							<?php foreach ($boards as $board): ?>
								<li>
									<a class="dropdown-item" href="?board=<?= esc($board['id']) ?>">
										<?= esc($board['board']) ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<?php if (!empty($tasks)): ?>
					<div class="overflow-auto">
						<div class="d-flex gap-3 mt-3 justify-content-center align-items-start">
							<?php foreach ($tasks as $spaltenId => $spalteData): if (empty($spalteData)) continue ?>
								<div class="card h-100" style="flex: 1 1 0; min-width: 200px;">
									<div class="card-header">
										<h5 class="text-center mb-3"><?= esc($spalteData['spalte']) ?></h5>
										<h6 class="text-center mb-3"><?= esc($spalteData['spaltenbeschreibung']) ?></h6>
									</div>
									<div class="card-body">
										<?php foreach ($spalteData['tasks'] as $task): ?>
											<div class="shadow-sm mb-3 border-2 rounded-4 p-3 bg-body-tertiary flex-grow-1">
												<!-- Task-Titel und Edit/Löschen Buttons: mobil und bis lg unter dem Titel, ab lg rechts in einer Zeile -->
												<div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-2 gap-2">
													<h6 class="mb-0 text-start flex-grow-1"><?= esc($task['tasks']) ?></h6>
													<div class="d-flex gap-2 justify-content-start justify-content-lg-end w-100 w-lg-auto">
														<a href="tasks/<?= esc($task['id']) ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
															<i class="bi bi-pencil"></i>
														</a>
														<form action="tasks/delete/<?= esc($task['id']) ?>" method="POST" class="d-inline delete-task-form">
															<button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center delete-task-btn" style="width:32px;height:32px;" data-task-id="<?= esc($task['id']) ?>">
																<i class="bi bi-trash"></i>
															</button>
														</form>
													</div>
												</div>
												<ul class="list-group list-group-flush mb-2">
													<li class="list-group-item bg-transparent"><strong>Art:</strong> <?= esc($task['taskartenid']) ?></li>
													<li class="list-group-item bg-transparent"><i class="bi bi-clock-history me-2"></i><?= (new DateTime($task['erstelldatum']))->format('d.m.Y') ?></li>
													<?php if (!empty($task['erinnerungsdatum']) && !empty($task['erinnerung']) && $task['erinnerung'] > 0): ?>
														<li class="list-group-item bg-transparent">
															<i class="bi bi-stopwatch me-2"></i>
															<?= (new DateTime($task['erinnerungsdatum']))->format('d.m.Y H:i') ?>
														</li>
													<?php endif; ?>
													<li class="list-group-item bg-transparent"><strong>Notizen:</strong> <?= esc($task['notizen']) ?></li>
												</ul>
												<div class="d-flex align-items-end ms-3">
													<span class="badge text-bg-<?= esc($task['erledigt']) ? 'success' : 'secondary' ?>">
														<?= esc($task['erledigt']) ? 'Erledigt' : 'Nicht erledigt' ?>
													</span>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="alert alert-info text-center">No tasks found</div>
					<?php endif; ?>
					</div>
			</div>
		</div>
	</div>
	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>

	<!-- Delete Confirmation Modal -->
	<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteConfirmModalLabel">Löschen bestätigen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Sind Sie sicher, dass Sie diese Aufgabe löschen möchten?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="confirmDeleteBtn">Löschen</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		let formToDelete = null;
		document.querySelectorAll('.delete-task-btn').forEach(btn => {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				formToDelete = this.closest('form');
				const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
				modal.show();
			});
		});
		document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
			if (formToDelete) {
				formToDelete.submit();
			}
			const modalEl = document.getElementById('deleteConfirmModal');
			const modal = bootstrap.Modal.getInstance(modalEl);
			modal.hide();
		});
	</script>

</body>

</html>
