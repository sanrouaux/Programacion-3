<?php

include './clases/Ovni.php';

$idGet = isset($_GET['id']) ? $_GET['id'] : NULL;
$idPost = isset($_POST['id']) ? $_POST['id'] : NULL;
$accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if($idGet != NULL) {
        $ovni = Ovni::TraerPorId($_GET['id']);
        if($ovni != NULL) {
            echo "El ovni esta en la BD";
        }
        else {
            echo "El ovni no esta en la BD";
        }
    }
    else {
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
        $pArchivo = fopen("ovnisBorrados/ovnis_borrados.txt", "r");
        while(!feof($pArchivo)) {
            $row = fgets($pArchivo);            
            if($row != "")
            {
                $obj = json_decode($row);
                $ovni = new Ovni($obj->tipo, $obj->velocidad, $obj->planetaOrigen, $obj->pathFoto);
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
            }
        fclose($pArchivo);
        echo $tabla;
    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($idPost != NULL && $accion == 'borrar') {
        $ovni = Ovni::TraerPorId($idPost);
        if($ovni != NULL && $ovni->Eliminar()) {
            $ovni->GuardarEnArchivo();
            header("Location: Listado.php");
        }
        else {
            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "No se pudo eliminar";
            echo json_encode($retorno);
        }
    }
}
