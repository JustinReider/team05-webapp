<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tasks</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>

<script
	src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-4 flex-fill">
		<div class="table-responsive">
			<table class="table table-striped ">
				<thead>
					<tr>
						<th>ID</th>
						<th>taskartenid</th>
						<th>spaltenid</th>
						<th>sortid</th>
						<th>tasks</th>
						<th>erstelldatum</th>
						<th>erinnerungsdatum</th>
						<th>erinnerungsdatum</th>
						<th>erinnerung</th>
						<th>notizen</th>
						<th>erledigt</th>
						<th>gelöscht</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($tasks)): ?>
						<?php foreach ($tasks as $task): ?>
							<tr>
								<td><?= esc($task['id']) ?></td>
								<td><?= esc($task['taskartenid']) ?></td>
								<td><?= esc($task['spaltenid']) ?></td>
								<td><?= esc($task['sortid']) ?></td>
								<td><?= esc($task['tasks']) ?></td>
								<td><?= esc($task['erstelldatum']) ?></td>
								<td><?= esc($task['erinnerungsdatum']) ?></td>
								<td><?= esc($task['erinnerung']) ?></td>
								<td><?= esc($task['notizen']) ?></td>
								<td><?= esc($task['erledigt']) ?></td>
								<td><?= esc($task['geloescht']) ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="2" class="text-center">No tasks found</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>

</body>

</html>
