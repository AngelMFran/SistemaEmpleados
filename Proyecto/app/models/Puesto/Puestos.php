<?php
// Incluir la barra de navegación y la conexión a la base de datos
include_once '../../navbar.php';  // Ajusta la ruta según la ubicación correcta de navbar.php
include_once '../../db.php';      // Ajusta la ruta según la ubicación correcta de db.php

use Phalcon\Db\Adapter\Pdo\Mysql;

class PuestoModel
{
    private $connection;

    // Constructor que recibe la conexión a la base de datos desde db.php
    public function __construct($dbConnection)
    {
        // Usar la conexión a la base de datos pasada como parámetro
        $this->connection = $dbConnection;
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

// Instanciar el modelo y pasar la conexión desde db.php
$puestoModel = new PuestoModel($connection);
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

    <!-- Incluir la barra de navegación -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Listado de Puestos</h2>

        <?php
        // Mostrar la lista de puestos
        $puestoModel->mostrarPuestos();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
