<?php

require_once './AccesoDatos.php';

class Usuario {

    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil; //propietario, encargado, empleado
    public $foto;

    public function __construct($correo, $clave, $nombre, $apellido, $perfil, $foto) {
        $this->correo = $correo;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->perfil = $perfil;
        $this->foto = $foto;
    } 

    //Metodos especiales para SLIM-API-REST
    public static function Alta($request, $response) {
        $arrayParams = $request->getParsedBody();        
        $correo = $arrayParams['correo'];
        $clave = $arrayParams['clave'];
        $nombre = $arrayParams['nombre'];
        $apellido = $arrayParams['apellido'];
        $perfil = $arrayParams['perfil'];
        
        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $destino = './fotos/'.date('His').'.'.$extension;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino); 

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta('INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :perfil, :foto)');
        $consulta->bindValue(':correo',$correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre',$nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$apellido, PDO::PARAM_STR);
        $consulta->bindValue(':perfil',$perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto',$destino, PDO::PARAM_STR);
        $resultado = $consulta->execute();
        $retorno = new stdClass();
        if($resultado == true) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se dio de alta un nuevo usuario';
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro dar el alta al nuevo usuario';
        }
        $newResponse = $response->withJson($retorno, 200);            	
        return $newResponse;
    }

    public static function TraerTodos($request, $response) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT correo, clave, nombre, apellido, perfil, foto FROM usuarios WHERE 1");
        $consulta->execute();
        $arrayUsuarios = array();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            $usuario = new Usuario($row->correo, $row->clave, $row->nombre, $row->apellido, $row->perfil, $row->foto);
            array_push($arrayUsuarios, $usuario);            
        }
        //$arrayMedias = $consulta->fetchAll(PDO::FETCH_CLASS, 'Media');
        $newResponse = $response->withJson($arrayUsuarios, 200);            	
        return $newResponse;    
    }

    public static function ListadoFotos($request, $response) {
        $jsonUsuarios = self::TraerTodos($request, $response);
        $arrayUsuarios = json_decode($jsonUsuarios->getBody()->__toString());
        
        $tabla = "<table border='1' width='100%' style='text-align:center'>";
        $tabla .= "<tr>";
        $tabla .= "<td>CORREO</td>";
        $tabla .= "<td>CLAVE</td>";
        $tabla .= "<td>NOMBRE</td>";
        $tabla .= "<td>APELLIDO</td>";
        $tabla .= "<td>PERFIL</td>";
        $tabla .= "<td>FOTO</td>";
        $tabla .= "</tr>";
        
        foreach($arrayUsuarios as $usu) {
            $tabla .= "<tr>";
            $tabla .= "<td>".$usu->correo."</td>";
            $tabla .= "<td>".$usu->clave."</td>";
            $tabla .= "<td>".$usu->nombre."</td>";
            $tabla .= "<td>".$usu->apellido."</td>";
            $tabla .= "<td>".$usu->perfil."</td>";
            $tabla .= "<td><img heigth='150px' width='150px' src='".$usu->foto."'/></td>";
            $tabla .= "</tr>";
        }
        $tabla .= "</table>";
        $response->getBody()->write($tabla);
        return $response;
    }

    public static function ExisteEnBD($correo, $clave) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
        $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->execute();
        $existeEnBD;
        if($consulta->fetch(PDO::FETCH_OBJ)) {
            $existeEnBD = true;
        }
        else {
            $existeEnBD = false;
        }
        return $existeEnBD;
    }

}