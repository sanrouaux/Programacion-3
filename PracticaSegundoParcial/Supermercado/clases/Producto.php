<?php
require_once ("AccesoDatos.php");
    class Producto {

        private $_id;
        private $_nombre;
        private $_precio;


        public function GetId() {

            return $this->_id;
        }

        public function GetNombre() {
            
            return $this->_nombre;
        }

        public function GetPrecio() {

            return $this->_precio;
        }

        public function __construct($id,$nombre,$precio) 
        {
            $this->_id=$id;
            $this->_nombre = $nombre;
            $this->_precio=$precio;
        }

        public function ToJson($obj) {

            return '{"id":"'.$obj->GetId().'" ,"nombre": "'.$obj->GetNombre().'", "precio":"'.$obj->GetPrecio().'"}';     
         }

        public static function Agregar($request, $response)
        {
            $parametros = $request->getParsedBody();
            $producto=new Producto($parametros["id"],$parametros["nombre"],$parametros["precio"]);
            $conexion=AccesoDatos::DameUnObjetoAcceso();
            $resultados = $conexion->RetornarConsulta("INSERT INTO `productos`(`id`, `nombre`, `precio`)VALUES ('".$producto->GetId()."' , '".$producto->GetNombre()."' ,'".$producto->GetPrecio()."')");
            
            if($resultados->execute())
            {
                $response->getBody()->write("Se ha cargado correctamente el nuevo producto.");
                return $response;
            }
            else
            {
                $response->getBody()->write("Error!! No se pudo cargar el producto");
                return $response;
            }
        }

        public static function Listado()
        {
            $conexion=AccesoDatos::DameUnObjetoAcceso();
            $resultados = $conexion->RetornarConsulta("SELECT * FROM `productos`");
            $resultados->execute();

            $listado=array();

            while($fila = $resultados->fetch(PDO::FETCH_ASSOC)) 
            {
                $producto=new Producto($fila["id"],$fila["nombre"],$fila["precio"]);
                array_push($listado,Producto::ToJson($producto));
            }
            return $listado;
        }

        public static function Modificar($request,$response)
        {
           
            $parametros=$request->getParsedBody();
            
            $conexion=AccesoDatos::DameUnObjetoAcceso();// CREO CONEXION A LA BASE DE DATOS
            $resultados= $conexion->RetornarConsulta("SELECT  * FROM `productos` WHERE id=".$parametros["id"]);
            $resultados->execute();

            $fila = $resultados->fetch(PDO::FETCH_ASSOC);
            $conexion=NULL;
            
            if($fila)
            {
                $conexion=AccesoDatos::DameUnObjetoAcceso();
                $resultados = $conexion->RetornarConsulta("UPDATE `productos` SET `nombre`='".$parametros["nombre"]."',`precio`=".$parametros["precio"]." WHERE id=".$parametros["id"]);
                $resultados->execute();

                $response->getBody()->write("Se ha modificado correctamente el producto con id: ".$parametros["id"]);
                return $response;
            }
            else
            {
                $response->getBody()->write("No existe el producto que desea modificar");
                return $response;
            }
        }

        public static function Eliminar($request,$response)
        {
            $parametros=$request->getParsedBody();
            
            $conexion=AccesoDatos::DameUnObjetoAcceso();// CREO CONEXION A LA BASE DE DATOS
            $resultados= $conexion->RetornarConsulta("SELECT  * FROM `productos` WHERE id=".$parametros["id"]);
            $resultados->execute();

            $fila = $resultados->fetch(PDO::FETCH_ASSOC);
            $conexion=NULL;
            
            if($fila)
            {
                $conexion=AccesoDatos::DameUnObjetoAcceso();
                $resultados = $conexion->RetornarConsulta("DELETE FROM `productos` WHERE id=".$parametros["id"]);
                $resultados->execute();

                $response->getBody()->write("Se ha eliminado correctamente el producto con id: ".$parametros["id"]);
                return $response;
            }
            else
            {
                $response->getBody()->write("No existe el producto que desea eliminar");
                return $response;
            }
        }
    }

?>