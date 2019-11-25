<?php

class MiClase
{

    public function MostrarInstancia($request, $response, $next){

        $response->getBody()->write('<br>Desde método de instancia<br>');
        return $next($request, $response);

    }
    
    public static function MostrarEstatico($request, $response, $next){

        $response->getBody()->write('<br>Desde método estático<br>');
        return $next($request, $response);

    }
}