<?php
include 'PuestoModel.php';

// Instancia del modelo
$puestoModel = new PuestoModel();

// Manejar el formulario de inserción
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $puesto = $_POST['puesto'];
    $puestoModel->insertarPuesto($puesto);
    header('Location: puestos.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Puesto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Puestos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="puestos.php">Volver a Puestos</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Insertar Nuevo Puesto</h2>

    <form action="insertar_puesto.php" method="POST">
        <div class="mb-3">
            <label for="puesto" class="form-label">Nombre del Puesto</label>
            <input type="text" class="form-control" id="puesto" name="puesto" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

</body>
</html>
