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
						<th>Vorname</th>
						<th>Name</th>
						<th>Email</th>
						<th>Passwort</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($tasks)): ?>
						<?php foreach ($tasks as $task): ?>
							<tr>
								<td><?= esc($task['id']) ?></td>
								<td><?= esc($task['vorname']) ?></td>
								<td><?= esc($task['name']) ?></td>
								<td><?= esc($task['email']) ?></td>
								<td>********</td>
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
