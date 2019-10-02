<?php

$pArchivo = fopen("saludo2.txt", "a"); //modo append
$retorno = fwrite($pArchivo, "Hola, mundo!\r\n");
$retorno = fwrite($pArchivo, $_POST["nombre"]."\n");
$retorno = fwrite($pArchivo, $_POST["apellido"]."\n");
if($retorno > 0)
{
    echo "El archivo se escribió correctamente";
}
fclose($pArchivo);