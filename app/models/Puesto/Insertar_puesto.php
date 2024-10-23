<?php
// Incluimos la clase Navbar y la conexión a la base de datos
include_once '../../navbar.php'; // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php';     // Ajusta la ruta según la ubicación correcta de db.php

// Clase para manejar el modelo de puestos
class PuestoModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
    }

    // Método para insertar un nuevo puesto
    public function insertarPuesto($puesto)
    {
        $sql = "INSERT INTO puestos (puesto) VALUES (:puesto)";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'puesto' => $puesto
        ]);
    }

    // Obtener todos los puestos
    public function obtenerPuestos()
    {
        $sql = "SELECT id_puesto, puesto FROM puestos";
        $result = $this->connection->query($sql);
        return $result->fetchAll(\Phalcon\Db\Enum::FETCH_ASSOC);
    }
}

// Instanciar el modelo y pasar la conexión a la base de datos
$puestoModel = new PuestoModel($connection);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $puestoModel->insertarPuesto($_POST['puesto']);

    // Redirigir a la página de puestos después de guardar
    header('Location: puestos.php');
    exit;
}

// Obtener la lista de puestos para mostrar en un select (si es necesario para otros usos)
$puestos = $puestoModel->obtenerPuestos();
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

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Insertar Nuevo Puesto</h2>

        <!-- Formulario para insertar un nuevo puesto -->
        <form method="POST">
            <div class="mb-3">
                <label for="puesto" class="form-label">Nombre del Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
