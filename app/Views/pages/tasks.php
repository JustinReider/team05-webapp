<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tasks</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<style>
		/* --- 1. TASK CARD DESIGN --- */
		.task-card {
			border: none !important;
			background-color: var(--bs-body);
			transition: all 0.2s ease-in-out;
			border-left: 4px solid transparent !important;
		}

		/* Status-Farben am linken Rand */
		.task-card.border-done {
			border-left-color: #198754 !important;
		}

		.task-card.border-pending {
			border-left-color: #6c757d !important;
		}

		.task-card:hover {
			transform: translateY(-3px);
			box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
			border-left-color: #007bff !important;
		}

		/* Meta-Infos (Icons & Text unter dem Titel) */
		.task-meta-list {
			font-size: 0.85rem;
			color: var(--bs-secondary-color);
		}

		.task-meta-item {
			display: flex;
			align-items: center;
			gap: 8px;
			margin-bottom: 4px;
		}

		/* --- 2. KEBAB-MENÜ (DROPDOWN) --- */
		.task-menu-container {
			position: absolute;
			top: 10px;
			right: 8px;
			z-index: 10;
		}

		.btn-task-menu {
			border: none;
			background: transparent;
			color: var(--bs-secondary-color);
			padding: 0 5px;
			font-size: 1.2rem;
			line-height: 1;
			border-radius: 50%;
			transition: background 0.2s;
		}

		.btn-task-menu:hover {
			background-color: var(--bs-secondary-bg);
		}

		/* Icon-Rotation bei Klick */
		.dropdown.show .btn-task-menu i {
			transform: rotate(90deg);
			transition: transform 0.2s ease;
		}

		.btn-task-menu i {
			display: inline-block;
			transition: transform 0.2s ease;
		}

		/* --- 3. DROPDOWN ANIMATION --- */
		.dropdown-menu {
			display: block;
			visibility: hidden;
			opacity: 0;
			transform: translateY(-10px) scale(0.95);
			transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
			pointer-events: none;
			right: 0 !important;
			left: auto !important;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
			border: 1px solid var(--bs-border-color-translucent);
		}

		.dropdown-menu.show {
			visibility: visible;
			opacity: 1;
			transform: translateY(0) scale(1);
			pointer-events: auto;
		}

		.dropdown-item {
			transition: background-color 0.2s, transform 0.1s;
		}

		.dropdown-item:active {
			transform: scale(0.98);
		}

		/* --- 4. HOVER-EFFEKTE (PENCILS & MENÜS) --- */
		.show-on-hover {
			opacity: 0;
			pointer-events: none;
			transition: opacity 0.2s;
		}

		.show-on-hover-parent:hover .show-on-hover,
		.show-on-hover-parent:focus-within .show-on-hover {
			opacity: 1;
			pointer-events: auto;
		}

		/* Absolute Positionierung für Spalten-Pencil */
		.top-end-absolute {
			position: absolute !important;
			top: 8px;
			right: 4px;
			z-index: 2;
		}

		/* Mobile: Hover-Elemente immer zeigen */
		@media (hover: none) and (pointer: coarse) {
			.show-on-hover {
				opacity: 1 !important;
				pointer-events: auto !important;
			}
		}
	</style>
</head>

