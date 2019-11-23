<?php

include "./clases/Usuario.php";

$email = isset($_POST["email"]) ? $_POST["email"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

$usuario = new Usuario($email, $clave);

if(Usuario::VerificarExistencia($usuario)) {;
    setcookie($email, date("c"));
    header("Location:./ListadoUsuarios.php");
}
else {
    $respuesta = new stdClass();
    $respuesta->exito = false;
    $respuesta->mensaje = "El usuario no existe";
    echo json_encode($respuesta);
}