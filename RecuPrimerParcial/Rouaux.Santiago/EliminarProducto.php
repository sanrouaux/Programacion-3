<?php
include './clases/Producto.php';
$codigoBarraGet = isset($_GET['codigoBarra']) ? $_GET['codigoBarra'] : NULL;
$codigoBarraPost = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : NULL;
$accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;

if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $arrayProd = Producto::Traer();
        $bandera = 0;
        foreach($arrayProd as $prod) {
            if($codigoBarraGet == $prod->codigoBarra) {
                $bandera = 1;
                break;
            }
        }
        if($bandera == 1) {
            echo "El producto esta en la BD";
        }
        else {
            echo "El producto no esta en la BD";
        }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($codigoBarraPost != NULL && $accion == 'borrar') {
        $retorno = new stdClass();
        $arrayProd = Producto::Traer();
        $auxProd=NULL;
        foreach($arrayProd as $prod) {
            if($codigoBarraPost == $prod->codigoBarra) {
                $auxProd = $prod;
                $bandera = 1;
                break;
            }
        }
        if($bandera == 1) {
            if($auxProd->Eliminar()) {
                header("Location: Listado.php");
            }
            else  {
                $retorno->exito = false;
                $retorno->mensaje = "No se pudo eliminar";
            }
        }
        else {
            $retorno->exito = false;
            $retorno->mensaje = "No se encontro el producto";
        }
        echo json_encode($retorno);
    }
}