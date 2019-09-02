<?php

$pArchivo = fopen("saludo2.txt", "r");

while(!(feof($pArchivo)))
{
    echo fgets($pArchivo)."<br>";
}

fclose($pArchivo);