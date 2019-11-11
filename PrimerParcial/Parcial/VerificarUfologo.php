<?php

include "./clases/Ufologo.php";

$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

$ufologo = new Ufologo("sin pais", $legajo, $clave);
$respuesta = Ufologo::VerificarExistencia($ufologo);

$obj = json_decode($respuesta);

if($obj->exito == true) {
    setcookie($legajo, date("d-m-Y -- H:i:s")." : ".$obj->mensaje);
    header("location: ListadoUfologos.php");
}
else {
    $retorno = new stdClass();
    $retorno->exito = false;
    $retorno->mensaje = $obj->mensaje;
    echo json_encode($retorno);
}
