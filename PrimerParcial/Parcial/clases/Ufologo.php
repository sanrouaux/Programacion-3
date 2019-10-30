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
            $retorno->mensaje = "Se guardo el ufologo";
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
        $retorno->mensaje = "No esta registrado";
        
        $arraUfo = Ufologo::TraerTodos();
        foreach($arraUfo as $ufo) {
            if($ufologo->legajo == $ufo->legajo && $ufologo->clave == $ufo->clave) {
                $retorno->exito = true;
                $retorno->mensaje = "El ufologo esta registrado";
            }
        }
        return json_encode($retorno);
    }    

    //************************************** */
    //FUNCIONES BASADAS EN CODIGO DE EMILIANO
    //*************************************** */

    /*public function GuardarEnArchivo() {
        $objRetorno = new stdClass();
        $objRetorno->exito = false;
        $objRetorno->mensaje = "Error en la escritura";
        $destino = "./archivos";
        $stringEscritura = "";
        if(file_exists($destino)){
            $destino .= "/ufologos.json";
            if(!file_exists($destino)){
                $stringEscritura .= "[";
            } else {
                $stringEscritura .= ",";
                if(file_exists($destino)){
                    $file = fopen($destino, 'r+') or die("can't open file");
                    $status = fstat($file);
                    ftruncate($file, $status['size']-3);
                    fclose($file);
                } else {
                    echo "error";
                }
            }
            $archivo = fopen($destino, "a");
            $stringEscritura .= $this->ToJson();
            $stringEscritura .= "]\r\n";
            $cantidad = fwrite($archivo, $stringEscritura);
            if($cantidad > 0){
                $objRetorno->exito = true;
                $objRetorno->mensaje = "Se guardo al ufologo en el archivo";
            }
            fclose($archivo);
        }
        return json_encode($objRetorno);
    }*/

    /*public static function TraerTodos() {
        $destino = "./archivos/ufologos.json";
        $linea = "";
        $ufologos = array();
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            while(!feof($archivo)){
                $linea .= fgets($archivo);
            }
            if(!empty($linea)){
                $listaUfologosJSON = json_decode($linea);
                foreach ($listaUfologosJSON as $ufoJSON) {
                    $nuevoUfo = new Ufologo($ufoJSON->pais, $ufoJSON->legajo, $ufoJSON->clave);
                    $ufologos[] = $nuevoUfo;
                }
            }
        }
        return $ufologos;
    }*/

}