<?php
// Configuración de la conexión a la base de datos para el entorno local
$servername = "localhost";
$username = "root";  // Usualmente en local es 'root', cámbialo si es diferente
$password = "";  // Deja vacío si no tienes contraseña en tu entorno local
$database = "crudbddv2_local";  // Nombre de tu base de datos local

// Crear conexión a MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");
?>
