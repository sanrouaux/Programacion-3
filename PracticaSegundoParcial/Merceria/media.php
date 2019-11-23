<?php

require_once './AccesoDatos.php';

class Media {

    public $color;
    public $marca;
    public $precio;
    public $talle;
    
    public function __construct($color, $marca, $precio, $talle) {
        $this->color = $color;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->talle = $talle;
    } 

    //Metodos especiales para SLIM-API-REST
    public static function Alta($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $color = $arrayParams['color'];
        $marca = $arrayParams['marca'];
        $precio = $arrayParams['precio'];
        $talle = $arrayParams['talle'];

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta('INSERT INTO medias (color, marca, precio, talle) VALUES (:color, :marca, :precio, :talle)');
        $consulta->bindValue(':color',$color, PDO::PARAM_STR);
        $consulta->bindValue(':marca',$marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$precio);
        $consulta->bindValue(':talle',$talle);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se dio de alta una nueva media';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro dar el alta a la nueva media';
        }
        $newResponse = $response->withJson($retorno, 200);            	
        return $newResponse;
    }

    public static function TraerTodos($request, $response) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT color, marca, precio, talle FROM medias WHERE 1");
        $consulta->execute();
        $arrayMedias = array();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            $media = new Media($row->color, $row->marca, $row->precio, $row->talle);
            array_push($arrayMedias, $media);            
        }
        //$arrayMedias = $consulta->fetchAll(PDO::FETCH_CLASS, 'Media');
        $newResponse = $response->withJson($arrayMedias, 200);            	
        return $newResponse;    
    }

    public static function BorrarPorId($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $id = $arrayParams['id_media'];

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("DELETE FROM medias WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se elimino el producto';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro eliminar el producto';
        }
        $response = $response->withJson($retorno, 200);            	
        return $response;
    }


    public static function ModificarPorId($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $media = $arrayParams['media'];
        $objMedia = json_decode($media);

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("UPDATE medias SET color=:color,marca=:marca,precio=:precio,talle=:talle WHERE id=:id");
        $consulta->bindValue(':color',$objMedia->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca',$objMedia->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$objMedia->precio);
        $consulta->bindValue(':talle',$objMedia->talle);
        $consulta->bindValue(':id',$objMedia->id, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se modifico el producto';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro modificar el producto';
        }
        $newResponse = $response->withJson($retorno, 200);            	
        return $newResponse;
    }

}