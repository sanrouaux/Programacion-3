<?php
include 'clases/Producto.php';

$retorno = new stdClass();

$prod = isset($_POST['producto']) ? $_POST['producto'] : NULL;
$obj = json_decode($prod);
$objProd = new Producto($obj->codigoBarra, $obj->descripcion, $obj->precio);

$nombreFoto = $_FILES['foto']['name'];
$arrayNombre = explode(".", $nombreFoto);
$arrayInvertido = array_reverse($arrayNombre);
$extensionFoto = $arrayInvertido[0];
$destino = "./productos/imagenes/".$objProd->codigoBarra.".".$objProd->descripcion.".".date("His").".".$extensionFoto;
    
$objProd->pathFoto = $destino;
    
if($objProd->Agregar() && move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) 
{
    $retorno->exito = true;
    $retorno->mensaje = "Se guardo el producto en la BD";
}
else {
    $retorno->exito = false;
    $retorno->mensaje = "No se pudo guardar el producto en la BD";
}

echo json_encode($retorno);