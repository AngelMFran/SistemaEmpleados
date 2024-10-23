<?php
// Configuración de la conexión a la base de datos en Azure
use Phalcon\Db\Adapter\Pdo\Mysql;

// Establecer la conexión a la base de datos usando los detalles proporcionados
$connection = new Mysql(
    [
        'host'     => 'crudbddv2.mysql.database.azure.com',
        'username' => 'alswalker',
        'password' => '@dministrad0r',
        'dbname'   => 'crudbddv2',
        'port'     => 3306,
        'options'  => [
            PDO::MYSQL_ATTR_SSL_CA => '/path/to/DigiCertGlobalRootCA.crt.pem', // Ajusta la ruta al certificado SSL
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        ]
    ]
);

// Puedes verificar la conexión y manejar errores aquí si es necesario
try {
    $connection->connect();
    echo "Conexión exitosa a la base de datos.";
} catch (\PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
