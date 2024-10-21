<?php
include 'PuestoModel.php';

// Instancia del modelo
$puestoModel = new PuestoModel();

// Verificar si hay un ID de puesto en la URL
if (isset($_GET['id'])) {
    $id_puesto = $_GET['id'];
    $puestoModel->eliminarPuesto($id_puesto);
    header('Location: puestos.php');
    exit;
} else {
    echo "No se ha proporcionado un ID de puesto.";
    exit;
}
?>
