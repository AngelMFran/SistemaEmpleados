<?php
include_once '../../navbar.php';
include_once '../../db.php';  // Incluye la conexión a la base de datos

class ReporteEmpleadoModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    // Método para obtener todos los empleados con todos los datos
    public function obtenerListaEmpleados()
    {
        $sql = "
            SELECT id_empleado, nombres, apellidos, fecha_nac, puesto, tienda, salario, fotografia
            FROM empleados
            LEFT JOIN puestos ON empleados.id_puesto = puestos.id_puesto
            LEFT JOIN tiendas ON empleados.id_tienda = tiendas.id_tienda
        ";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }

    // Método para totalizar los salarios de todos los empleados
    public function totalizarSalarios()
    {
        $sql = "SELECT SUM(salario) as total_salario FROM empleados";
        $result = $this->connection->query($sql);
        return $result->fetch(\Phalcon\Db\Enum::FETCH_ASSOC)['total_salario'];
    }
}

// Instanciar el modelo y obtener los datos
$reporteModel = new ReporteEmpleadoModel($connection);
$empleados = $reporteModel->obtenerListaEmpleados();
$totalSalario = $reporteModel->totalizarSalarios();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?= Navbar::render(); ?>

<div class="container mt-5">
    <h2 class="text-center">Lista General de Empleados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Puesto</th>
                <th>Tienda</th>
                <th>Salario</th>
                <th>Fotografía</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= $empleado['id_empleado'] ?></td>
                    <td><?= $empleado['nombres'] . ' ' . $empleado['apellidos'] ?></td>
                    <td><?= $empleado['fecha_nac'] ?></td>
                    <td><?= $empleado['puesto'] ?></td>
                    <td><?= $empleado['tienda'] ?></td>
                    <td>Q<?= $empleado['salario'] ?></td>
                    <td>
                        <?php if ($empleado['fotografia']): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($empleado['fotografia']) ?>" width="100">
                        <?php else: ?>
                            Sin fotografía
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Total de Salarios: Q<?= $totalSalario ?></h4>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
