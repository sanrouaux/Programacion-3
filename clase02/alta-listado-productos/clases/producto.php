<?php
class Producto{
    private $nombre;
    private $cod_barra;
    private $path_foto;

    public function __construct($n=null, $c=null, $p=null){
        $this->nombre = $n;   
        $this->cod_barra = $c;
        $this->path_foto = $p;
    }

    public function GetCodBarra(){
        return $this->cod_barra;
    }


    public function GetNombre(){
        return $this->nombre;
    }

    public function GetPath(){
        return $this->path_foto;
    }

    public function ToString(){
        return $this->GetCodBarra() . " - " . $this->GetNombre() . " - " . $this->GetPath() . "\r\n";
    }

    //devuelve un booleano
    public static function Guardar($obj){
        $result = false;
        $archivo = fopen("./Archivos/productos.txt", "a+");
        
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
            $prod = new Producto($elemento[0], $elemento[1], $elemento[2]);
            array_push($array, $prod);
        }

        fclose($archivo);
        return $array;
    }
}


?>