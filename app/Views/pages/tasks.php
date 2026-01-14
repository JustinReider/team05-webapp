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
<!-- INHALT -->
<div class="container mt-4 flex-fill">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="tasks/new">
      <button type="button" class="btn btn-primary">
        <i class="fas"></i>Erstellen
      </button>
    </a>
    <div class="dropdown">
<button class="btn btn-primary dropdown-toggle" type="button" id="boardDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Board
      </button>
      <ul class="dropdown-menu" aria-labelledby="boardDropdown">
        <li><a class="dropdown-item" href="?board=1">Board 1</a></li>
        <li><a class="dropdown-item" href="?board=2">Board 2</a></li>
      </ul>
    </div>
  </div>

		<?php if (!empty($tasks)): ?>
			<div class="overflow-auto">
				<div class="d-flex flex-nowrap gap-3 mt-3">
					<?php foreach ($tasks as $spaltenId => $spalteTasks): ?>
						<div class="flex-grow-1" style="min-width: 200px; max-width: 300px;">
							<h5 class="text-center mb-3">Spalte <?= esc($spaltenId) ?></h5>
							<?php foreach ($spalteTasks as $task): ?>
								<div class="card shadow-sm mb-3 border-0 bg-body-tertiary">
									<div class="card-body">
										<div class="d-flex align-items-center mb-2">
											<span class="badge text-bg-primary me-2">#<?= esc($task['id']) ?></span>
											<h6 class="card-title mb-0 flex-grow-1"><?= esc($task['tasks']) ?></h6>
										</div>
										<ul class="list-group list-group-flush mb-2">
											<li class="list-group-item bg-transparent"><strong>Art:</strong> <?= esc($task['taskartenid']) ?></li>
											<li class="list-group-item bg-transparent"><strong>Sortierung:</strong> <?= esc($task['sortid']) ?></li>
											<li class="list-group-item bg-transparent"><strong>Erstellt:</strong> <?= esc($task['erstelldatum']) ?></li>
											<li class="list-group-item bg-transparent"><strong>Erinnerung:</strong> <?= esc($task['erinnerungsdatum']) ?></li>
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
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<div class="alert alert-info text-center">No tasks found</div>
			<?php endif; ?>
			</div>
	</div>
	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>

</body>

</html>
