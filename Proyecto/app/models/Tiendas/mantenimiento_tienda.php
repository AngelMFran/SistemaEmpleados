<?php
// Incluir la barra de navegación y la conexión a la base de datos
include_once '../../navbar.php';  // Ajusta la ruta según la ubicación de tu archivo navbar.php
include_once '../../db.php';      // Ajusta la ruta según la ubicación correcta de db.php

// Clase para manejar el modelo de tiendas
class TiendaModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
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

// Instanciar el modelo y pasar la conexión desde db.php
$tiendaModel = new TiendaModel($connection);
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

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Mantenimiento de Tiendas</h2>

        <?php
        // Mostrar la lista de tiendas
        $tiendaModel->mostrarTiendas();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
