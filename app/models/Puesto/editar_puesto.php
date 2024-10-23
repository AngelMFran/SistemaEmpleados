<?php
// Incluimos la clase Navbar y la conexión a la base de datos
include_once '../../navbar.php';  // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php';      // Ajusta la ruta según la ubicación correcta de db.php

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

    // Método para obtener un puesto por ID
    public function obtenerPuestoPorId($id_puesto)
    {
        $sql = "SELECT * FROM puestos WHERE id_puesto = :id_puesto";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_puesto' => $id_puesto]);
        return $query->fetch(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para actualizar un puesto
    public function actualizarPuesto($id_puesto, $puesto)
    {
        $sql = "UPDATE puestos 
                SET puesto = :puesto 
                WHERE id_puesto = :id_puesto";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'puesto'    => $puesto,
            'id_puesto' => $id_puesto
        ]);
    }
}

// Instanciar el modelo y pasar la conexión a la base de datos
$puestoModel = new PuestoModel($connection);

// Verificar si hay un ID de puesto en la URL y obtener los datos del puesto
if (isset($_GET['id'])) {
    $id_puesto = $_GET['id'];
    $puesto = $puestoModel->obtenerPuestoPorId($id_puesto);
} else {
    echo "No se ha proporcionado un ID de puesto.";
    exit;
}

// Manejar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $puestoActualizado = $_POST['puesto'];

    // Actualizar el puesto
    $puestoModel->actualizarPuesto($id_puesto, $puestoActualizado);

    // Redirigir de nuevo a la tabla de puestos tras la actualización
    header('Location: puestos.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Puesto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Editar Puesto</h2>

        <form action="editar_puesto.php?id=<?= $puesto['id_puesto'] ?>" method="POST">
            <input type="hidden" name="id_puesto" value="<?= $puesto['id_puesto'] ?>">

            <div class="mb-3">
                <label for="puesto" class="form-label">Nombre del Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="<?= $puesto['puesto'] ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
