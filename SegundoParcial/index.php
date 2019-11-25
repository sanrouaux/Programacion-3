<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './auto.php';
require_once './usuario.php';
require_once './MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->post('/usuarios[/]', \usuario::class . '::Alta');

$app->get('[/]', \usuario::class . '::TraerTodos');

$app->post('[/]', \auto::class . '::Alta');  

$app->get('/autos[/]', \auto::class . '::TraerTodos'); 

$app->group('/login', function() {
  
    $this->post('[/]', \usuario::class . '::CreaJWT');
   
    $this->get('[/]', \usuario::class . '::VerificaJWT');
 });

$app->delete('[/]', \auto::class . '::BorrarPorId')
->add(\MW::class . ':EsPropietario')
->add(\MW::class . ':EsTokenValido');

$app->put('[/]', \auto::class . '::ModificarPorId')
->add(\MW::class . ':EsEncargado')
->add(\MW::class . ':EsTokenValido');


$app->run();