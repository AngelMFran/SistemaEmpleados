<?php
// Incluir la conexión a la base de datos
include_once '../../db.php';  // Ajusta la ruta según la ubicación correcta de db.php

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

    // Método para eliminar una tienda
    public function eliminarTienda($id_tienda)
    {
        $sql = "DELETE FROM tiendas WHERE id_tienda = :id_tienda";
        $query = $this->connection->prepare($sql);
        return $query->execute(['id_tienda' => $id_tienda]);
    }
}

// Instanciar el modelo y pasar la conexión a la base de datos desde db.php
$tiendaModel = new TiendaModel($connection);

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
