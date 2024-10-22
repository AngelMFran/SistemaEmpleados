<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class TiendaModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'crudbddv2_local',
            ]
        );
    }

    // Método para insertar una nueva tienda
    public function insertarTienda($tienda, $direccion, $jefe)
    {
        $sql = "INSERT INTO tiendas (tienda, direccion, jefe) VALUES (:tienda, :direccion, :jefe)";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'tienda'    => $tienda,
            'direccion' => $direccion,
            'jefe'      => $jefe
        ]);
    }
}

// Manejar el formulario de inserción
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tienda = $_POST['tienda'];
    $direccion = $_POST['direccion'];
    $jefe = $_POST['jefe'];

    // Instanciar el modelo y realizar la inserción
    $tiendaModel = new TiendaModel();
    $tiendaModel->insertarTienda($tienda, $direccion, $jefe);

    // Redirigir a la lista de tiendas
    header('Location: tiendas.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Tiendas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="tiendas.php">Listado de Tiendas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Insertar Nueva Tienda</h2>

    <form action="insertar_tienda.php" method="POST">
        <div class="mb-3">
            <label for="tienda" class="form-label">Nombre de la Tienda</label>
            <input type="text" class="form-control" id="tienda" name="tienda" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>

        <div class="mb-3">
            <label for="jefe" class="form-label">Jefe de la Tienda</label>
            <input type="text" class="form-control" id="jefe" name="jefe" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Tienda</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
