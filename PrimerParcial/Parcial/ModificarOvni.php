<?php

include './clases/Ovni.php';

$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$velocidad = isset($_POST['velocidad']) ? $_POST['velocidad'] : NULL;
$planeta = isset($_POST['planeta']) ? $_POST['planeta'] : NULL;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : NULL;


$registroAnterior = Ovni::TraerPorId($id);

$nombreFoto = $foto['name'];
$arrayNombre = explode(".", $nombreFoto);
$arrayInvertido = array_reverse($arrayNombre);
$extensionFoto = $arrayInvertido[0];
$destino = "./ovnis/imagenes/".$tipo.".".$planeta.".".date("His").".".$extensionFoto;
move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

$ovni = new Ovni($tipo, $velocidad, $planeta, $destino);

$respuesta = $ovni->Modificar($id);

if($respuesta == true) {
    $extension = pathinfo($registroAnterior->pathFoto,PATHINFO_EXTENSION);
    $destinoFotoModificada = "./ovnisModificados/".$registroAnterior->tipo.".".$registroAnterior->planetaOrigen.".modificado.".date("His").".".$extension;
    rename($registroAnterior->pathFoto, $destinoFotoModificada);
    header("Location: ListadoUfologos.php"); 
}
else {
    $retorno = new stdClass();
    $retorno->exito = false;
    $retorno->mensaje = "No se pudo modificar el OVNI";
}

echo json_encode($retorno);
