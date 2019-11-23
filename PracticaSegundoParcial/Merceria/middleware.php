<?php

class MW {

    public static function EsPropietario($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $usuario = $arrayParams['usuario'];
        $objUsu = json_decode($usuario);

        if($objUsu->perfil == 'propietario') {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El usuario no es propietario. No cuenta con permisos para realizar esta accion.';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function EsEncargado($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $usuario = $arrayParams['usuario'];
        $objUsu = json_decode($usuario);

        if($objUsu->perfil == 'encargado') {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El usuario no es encargado. No cuenta con permisos para realizar esta accion.';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function EsPropietarioOEncargado($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $usuario = $arrayParams['usuario'];
        $objUsu = json_decode($usuario);

        if($objUsu->perfil == 'encargado' || $objUsu->perfil == 'propietario') {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El usuario no es propietario ni encargado. No cuenta con permiso para realizar esta accion';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

    public function EsEmpleado($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        $usuario = $arrayParams['usuario'];
        $objUsu = json_decode($usuario);

        if($objUsu->perfil == 'empleado') {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El usuario no es empleado. No cuenta con permisos para realizar esta accion.';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }


    public function CorreoYClaveSeteados($request, $response, $next) {
        $arrayParams = $request->getParsedBody();
        if(isset($arrayParams['correo']) && isset($arrayParams['clave'])) {
            $response = $next($request, $response);
        }
        else {
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
        if(!$existeEnBD) {
            $response = $next($request, $response);
        }
        else {
            $retorno = new stdClass();
            $retorno->mensaje = 'El correo o la clave ya existen en la base de datos';
            $response = $response->withJson($retorno, 409);
        }
        return $response;
    }

}