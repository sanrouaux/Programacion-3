<?php

$pArchivo = fopen("saludo.txt", "w");
$retorno = fwrite($pArchivo, "Hola, mundo!");

if($retorno > 0)
{
    echo "El archivo se escribió correctamente";
}
fclose($pArchivo);