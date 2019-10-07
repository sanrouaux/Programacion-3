<?php

include "./clases/Ufologo.php";

$jsonLegajo = isset($_GET["json"]) ? $_GET["json"] : NULL;

$obj = json_decode($jsonLegajo);

$respuesta = new stdClass();

if(isset($_COOKIE[$obj->legajo])) {
    $respuesta->exito = true;
    $respuesta->mensaje = $_COOKIE[$obj->legajo]." - "."Existe la cookie";
}
else {
    $respuesta->exito = false;
    $respuesta->mensaje = "No existe la cookie";
}

echo json_encode($respuesta);
