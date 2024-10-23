<?php

include_once '../../navbar.php'; // Asegúrate de ajustar la ruta de navbar.php
include_once '../../db.php'; // Asegúrate de ajustar la ruta de db.php

class LogrosModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    // Método para obtener los logros de los empleados
    public function obtenerLogros()
    {
        $sql = "SELECT a.id_atencion, a.descripcion, a.fecha_ocurrencia, e.nombres, e.apellidos 
                FROM atencion a 
                INNER JOIN empleados e ON a.id_empleado = e.id_empleado 
                WHERE a.tipo_logro = 'Positivo'";

        $result = $this->connection->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}

$logrosModel = new LogrosModel($connection);
$logros = $logrosModel->obtenerLogros();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Logros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?= Navbar::render(); ?>

<div class="container mt-5">
    <h2 class="text-center">Reporte de Logros de Empleados</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Logro</th>
                <th>Descripción</th>
                <th>Fecha de Ocurrencia</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logros as $logro): ?>
                <tr>
                    <td><?= $logro['id_atencion'] ?></td>
                    <td><?= $logro['descripcion'] ?></td>
                    <td><?= $logro['fecha_ocurrencia'] ?></td>
                    <td><?= $logro['nombres'] . ' ' . $logro['apellidos'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
