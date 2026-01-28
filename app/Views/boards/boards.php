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
	<div class="container mt-3 flex-fill" style="max-width: 95%;">
		<div class="card">
			<div class="card-header">
				<h2 class="card-title">Boards</h2>
			</div>
			<div class="card-body">
				<p>
					<a href="/boards/new">
						<button type="button" class="btn btn-primary">
							<i class="fas"></i>Neu
						</button>
					</a>
				</p>
				<p>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>ID<br></th>
								<th>Titel<br></th>
							</tr>
						</thead>

						<tbody>
								<?php foreach ($boards as $board): if(empty($board)) continue ?>
								<tr>
									<td><?= esc($board['id']) ?></td>
									<td><?= esc($board['board']) ?></td>
									<td>
										<a href="boards/<?= esc($board['id']) ?>" class="btn btn-sm btn-primary me-2">
											<i class="fas fa-pen-to-square"></i>
										</a>

										<form action="boards/delete/<?= esc($board['id']) ?>" method="POST" class="d-inline delete-board-form">
											<button type="button" class="btn btn-sm btn-danger delete-board-btn" data-board-id="<?= esc($board['id']) ?>">
												<i class="fas fa-trash"></i>
											</button>
										</form>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				</p>
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
					Sind Sie sicher, dass Sie dieses Board löschen möchten?
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
		document.querySelectorAll('.delete-board-btn').forEach(btn => {
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
