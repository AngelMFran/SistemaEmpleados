<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class TiendaModel
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

    // Método para mostrar la tabla de tiendas
    public function mostrarTiendas()
    {
        $sql = "
            SELECT id_tienda, tienda, direccion, jefe
            FROM tiendas
        ";

        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);

        // Mostrar tabla de tiendas
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Tienda</th>
                    <th>Dirección</th>
                    <th>Jefe</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id_tienda'] . '</td>';
            echo '<td>' . $row['tienda'] . '</td>';
            echo '<td>' . $row['direccion'] . '</td>';
            echo '<td>' . $row['jefe'] . '</td>';
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
    <title>Listado de Tiendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gestión de Tiendas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Menú Tienda con Submenús Insertar y Mantenimiento -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tiendaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tienda
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="tiendaDropdown">
                        <li><a class="dropdown-item" href="insertar_tienda.php">Insertar</a></li>
                        <li><a class="dropdown-item" href="mantenimiento_tienda.php">Mantenimiento</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Listado de Tiendas</h2>

    <?php
    // Instanciar el modelo y mostrar la lista de tiendas
    $tiendaModel = new TiendaModel();
    $tiendaModel->mostrarTiendas();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
