<?php

class Usuario {
    
    private $email;
    private $clave;

    public function __construct($email, $clave) {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function ToJSON() {
        return '{"email": "'.$this->email.'", "clave": "'.$this->clave.'"}';
    }

    public function GuardarEnArchivo() {
        $retorno = new stdClass();

        $pArchivo = fopen("./archivos/usuarios.json", "a");
        $respuesta = fwrite($pArchivo, $this->ToJSON()."\r\n");
        if($respuesta > 0) {
            $retorno->exito = true;
            $retorno->mensaje = "Se guardo el usuario";
        }        
        fclose($pArchivo);

        return json_encode($retorno);
    }

    public static function TraerTodos() {
        $retorno = array();

        $pArchivo = fopen("./archivos/usuarios.json", "r");
        while(!feof($pArchivo)) {
            $row = fgets($pArchivo);
            $obj = json_decode($row);
            if($obj != NULL)
            {
                $usuario = new Usuario($obj->email, $obj->clave);
                array_push($retorno, $usuario);
            }   
        }
        fclose($pArchivo);
        return $retorno;
    }

    public static function VerificarExistencia($usuario) {

        $arrayUsuarios = Usuario::TraerTodos();
        foreach($arrayUsuarios as $u) {
            if($u->email == $usuario->email && $u->clave == $usuario->clave) {
                return true;
            }
        }
        return false;
    }
}