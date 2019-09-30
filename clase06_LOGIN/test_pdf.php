<?php

require_once __DIR__ . '/vendor/autoload.php';
include ("usuario.php");

$mpdf = new \Mpdf\Mpdf();

$usuarios = usuario::TraerTodosLosUsuarios();

$tabla = "<table>";

foreach($usuarios as $usu)
{
    $tabla .= "<tr><td>".$usu->nombre."</td><td>".$usu->apellido."</td></tr>";
}

$tabla .= "</table>";

$mpdf->writeHtml($tabla);
$mpdf->output();