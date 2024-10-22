<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class LlamadaModel
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

    // Método para mostrar la tabla de llamadas con el nombre del empleado
    public function mostrarLlamadas()
    {
        $sql = "
            SELECT atencion.id_atencion, atencion.descripcion, atencion.tipo_logro, atencion.fecha_ocurrencia, 
                   empleados.nombres, empleados.apellidos
            FROM atencion
            LEFT JOIN empleados ON atencion.id_empleado = empleados.id_empleado
        ";

        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);

        // Mostrar tabla de llamadas
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID Llamada</th>
                    <th>Descripción</th>
                    <th>Tipo de Logro</th>
                    <th>Fecha de Ocurrencia</th>
                    <th>Empleado</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id_atencion'] . '</td>';
            echo '<td>' . $row['descripcion'] . '</td>';
            echo '<td>' . $row['tipo_logro'] . '</td>';
            echo '<td>' . $row['fecha_ocurrencia'] . '</td>';
            echo '<td>' . $row['nombres'] . ' ' . $row['apellidos'] . '</td>';
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
    <title>Listado de Llamadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Llamadas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="llamadaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Llamada
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="llamadaDropdown">
                        <li><a class="dropdown-item" href="agregar_llamada.php">Agregar Nueva Llamada</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Listado de Llamadas</h2>

    <?php
    // Instanciar el modelo y mostrar la lista de llamadas
    $llamadaModel = new LlamadaModel();
    $llamadaModel->mostrarLlamadas();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
