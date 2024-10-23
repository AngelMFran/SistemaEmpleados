<?php
// Incluimos la clase Navbar y la conexión a la base de datos
include_once '../../navbar.php'; // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php'; // Ajusta la ruta según la ubicación correcta de db.php

// Clase para manejar el modelo de empleados
class EmpleadoModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
    }

    // Método para insertar un nuevo empleado con fotografía
    public function insertarEmpleado($nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario, $fotografia)
    {
        $sql = "INSERT INTO empleados (nombres, apellidos, fecha_nac, id_puesto, id_tienda, salario, fotografia)
                VALUES (:nombres, :apellidos, :fecha_nac, :id_puesto, :id_tienda, :salario, :fotografia)";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'nombres'    => $nombres,
            'apellidos'  => $apellidos,
            'fecha_nac'  => $fecha_nac,
            'id_puesto'  => $id_puesto,
            'id_tienda'  => $id_tienda,
            'salario'    => $salario,
            'fotografia' => $fotografia
        ]);
    }

    // Obtener opciones de Puestos
    public function obtenerPuestos()
    {
        $sql = "SELECT id_puesto, puesto FROM puestos";
        $result = $this->connection->query($sql);
        return $result->fetchAll(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Obtener opciones de Tiendas
    public function obtenerTiendas()
    {
        $sql = "SELECT id_tienda, tienda FROM tiendas";
        $result = $this->connection->query($sql);
        return $result->fetchAll(\Phalcon\Db\Enum::FETCH_ASSOC);
    }
}

// Instanciar el modelo y pasar la conexión a la base de datos
$empleadoModel = new EmpleadoModel($connection);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fotografia = null;

    // Procesar la fotografía si se ha subido
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
        $fotografia = file_get_contents($_FILES['fotografia']['tmp_name']); // Obtener el contenido de la imagen
    }

    // Insertar empleado en la base de datos
    $empleadoModel->insertarEmpleado(
        $_POST['nombres'],
        $_POST['apellidos'],
        $_POST['fecha_nac'],
        $_POST['id_puesto'],
        $_POST['id_tienda'],
        $_POST['salario'],
        $fotografia
    );

    // Redirigir a la página de empleados después de guardar
    header('Location: Empleado.php');
    exit;
}

// Obtener opciones para los combos
$puestos = $empleadoModel->obtenerPuestos();
$tiendas = $empleadoModel->obtenerTiendas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Insertar Nuevo Empleado</h2>

        <!-- Formulario para insertar un nuevo empleado -->
        <!-- Nota: enctype="multipart/form-data" es necesario para subir archivos -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required>
            </div>
            <div class="mb-3">
                <label for="id_puesto" class="form-label">Puesto</label>
                <select class="form-control" id="id_puesto" name="id_puesto" required>
                    <?php foreach ($puestos as $puesto): ?>
                        <option value="<?= $puesto['id_puesto'] ?>"><?= $puesto['puesto'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tienda" class="form-label">Tienda</label>
                <select class="form-control" id="id_tienda" name="id_tienda" required>
                    <?php foreach ($tiendas as $tienda): ?>
                        <option value="<?= $tienda['id_tienda'] ?>"><?= $tienda['tienda'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="number" class="form-control" id="salario" name="salario" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="fotografia" class="form-label">Fotografía</label>
                <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
