<?php

include "./clases/Ufologo.php";

$legajo = isset($_GET["paramLegajo"]) ? $_GET["paramLegajo"] : NULL;

$obj = json_decode($legajo);

$retorno = new stdClass();

if(isset($_COOKIE[$obj->legajo])) {
    $retorno->exito = true;
    $retorno->mensaje = $_COOKIE[$obj->legajo];
}
else {
    $retorno->exito = false;
    $retorno->mensaje = "No existe una cookie para tal legajo";
}

echo json_encode($retorno);
