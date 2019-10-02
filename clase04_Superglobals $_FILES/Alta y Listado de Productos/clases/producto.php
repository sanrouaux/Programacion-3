<?php
class Producto{
    private $nombre;
    private $cod_barra;
    private $path_foto;

    //Constructor con parámetros opcionales
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
        $archivo = fopen("./Archivos/productos.txt", "a");
        
        if(fwrite($archivo, $obj->ToString()) > 0 )
        $result = true;

        fclose($archivo);
        return $result;
    }

    //devuelve un array de tipo producto
    public static function TraerTodosLosProductos(){
        $array = array();
        $archivo = fopen("./Archivos/productos.txt", "r");
        
        while(!feof($archivo)){
            //La función explode() secciona un string y crea un arra indexado con las secciones obtenidas
            $elemento = explode(" - ", fgets($archivo));
            if($elemento[0] != "" && $elemento[1] != "" && $elemento[2] != "")
            {
                $prod = new Producto($elemento[0], $elemento[1], $elemento[2]);
                array_push($array, $prod);
            }            
        }

        fclose($archivo);
        return $array;
    }
}


?>