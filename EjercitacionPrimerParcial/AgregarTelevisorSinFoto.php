<?php

include "./clases/Televisor.php";

$retorno = new stdClass();

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : NULL;
$pais = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : NULL;

$televisor = new Televisor($tipo, $precio, $pais);

if($televisor->Agregar()) {
    $retorno->exito = true;
    $retorno->mensaje ="Se agreg&oacute; el televisor";
    echo json_encode($retorno);
}
else {
    $retorno->exito = false;
    $retorno->mensaje ="No se agreg&oacute; el televisor";
    echo json_encode($retorno);
}
