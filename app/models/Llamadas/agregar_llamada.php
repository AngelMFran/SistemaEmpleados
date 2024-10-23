<?php
// Conectar a la base de datos
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

    // Método para obtener todos los empleados
    public function obtenerEmpleados()
    {
        $sql = "SELECT id_empleado, nombres, apellidos FROM empleados";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }
}

// Instancia del modelo
$empleadoModel = new EmpleadoModel();
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Llamadas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Menú Llamada con Submenús -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="llamadaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Llamada
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="llamadaDropdown">
                        <li><a class="dropdown-item" href="listado_llamadas.php">Lista de Llamadas</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
