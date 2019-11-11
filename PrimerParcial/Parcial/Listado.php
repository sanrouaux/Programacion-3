<?php

include './clases/Ovni.php';

$arrayOvnis = Ovni::Traer();

$tabla = "<table border='1' width='80%' style='text-align:center'>
            <thead>
                <tr>
                    <td>TIPO</td>
                    <td>VELOCIDAD</td>
                    <td>PLANETA DE ORIGEN</td>
                    <td>FOTO</td>
                    <td>VELOCIDAD WARP</td>
                </tr>            
            </thead>
            <tbody>";

foreach($arrayOvnis as $ovni) {
    $tabla .= "<tr>
                    <td>".$ovni->tipo."</td>
                    <td>".$ovni->velocidad."</td>
                    <td>".$ovni->planetaOrigen."</td>";
                    if($ovni->pathFoto != "") {
                        $tabla .= "<td><img src='".$ovni->pathFoto."' alt='ovni' height='200px' width='200px'></td>";
                    }
                    else {
                        $tabla .= "<td>Sin foto</td>";
                    }                    
                    $tabla .= "<td>".$ovni->ActivarVelocidadWarp()."</td>
                </tr>";
}

$tabla .=       "</tbody>
            </table>";


echo $tabla;