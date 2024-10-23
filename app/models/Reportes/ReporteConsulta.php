<?php

include_once '../../navbar.php'; // Asegúrate de ajustar la ruta de navbar.php
include_once '../../db.php'; // Asegúrate de ajustar la ruta de db.php

class EmpleadoModel
{
    private $connection;

    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
    }

    // Obtener todos los empleados para el combo box
    public function obtenerEmpleados()
    {
        $sql = "SELECT id_empleado, nombres, apellidos FROM empleados";
        $result = $this->connection->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener la información completa de un empleado, incluyendo su puesto y tienda
    public function obtenerEmpleadoPorId($id_empleado)
    {
        $sql = "
            SELECT empleados.*, puestos.puesto AS nombre_puesto, tiendas.tienda AS nombre_tienda
            FROM empleados
            LEFT JOIN puestos ON empleados.id_puesto = puestos.id_puesto
            LEFT JOIN tiendas ON empleados.id_tienda = tiendas.id_tienda
            WHERE empleados.id_empleado = :id_empleado";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_empleado' => $id_empleado]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

$empleadoModel = new EmpleadoModel($connection);

// Obtener todos los empleados para mostrar en el combo box
$empleados = $empleadoModel->obtenerEmpleados();

// Procesar la selección del combo box
$empleadoSeleccionado = null;
if (isset($_POST['id_empleado'])) {
    $empleadoSeleccionado = $empleadoModel->obtenerEmpleadoPorId($_POST['id_empleado']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?= Navbar::render(); ?>

<div class="container mt-5">
    <h2 class="text-center">Consulta de Empleado</h2>

    <!-- Formulario de selección de empleado -->
    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="id_empleado" class="form-label">Selecciona un Empleado</label>
            <select class="form-control" id="id_empleado" name="id_empleado" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['id_empleado'] ?>" <?= (isset($_POST['id_empleado']) && $_POST['id_empleado'] == $empleado['id_empleado']) ? 'selected' : '' ?>>
                        <?= $empleado['nombres'] . ' ' . $empleado['apellidos'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <?php if ($empleadoSeleccionado): ?>
        <!-- Mostrar la información del empleado seleccionado -->
        <h3>Información del Empleado</h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?= $empleadoSeleccionado['id_empleado'] ?></td>
            </tr>
            <tr>
                <th>Nombres</th>
                <td><?= $empleadoSeleccionado['nombres'] ?></td>
            </tr>
            <tr>
                <th>Apellidos</th>
                <td><?= $empleadoSeleccionado['apellidos'] ?></td>
            </tr>
            <tr>
                <th>Fecha de Nacimiento</th>
                <td><?= $empleadoSeleccionado['fecha_nac'] ?></td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td><?= $empleadoSeleccionado['nombre_puesto'] ?></td> <!-- Mostrar el nombre del puesto -->
            </tr>
            <tr>
                <th>Tienda</th>
                <td><?= $empleadoSeleccionado['nombre_tienda'] ?></td> <!-- Mostrar el nombre de la tienda -->
            </tr>
            <tr>
                <th>Salario</th>
                <td><?= $empleadoSeleccionado['salario'] ?></td>
            </tr>
            <tr>
                <th>Fotografía</th>
                <td>
                    <?php if ($empleadoSeleccionado['fotografia']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($empleadoSeleccionado['fotografia']) ?>" width="150">
                    <?php else: ?>
                        Sin foto
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
