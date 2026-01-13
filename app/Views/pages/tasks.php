<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tasks</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<script
	src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-4 flex-fill">
		<p>
			<a href="tasks/new">
				<button type="button" class="btn btn-primary">
					<i class="fas"></i>Erstellen
				</button>
			</a>
		</p>
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
			<?php if (!empty($tasks)): ?>
				<?php foreach ($tasks as $task): ?>
					<div class="col">
						<div class="card shadow-sm h-100 border-0 bg-body-tertiary">
							<div class="card-body">
								<div class="d-flex align-items-center mb-2">
									<span class="badge text-bg-primary me-2">#<?= esc($task['id']) ?></span>
									<h5 class="card-title mb-0 flex-grow-1">Task: <?= esc($task['tasks']) ?></h5>
								</div>
								<ul class="list-group list-group-flush mb-3">
									<li class="list-group-item bg-transparent"><strong>Art:</strong> <?= esc($task['taskartenid']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Spalte:</strong> <?= esc($task['spaltenid']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Sortierung:</strong> <?= esc($task['sortid']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Erstellt:</strong> <?= esc($task['erstelldatum']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Erinnerung:</strong> <?= esc($task['erinnerungsdatum']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Erinnerung aktiv:</strong> <?= esc($task['erinnerung']) ?></li>
									<li class="list-group-item bg-transparent"><strong>Notizen:</strong> <?= esc($task['notizen']) ?></li>
								</ul>
								<div class="d-flex justify-content-between align-items-center">
									<span class="badge text-bg-<?= esc($task['erledigt']) ? 'success' : 'secondary' ?>">
										<?= esc($task['erledigt']) ? 'Erledigt' : 'Offen' ?>
									</span>
									<span class="badge text-bg-<?= esc($task['geloescht']) ? 'danger' : 'info' ?>">
										<?= esc($task['geloescht']) ? 'Gelöscht' : 'Aktiv' ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="col">
					<div class="alert alert-info text-center">No tasks found</div>
				</div>
			<?php endif; ?>
		</div>
		<style>
			.card {
				transition: transform 0.15s cubic-bezier(.4, 2, .6, 1), box-shadow 0.15s;
			}

			.card:hover {
				transform: translateY(-4px) scale(1.02);
				box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
			}

			.card .badge {
				font-size: 0.95em;
				letter-spacing: 0.03em;
			}

			.card-title {
				font-weight: 600;
			}

			.list-group-item {
				border: none;
				padding-left: 0;
				padding-right: 0;
			}
		</style>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>

</body>

</html>
