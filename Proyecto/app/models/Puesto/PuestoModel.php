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

    // Método para obtener todos los puestos
    public function obtenerPuestos()
    {
        $sql = "SELECT * FROM puestos";
        $query = $this->connection->query($sql);
        $query->setFetchMode(\Phalcon\Db\Enum::FETCH_ASSOC);
        return $query->fetchAll();
    }

    // Método para obtener un puesto por ID
    public function obtenerPuestoPorId($id_puesto)
    {
        $sql = "SELECT * FROM puestos WHERE id_puesto = :id_puesto";
        $query = $this->connection->prepare($sql);
        $query->execute(['id_puesto' => $id_puesto]);
        return $query->fetch(\Phalcon\Db\Enum::FETCH_ASSOC);
    }

    // Método para insertar un nuevo puesto
    public function insertarPuesto($puesto)
    {
        $sql = "INSERT INTO puestos (puesto) VALUES (:puesto)";
        $query = $this->connection->prepare($sql);
        return $query->execute(['puesto' => $puesto]);
    }

    // Método para actualizar un puesto
    public function actualizarPuesto($id_puesto, $puesto)
    {
        $sql = "UPDATE puestos SET puesto = :puesto WHERE id_puesto = :id_puesto";
        $query = $this->connection->prepare($sql);
        return $query->execute(['puesto' => $puesto, 'id_puesto' => $id_puesto]);
    }

    // Método para eliminar un puesto
    public function eliminarPuesto($id_puesto)
    {
        $sql = "DELETE FROM puestos WHERE id_puesto = :id_puesto";
        $query = $this->connection->prepare($sql);
        return $query->execute(['id_puesto' => $id_puesto]);
    }
}
