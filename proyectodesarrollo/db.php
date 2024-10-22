<?php
// Configuración de la conexión a la base de datos local
$servername = "127.0.0.1";<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

$username = "root";
$password = ""; // Si tienes contraseña en tu servidor local, inclúyela aquí
$database = "crudbddv2_local";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8mb4");
?>
