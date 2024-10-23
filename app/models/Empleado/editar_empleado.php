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

    // Método para obtener un empleado por ID
    public function obtenerEmpleadoPorId($id_empleado)
    {
        $sql = "SELECT * FROM empleados WHERE id_empleado = :id_empleado";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_empleado' => $id_empleado]);
        return $query->fetch(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para obtener todos los puestos
    public function obtenerPuestos()
    {
        $sql = "SELECT id_puesto, puesto FROM puestos";
        $result = $this->connection->query($sql);
        return $result->fetchAll(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para obtener todas las tiendas
    public function obtenerTiendas()
    {
        $sql = "SELECT id_tienda, tienda FROM tiendas";
        $result = $this->connection->query($sql);
        return $result->fetchAll(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para actualizar un empleado
    public function actualizarEmpleado($id_empleado, $nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario, $fotografia = null)
    {
        if ($fotografia) {
            $sql = "UPDATE empleados 
                    SET nombres = :nombres, apellidos = :apellidos, fecha_nac = :fecha_nac, fotografia = :fotografia, id_puesto = :id_puesto, id_tienda = :id_tienda, salario = :salario 
                    WHERE id_empleado = :id_empleado";
            $query = $this->connection->prepare($sql);
            return $query->execute([
                'nombres'    => $nombres,
                'apellidos'  => $apellidos,
                'fecha_nac'  => $fecha_nac,
                'fotografia' => $fotografia,
                'id_puesto'  => $id_puesto,
                'id_tienda'  => $id_tienda,
                'salario'    => $salario,
                'id_empleado' => $id_empleado
            ]);
        } else {
            $sql = "UPDATE empleados 
                    SET nombres = :nombres, apellidos = :apellidos, fecha_nac = :fecha_nac, id_puesto = :id_puesto, id_tienda = :id_tienda, salario = :salario 
                    WHERE id_empleado = :id_empleado";
            $query = $this->connection->prepare($sql);
            return $query->execute([
                'nombres'    => $nombres,
                'apellidos'  => $apellidos,
                'fecha_nac'  => $fecha_nac,
                'id_puesto'  => $id_puesto,
                'id_tienda'  => $id_tienda,
                'salario'    => $salario,
                'id_empleado' => $id_empleado
            ]);
        }
    }
}

// Instanciar el modelo y pasar la conexión a la base de datos
$empleadoModel = new EmpleadoModel($connection);

// Verificar si hay un ID de empleado en la URL y obtener los datos del empleado
if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    $empleado = $empleadoModel->obtenerEmpleadoPorId($id_empleado);
    $puestos = $empleadoModel->obtenerPuestos();  // Obtener opciones para el combo de puestos
    $tiendas = $empleadoModel->obtenerTiendas();  // Obtener opciones para el combo de tiendas
} else {
    echo "No se ha proporcionado un ID de empleado.";
    exit;
}

// Manejar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_empleado = $_POST['id_empleado'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $fecha_nac = $_POST['fecha_nac'];
    $id_puesto = $_POST['id_puesto'];
    $id_tienda = $_POST['id_tienda'];
    $salario = $_POST['salario'];

    // Verificar si se subió una nueva imagen
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['tmp_name']) {
        $fotografia = file_get_contents($_FILES['fotografia']['tmp_name']);
        $empleadoModel->actualizarEmpleado($id_empleado, $nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario, $fotografia);
    } else {
        $empleadoModel->actualizarEmpleado($id_empleado, $nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario);
    }

    // Redirigir de nuevo a la tabla de empleados tras la actualización
    header('Location: Empleado.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Editar Empleado</h2>

        <form action="editar_empleado.php?id=<?= $empleado['id_empleado'] ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?= $empleado['nombres'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= $empleado['apellidos'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="<?= $empleado['fecha_nac'] ?>" required>
            </div>

            <!-- Combo box de Puestos -->
            <div class="mb-3">
                <label for="id_puesto" class="form-label">Puesto</label>
                <select class="form-control" id="id_puesto" name="id_puesto" required>
                    <?php foreach ($puestos as $puesto): ?>
                        <option value="<?= $puesto['id_puesto'] ?>" <?= ($empleado['id_puesto'] == $puesto['id_puesto']) ? 'selected' : '' ?>>
                            <?= $puesto['puesto'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Combo box de Tiendas -->
            <div class="mb-3">
                <label for="id_tienda" class="form-label">Tienda</label>
                <select class="form-control" id="id_tienda" name="id_tienda" required>
                    <?php foreach ($tiendas as $tienda): ?>
                        <option value="<?= $tienda['id_tienda'] ?>" <?= ($empleado['id_tienda'] == $tienda['id_tienda']) ? 'selected' : '' ?>>
                            <?= $tienda['tienda'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="salario" class="form-label">Salario</label>
                <input type="number" class="form-control" id="salario" name="salario" step="0.01" value="<?= $empleado['salario'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="fotografia" class="form-label">Fotografía (opcional)</label>
                <input type="file" class="form-control" id="fotografia" name="fotografia">
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
