<?php
include_once '../../navbar.php';
include_once '../../db.php';  // Incluye la conexión a la base de datos

class ReporteSalarioTiendaModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    // Método para obtener lista de empleados agrupados por tienda y ordenados por salario
    public function obtenerSalariosPorTienda()
    {
        $sql = "
            SELECT tiendas.tienda, empleados.nombres, empleados.apellidos, empleados.salario
            FROM empleados
            LEFT JOIN tiendas ON empleados.id_tienda = tiendas.id_tienda
            ORDER BY tiendas.tienda, empleados.salario DESC
        ";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }
}

// Instanciar el modelo y obtener los datos
$reporteModel = new ReporteSalarioTiendaModel($connection);
$empleadosPorTienda = $reporteModel->obtenerSalariosPorTienda();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salarios por Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?= Navbar::render(); ?>

<div class="container mt-5">
    <h2 class="text-center">Salarios de Empleados por Tienda</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tienda</th>
                <th>Empleado</th>
                <th>Salario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleadosPorTienda as $empleado): ?>
                <tr>
                    <td><?= $empleado['tienda'] ?></td>
                    <td><?= $empleado['nombres'] . ' ' . $empleado['apellidos'] ?></td>
                    <td><?= $empleado['salario'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
