<?php
require_once ("AccesoDatos.php");
require_once './vendor/autoload.php';

    class Empleado {

        private $_id;
        private $_nombre;
        private $_apellido;
        private $_email;
        private $_foto;
        private $_legajo;
        private $_clave;
        private $_perfil;


        public function GetId() {

            return $this->_id;
        }

        public function GetNombre() {
            
            return $this->_nombre;
        }

        public function GetApellido() {

            return $this->_apellido;
        }

        public function GetEmail() {
            
            return $this->_email;
        }

        public function GetFoto() {
            
            return $this->_foto;
        }
        public function GetLegajo() {
            
            return $this->_legajo;
        }

        public function GetClave() {
            
            return $this->_clave;
        }

        public function GetPerfil(){
            return $this->_perfil;
        }

        public function __construct($id=NULL,$nombre,$apellido,$email,$foto,$legajo , $clave , $perfil) {

            $this->_id=$id;
            $this->_nombre = $nombre;
            $this->_apellido=$apellido;
            $this->_email=$email;
            $this->_foto = $foto;
            $this->_legajo=$legajo;
            $this->_clave = $clave;
            $this->_perfil = $perfil;
            
        }

        public static function ToJson($obj) {

            return '{"id":"'.$obj->GetId().'", "nombre":"'.$obj->GetNombre().'" ,"apellido": "'.$obj->GetApellido().'", "email":"'.$obj->GetEmail().'","foto":"'.$obj->GetFoto().
                '","legajo":"'.$obj->GetLegajo().'","clave":"'.$obj->GetClave().'","perfil":"'.$obj->GetPerfil().'"}';
        }

        public static function Agregar($request , $response , $foto)
        {
            $parametros = $request->getParsedBody();
            $fotoFinal = date("Gis").".".pathinfo($foto["foto"]["name"] , PATHINFO_EXTENSION);
            $rutaFoto = "./img/".$fotoFinal;

            $empleado=new Empleado(NULL,$parametros["nombre"],$parametros["apellido"],$parametros["email"],$fotoFinal,$parametros["legajo"],$parametros["clave"],$parametros["perfil"]);
           
            if(move_uploaded_file($foto["foto"]["tmp_name"] , $rutaFoto))
                $response->getBody()->write("La foto se cargo correctamente.");
            else
                $response->getBody()->write("Error al cargar la foto.");

            $conexion=AccesoDatos::DameUnObjetoAcceso();
            $resultados = $conexion->RetornarConsulta("INSERT INTO `empleados`(`nombre`, `apellido`, `email`, `foto`, `legajo`, `clave`, `perfil`)VALUES ('".$empleado->GetNombre()."' , '".$empleado->GetApellido()."' ,'".$empleado->GetEmail()."' , '".$fotoFinal." ','".$empleado->GetLegajo()."','".$empleado->GetClave()."','".$empleado->GetPerfil()."')");
            if($resultados->execute())
            {    
                $response->getBody()->write("Se ha cargado correctamente el nuevo usuario.");
                return $response;
            }
            else
            {
                $response->getBody()->write("Error al cargar el usuario.");
                return $response;
            }
        }

        public static function Verificar($request , $response)
        {
            /*(POST) /email/clave/ Verifica empleado (email-clave). Retorna un json
            {valido:true/false, usuario:{datos}}*/
            $parametros = $request->getParsedBody();// RECIBO PARAMETROS
            $conexion=AccesoDatos::DameUnObjetoAcceso();// CREO CONEXION A LA BASE DE DATOS
            $resultados = $conexion->RetornarConsulta("SELECT * FROM `empleados` WHERE email='".$parametros["email"]."' AND clave=".$parametros["clave"]);
            $resultados->execute();
            
            $fila = $resultados->fetch(PDO::FETCH_ASSOC);
            
            if($fila)
            {
                $retorno='{"valido":"true","usuario":{"id":"'.$fila["id"].'", "nombre":"'.$fila["nombre"].'" ,"apellido": "'.$fila["apellido"].'", "email":"'.$fila["email"].'","foto":"'.$fila["foto"].'","legajo":'.$fila["legajo"].',"clave":"'.$fila["clave"].'","perfil":"'.$fila["perfil"].'"}}';
                //$response->getBody()->write($retorno);
                return $retorno;
            }
            else
            {
                $retorno='{"valido":"false"}';
                return $retorno;
            }
        }

        public static function Listado()
        {
            $conexion=AccesoDatos::DameUnObjetoAcceso();
            $resultados = $conexion->RetornarConsulta("SELECT * FROM `empleados`");
            $resultados->execute();

            $listado=array();

            while($fila = $resultados->fetch(PDO::FETCH_ASSOC)) 
            {
                $empleado=new Empleado($fila["id"],$fila["nombre"],$fila["apellido"],$fila["email"],$fila["foto"],$fila["legajo"],$fila["clave"],$fila["perfil"]);
                // $empleadoJSON=Empleado::ToJson($empleado);
                // var_dump(json_decode($empleadoJSON));
                array_push($listado,Empleado::ToJson($empleado));
                //array_push($listado,$empleadoJSON);
            }
            return $listado;
        }




    }

?>