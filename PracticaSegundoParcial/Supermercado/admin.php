<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/Empleado.php';
require_once './clases/Producto.php';
require_once './clases/Middleware.php';
require_once './clases/JWT.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);

/************************** AGREGO EMPLEADO ******************************** */
$app->post("[/]" , function(Request $request , Response $response) 
    {
        Empleado::Agregar($request , $response, $_FILES);
    });
/************************* VERIFICO EMPLEADO ****************************** */
$app->post("/email/clave[/]" , function(Request $request , Response $response) 
    {
        Empleado::Verificar($request, $response);
    });
/**************** LISTADO DE EMPLEADOS *********************************** */
$app->get("[/]" , function(Request $request , Response $response) 
    {
        var_dump(Empleado::Listado());
    });
/*****************************************************************************/


$app->group('/productos', function (){
/***************** AGREGO PRODUCTO *******************************************/
$this->post("[/]" , function(Request $request , Response $response) 
    {
        Producto::Agregar($request, $response);  
    })->add(\Middleware::class . ":logNombreApellido");
/**************** LISTADO DE PRODUCTOS **************************************/
$this->get("[/]" , function(Request $request , Response $response) 
    {
        var_dump(Producto::Listado());          
    });
/*************** MODIFICACION DE PRODUCTOS ***********************************/
$this->put("[/]" , function(Request $request , Response $response) 
    {   
        Producto::Modificar($request,$response);       
    });
/*************** ELIMINACION DE PRODUCTOS *************************************/
$this->delete("[/]" , function(Request $request , Response $response) 
    { 
        Producto::Eliminar($request,$response);       
    });    
})->add(\Middleware::class . ":log");

/********************* FUNCION MIDDLEWARE **************************************/
$mw=function($request, $response, $next) 
{
    $datos=json_decode(Empleado::Verificar($request,$response));
    if($datos->usuario->clave==="1234")
    {
        Token::JWT($datos);
    }
    
        if($request->isGet()) 
        {
            $response = $next($request, $response);
        }
        else
        {
            if($datos->usuario->perfil==="admin")
            {
                $response->getBody()->write("Procesando su pedido.\n");
                $response = $next($request, $response);
            }
            elseif($datos->usuario->perfil==="user"&&$request->isPut()||$datos->usuario->perfil==="user"&&$request->isDelete())
            {
                $response->getBody()->write("No tiene permisos.");
            }
            else
            {
                $response = $next($request,$response);
            }
        
        }
        return $response;
};
/********************************************************************************/
$app->add($mw);
$app->run();
