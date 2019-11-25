<?php

require_once './AccesoDatos.php';

use Firebase\JWT\JWT;

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
        $usuario = json_decode($arrayParams['usuario']);        
        
        $archivos = $request->getUploadedFiles();
        $nombreAnterior = $archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior);
        $extension = array_reverse($extension);
        $extension = $extension[0];
        $destino = './fotos/'.date('His').'.'.$extension;
        $archivos['foto']->moveTo($destino);

        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta('INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :perfil, :foto)');
        $consulta->bindValue(':correo',$usuario->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':nombre',$usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':perfil',$usuario->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto',$destino, PDO::PARAM_STR);
        $resultado = $consulta->execute();
        $retorno = new stdClass();
        if($resultado == true) { 
            $retorno->exito = true;
            $retorno->mensaje = 'Se dio de alta un nuevo usuario';
            $response = $response->withJson($retorno, 200);            	
            return $response;
        }
        else {
           $retorno->exito = false;
           $retorno->mensaje = 'No se logro dar el alta al nuevo usuario';
           $response = $response->withJson($retorno, 418);            	
           return $response;
        }
        
    }
    public static function TraerTodos($request, $response) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE 1");
        $consulta->execute();
        $arrayUsuarios = array();
        while($row = $consulta->fetch(PDO::FETCH_OBJ)) {
            array_push($arrayUsuarios, $row);            
        }

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

        $retorno = new stdClass();
        $retorno->exito = true;
        $retorno->mensaje = 'Se logro traer a los usuarios';
        //$retorno->tabla = $tabla;
        $response = $response->withJson($retorno, 200);
        $response->getBody()->write($tabla);           	
        return $response;    
    }

    public static function TraerUno($correo, $clave) {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
        $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);        
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_OBJ);
        return $usuario;    
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

    public static function CreaJWT($request, $response) {
        $arrayParams = $request->getParsedBody();     
        $datos = $arrayParams['datos'];
        $datosJson = json_decode($datos);
        
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
        $consulta->bindValue(':correo', $datosJson->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $datosJson->clave, PDO::PARAM_STR);
        $respuesta = $consulta->execute();

        $retorno = new stdClass();
        $usuario;
        if($usuario = $consulta->fetch(PDO::FETCH_OBJ)) {
            //$usuario = $consulta->fetch(PDO::FETCH_OBJ);
            $ahora = time();
            $payload = array(
            'iat' => $ahora,            //CUANDO SE CREO EL JWT (OPCIONAL)
            'exp' => $ahora + (100),     //INDICA EL TIEMPO DE VENCIMIENTO DEL JWT (OPCIONAL)
            'data' => $usuario,           //DATOS DEL JWT
            'app' => "SEGUNDO PARCIAL"    //INFO DE LA APLICACION (PROPIO)
            );
            $token = JWT::encode($payload, "miClaveSecreta");  
            $retorno->exito = true;
            $retorno->jwt = $token;
            $response = $response->withJson($retorno, 200);            	 
        }
        else {
            $retorno->exito = false;
            $retorno->jwt = NULL;
            $response = $response->withJson($retorno, 403);            	
             
        }
        return $response;
    }

    public static function VerificaJWT($request, $response) {
        $arrayParams = $request->getParsedBody();   
        $token = $arrayParams['token'];    
        $retorno = new stdClass();
        try {         
            $decodificado = JWT::decode(
            $token,
            "miClaveSecreta",
            ['HS256']
            );
            $retorno->mensaje = 'Token valido';
            $response = $response->withJson($retorno, 200);
            return $response;
        } 
        catch (Exception $e) {
            $retorno->mensaje = 'Token invalido';
            $response = $response->withJson($retorno, 403);
            return $response;
        }
    }
}