<?php
// Incluimos la clase Navbar y la conexión a la base de datos
include_once '../../navbar.php'; // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php'; // Ajusta la ruta según la ubicación correcta de db.php

// Clase para manejar el modelo de llamadas
class LlamadaModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
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

// Instanciar el modelo y pasar la conexión a la base de datos
$llamadaModel = new LlamadaModel($connection);
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

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Listado de Llamadas</h2>

        <?php
        // Mostrar la lista de llamadas
        $llamadaModel->mostrarLlamadas();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
