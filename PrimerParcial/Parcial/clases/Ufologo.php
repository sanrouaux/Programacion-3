<?php

class Ufologo
{
    private $pais;
    private $legajo;
    private $clave;

    public function __construct($pais, $legajo, $clave) {
        $this->pais = $pais;
        $this->legajo = $legajo;
        $this->clave = $clave;
    }

    public function ToJSON() {
        return '{"pais": "'.$this->pais.'", "legajo": "'.$this->legajo.'", "clave": "'.$this->clave.'"}';
    }

    public function GuardarEnArchivo() {
        $retorno = new stdClass();
        $pArchivo = fopen("./archivos/ufologos.json", "a");
        $respuesta = fwrite($pArchivo, $this->ToJSON()."\r\n");
        if($respuesta > 0) {
            $retorno->exito = true;
            $retorno->mensaje = "Se guard&oacute; el uf&oacute;logo";
        }
        else {
            $retorno->exito = false;
            $retorno->mensaje = "No se pudo guardar el uf&oacute;logo";
        }        
        fclose($pArchivo);
        return json_encode($retorno);
    }

    public static function TraerTodos() {
        $retorno = array();
        $pArchivo = fopen("./archivos/ufologos.json", "r");
        while(!feof($pArchivo)) {
            $row = fgets($pArchivo);            
            if($row != "")
            {
                $obj = json_decode($row);
                $ufologo = new Ufologo($obj->pais, $obj->legajo, $obj->clave);
                array_push($retorno, $ufologo);
            }   
        }
        fclose($pArchivo);
        return $retorno;
    }

    public static function VerificarExistencia($ufologo) {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El uf&oacute;logo no est&aacute; registrado";
        
        $arrayUfo = Ufologo::TraerTodos();
        foreach($arrayUfo as $ufo) {
            if($ufologo->legajo == $ufo->legajo && $ufologo->clave == $ufo->clave) {
                $retorno->exito = true;
                $retorno->mensaje = "El uf&oacute;logo est&aacute; registrado";
                break;
            }
        }
        return json_encode($retorno);
    } 

}