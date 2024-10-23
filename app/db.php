<?php
use Phalcon\Db\Adapter\Pdo\Mysql;

// Crear la conexión a la base de datos
$connection = new Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'crudbddv2_local',
    ]
);
?>
