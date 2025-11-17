<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spalten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<!-- Bootstrap JS -->
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<body class="d-flex flex-column min-vh-100">
<!-- NAVBAR -->
<?= $this->include("templates/header.php"); ?>

<!-- INHALT -->
<div class="container mt-4 flex-fill">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Spalten</h2>
        </div>
        <div class="card-body">
            <p>
               <a href="http://localhost"> <button type="button" class="btn btn-primary">
                   <i class="fas"></i>Erstellen
               </button>
               </a> </p>
            <p>
                <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>ID<br></th>
                <th>Board<br></th>
                <th>Sortid<br></th>
                <th>Spalte<br></th>
                <th>Spaltenbeschreibung<br></th>
                <th>Bearbeiten<br></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>1</td>
                <td>Allgemeine Tool</td>
                <td>100</td>
                <td>Zu besprechen</td>
                <td>Noch zu besprechende Todos</td>
                <td>
                    <button class="btn btn-sm btn-primary me-2" title="Bearbeiten">
                        <i class="fas fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Löschen">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Allgemeine Tool</td>
                <td>200</td>
                <td>In Bearbeitung</td>
                <td>Todos die aktuell bearbeitet werden</td>
                <td>
                    <button class="btn btn-sm btn-primary me-2" title="Bearbeiten">
                        <i class="fas fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Löschen">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
            </p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?= $this->include("templates/footer.php"); ?>

</body>
</html>