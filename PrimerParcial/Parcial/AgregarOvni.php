<?php

include './clases/Ovni.php';

$retorno = new stdClass();

$ovni = isset($_POST['ovni']) ? $_POST['ovni'] : NULL;
$obj = json_decode($ovni);

$objOvni = new Ovni($obj->tipo, $obj->velocidad, $obj->planetaOrigen);

$arrayOvnis = Ovni::Traer();
$respuesta = $objOvni->Existe($arrayOvnis);

if($respuesta == true) {
    $retorno->exito = false;
    $retorno->mensaje = "El ovni ya existe en la BD";
}
else {
    $nombreFoto = $_FILES['foto']['name'];
    $arrayNombre = explode(".", $nombreFoto);
    $arrayInvertido = array_reverse($arrayNombre);
    $extensionFoto = $arrayInvertido[0];

    $destino = "./ovnis/imagenes/".$objOvni->tipo.".".$objOvni->planetaOrigen.".".date("His").".".$extensionFoto;
    
    $objOvni->pathFoto = $destino;
    
    if($objOvni->Agregar() &&
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) 
    {
        header("location: Listado.php");
    }
    else {
        $retorno->exito = false;
        $retorno->mensaje = "No se pudo agregar el ovni a la BD";
    }
}

echo json_encode($retorno);
