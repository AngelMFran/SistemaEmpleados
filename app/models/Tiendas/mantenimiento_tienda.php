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
        $sql = "SELECT id_tienda, tienda, direccion, jefe FROM tiendas";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);

        // Mostrar tabla de tiendas
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Tienda</th>
                    <th>Dirección</th>
                    <th>Jefe</th>
                    <th>Acciones</th>
                </tr>
              </thead>';
        echo '<tbody>';
        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row['id_tienda'] . '</td>';
            echo '<td>' . $row['tienda'] . '</td>';
            echo '<td>' . $row['direccion'] . '</td>';
            echo '<td>' . $row['jefe'] . '</td>';
            echo '<td>
                    <a href="edit_tienda.php?id=' . $row['id_tienda'] . '" class="btn btn-warning btn-sm">Editar</a>
                    <a href="delete_tienda.php?id=' . $row['id_tienda'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta tienda?\');">Eliminar</a>
                  </td>';
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
    <title>Mantenimiento de Tiendas</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="insertar_tienda.php">Insertar Nueva Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tiendas.php">Listado de Tiendas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Mantenimiento de Tiendas</h2>

    <?php
    // Instanciar el modelo y mostrar la lista de tiendas
    $tiendaModel = new TiendaModel();
    $tiendaModel->mostrarTiendas();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
