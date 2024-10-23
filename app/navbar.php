<?php

class Navbar
{
    public static function render()
    {
        return '
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/Proyecto/index.php">Gestión de Sistema</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- Opción para volver al Inicio -->
                        <li class="nav-item">
                            <a class="nav-link" href="/Proyecto/index.php">Inicio</a>
                        </li>
                        <!-- Empleados -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="empleadoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Empleados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="empleadoDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/insertar_empleado.php">Insertar Nuevo Empleado</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/empleado.php">Listado Empleados</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Empleado/mantenimiento_empleado.php">Mantenimiento Empleados</a></li>
                            </ul>
                        </li>

                        <!-- Llamadas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="llamadasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Llamadas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="llamadasDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Llamadas/agregar_llamada.php">Insertar Nueva Llamada</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Llamadas/listado_llamadas.php">Listado Llamadas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Llamadas/mantenimiento_llamada.php">Mantenimiento Llamadas</a></li>
                            </ul>
                        </li>

                        <!-- Puestos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="puestosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Puestos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="puestosDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/insertar_puesto.php">Insertar Nuevo Puesto</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/puestos.php">Listado Puestos</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Puesto/mantenimiento_puesto.php">Mantenimiento Puestos</a></li>
                            </ul>
                        </li>

                        <!-- Tiendas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tiendasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tiendas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tiendasDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/insertar_tienda.php">Insertar Nueva Tienda</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/tiendas.php">Listado Tiendas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Tiendas/mantenimiento_tienda.php">Mantenimiento Tiendas</a></li>
                            </ul>
                        </li>

                        <!-- Reportes -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="reporteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Reportes
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="reporteDropdown">
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Reportes/ReporteEmpleado.php">Reporte de Empleados</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Reportes/ReporteTiendas.php">Reporte de Tiendas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Reportes/ReporteLogros.php">Reporte de Logros</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Reportes/ReporteLlamadas.php">Reporte de Llamadas</a></li>
                                <li><a class="dropdown-item" href="/Proyecto/app/models/Reportes/ReporteConsulta.php">Reporte Consulta Empleado</a></li> <!-- Nuevo enlace -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        ';
    }
}
