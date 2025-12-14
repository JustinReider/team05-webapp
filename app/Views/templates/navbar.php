<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script>
	document.addEventListener("DOMContentLoaded", () => {

		const html = document.documentElement;
		const items = document.querySelectorAll("[data-theme]");
		const dropdownBtn = document.getElementById("toggleTheme");

		function applyTheme(theme) {
			if (theme === "system") {
				const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
				html.setAttribute("data-bs-theme", prefersDark ? "dark" : "light");
				document.documentElement.style.colorScheme = prefersDark ? "dark" : "light";
				dropdownBtn.innerHTML = "<i class=\"bi bi-circle-half me-2 text-light\"></i>";
				return;
			}

			const isDark = theme === "dark";
			html.setAttribute("data-bs-theme", isDark ? "dark" : "light");
			document.documentElement.style.colorScheme = isDark ? "dark" : "light";
			if (isDark) {
				dropdownBtn.innerHTML = "<i class=\"bi bi-moon-stars-fill me-2 text-light\"></i>";
			} else {
				dropdownBtn.innerHTML = "<i class=\"bi bi-brightness-high-fill me-2 text-light\"></i>";
			}
		}

		function setTheme(theme) {
			localStorage.setItem("theme", theme);
			applyTheme(theme);
		}

		const saved = localStorage.getItem("theme");

		if (saved) {
			applyTheme(saved);
		} else {
			applyTheme("system");
		}

		items.forEach(item => {
			item.addEventListener("click", (e) => {
				e.preventDefault();
				setTheme(item.dataset.theme);
			});
		});

	});
</script>

<nav class="navbar navbar-expand-md navbar-custom">
	<div class="container mw-100 justify-content-start align-items-center">

		<!-- Logo + Text -->
		<a class="navbar-brand ms-auto ms-sm-3 me-auto me-sm-3" href="<?= base_url('/') ?>">
			<img src="<?= base_url('logo.svg') ?>" alt="Logo" class="navbar-logo">
		</a>
		<div class="d-flex flex-grow-1 ms-auto ms-sm-0 me-auto me-sm-0">
			<!-- Navigation -->
			<div class="ms-auto ms-sm-0 me-0 me-sm-auto">
				<ul class="navbar-nav flex-row">

					<li class="nav-item mx-1">
						<a class="nav-link" href="<?= base_url('tasks') ?>" title="Tasks">
							<i class="bi bi-clipboard-check-fill icon-main-menu"></i>
							<span class="me-2 me-md-0 d-inline-flex d-sm-none d-md-inline-flex">
								Tasks
							</span>
						</a>
					</li>

					<li class="nav-item mx-1">
						<a class="nav-link" href="#" title="Boards">
							<i class="bi bi-kanban-fill icon-main-menu"></i>
							<span class="me-2 me-md-0 d-inline-flex d-sm-none d-md-inline-flex">
								Boards
							</span>
						</a>
					</li>

					<li class="nav-item mx-1">
						<a class="nav-link" href="<?= base_url('spalten') ?>" title="Spalten">
							<i class="bi bi-layout-three-columns icon-main-menu"></i>
							<span class="me-2 me-md-0 d-inline-flex d-sm-none d-md-inline-flex">
								Spalten
							</span>
						</a>
					</li>
				</ul>
			</div>

			<!-- Dark Mode -->
			<div class="nav-item dropdown ms-0 ms-sm-auto me-auto me-sm-0" title="Theme wechseln">
				<button class="btn dropdown-toggle text-light" id="toggleTheme" type="button" data-bs-toggle="dropdown"></button>
				<ul class="dropdown-menu dropdown-menu-end">
					<li>
						<button type="button" class="dropdown-item d-flex align-items-center" data-theme="light">
							<i class="bi bi-brightness-high-fill me-2"></i>
							<span class="">Light</span>
						</button>
					</li>
					<li>
						<button type="button" class="dropdown-item d-flex align-items-center" data-theme="dark">
							<i class="bi bi-moon-stars-fill me-2"></i>
							<span class="">Dark</span>
						</button>
					</li>
					<li>
						<button type="button" class="dropdown-item d-flex align-items-center" data-theme="system">
							<i class="bi bi-circle-half me-2"></i>
							<span class="">System</span>
						</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
