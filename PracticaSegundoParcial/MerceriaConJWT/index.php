<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './media.php';
require_once './usuario.php';
require_once './MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


//************************************ //
//************* VERBOS API *********** //
//************************************ //

$app->post('[/]', \media::class . '::Alta');  

$app->get('/medias[/]', \media::class . '::TraerTodos'); 

$app->post('/usuarios[/]', \usuario::class . '::Alta');

$app->get('[/]', \usuario::class . '::TraerTodos');


$app->group('/login', function() {
  
   $this->post('[/]', \usuario::class . '::CreaJWT')
   ->add(\MW::class . ':CorreoYClaveEnBD')
   ->add(\MW::class . '::CorreoYClaveNoVacios')
   ->add(\MW::class . ':CorreoYClaveSeteados');
  
   $this->get('[/]', \usuario::class . '::VerificaJWT');
});

$app->delete('[/]', \media::class . '::BorrarPorId')
->add(\MW::class . ':EsPropietario')
->add(\MW::class . ':EsTokenValido');

$app->put('[/]', \media::class . '::ModificarPorId')
->add(\MW::class . ':EsEncargado')
->add(\MW::class . ':EsTokenValido');

$app->group('/listados', function() {

    $this->get('[/]', \media::class . '::TraerTodos');

});


$app->run();