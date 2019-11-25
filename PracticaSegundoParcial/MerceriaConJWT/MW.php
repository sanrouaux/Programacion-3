<?php

use Firebase\JWT\JWT;

class MW {

    public function CorreoYClaveSeteados($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        if(isset($arrayParams['correo']) && isset($arrayParams['clave'])) {
            $response = $next($request, $response);
        }
        else {
            //$retorno = array('error'=> 'Correo o clave no seteados');
            $retorno = new stdClass();
            $retorno->mensaje = 'Correo o clave no seteados';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public static function CorreoYClaveNoVacios($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        if($arrayParams['correo'] != "" && $arrayParams['clave'] != "") {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'Correo o clave vacios';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function CorreoYClaveEnBD($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $correo = $arrayParams['correo'];
        $clave = $arrayParams['clave'];
        $existeEnBD = Usuario::ExisteEnBD($correo, $clave);
        if($existeEnBD) {
            $response = $next($request, $response);
        }
        else {
            $retorno = array('error'=>'Correo o clave incorrectos');
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function EsTokenValido($request, $response, $next) {
        $arrayParams = $request->getParsedBody();   
        $token = $arrayParams['token'];   
        
        try {         
            $decodificado = JWT::decode(
            $token,
            "miClaveSecreta",
            ['HS256']
            );
            $response = $next($request, $response);
        } 
        catch (Exception $e) {
            $retorno = array('error'=> $e->getMessage());
            $response = $response->withJson($retorno, 409);            
        }
        return $response;
    }
    
    public static function EsPropietario($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $token = $arrayParams['token'];

        try {         
            $payload = JWT::decode(
            $token,
            "miClaveSecreta",
            ['HS256']
            );
            $data = $payload->data;
            $correo = $data->correo;
            $clave = $data->clave;
            $usuario = Usuario::TraerUno($correo, $clave);
            if($usuario->perfil === 'propietario') {
                $response = $next($request, $response);
            }
            else {
                $retorno = array('error'=> 'El usuario no es propietario');
                $response = $response->withJson($retorno, 409);
            }            
        } 
        catch (Exception $e) {
            $retorno = array('error'=> $e->getMessage());
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function EsEncargado($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $token = $arrayParams['token'];

        try {         
            $payload = JWT::decode(
            $token,
            "miClaveSecreta",
            ['HS256']
            );
            $data = $payload->data;
            $correo = $data->correo;
            $clave = $data->clave;
            $usuario = Usuario::TraerUno($correo, $clave);
            if($usuario->perfil === 'encargado' || $usuario->perfil === 'propietario') {
                $response = $next($request, $response);
            }
            else {
                $retorno = array('error'=> 'El usuario no es encargado (o cargo superior)');
                $response = $response->withJson($retorno, 409);
            }            
        } 
        catch (Exception $e) {
            $retorno = array('error'=> $e->getMessage());
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    /*
    public function ListadoDiferencial($request, $response, $next) {
        $response = $next($request, $response);

        $arrayParams = $request->getParsedBody();
        $token = $arrayParams['token'];
        try {
            $payload = JWT::decode($token, "miClaveSecreta", ['HS256']);
            $data = $payload->data;
            $correo = $data->correo;
            $clave = $data->clave;
            $usuario = Usuario::TraerUno($correo, $clave);
            if($usuario->perfil === 'empleado') {
               $response->getBody();
            }
            else if ($usuario->perfil === 'encargado') {

            }
            else if ($usuario->perfil === 'propietario') {

            }      
        } 
        catch (Exception $e) {
            $retorno = array('error'=> $e->getMessage());
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }
    */
}