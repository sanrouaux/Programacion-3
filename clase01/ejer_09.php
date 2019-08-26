<?php

    $vec = array();

    for($i = 0; $i < 5; $i++)
    {
        array_push($vec, rand(0,10));
    }

    $suma = 0;

    for($i = 0; $i < 5; $i++)
    {
        $suma += $vec[$i];
    }

    $promedio = $suma/5;

    if($promedio > 6)
    {
        echo "El promedio es mayor que 6";
    }
    else if($promedio < 6)
    {
        echo "El promedio es menor que 6";
    }
    else
    {
        echo "El promedio es igual a 6";
    }
