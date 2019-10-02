<?php

require "vendor/autoload.php";
include ("usuario.php");

$mpdf = new \Mpdf\Mpdf();

$usuarios = usuario::TraerTodosLosUsuarios();

$tabla = "<table>
            <theader>
                <td>ID</td>
                <td>NOMBRE</td>
                <td>APELLIDO</td>
                <td>CORREO</td>
                <td>PERFIL</td>
                <td>FOTO</td>
            </theader>
        </table>";

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

$mpdf->writeHtml($tabla);
$mpdf->output();