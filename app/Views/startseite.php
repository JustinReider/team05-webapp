<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<script
        src="https://unpkg.com/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js">
</script>

<body class="d-flex flex-column min-vh-100">
<!-- NAVBAR -->


<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid d-flex flex-nowrap">

        <!-- Logo + Text -->
        <a class="navbar-brand ms-3" href="#">
            <img src="logo.svg" alt="Logo" class="navbar-logo">
        </a>

        <!-- Navigation -->
        <ul class="navbar-nav me-auto flex-row">
            <li class="nav-item"><a class="nav-link" href="#">Tasks</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Boards</a></li>
            <li class="nav-item"><a class="nav-link" href="../../public/spalten.html">Spalten</a></li>
        </ul>
    </div>
</nav>

<!-- INHALT -->
<div class="container mt-4 flex-fill">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Tasks</h2>
        </div>
        <div class="card-body">
            <p></p>
        </div>
    </div>
</div>

<footer class="footer-custom">
    <div class="container-fluid d-flex justify-content-between">

        <!-- Linker Text -->
        <span>©Web-Entwicklung 2023</span>

        <!-- Rechte Links -->
        <div>
            <a href="#">Impressum</a>
            <a href="#">Datenschutz</a>
            <a href="#">Kontakt</a>
        </div>

    </div>
</footer>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>