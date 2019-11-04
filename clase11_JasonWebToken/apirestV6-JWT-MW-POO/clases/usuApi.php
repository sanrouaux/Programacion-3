<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';
require_once "AutentificadorJWT.php";

class usuApi extends usuario
{
 	public function TraerUno($request, $response) {
        $params = $request->getParsedBody();
        $nombre=$params['nombre'];
         $contraseña=$params['contraseña'];
        $usu=usuario::TraerUnUsuario($nombre, $contraseña);
        if(!$usu)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No esta el usuario";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {
            $datos = ['nombre' => $usu->nombre, 'perfil' => $usu->perfil];
            $token= AutentificadorJWT::CrearToken($datos);
            $NuevaRespuesta = $response->withJson($token, 200); 
        }     
        return $NuevaRespuesta;
    }

}