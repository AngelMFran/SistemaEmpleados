<?php
// Incluir la barra de navegación y la conexión a la base de datos
include_once '../../navbar.php';  // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php';      // Ajusta la ruta según la ubicación correcta de db.php

// Clase para manejar el modelo de tiendas
class TiendaModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
    }

    // Método para obtener una tienda por ID
    public function obtenerTiendaPorId($id_tienda)
    {
        $sql = "SELECT * FROM tiendas WHERE id_tienda = :id_tienda";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_tienda' => $id_tienda]);
        return $query->fetch(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para actualizar una tienda
    public function actualizarTienda($id_tienda, $tienda, $direccion, $jefe)
    {
        $sql = "UPDATE tiendas SET tienda = :tienda, direccion = :direccion, jefe = :jefe WHERE id_tienda = :id_tienda";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'tienda'     => $tienda,
            'direccion'  => $direccion,
            'jefe'       => $jefe,
            'id_tienda'  => $id_tienda
        ]);
    }
}

// Instanciar el modelo y pasar la conexión desde db.php
$tiendaModel = new TiendaModel($connection);

// Verificar si hay un ID de tienda en la URL y obtener los datos de la tienda
if (isset($_GET['id'])) {
    $id_tienda = $_GET['id'];
    $tienda = $tiendaModel->obtenerTiendaPorId($id_tienda);
} else {
    echo "No se ha proporcionado un ID de tienda.";
    exit;
}

// Manejar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tienda = $_POST['tienda'];
    $direccion = $_POST['direccion'];
    $jefe = $_POST['jefe'];

    // Actualizar tienda
    $tiendaModel->actualizarTienda($id_tienda, $tienda, $direccion, $jefe);

    // Redirigir a la lista de tiendas tras la actualización
    header('Location: tiendas.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Editar Tienda</h2>

        <form action="edit_tienda.php?id=<?= $tienda['id_tienda'] ?>" method="POST">
            <div class="mb-3">
                <label for="tienda" class="form-label">Nombre de la Tienda</label>
                <input type="text" class="form-control" id="tienda" name="tienda" value="<?= $tienda['tienda'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $tienda['direccion'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jefe" class="form-label">Jefe de la Tienda</label>
                <input type="text" class="form-control" id="jefe" name="jefe" value="<?= $tienda['jefe'] ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
