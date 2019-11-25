<?php

use Firebase\JWT\JWT;


class MW {

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
            $response = $response->withJson($retorno, 403);            
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

}