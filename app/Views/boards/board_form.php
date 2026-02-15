<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Boards</title>
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

				<form method="POST" action="<?= base_url('public/boards/save' . (isset($board['id']) ? '/' . $board['id'] : '')) ?>">
					<?= csrf_field() ?>

					<!-- Board-Bezeichnung -->
					<?= view('templates/form_components/_form_input', [
						'label' => 'Board-Bezeichnung',
						'type' => 'text',
						'name' => 'board',
						'placeholder' => 'Bezeichnung für das Board',
						'value' => $board['board'] ?? '',
					]) ?>

					<?= view('templates/form_components/_form_buttons', [
						'submitLabel' => 'Speichern',
						'cancelUrl' => isset($origin) ? $origin : (isset($_SERVER['HTTP_REFERER']) ? esc($_SERVER['HTTP_REFERER']) : base_url('boards')),
						'cancelLabel' => 'Abbrechen'
					]) ?>

				</form>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>
