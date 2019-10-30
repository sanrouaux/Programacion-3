<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require './verificadora.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);



// PROBAMOS UNA API REST

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!!");
    return $response;
});

$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!!");
    return $response;
});

$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!!");
    return $response;
});

$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DEL => Bienvenido!!!");
    return $response;
});


// AGREGAMOS MIDDLEWARE INCRUSTADO EN LA API (No es una práctica recomendable)

$app->group('/credenciales', function () {    
    
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Llego al metodo!!!");
        return $response;
    });

    $this->post('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Llego al metodo!!!");
        return $response;
    });

})->add(function($request, $response, $next) {

    if($request->isGet()) {
        $response = $next($request, $response);
    }
    else if ($request->isPost()) {
       $params = $request->getParsedBody();
       $tipo = $params['tipo'];
       $nombre = $params['nombre'];

       if($tipo == 'admin') {
        $response->getBody()->write("Bienvenido, " . $nombre . "<br>");
           $response = $next($request, $response);
       }
       else {
            $response->getBody()->write("Error");
       }       
    }
    return $response;
});



//Agregamos Middleware programados según POO (Es la práctica recomendada)

$app->group('/credenciales/POO', function () {    
    
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Llego al metodo a través de un GET!!!");
        return $response;
    });

    $this->post('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Validó y llegó al método a través del POST!!!");
        return $response;
    });

})->add(Verificadora::class . ":Verificar");


//Nuevo grupo con middleware que habilita permisos de acuerdo a perfiles

$app->group('/credenciales/Ejercicio', function () {    
    
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Llega al metodo GET. No verifica en BD!!!");
        return $response;
    });

    $this->post('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Verifica en BD y llega al método a través del POST!!!");
        return $response;
    });

    $this->put('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Validó y llegó al método a través del POST!!!");
        return $response;
    });

    $this->delete('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("Validó y llegó al método a través del POST!!!");
        return $response;
    });

})->add(Verificadora::class . ":VerificaEnBD");


$app->run();