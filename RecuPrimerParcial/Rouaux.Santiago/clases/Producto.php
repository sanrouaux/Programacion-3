<?php
include 'IParte2.php';
class Producto implements IParte2{
    public $codigoBarra;
    public $descripcion;
    public $precio;
    public $pathFoto;
    public function __construct($codigoBarra = 0, $descripcion = "", $precio = 0, $pathFoto = "") {
        $this->codigoBarra = $codigoBarra;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->pathFoto = $pathFoto;
    }
    public function ToJSON() {
        return '{"codigoBarra": "'.$this->codigoBarra.'", "descripcion": "'.$this->descripcion.'", "precio": "'.$this->precio.'" , "pathFoto": "'.$this->pathFoto.'"}';
    }
    public function Agregar() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("INSERT INTO productos (`codigo_barra`, `descripcion`, `precio`, `foto`) VALUES (:codigo_barra, :descripcion, :precio, :foto)");
            $sentencia->bindParam(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $sentencia->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $sentencia->bindParam(':precio', $this->precio);
            $sentencia->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);
            $respuesta = $sentencia->execute();
        }
        catch(PDOException $e) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public static function Traer() {        
        $arrayProd = array();
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM productos");
            $sentencia->execute();
            if($sentencia->rowCount() > 0) {
                while($row = $sentencia->fetch(PDO::FETCH_OBJ)) {
                $prod = new Producto($row->codigo_barra, $row->descripcion, $row->precio, $row->foto);
                array_push($arrayProd, $prod);
                }
            }            
            return $arrayProd;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }        
    }
 
    public function CalcularIVA() {
        return $this->precio * 1.21;
    }

    public function Existe($arrayProd) {
        foreach($arrayProd as $prod) {
            if($this->codigoBarra == $prod->codigoBarra) {
               return true;
            }
        }
        return false;
    }

    public function Modificar($id) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("UPDATE `productos` SET `descripcion`=:descripcion,`precio`=:precio,`foto`=:foto, codigo_barra = :codigo_barra WHERE id = :id");
            $sentencia->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $sentencia->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $sentencia->bindValue(':precio', $this->precio);
            $sentencia->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            $sentencia->bindValue(':id', $id, PDO::PARAM_INT);
            $respuesta = $sentencia->execute();
        }
        catch(PDOException $e) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public function Eliminar() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("DELETE FROM productos WHERE codigo_barra = :codigo_barra AND descripcion = :descripcion AND precio = :precio AND foto = :foto");
            $sentencia->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $sentencia->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $sentencia->bindValue(':precio', $this->precio);
            $sentencia->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            $respuesta = $sentencia->execute();
        }
        catch(PDOException $e) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public static function TraerPorId($id) {        
        try {
            $prod = NULL;
            $pdo = new PDO("mysql:host=localhost;dbname=almacen_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            if($sentencia->rowCount() > 0) {
                $row = $sentencia->fetch(PDO::FETCH_OBJ);
                $prod = new Producto($row->codigo_barra, $row->descripcion, $row->precio, $row->foto);
            }            
            return $prod;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }        
    }
    
}