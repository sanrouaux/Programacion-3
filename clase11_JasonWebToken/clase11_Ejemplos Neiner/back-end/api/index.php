<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';

//NECESARIO PARA GENERAR EL JWT
use Firebase\JWT\JWT;

//require_once '/clases/AutentificadorJWT.php';
//require_once '/clases/MWparaCORS.php';
//require_once '/clases/MWparaAutentificar.php';
require_once '/clases/Usuario.php';

$config['displayErrorDetails'] = TRUE;
$config['addContentLengthHeader'] = FALSE;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).
  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/
$app = new \Slim\App(["settings" => $config]);


//************************************************************************************************************//
//************************************************************************************************************//

$app->post("/jwt/CrearToken[/]", function (Request $request, Response $response) {

    $datos = $request->getParsedBody();
    $ahora = time();
    
    //PARAMETROS DEL PAYLOAD -- https://tools.ietf.org/html/rfc7519#section-4.1 --
    //SE PUEDEN AGREGAR LOS PROPIOS, EJ. 'app'=> "API REST 2018"       
    $payload = array(
        'iat' => $ahora,            //CUANDO SE CREO EL JWT (OPCIONAL)
        'exp' => $ahora + (30),     //INDICA EL TIEMPO DE VENCIMIENTO DEL JWT (OPCIONAL)
        'data' => $datos,           //DATOS DEL JWT
        'app' => "API REST 2018"    //INFO DE LA APLICACION (PROPIO)
    );
      
    //CODIFICO A JWT
    $token = JWT::encode($payload, "miClaveSecreta");
    
    return $response->withJson($token, 200);
});


$app->post("/jwt/VerificarToken[/]", function (Request $request, Response $response) {
  
    $ArrayDeParametros = $request->getParsedBody();
    $token = $ArrayDeParametros['token'];

    if(empty($token) || $token === "") {
      
      throw new Exception("El token esta vacío!!!");
    } 
      
    try {
      //DECODIFICO EL TOKEN RECIBIDO            
      $decodificado = JWT::decode(
        $token,
        "miClaveSecreta",
        ['HS256']
      );
    } 
    catch (Exception $e) {
      throw new Exception("Token no válido!!! --> " . $e->getMessage());
    }
    
    return "Token OK!!!";

});

$app->post("/jwt/ObtenerPayLoad[/]", function (Request $request, Response $response) {
  
      $ArrayDeParametros = $request->getParsedBody();
      $token = $ArrayDeParametros['token'];

      $payLoad = JWT::decode(
        $token,
        "miClaveSecreta",
        ['HS256']
      );

      return $response->withJson($payLoad, 200);
});

$app->post("/jwt/ObtenerData[/]", function (Request $request, Response $response) {
  
      $ArrayDeParametros = $request->getParsedBody();
      $token = $ArrayDeParametros['token'];

      $data = JWT::decode(
        $token,
        "miClaveSecreta",
        ['HS256']
      )->data;

      return $response->withJson($data, 200);
});
//************************************************************************************************************//
//************************************************************************************************************//

//CREAR MW QUE: 
//1.- VERIFIQUE QUE ESTEN SETEADOS EL 'USUARIO' Y LA 'CLAVE'
//->SI NO EXISTE ALGUNO DE LOS DOS (O LOS DOS) RETORNAR JSON CON MENSAJE DE ERROR (Y STATUS 409)
//->SI EXISTEN, VERIFICAR QUE: 
//2.- SI ALGUNO ESTA VACIO (O LOS DOS) RETORNAR JSON CON MENSAJE DE ERROR (Y STATUS 409)
//->CASO CONTRARIO, ACCEDER AL VERBO DE LA API

//CREAR EL GRUPO '/JWT' QUE POSEA LOS SIGUIENTES VERBOS:
//*-POST('/'). RECIBE 'USUARIO', 'CLAVE' Y PERFIL Y GENERA UN JWT QUE SERA RETORNADO (STATUS 200). 
//SIEMPRE Y CUANDO NO EXISTA UN 'USUARIO' IGUAL YA GENERADO. (VERIFICAR CON OTRO MW)
//APLICAR EL MW ANTERIOR.

//*********************************************************************************************//
//AGREGO GROUP MIDDLEWARE
//*********************************************************************************************//

$app->group('/jwt', function() {
     
    $this->post('/', function (Request $request, Response $response) {

      $datos = $request->getParsedBody();
      $ahora = time();

      $payload = array(
        'iat' => $ahora,            //CUANDO SE CREO EL JWT (OPCIONAL)
        'exp' => $ahora + (30),     //INDICA EL TIEMPO DE VENCIMIENTO DEL JWT (OPCIONAL)
        'data' => $datos,           //DATOS DEL JWT
        'app' => "API REST 2018"    //INFO DE LA APLICACION (PROPIO)
      );

      $token = JWT::encode($payload, "miClaveSecreta");

      return $response->withJson($token, 200);

    })->add(function($request, $response, $next) {

      $ArrayDeParametros = $request->getParsedBody();

      if(isset($ArrayDeParametros['usuario']) && isset($ArrayDeParametros['clave'])) {

        if($ArrayDeParametros['usuario'] !== "" && $ArrayDeParametros['clave'] !== ""){

          $response = $next($request, $response);
        }
        else{

          $retorno = array('error'=>"Los datos del usuario y/o clave están vacíos!!!" );
          
          $response = $response->withJson($retorno, 409); 
        }

      }
      else {

        $retorno = array('error'=>"Faltan los datos del usuario y clave!!!" );
        
        $response = $response->withJson($retorno, 409); 
      }
 
    	return $response;
              
    })->add(function($request, $response, $next) {
      
      $response = $next($request, $response);

      if(isset($response->error)){

        $retorno = array('error'=> $response->error);
        
        $response = $response->withJson($retorno, 409); 

      }
      else{

        $ArrayDeParametros = $request->getParsedBody();
        $esValido = !Usuario::VerificarUsuario($ArrayDeParametros['usuario']);

        if(! $esValido){
          $retorno = array('error'=>"Nombre de usuario repetido!!!" );
          
          $response = $response->withJson($retorno, 409); 
            
        }
      }

      return $response;
    });
 
    
  $this->get('/', function (Request $request, Response $response) {      
    
      $arrayConToken = $request->getHeader('miTokenUTNfra');
      $token = $arrayConToken[0];
  
      try {
        //DECODIFICO EL TOKEN RECIBIDO            
        $decodificado = JWT::decode(
          $token,
          "miClaveSecreta",
          ['HS256']
        );

        $exito = array("mensaje" => "PHP: Su token es " . $token);
        
        $newResponse = $response->withJson($exito, 200); 
        
      } 
      catch (Exception $e) {

        $textoError = "ERROR -> " . $e->getMessage();
        
        $error = array('tipo' => 'acceso', 'descripcion' => $textoError);
  
        $newResponse = $response->withJson($error, 403); 
      }
      
      return $newResponse;
    });

  });


$app->run();