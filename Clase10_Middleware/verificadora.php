<?php

include './AccesoDatos.php';

class Verificadora {

    private static function DeterminarVerbo($request) {
        if($request->isGet()) {
            return 'get';
        }
        else if($request->isPost()) {
            return 'post';
        }
    }

    //Verifica que exista usuario en archivo de texto
    private static function ExisteUsuario($obj) {
        
        $bandera = 0;

        $pArchivo = fopen("usuarios.txt", "r");
        while(!(feof($pArchivo)))
        {
            $usu = fgets($pArchivo);
            $usu = explode(' - ', $usu);
            if(trim($usu[0]) == $obj->nombre && trim($usu[1]) == $obj->clave) {
                $bandera = 1;
                break;
            }
        }   
        fclose($pArchivo);
        
        if($bandera == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function Verificar($request, $response, $next) {
        $metodo = Verificadora::DeterminarVerbo($request);
        if($metodo == 'get') {
            $response = $next($request, $response);
        }
        if($metodo == 'post') {
            $params = $request->getParsedBody();
            $usuario = new stdClass();
            $usuario->tipo = $params['tipo'];
            $usuario->nombre = $params['nombre'];
            $usuario->clave = $params['clave'];

            if($usuario->tipo == 'admin' && Verificadora::ExisteUsuario($usuario)) {
                $response->getBody()->write("Bienvenido, " . $usuario->nombre . "<br>");
                $response = $next($request, $response);
            }
            else {
                $response->getBody()->write("No existe usuario o el usuario no es ADMIN");
            }       
        }
        return $response;
    }


    public function VerificaEnBD($request, $response, $next) {
        
        if($request->isGet()) {
            $response = $next($request, $response);
        }
        if ($request->isPost()) {
           $params = $request->getParsedBody();
           $nombre = $params['nombre'];
           $clave = $params['clave'];
    
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
           $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE nombre = :nombre && clave = :clave");
           $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
           $consulta->bindParam(':clave', $clave, PDO::PARAM_STR);
           $consulta->execute();        
           if($consulta->rowCount() > 0) {
                $response = $next($request, $response);
            }
            else {
                 $response->getBody()->write("Usuario o contraseña incorrecta");
            }   
        }
        return $response;
    }

}