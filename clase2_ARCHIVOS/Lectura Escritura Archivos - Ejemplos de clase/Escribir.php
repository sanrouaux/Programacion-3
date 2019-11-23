<?php

$pArchivo = fopen("saludo.txt", "w"); //modo write
$retorno = fwrite($pArchivo, "Hola, mundo!");

if($retorno > 0)
{
    echo "El archivo se escribió correctamente";
}
fclose($pArchivo);


//Tres funciones principales: fopen(), fwrite() y fclose()