<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos para centrar la imagen */
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh; /* Ajusta la altura según sea necesario */
        }
        .logo-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Gestión de Sistema</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- Empleados -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="empleadoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Empleados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="empleadoDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/empleado.php">Listado Empleados</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/mantenimiento_empleado.php">Mantenimiento Empleados</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/insertar_empleado.php">Insertar Nuevo Empleado</a></li>
                            </ul>
                        </li>

                        <!-- Llamadas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="llamadasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Llamadas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="llamadasDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Llamadas/listado_llamadas.php">Listado Llamadas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Llamadas/agregar_llamada.php">Agregar Nueva Llamada</a></li>
                            </ul>
                        </li>

                        <!-- Puestos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="puestosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Puestos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="puestosDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/puestos.php">Listado Puestos</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/mantenimiento_puesto.php">Mantenimiento Puestos</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/insertar_puesto.php">Insertar Nuevo Puesto</a></li>
                            </ul>
                        </li>

                        <!-- Tiendas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tiendasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tiendas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tiendasDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/tiendas.php">Listado Tiendas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/mantenimiento_tienda.php">Mantenimiento Tiendas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/insertar_tienda.php">Insertar Nueva Tienda</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
<div class="container mt-5">
    <h1 class="text-center">Bienvenido al Sistema de Gestión</h1>
    <p class="text-center">Selecciona una opción en la barra de navegación para gestionar empleados, llamadas, puestos o tiendas.</p>
</div>

<!-- Contenedor para centrar el logo -->
<div class="container mt-5 logo-container">
<img src="logo.png" alt="Logo de la empresa">
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
