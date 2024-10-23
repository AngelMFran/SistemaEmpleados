<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class PuestoModel
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

    // Método para mostrar la tabla de puestos
    public function mostrarPuestos()
    {
        $sql = "
            SELECT id_puesto, puesto
            FROM puestos
        ";

        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);

        // Mostrar tabla de puestos
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Puesto</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id_puesto'] . '</td>';
            echo '<td>' . $row['puesto'] . '</td>';
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
    <title>Listado de Puestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Puestos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Menú Puesto con Submenús Insertar y Mantenimiento -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="puestoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Puesto
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="puestoDropdown">
                        <li><a class="dropdown-item" href="insertar_puesto.php">Insertar</a></li>
                        <!-- Actualizando el enlace de Mantenimiento para redirigir correctamente -->
                        <li><a class="dropdown-item" href="mantenimiento_puesto.php">Mantenimiento</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Listado de Puestos</h2>

    <?php
    // Instanciar el modelo y mostrar la lista de puestos
    $puestoModel = new PuestoModel();
    $puestoModel->mostrarPuestos();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
