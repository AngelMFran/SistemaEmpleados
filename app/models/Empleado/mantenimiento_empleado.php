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

    // Método para obtener todos los empleados
    public function obtenerEmpleados()
    {
        $sql = "SELECT empleados.id_empleado, empleados.nombres, empleados.apellidos, empleados.fecha_nac, puestos.puesto AS puesto, tiendas.tienda AS tienda, empleados.salario 
                FROM empleados
                LEFT JOIN puestos ON empleados.id_puesto = puestos.id_puesto
                LEFT JOIN tiendas ON empleados.id_tienda = tiendas.id_tienda";
        
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

// Instanciar el modelo y pasar la conexión a la base de datos
$empleadoModel = new EmpleadoModel($connection);

// Verificar si se ha solicitado la eliminación de un empleado
if (isset($_GET['eliminar_id'])) {
    if ($empleadoModel->eliminarEmpleado($_GET['eliminar_id'])) {
        // Redirigir antes de enviar cualquier salida
        header('Location: mantenimiento_empleado.php');
        exit;
    } else {
        echo "Error al eliminar el empleado.";
    }
}

// Obtener la lista de empleados para mostrarla en la tabla
$empleados = $empleadoModel->obtenerEmpleados();
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

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Mantenimiento de Empleados</h2>

        <!-- Tabla de empleados -->
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
                // Iterar sobre los empleados y mostrarlos en la tabla
                foreach ($empleados as $empleado) {
                    echo '<tr>';
                    echo '<td>' . $empleado['id_empleado'] . '</td>';
                    echo '<td>' . $empleado['nombres'] . '</td>';
                    echo '<td>' . $empleado['apellidos'] . '</td>';
                    echo '<td>' . $empleado['fecha_nac'] . '</td>';
                    echo '<td>' . $empleado['puesto'] . '</td>';
                    echo '<td>' . $empleado['tienda'] . '</td>';
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

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
