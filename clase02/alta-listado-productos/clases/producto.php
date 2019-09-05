<?php
class Producto{
    private $nombre;
    private $cod_barra;

    public function __construct($n=null, $c=null){
        if($n!=null && $c!=null){
            $this->nombre = $n;
            $this->cod_barra = $c;
        }
    }

    public function GetCodBarra(){
        return $this->cod_barra;
    }


    public function GetNombre(){
        return $this->nombre;
    }

    public function ToString(){
        return $this->cod_barra . " - " . $this->nombre . "\r\n";
    }

    //devuelve un booleano
    public static function Guardar($obj){
        $result = false;
        $archivo = fopen("./archivos/productos.txt", "a+");
        
        if(fwrite($archivo, $obj->ToString()) > 0 )
        $result = true;

        fclose($archivo);
        return $result;
    }

    //devuelve un array de tipo producto
    public static function TraerTodosLosProductos(){
        $array = array();
        $archivo = fopen("./Archivos/productos.txt", "a+");
        
        while(!feof($archivo)){
            $elemento = explode(" - ", fgets($archivo));
            //echo $elemento[0] . " - " . $elemento[1] . "\r\n";
            array_push($array, $elemento);
        }

        fclose($archivo);
        return $array;
    }
}


?>