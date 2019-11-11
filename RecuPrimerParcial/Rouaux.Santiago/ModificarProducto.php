<?php
include './clases/Producto.php';

$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$codigoBarra = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : NULL;
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : NULL;

$nombreFoto = $foto['name'];
$arrayNombre = explode(".", $nombreFoto);
$arrayInvertido = array_reverse($arrayNombre);
$extensionFoto = $arrayInvertido[0];
$destino = "./productos/imagenes/".$codigoBarra.".".$descripcion.".".date("His").".".$extensionFoto;
move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

$registroAnterior = Producto::TraerPorId($id);

$prod = new Producto($codigoBarra, $descripcion, $precio, $destino);

$respuesta = $prod->Modificar($id);
if($respuesta == true) {
    $extension = pathinfo($registroAnterior->pathFoto,PATHINFO_EXTENSION);
    $destinoFotoModificada = "./productosModificados/".$id.".".$registroAnterior->descripcion.".modificado.".date("His").".".$extension;
    rename($registroAnterior->pathFoto, $destinoFotoModificada);
    header("Location: Listado.php"); 
}
else {
    $retorno = new stdClass();
    $retorno->exito = false;
    $retorno->mensaje = "No se pudo modificar el producto";
}

echo json_encode($retorno);