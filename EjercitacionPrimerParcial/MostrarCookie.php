<?php

$email = isset($_GET["email"]) ? $_GET["email"] : NULL;

$respuesta = new stdClass();

$emailConGuion = str_replace(".", "_", $email);

if(isset($_COOKIE[$emailConGuion])) {
    $respuesta->exito = true;
    $respuesta->mensaje = $_COOKIE[$emailConGuion];
}
else {
    $respuesta->exito = false;
    $respuesta->mensaje = "No hay cookie para este usuario";
}

echo json_encode($respuesta);