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
				<h2 class="card-title"><?= $title ?></h2>
			</div>
			<div class="card-body">



				<?php if (isset($error)): ?>
					<div class="alert alert-danger">
						<?php foreach ($error as $err): ?>
							<div><?= esc($err) ?></div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>


				<form method="POST" action="<?= base_url('public/spalten/save' . (isset($spalte['id']) ? '/' . $spalte['id'] : '')) ?>">
					<?= csrf_field() ?>
					<input type="hidden" name="boardsid" value="1">

					<!-- Spalten-Bezeichnung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Spalten-Bezeichnung</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="spalte" placeholder="Bezeichnung für die Spalte" required value="<?= isset($spalte['spalte']) ? esc($spalte['spalte']) : '' ?>">
						</div>
					</div>

					<!-- Spaltenbeschreibung -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Spaltenbeschreibung</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="spaltenbeschreibung" rows="4" required><?= isset($spalte['spaltenbeschreibung']) ? esc($spalte['spaltenbeschreibung']) : '' ?></textarea>
						</div>
					</div>

					<!-- Sortid -->
					<div class="row mb-3">
						<label class="col-sm-2 col-form-label">Sortid</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" name="sortid" placeholder="Sortid angeben" min="1" step="1" required value="<?= isset($spalte['sortid']) ? esc($spalte['sortid']) : '' ?>">
						</div>
					</div>

					<!-- Board auswählen -->
					<div class="row mb-4">
						<label class="col-sm-2 col-form-label">Board auswählen</label>
						<div class="col-sm-10">
							<!--
        <select class="form-select" name="boardsid">
            <option value="1">Allgemeine Todos</option>
            <option value="2">Projekt A</option>
            <option value="3">Projekt B</option>
            <option value="4">Projekt C</option>
        </select>
        -->
							<input type="number" class="form-control" name="boardsid" placeholder="Boards-ID angeben" min="1" step="1" required value="<?= isset(
																																																																						$spalte['boardsid']
																																																																					) ? esc($spalte['boardsid']) : '' ?>">
						</div>
					</div>

					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-success">Speichern</button>
						<a href="<?= isset($origin) ? $origin : (isset($_SERVER['HTTP_REFERER']) ? esc($_SERVER['HTTP_REFERER']) : base_url('spalten')) ?>" class="btn btn-secondary">Abbrechen</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>
