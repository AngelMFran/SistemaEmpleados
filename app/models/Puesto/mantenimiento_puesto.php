<?php
// Incluimos la clase Navbar
include_once '../../navbar.php';

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

    // Método para obtener todos los puestos
    public function obtenerPuestos()
    {
        $sql = "SELECT * FROM puestos";
        $result = $this->connection->query($sql);
        $result->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $result->fetchAll();
    }

    // Método para eliminar un puesto
    public function eliminarPuesto($id)
    {
        $sql = "DELETE FROM puestos WHERE id_puesto = :id";
        $query = $this->connection->prepare($sql);
        return $query->execute(['id' => $id]);
    }
}

$puestoModel = new PuestoModel();

// Verificar si se ha solicitado la eliminación de un puesto
if (isset($_GET['eliminar_id'])) {
    $puestoModel->eliminarPuesto($_GET['eliminar_id']);
    header('Location: mantenimiento_puesto.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Puestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Renderizamos la Navbar -->
    <?= Navbar::render(); ?>

    <div class="container mt-5">
        <h2 class="text-center">Mantenimiento de Puestos</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Puesto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtener los puestos y mostrarlos
                $puestos = $puestoModel->obtenerPuestos();
                foreach ($puestos as $puesto) {
                    echo '<tr>';
                    echo '<td>' . $puesto['id_puesto'] . '</td>';
                    echo '<td>' . $puesto['puesto'] . '</td>';
                    echo '<td>
                            <a href="editar_puesto.php?id=' . $puesto['id_puesto'] . '" class="btn btn-warning btn-sm">Editar</a>
                            <a href="mantenimiento_puesto.php?eliminar_id=' . $puesto['id_puesto'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este puesto?\');">Eliminar</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
