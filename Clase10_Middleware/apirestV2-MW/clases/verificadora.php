<?php

class Verificadora
{
    public function VerificarUsuario($request, $response, $next){

        if($request->isGet()) {
            $response->getBody()->write('<br>NO necesita credenciales para los get<br>');
            $response = $next($request, $response);
        }
        else{
            $response->getBody()->write('<br>Verifico credenciales en archivo!<br>');
            $ArrayDeParametros = $request->getParsedBody();
            $objUser = new stdClass();
            $objUser->Nombre = $ArrayDeParametros['nombre'];
            $objUser->Clave = $ArrayDeParametros['clave'];

            if(Verificadora::ExisteUsuario($objUser)) {
                $response->getBody()->write("<h3>Bienvenido {$objUser->Nombre}</h3>");
                $response = $next($request, $response);
            }
            else{
                $response->getBody()->write('<h2>Access Denied!!!</h2>');
            }  
        }

        return $response;  
    }

    private static function ExisteUsuario($objUser){

		$archivo=fopen("./archivos/usuarios.txt", "r");
        $existe = FALSE;

        while(!feof($archivo)){

			$archAux = fgets($archivo);
			$users = explode(";", $archAux);

            if(trim($users[0]) != ""){
				if (trim($users[0]) === $objUser->Nombre && trim($users[1]) === $objUser->Clave) {
                    $existe = TRUE;
                    break;
                }
			}
        }
        
		fclose($archivo);

        return $existe;
    }
    
}