<?php

include "./clases/Televisor.php";

$arrayTelevisores = Televisor::Traer();

$tabla = "<table style='text-align:center' border='1' width='80%' height='100%'>
            <thead>
                <tr>
                    <td>TIPO</td>
                    <td>PRECIO</td>
                    <td>PAIS DE ORIGEN</td>
                    <td>PRECIO CON IVA</td>
                    <td>FOTO</td>
                </tr>
            </thead>";

foreach($arrayTelevisores as $televisor) {
    $tabla .= "<tr>
                <td>".$televisor->tipo."</td>
                <td>".$televisor->precio."</td>
                <td>".$televisor->paisOrigen."</td>
                <td>".$televisor->CalcularIVA()."</td>
                <td><img src='".$televisor->path."' alt='photo'></td>
            </tr>";
}

$tabla .= "</table>";

echo $tabla;
