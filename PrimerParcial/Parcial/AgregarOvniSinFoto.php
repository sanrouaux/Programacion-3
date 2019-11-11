<?php

include './clases/Ovni.php';

$ovni = isset($_POST['ovni']) ? $_POST['ovni'] : NULL;

$obj = json_decode($ovni);

$objOvni = new Ovni($obj->tipo, $obj->velocidad, $obj->planetaOrigen);

$respuesta = $objOvni->Agregar();

if($respuesta == true) {
    $retorno = new stdClass();
    $retorno->exito = true;
    $retorno->mensaje = "Se agrego un ovni a la base de datos";
}
else {
    $retorno = new stdClass();
    $retorno->exito = false;
    $retorno->mensaje = "No se pudo agregar el ovni a la base de datos";
}

echo json_encode($retorno);