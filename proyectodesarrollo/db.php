<?php
// Configuraci�n de la conexi�n a la base de datos local
$servername = "127.0.0.1";
$username = "root";
$password = ""; // Si tienes contrase�a en tu servidor local, incl�yela aqu�
$database = "crudbddv2_local";

// Crear conexi�n
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Verificar la conexi�n
if ($conn->connect_error) {
    die("Error de conexi�n: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8mb4");
?>
