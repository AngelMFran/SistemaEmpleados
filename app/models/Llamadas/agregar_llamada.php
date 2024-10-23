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
        $sql = "SELECT id_empleado, nombres, apellidos FROM empleados";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }
}

// Instancia del modelo y pasar la conexión a la base de datos
$empleadoModel = new EmpleadoModel($connection);
$empleados = $empleadoModel->obtenerEmpleados();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Llamada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Agregar Nueva Llamada</h2>

        <form action="guardar_llamada.php" method="POST">
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>

            <div class="mb-3">
                <label for="tipo_logro" class="form-label">Tipo de Logro</label>
                <select class="form-control" id="tipo_logro" name="tipo_logro" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Positivo">Positivo</option>
                    <option value="Negativo">Negativo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_ocurrencia" class="form-label">Fecha de Ocurrencia</label>
                <input type="date" class="form-control" id="fecha_ocurrencia" name="fecha_ocurrencia" required>
            </div>

            <div class="mb-3">
                <label for="id_empleado" class="form-label">Empleado</label>
                <select class="form-control" id="id_empleado" name="id_empleado" required>
                    <option value="">Seleccione un empleado</option>
                    <?php foreach ($empleados as $empleado): ?>
                        <option value="<?= $empleado['id_empleado'] ?>">
                            <?= $empleado['nombres'] . ' ' . $empleado['apellidos'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Llamada</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
