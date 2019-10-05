<?php
    echo "Hola ";
    echo " mundo";

    $nombre = "SANTIAGO";
    $apellido = "rouaux";

    //Función strtolower() pasa a letras minúsculas todos los caracteres de un string
    //Función strtoupper() pasa a letras mayúsculas todos los caracteres de un string
    //Se puede acceder a los caracteres de un string como un array indexado
    $nombre = strtolower($nombre);
    $nombre[0] = strtoupper($nombre[0]);

    $apellido = strtolower($apellido);
    $apellido[0] = strtoupper($apellido[0]);

    //El código PHP puede devolver texto plano, variables con texto, o código HTML
    echo "<br>";
    echo $nombre.", ".$apellido;