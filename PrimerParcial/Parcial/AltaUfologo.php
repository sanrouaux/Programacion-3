<?php

include "./clases/Ufologo.php";

$pais = isset($_POST["pais"]) ? $_POST["pais"] : NULL;
$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

$ufologo = new Ufologo($pais, $legajo, $clave);
$retorno = $ufologo->GuardarEnArchivo();

echo $retorno;
