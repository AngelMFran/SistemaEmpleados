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

    // Método para obtener todos los empleados
    public function obtenerEmpleados()
    {
        $sql = "SELECT * FROM empleados";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }

    // Método para eliminar un empleado
    public function eliminarEmpleado($id)
    {
        $sql = "DELETE FROM empleados WHERE id_empleado = :id";
        $query = $this->connection->prepare($sql);
        return $query->execute(['id' => $id]);
    }
}

$empleadoModel = new EmpleadoModel();

// Verificar si se ha solicitado la eliminación de un empleado
if (isset($_GET['eliminar_id'])) {
    $empleadoModel->eliminarEmpleado($_GET['eliminar_id']);
    header('Location: mantenimiento_empleado.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Empleados</title>
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
    <h2 class="text-center">Mantenimiento de Empleados</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Puesto</th>
                <th>Tienda</th>
                <th>Salario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener los empleados y mostrarlos
            $empleados = $empleadoModel->obtenerEmpleados();
            foreach ($empleados as $empleado) {
                echo '<tr>';
                echo '<td>' . $empleado['id_empleado'] . '</td>';
                echo '<td>' . $empleado['nombres'] . '</td>';
                echo '<td>' . $empleado['apellidos'] . '</td>';
                echo '<td>' . $empleado['fecha_nac'] . '</td>';
                echo '<td>' . $empleado['id_puesto'] . '</td>';
                echo '<td>' . $empleado['id_tienda'] . '</td>';
                echo '<td>' . $empleado['salario'] . '</td>';
                echo '<td>
                        <a href="editar_empleado.php?id=' . $empleado['id_empleado'] . '" class="btn btn-warning btn-sm">Editar</a>
                        <a href="mantenimiento_empleado.php?eliminar_id=' . $empleado['id_empleado'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este empleado?\');">Eliminar</a>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
