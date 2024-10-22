<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class TiendaModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'crudbddv2_local',
            ]
        );
    }

    // Método para eliminar una tienda
    public function eliminarTienda($id_tienda)
    {
        $sql = "DELETE FROM tiendas WHERE id_tienda = :id_tienda";
        $query = $this->connection->prepare($sql);
        return $query->execute(['id_tienda' => $id_tienda]);
    }
}

// Instancia del modelo
$tiendaModel = new TiendaModel();

// Verificar si hay un ID de tienda en la URL y eliminar la tienda
if (isset($_GET['id'])) {
    $id_tienda = $_GET['id'];
    $tiendaModel->eliminarTienda($id_tienda);

    // Redirigir a la lista de tiendas tras la eliminación
    header('Location: tiendas.php');
    exit;
} else {
    echo "No se ha proporcionado un ID de tienda.";
}

?>
