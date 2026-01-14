<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Spalten</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<!-- Bootstrap JS -->
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-4 flex-fill">
		<div class="card">
			<div class="card-header">
				<h2 class="card-title">Task erstellen</h2>
			</div>
			<div class="card-body">
				<form>
					<!-- Task-Bezeichnung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Tasks</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Bezeichnung für den Task" required>
						</div>
					</div>

					<!-- Taskbeschreibung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Notizen</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4"
								placeholder="" required></textarea>
						</div>
					</div>

					<!-- Taskart -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Taskart auswählen</label>
						<div class="col-sm-10">
							<select class="form-select">
								<option>Allgemeine Todos</option>
								<option>Projekt A</option>
								<option>Projekt B</option>
								<option>Projekt C</option>
							</select>
						</div>
					</div>

					<!-- Sortid -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Sortid</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Sortid angeben" required>
						</div>
					</div>

					<!-- Board auswählen -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Spalte auswählen</label>
						<div class="col-sm-10">
							<select class="form-select">
								<option>Allgemeine Todos</option>
								<option>Projekt A</option>
								<option>Projekt B</option>
								<option>Projekt C</option>
							</select>
						</div>
					</div>

					<!-- Erinnerungsdatum -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Erinnerungsdatum</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" placeholder="Bezeichnung für den Task" required>
						</div>
					</div>

					<!-- Erinnerung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Erinnerung</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Bezeichnung für den Task" required>
						</div>
					</div>

					<!-- Buttons -->
					<div class="d-flex gap-2">
						<a href="#"><button type="submit" class="btn btn-success" href="#">Speichern</button></a>
						<a href=<?= base_url('tasks') //TODO add boardId to url?>><button type="button" class="btn btn-secondary">Abbrechen</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>
