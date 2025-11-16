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
<?= $this->include("templates/header.php"); ?>

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

<!-- FOOTER -->
<?= $this->include("templates/footer.php"); ?>

</body>
</html>