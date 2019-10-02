<?php

$pArchivo = fopen("saludo.txt", "r");

//A diferencia del método fread(), fgets() lee hasta el salto de línea
while(!(feof($pArchivo)))
{
    echo fgets($pArchivo)."<br>";
}

fclose($pArchivo);