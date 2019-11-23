<?php

$pArchivo = fopen("saludo.txt", "r");
//Trae todo el texto del archivo. No respeta saltos de línea
$texto = fread($pArchivo, filesize("saludo.txt")); 
if($texto != null)
{
    echo $texto;
}
fclose($pArchivo);