<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

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


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;
});

$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;
});

$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;
});

$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DEL => Bienvenido!!! a SlimFramework");
    return $response;
});


$app->get('/parametros/{nombre}[/{apellido}]', function (Request $request, Response $response, array $args) {    
    
    if(isset($args['apellido'])) {
         $response->getBody()->write("Bienvenid@, " . $args['nombre'] . " " . $args['apellido']);
    }
    else {
        $response->getBody()->write("Bienvenid@, " . $args['nombre']);
    }
   
    return $response;
});

$app->group('/JSON', function () {    
    
    $this->post('[/]', function (Request $request, Response $response) {    
        $params = $request->getParsedBody();
        var_dump($params);
        return $response;
    });

    $this->get('[/]', function (Request $request, Response $response) {    
        $obj = new stdClass();
        $obj->nombre = "juan";
        $obj->apellido = "perez";
        $newResponse = $response->withJson($obj, 200);
        return $response;
    });


    $this->delete('[/]', function (Request $request, Response $response) {    
        $params = $request->getParsedBody();
        $paramInvertido = array(
            "apellido" => $params['apellido'],
            "nombre" => $params['nombre']
        );
        $newResponse =  $response->withJson($paramInvertido, 200);
        return $newResponse;
    });

    $this->post('/foto', function (Request $request, Response $response) {    
        
        $params = $request->getParsedBody();
        $newResponse =  $response->withJson($params, 200);

        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior);
        $extension=array_reverse($extension);

        $archivos['foto']->moveTo($destino.date('his').".".$extension[0]);
        
        return $newResponse;
    });
   
});

/*
COMPLETAR POST, PUT Y DELETE
*/

$app->run();