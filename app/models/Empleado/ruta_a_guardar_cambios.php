<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class EmpleadoModel
{
    private $connection;

    public function __construct()
    {
        // Configurar la conexión a la base de datos
        $this->connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'crudbddv2_local',
            ]
        );
    }

    // Método para obtener un empleado por ID
    public function obtenerEmpleadoPorId($id_empleado)
    {
        $sql = "SELECT * FROM empleados WHERE id_empleado = :id_empleado";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_empleado' => $id_empleado]);
        return $query->fetch(\Phalcon\Db\Enum::FETCH_ASSOC);
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

// Instancia del modelo
$empleadoModel = new EmpleadoModel();

// Verificar si hay un ID de empleado en la URL y obtener los datos del empleado
if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    $empleado = $empleadoModel->obtenerEmpleadoPorId($id_empleado);
} else {
    echo "No se ha proporcionado un ID de empleado.";
    exit;
}

// Manejar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Empleados</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Empleado.php">Volver a Empleado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="insertar_empleado.php">Insertar Nuevo Empleado</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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

        <div class="mb-3">
            <label for="id_puesto" class="form-label">Puesto</label>
            <input type="text" class="form-control" id="id_puesto" name="id_puesto" value="<?= $empleado['id_puesto'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_tienda" class="form-label">Tienda</label>
            <input type="text" class="form-control" id="id_tienda" name="id_tienda" value="<?= $empleado['id_tienda'] ?>" required>
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
