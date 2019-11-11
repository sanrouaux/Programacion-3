<?php
include './clases/Producto.php';
$prod = isset($_POST['producto']) ? $_POST['producto'] : NULL;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : NULL;

$objProd = json_decode($prod);

$producto = new Producto($objProd->codigoBarra, $objProd->descripcion, $objProd->precio);

$arrayProd = Producto::Traer();

$retorno = new stdClass();

if($producto->Existe($arrayProd)) {
    $retorno->exito = false;
    $retorno->mensaje = "El producto ya existe en la BD";
}
 else {
    $nombreFoto = $_FILES['foto']['name'];
    $arrayNombre = explode(".", $nombreFoto);
    $arrayInvertido = array_reverse($arrayNombre);
    $extensionFoto = $arrayInvertido[0];
    $destino = "./productos/imagenes/".$producto->codigoBarra.".".$producto->descripcion.".".date("His").".".$extensionFoto;
        
    $producto->pathFoto = $destino;
        
    if($producto->Agregar() && move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) 
    {
        header("Location: Listado.php");
    }
    else {
        $retorno->exito = false;
        $retorno->mensaje = "No se pudo guardar el producto en la BD";
    }
 }

 echo json_encode($retorno);