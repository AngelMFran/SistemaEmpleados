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

    // Método para mostrar la tabla de empleados
    public function mostrarEmpleados()
    {
        $sql = "
            SELECT empleados.id_empleado, empleados.nombres, empleados.apellidos, empleados.fecha_nac, puestos.puesto AS puesto, tiendas.tienda AS tienda, empleados.salario, empleados.fotografia
            FROM empleados
            LEFT JOIN puestos ON empleados.id_puesto = puestos.id_puesto
            LEFT JOIN tiendas ON empleados.id_tienda = tiendas.id_tienda
        ";

        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);

        // Mostrar tabla de empleados
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Puesto</th>
                    <th>Tienda</th>
                    <th>Salario</th>
                    <th>Fotografía</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id_empleado'] . '</td>';
            echo '<td>' . $row['nombres'] . ' ' . $row['apellidos'] . '</td>';
            echo '<td>' . $row['fecha_nac'] . '</td>';
            echo '<td>' . $row['puesto'] . '</td>';
            echo '<td>' . $row['tienda'] . '</td>';
            echo '<td>' . $row['salario'] . '</td>';
            echo '<td>';
            if ($row['fotografia']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['fotografia']) . '" width="100">';
            } else {
                echo 'Sin foto';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empleados</title>
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
                <!-- Menú Empleado con Submenús Insertar y Mantenimiento -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="empleadoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Empleado
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="empleadoDropdown">
                        <li><a class="dropdown-item" href="insertar_empleado.php">Insertar</a></li>
                        <li><a class="dropdown-item" href="mantenimiento_empleado.php">Mantenimiento</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Listado de Empleados</h2>

    <?php
    // Instanciar el modelo y mostrar la lista de empleados
    $empleadoModel = new EmpleadoModel();
    $empleadoModel->mostrarEmpleados();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
