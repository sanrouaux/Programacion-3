<?php

include './clases/Ovni.php';

$ovni = isset($_POST['ovni']) ? $_POST['ovni'] : NULL;

$retorno = "No se encontr&oacute; el ovni";

$obj = json_decode($ovni);

$arrayOvnis = Ovni::Traer();

foreach($arrayOvnis as $ovni) {
    if($obj->tipo == $ovni->tipo &&
    $obj->velocidad == $ovni->velocidad &&
    $obj->planetaOrigen == $ovni->planetaOrigen) {
        $retorno = $ovni->ToJSON();
    }
}

echo $retorno;
