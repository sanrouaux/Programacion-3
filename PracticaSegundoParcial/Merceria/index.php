<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './media.php';
require_once './usuario.php';
require_once './venta.php';
require_once './middleware.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

//METODOS
$app->group('', function() {

    //*****ALTA DE MEDIA******//
    $this->post('[/]', \media::class . '::Alta');  
    
    //*****LISTADO DE MEDIAS******//
    $this->get('/medias', \media::class . '::TraerTodos');  

    //*****ALTA DE USUARIO******//
    $this->post('/usuarios', \usuario::class . '::Alta')
    ->add(\MW::class . ':CorreoYClaveEnBD')
    ->add(\MW::class . '::CorreoYClaveNoVacios') 
    ->add(\MW::class . ':CorreoYClaveSeteados');
    
    //*****LISTADO DE USUARIOS******//
    $this->get('[/]', \usuario::class . '::TraerTodos');
    

    $this->group('/ventas', function() {
         //ALTA DE VENTA
        $this->post('[/]', \venta::class . '::Alta');

        //LISTADO DE VENTAS
        $this->get('[/]', \venta::class . '::TraerTodos');
    });


    $this->group('', function() {
        //BORRADO DE MEDIA
        $this->delete('[/]', \media::class . '::BorrarPorId')
        ->add(\MW::class . '::EsPropietario');

        //MODIFICA UNA MEDIA
        $this->put('[/]', \media::class . '::ModificarPorId')
        ->add(\MW::class . ':EsPropietarioOEncargado');;    
    });


    $this->group('/ventas', function() {
        //BORRA UNA VENTA
        $this->delete('[/]', \venta::class . '::BorrarVentaPorUsuarioYMedia');

        //MODIFICA UNA VENTA
        $this->put('[/]', \venta::class . '::ModificarCantidadPorId');   
   
    })->add(\MW::class . ':EsEmpleado');     


    $this->get('/listadoFotos[/]', \usuario::class . '::ListadoFotos');

});

$app->run();