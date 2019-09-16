<?php

$pArchivo = fopen("saludo.txt", "r");
$texto = fread($pArchivo, filesize("saludo.txt"));
if($texto != null)
{
    echo $texto;
}
fclose($pArchivo);