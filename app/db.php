<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql;

$di = new FactoryDefault();

$di->set('db', function () {
    return new Mysql([
        'host'     => 'crudbddv2.mysql.database.azure.com',
        'username' => 'alswalker',
        'password' => '@dministrad0r',
        'dbname'   => 'test',
        'charset'  => 'utf8',
    ]);
});

$connection = $di->get('db'); // Asegúrate de tener esta línea para obtener la conexión
