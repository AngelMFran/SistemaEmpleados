<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

class LlamadaModel
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

    // Método para insertar una nueva llamada (atención)
    public function insertarLlamada($descripcion, $tipo_logro, $fecha_ocurrencia, $id_empleado)
    {
        $sql = "INSERT INTO atencion (descripcion, tipo_logro, fecha_ocurrencia, id_empleado) 
                VALUES (:descripcion, :tipo_logro, :fecha_ocurrencia, :id_empleado)";
        $query = $this->connection->prepare($sql);
        return $query->execute([
            'descripcion'     => $descripcion,
            'tipo_logro'      => $tipo_logro,
            'fecha_ocurrencia'=> $fecha_ocurrencia,
            'id_empleado'     => $id_empleado
        ]);
    }
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descripcion = $_POST['descripcion'];
    $tipo_logro = $_POST['tipo_logro'];
    $fecha_ocurrencia = $_POST['fecha_ocurrencia'];
    $id_empleado = $_POST['id_empleado'];

    // Instanciar el modelo y guardar la llamada
    $llamadaModel = new LlamadaModel();
    $llamadaModel->insertarLlamada($descripcion, $tipo_logro, $fecha_ocurrencia, $id_empleado);

    // Redirigir al listado de llamadas
    header('Location: listado_llamadas.php');
    exit;
} else {
    echo "Método no permitido.";
}

?>
