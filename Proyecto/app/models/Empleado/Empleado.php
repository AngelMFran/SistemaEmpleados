<?php
// Incluimos la clase Navbar desde la carpeta correcta
include_once '../../navbar.php'; // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php'; // Ajusta la ruta según la ubicación correcta de db.php
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

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Listado de Empleados</h2>

        <?php
        class EmpleadoModel
        {
            private $connection;

            public function __construct($dbConnection)
            {
                // Usar la conexión a la base de datos pasada como parámetro
                $this->connection = $dbConnection;
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

        // Instanciar el modelo y pasarle la conexión a la base de datos
        $empleadoModel = new EmpleadoModel($connection);
        $empleadoModel->mostrarEmpleados();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
