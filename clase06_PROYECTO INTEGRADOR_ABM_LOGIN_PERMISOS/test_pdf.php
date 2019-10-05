<?php

require_once __DIR__ . '/vendor/autoload.php';
include ("usuario.php");

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf();

$usuarios = usuario::TraerTodosLosUsuarios();

$tabla = "<table>
            <thead>
                <tr>
                <td>ID</td>
                <td>NOMBRE</td>
                <td>APELLIDO</td>
                <td>CORREO</td>
                <td>PERFIL</td>
                <td>FOTO</td>
                </tr>
            </thead>";

foreach($usuarios as $usu)
{
    $tabla .= "<tr>
                <td>$usu->id</td>
                <td>$usu->nombre</td>
                <td>$usu->apellido</td>
                <td>$usu->correo</td>
                <td>$usu->perfil</td>
                <td>$usu->foto</td>
            </tr>";    
}

$tabla .= "</table>";

$mpdf->WriteHTML($tabla);
$mpdf->Output();