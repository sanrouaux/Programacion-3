<?php

require_once './AccesoDatos.php';

class Auto {
    public $color;
    public $marca;
    public $precio;
    public $modelo;
    
    public function __construct($color, $marca, $precio, $modelo) {
        $this->color = $color;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->modelo = $modelo;
    } 
    //Metodos especiales para SLIM-API-REST
    public static function Alta($request, $response) {
        $arrayParams = $request->getParsedBody(); 
        $auto = json_decode($arrayParams['auto']);
        
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta('INSERT INTO autos (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)');
        $consulta->bindValue(':color',$auto->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca',$auto->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$auto->precio);
        $consulta->bindValue(':modelo',$auto->modelo, PDO::PARAM_STR);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se dio de alta un nuevo auto';
            $response = $response->withJson($retorno, 200);            	
            return $response;
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro dar el alta el nuevo auto';
           $response = $response->withJson($retorno, 418);            	
            return $response;
        }
    }

    public static function TraerTodos($request, $response) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM autos WHERE 1");
        $consulta->execute();
        $arrayAutos = array();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            array_push($arrayAutos, $row);            
        }
        //$arrayMedias = $consulta->fetchAll(PDO::FETCH_CLASS, 'Media');
        
        $tabla = "<table border='1' width='100%' style='text-align:center'>";
        $tabla .= "<tr>";
        $tabla .= "<td>COLOR</td>";
        $tabla .= "<td>MARCA</td>";
        $tabla .= "<td>PRECIO</td>";
        $tabla .= "<td>MODELO</td>";
        $tabla .= "</tr>";

        foreach($arrayAutos as $auto) {
            $tabla .= "<tr>";
            $tabla .= "<td>".$auto->color."</td>";
            $tabla .= "<td>".$auto->marca."</td>";
            $tabla .= "<td>".$auto->precio."</td>";
            $tabla .= "<td>".$auto->modelo."</td>";
            $tabla .= "</tr>";
        }
        $tabla .= "</table>";

        $retorno = new stdClass();
        $retorno->exito = true;
        $retorno->mensaje = 'Se logro traer los autos';
        //$retorno->tabla = $tabla;
        $response = $response->withJson($retorno, 200);
        $response->getBody()->write($tabla);           	
        return $response;     
    }

    public static function BorrarPorId($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $id = $arrayParams['id_auto'];
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("DELETE FROM autos WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se elimino el auto';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro eliminar el auto';
        }
        $response = $response->withJson($retorno, 200);            	
        return $response;
    }
    
    public static function ModificarPorId($request, $response) {
        $arrayParams = $request->getParsedBody(); 
        //$id = $arrayParams['id_media'];       
        $auto = $arrayParams['infoAuto'];
        $objAuto = json_decode($auto);
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("UPDATE autos SET color=:color,marca=:marca,precio=:precio,modelo=:modelo WHERE id=:id");
        $consulta->bindValue(':color',$objAuto->color, PDO::PARAM_STR);
        $consulta->bindValue(':marca',$objAuto->marca, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$objAuto->precio);
        $consulta->bindValue(':modelo',$objAuto->modelo);
        $consulta->bindValue(':id',$objAuto->id, PDO::PARAM_INT);
        $consulta->execute();
        $retorno = new stdClass();
        if($consulta->rowCount() > 0) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se modifico el auto';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro modificar el auto';
        }
        $newResponse = $response->withJson($retorno, 200);            	
        return $newResponse;
    }
}