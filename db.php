<?php
// Información de conexión a la base de datos local
$server = 'localhost';       // El servidor donde está la base de datos
$username = 'root';          // Usuario de MySQL local (cambia si es necesario)
$password = '';              // Contraseña de MySQL (cambia si es necesario)
$db = 'crudbddv2_local';     // Nombre de la base de datos local

// Crear la conexión a MySQL
$conn = new mysqli($server, $username, $password, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos local.";
}
?>
