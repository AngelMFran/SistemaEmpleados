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

    // Método para insertar un nuevo empleado
    public function insertarEmpleado($nombres, $apellidos, $fecha_nac, $id_puesto, $id_tienda, $salario)
    {
        $sql = "INSERT INTO empleados (nombres, apellidos, fecha_nac, id_puesto, id_tienda, salario)
                VALUES (:nombres, :apellidos, :fecha_nac, :id_puesto, :id_tienda, :salario)";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'nombres'    => $nombres,
            'apellidos'  => $apellidos,
            'fecha_nac'  => $fecha_nac,
            'id_puesto'  => $id_puesto,
            'id_tienda'  => $id_tienda,
            'salario'    => $salario
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

$empleadoModel = new EmpleadoModel();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empleadoModel->insertarEmpleado(
        $_POST['nombres'],
        $_POST['apellidos'],
        $_POST['fecha_nac'],
        $_POST['id_puesto'],
        $_POST['id_tienda'],
        $_POST['salario']
    );

    // Redirigir a la página de empleados
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Empleados</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Menú Empleado con Submenús Insertar, Mantenimiento y Volver a Empleado -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="empleadoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Empleado
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="empleadoDropdown">
                        <li><a class="dropdown-item" href="insertar_empleado.php">Insertar</a></li>
                        <li><a class="dropdown-item" href="mantenimiento_empleado.php">Mantenimiento</a></li>
                        <li><a class="dropdown-item" href="Empleado.php">Volver a Empleado</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Insertar Nuevo Empleado</h2>

    <form method="POST">
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
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
