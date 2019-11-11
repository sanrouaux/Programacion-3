<?php
include './clases/Producto.php';
$arrayProd = Producto::Traer();
$tabla = "<table border='1' width='80%' style='text-align:center'>
            <thead>
                <tr>
                    <td>CODIGO BARRA</td>
                    <td>DESCRIPCION</td>
                    <td>PRECIO</td>
                    <td>FOTO</td>
                    <td>PRECIO CON IVA</td>
                </tr>            
            </thead>
            <tbody>";
foreach($arrayProd as $prod) {
    $tabla .= "<tr>
                    <td>".$prod->codigoBarra."</td>
                    <td>".$prod->descripcion."</td>
                    <td>".$prod->precio."</td>";
                    if($prod->pathFoto != "") {
                        $tabla .= "<td><img src='".$prod->pathFoto."' alt='ovni' height='200px' width='200px'></td>";
                    }
                    else {
                        $tabla .= "<td>Sin foto</td>";
                    }                    
                    $tabla .= "<td>".$prod->CalcularIVA()."</td>
                </tr>";
}
$tabla .=       "</tbody>
            </table>";
echo $tabla;