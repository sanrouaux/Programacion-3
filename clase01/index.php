<?php
    echo "Hola ";
    echo " mundo";

    $nombre = "SANTIAGO";
    $apellido = "rouaux";

    $nombre = strtolower($nombre);
    $nombre[0] = strtoupper($nombre[0]);

    $apellido = strtolower($apellido);
    $apellido[0] = strtoupper($apellido[0]);

    echo "<br>";
    echo $nombre.", ".$apellido;