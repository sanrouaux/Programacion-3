<?php
include './clases/Producto.php';
$prod = isset($_POST['producto']) ? $_POST['producto'] : NULL;

$retorno = "No se encontr&oacute; el producto";

$obj = json_decode($prod);

$arrayProd = Producto::Traer();

foreach($arrayProd as $prod) {
    if($obj->codigoBarra == $prod->codigoBarra) {
        $retorno = $prod->ToJSON();
        break;
    }
}
echo $retorno;