<script
	src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-3 flex-fill" style="max-width: 95%;">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					<h2>Tasks</h2>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<a href="tasks/new" class="text-decoration-none">
						<button type="button" class="btn btn-primary d-inline-flex align-items-center shadow-sm">
							<i class="bi bi-plus-lg me-2"></i>Neu
						</button>
					</a>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" id="boardDropdown" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo ($boardName); ?>
						</button>

						<ul class="dropdown-menu shadow" aria-labelledby="boardDropdown">
							<?php foreach ($boards as $index => $board): ?>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2" href="?board=<?= esc($board['id']) ?>">
										<?= esc($board['board']) ?>
									</a>
								</li>

								<?php if ($index < count($boards) - 1): ?>
									<li>
										<hr class="dropdown-divider">
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<?php if (!empty($tasks)): ?>
					<div class="overflow-auto">
						<div class="d-flex gap-3 mt-3 justify-content-start">
							<?php foreach ($tasks as $spaltenId => $spalteData): if (empty($spalteData)) continue ?>
								<div class="card h-100 rounded-3" style="flex: 1 1 0; min-width: 272px;">
									<div class="card-header show-on-hover-parent">
										<h5 class="text-center mb-3"><?= esc($spalteData['spalte']) ?></h5>
										<h6 class="text-center mb-3"><?= esc($spalteData['spaltenbeschreibung']) ?></h6>
										<a href="<?= base_url("spalten/" . $spaltenId) ?>" class="btn btn-outline-secondary btn-sm top-end-absolute show-on-hover">
											<i class="bi bi-pencil-fill"></i>
										</a>
									</div>
									<div class="card-body">
										<?php foreach ($spalteData['tasks'] as $task): ?>
											<div class="task-card shadow-sm mb-3 rounded-4 p-3 show-on-hover-parent position-relative <?= $task['erledigt'] ? 'border-done' : 'border-pending' ?>">

												<div class="task-menu-container">
													<div class="dropdown">
														<button class="btn-task-menu" type="button" data-bs-toggle="dropdown" data-bs-offset="0,10">
															<i class="bi bi-three-dots-vertical"></i>
														</button>
														<ul class="dropdown-menu dropdown-menu-end shadow">
															<li>
																<a class="dropdown-item d-flex align-items-center" href="tasks/<?= esc($task['id']) ?>">
																	<i class="bi bi-pencil-square me-2 text-secondary"></i> Bearbeiten
																</a>
															</li>
															<li>
																<hr class="dropdown-divider">
															</li>
															<li>
																<form action="tasks/delete/<?= esc($task['id']) ?>" method="POST" class="d-inline delete-task-form">
																	<button type="button" class="dropdown-item d-flex align-items-center text-danger delete-task-btn" data-task-id="<?= esc($task['id']) ?>">
																		<i class="bi bi-trash3-fill me-2"></i> Löschen
																	</button>
																</form>
															</li>
														</ul>
													</div>
												</div>

												<div class="mb-2 pe-4">
													<h6 class="fw-bold mb-0 text-break"><?= esc($task['tasks']) ?></h6>
												</div>

												<div class="task-meta-list mb-3">
													<div class="task-meta-item">
														<span title="Art"><?= $task['taskartenicon'] ?></span>
														<span class="text-muted small"><?= esc($task['notizen']) ?></span>
													</div>

													<div class="task-meta-item small mt-2 d-flex flex-wrap gap-3 justify-content-between">
														<span>
															<i class="bi bi-calendar3 me-1"></i>
															<?= (new DateTime($task['erstelldatum']))->format('d. M') ?>
														</span>

														<?php if (!empty($task['erinnerungsdatum']) && !empty($task['erinnerung']) && $task['erinnerung'] > 0): ?>
															<span class="<?= (strtotime($task['erinnerungsdatum']) < time()) ? 'text-danger fw-semibold' : '' ?>" title="Erinnerung">
																<i class="bi bi-alarm me-1"></i>
																<?= (new DateTime($task['erinnerungsdatum']))->format('d.m. H:i') ?>
															</span>
														<?php endif; ?>
													</div>
												</div>


                                                <div class="task-meta-item small mt-2 d-flex flex-wrap gap-3 justify-content-between">
                                                    <span>
                                                        <i class="bi bi-person me-1 text-secondary"></i>
                                                             <?php if (!empty($task['personen'])): ?>
                                                              <?= esc(implode(', ', array_map(
                                                               fn ($p) => trim(($p['vorname'] ?? '') . ' ' . ($p['nachname'] ?? '')),
                                                                $task['personen']))) ?>
                                                                  <?php else: ?>
                                                                     Keine Person zugeordnet
                                                             <?php endif; ?>
                                                        </span>
                                                </div>



												<div class="d-flex justify-content-end mt-2">
													<form action="tasks/toggle_done/<?= esc($task['id']) ?>" method="POST" class="d-inline toggle-done-form">
														<button type="button"
															class="badge rounded-pill <?= $task['erledigt'] ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?> toggle-done-btn"
															style="font-size: 0.7rem; border: none;"
															data-task-id="<?= esc($task['id']) ?>"
															data-task-status="<?= $task['erledigt'] ?>">
															<?= $task['erledigt'] ? 'Erledigt' : 'Offen' ?>
														</button>
													</form>
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
					Sind Sie sicher, dass Sie diese Task löschen möchten?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="confirmDeleteBtn">Löschen</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Toggle Done Modal (zentral, wird per JS befüllt) -->
	<div class="modal fade" id="toggleDoneModal" tabindex="-1" aria-labelledby="toggleDoneModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="toggleDoneModalLabel">Status ändern</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="toggleDoneModalBody">
					Möchten Sie den Status dieser Task wirklich ändern?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="confirmToggleDoneBtn">Ja</button>
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

		// Toggle Done Modal Handling analog zu Delete
		let formToToggleDone = null;
		document.querySelectorAll('.toggle-done-btn').forEach(btn => {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				formToToggleDone = this.closest('form');
				const erledigt = this.getAttribute('data-task-status');
				document.getElementById('toggleDoneModalBody').textContent = erledigt == '1' ?
					'Möchten Sie diese Task wirklich als offen markieren?' :
					'Möchten Sie diese Task wirklich als erledigt markieren?';
				const modal = new bootstrap.Modal(document.getElementById('toggleDoneModal'));
				modal.show();
			});
		});
		document.getElementById('confirmToggleDoneBtn').addEventListener('click', function() {
			if (formToToggleDone) {
				formToToggleDone.submit();
			}
			const modalEl = document.getElementById('toggleDoneModal');
			const modal = bootstrap.Modal.getInstance(modalEl);
			modal.hide();
		});
	</script>



</body>

</html>
