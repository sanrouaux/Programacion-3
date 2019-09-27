<?php

include ("usuario.php");

$obj = new stdClass();
$obj->correo = "micorreo@gmail.com";
$obj->clave = "miclave";

$objJson = json_encode($obj);

echo usuario::ExisteEnBD($objJson);