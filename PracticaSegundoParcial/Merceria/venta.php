<?php

require_once './AccesoDatos.php';

class Venta {

    public $id_usuario;
    public $id_media;
    public $cantidad;

    public function __construct($id_usuario, $id_media, $cantidad) {
        $this->id_usuario = $id_usuario;
        $this->id_media = $id_media;
        $this->cantidad = $cantidad;
    } 

    //Metodos especiales para SLIM-API-REST
    public static function Alta($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $id_usuario = $arrayParams['id_usuario'];
        $id_media = $arrayParams['id_media'];
        $cantidad = $arrayParams['cantidad'];

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta('INSERT INTO ventas (id_usuario, id_media, cantidad) VALUES (:id_usuario, :id_media, :cantidad)');
        $consulta->bindValue(':id_usuario',$id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':id_media',$id_media, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);

        $resultado = $consulta->execute();
        $retorno = new stdClass();
        if($resultado == true) {             
            $retorno->mensaje = 'Se dio de alta una venta';
            $newResponse = $response->withJson($retorno, 200);
        }
        else {           
           $retorno->mensaje = 'No se logro dar el alta a la nueva venta';
           $newResponse = $response->withJson($retorno, 504);
        }                    	
        return $newResponse;
    }

    public static function TraerTodos($request, $response) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id_usuario, id_media, cantidad FROM ventas WHERE 1");
        $consulta->execute();
        $arrayVentas = array();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            $venta = new Venta($row->id_usuario, $row->id_media, $row->cantidad);
            array_push($arrayVentas, $venta);            
        }
        //$arrayMedias = $consulta->fetchAll(PDO::FETCH_CLASS, 'Media');
        $newResponse = $response->withJson($arrayMedias, 200);            	
        return $newResponse;    
    }

    public static function BorrarVentaPorUsuarioYMedia($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $id_media = $arrayParams['id_media'];
        $id_usuario = $arrayParams['id_usuario'];

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("DELETE FROM ventas WHERE id_usuario = :id_usuario AND id_media = :id_media");
        $consulta->bindValue(':id_usuario',$id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':id_media',$id_media, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se elimino la venta';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro eliminar la venta';
        }
        $response = $response->withJson($retorno, 200);            	
        return $response;
    }


    public static function ModificarCantidadPorId($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $id = $arrayParams['id'];
        $nuevaCantidad = $arrayParams['nuevaCantidad'];

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("UPDATE ventas SET cantidad=:cantidad WHERE id=:id");
        $consulta->bindValue(':cantidad',$nuevaCantidad, PDO::PARAM_INT);
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se modifico la venta';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro modificar la venta';
        }
        $newResponse = $response->withJson($retorno, 200);            	
        return $newResponse;
    }

}