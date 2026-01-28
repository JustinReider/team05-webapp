<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Startseite</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<script
	src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<style>
	.hero-gradient {
		background: linear-gradient(135deg, var(--bs-primary) 0%, #6610f2 100%);
		color: white;
		border-radius: 2rem;
		padding: 4rem 2rem;
		position: relative;
		overflow: hidden;
		z-index: 1;
	}

	.hero-gradient::after {
		content: "";
		position: absolute;
		top: -30%;
		left: -30%;
		width: 160%;
		height: 160%;
		background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, transparent 60%);
		animation: rotateHero 15s linear infinite;
		z-index: -1;
	}

	@keyframes rotateHero {
		from {
			transform: rotate(0deg);
		}

		to {
			transform: rotate(360deg);
		}
	}

	.hover-lift {
		transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
	}

	.hover-lift:hover {
		transform: translateY(-8px);
		box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
	}

	.hierarchy-step {
		position: relative;
		padding: 1.5rem;
		border-left: 3px solid var(--bs-primary);
		margin-left: 1rem;
		transition: border-left 0.3s ease;
	}

	.hierarchy-step:hover {
		border-left-color: #ffc107;
	}

	.hierarchy-step::before {
		content: '';
		position: absolute;
		left: -11px;
		top: 50%;
		transform: translateY(-50%);
		width: 19px;
		height: 19px;
		background: var(--bs-primary);
		border: 4px solid var(--bs-body-bg);
		border-radius: 50%;
		transition: background 0.3s ease;
	}

	.hierarchy-step:hover::before {
		background: #ffc107;
	}
</style>

<body class="d-flex flex-column min-vh-100">
	<!-- NAVBAR -->
	<?= $this->include("templates/navbar.php"); ?>

	<!-- INHALT -->
	<div class="container mt-5 flex-fill">

		<section class="hero-gradient mb-5 p-5 text-center shadow-lg">
			<h1 class="display-3 fw-bold mb-3">Team 5</h1>
			<p class="lead mb-4 mx-auto" style="max-width: 800px;">
				Willkommen beim Dashboard von Team 5. Hier laufen alle Fäden unseres Webentwicklung-Projekts zusammen.
				Verwalte hier Boards, Spalten und Aufgaben.
			</p>
			<div class="d-flex justify-content-center gap-3">
				<a href="<?= base_url('tasks') ?>" class="btn btn-light btn-lg px-4 fw-bold text-primary">Board öffnen</a>
				<a href="<?= base_url('boards') ?>" class="btn btn-outline-light btn-lg px-4">Boards verwalten</a>
			</div>
		</section>

		<div class="row g-4 mb-5">
			<div class="col-md-3">
				<div class="card h-100 border-0 shadow-sm rounded-4 hover-lift bg-body-tertiary">
					<div class="card-body text-center">
						<i class="bi bi-kanban-fill fs-1 text-primary mb-3"></i>
						<h5 class="card-title">Boards</h5>
						<p class="card-text small text-muted">Erstelle Projekte und behalte den Überblick.</p>
						<a href="<?= base_url('boards') ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card h-100 border-0 shadow-sm rounded-4 hover-lift bg-body-tertiary">
					<div class="card-body text-center">
						<i class="bi bi-layout-three-columns fs-1 text-success mb-3"></i>
						<h5 class="card-title">Spalten</h5>
						<p class="card-text small text-muted">Definiere deinen Workflow (z.B. To-Do, In Progress).</p>
						<a href="<?= base_url('spalten') ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card h-100 border-0 shadow-sm rounded-4 hover-lift bg-body-tertiary">
					<div class="card-body text-center">
						<i class="bi bi-clipboard-check-fill fs-1 text-warning mb-3"></i>
						<h5 class="card-title">Tasks</h5>
						<p class="card-text small text-muted">Verwalte Aufgaben mit Deadlines und Notizen.</p>
						<a href="<?= base_url('tasks') ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card h-100 border-0 shadow-sm rounded-4 hover-lift bg-body-tertiary">
					<div class="card-body text-center">
						<i class="bi bi-people-fill fs-1 text-info mb-3"></i>
						<h5 class="card-title">Personen</h5>
						<p class="card-text small text-muted">Weise Teammitglieder den Aufgaben zu.</p>
						<a href="<?= base_url('personen') ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
		</div>

		<section class="my-5 p-4 rounded-4 bg-body-secondary shadow-sm">
			<h2 class="text-center mb-5">Wie das Task-Board funktioniert</h2>
			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="hierarchy-step mb-4">
						<h4>1. Das Board</h4>
						<p>Dein Projekt wird hier angelegt. Alle Tasks laufen hier zusammen.</p>
					</div>
					<div class="hierarchy-step mb-4">
						<h4>2. Die Spalten</h4>
						<p>Unterteile dein Board in Phasen. Jede Spalte repräsentiert einen Fortschritts-Status.</p>
					</div>
					<div class="hierarchy-step mb-4">
						<h4>3. Die Tasks</h4>
						<p>Einzelne Aufgaben mit Prioritäten, Datum und Zuständigkeiten.</p>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="p-4 rounded-4 bg-dark text-white shadow-lg border border-primary border-2">
						<div class="d-flex justify-content-between mb-3">
							<span class="badge bg-primary">Task-Vorschau</span>
							<i class="bi bi-three-dots"></i>
						</div>
						<h6>🚀 Landing Page finalisieren</h6>
						<div class="small opacity-75 mb-3">Art: 🌐 Webdesign</div>
						<div class="d-flex gap-2 mb-2">
							<span class="badge rounded-pill bg-secondary small"><i class="bi bi-clock me-1"></i> 28.01.2026</span>
						</div>
						<hr>
						<div class="d-flex justify-content-between align-items-center">
							<span class="text-success small fw-bold">Status: Aktiv</span>
							<div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center shadow" style="width: 32px; height: 32px; font-size: 12px;">T5</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="row text-center g-4 my-5">
			<div class="col-md-4">
				<i class="bi bi-layout-three-columns fs-2 text-primary"></i>
				<h4 class="mt-2">Klare Struktur</h4>
				<p class="text-muted">Organisiere deine Tasks in individuellen Spalten und Boards für maximale Übersicht.</p>
			</div>
			<div class="col-md-4">
				<i class="bi bi-lightning-charge-fill fs-2 text-warning"></i>
				<h4 class="mt-2">Schnell & Dynamisch</h4>
				<p class="text-muted">Dank Bootstrap 5 und CI4 optimiert für Geschwindigkeit.</p>
			</div>
			<div class="col-md-4">
				<i class="bi bi-palette-fill fs-2 text-danger"></i>
				<h4 class="mt-2">Adaptives Design</h4>
				<p class="text-muted">Nutze den Dark oder Light Mode, wie es dir gefällt.</p>
			</div>
		</section>

	</div>

	<!-- FOOTER -->
	<?= $this->include("templates/footer.php"); ?>

</body>

</html>
