<?php

use Phalcon\Mvc\Controller;

class EmpleadosController extends Controller
{
    public function indexAction()
    {
        // Recuperar todos los empleados de la base de datos
        $empleados = Empleados::find();

        // Iniciar el código HTML de la tabla
        $html = '<table border="1" cellpadding="5" cellspacing="0">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID Empleado</th>';
        $html .= '<th>Nombres</th>';
        $html .= '<th>Apellidos</th>';
        $html .= '<th>Fecha de Nacimiento</th>';
        $html .= '<th>Fotografía</th>';
        $html .= '<th>Puesto</th>';
        $html .= '<th>Tienda</th>';
        $html .= '<th>Salario</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Recorrer los empleados y construir las filas
        foreach ($empleados as $empleado) {
            $html .= '<tr>';
            $html .= '<td>' . $empleado->id_empleado . '</td>';
            $html .= '<td>' . $empleado->nombres . '</td>';
            $html .= '<td>' . $empleado->apellidos . '</td>';
            $html .= '<td>' . $empleado->fecha_nac . '</td>';
            $html .= '<td><img src="' . $empleado->fotografia . '" alt="Foto de ' . $empleado->nombres . '" style="width: 100px; height: auto;"></td>';
            $html .= '<td>' . $empleado->getPuesto() . '</td>';
            $html .= '<td>' . $empleado->getTienda() . '</td>';
            $html .= '<td>' . $empleado->salario . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Pasar el HTML al view como string
        echo $html;
    }
}
