<?php

require "Iparte2.php";

class Televisor implements IParte2{

    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;

    public function __construct($tipo = "", $precio = 0, $paisOrigen = "", $path = "sin foto") {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->path = $path;
    }

    public function ToJSON() {
        return '{"tipo": "'.$this->tipo.'", "precio": "'.$this->precio.'", "paisOrigen": "'.$this->paisOrigen.'", "path": "'.$this->path.'"}';
    }

    public function Agregar() {
        $retorno = false;
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("INSERT INTO `televisores` (`tipo`, `precio`, `pais`, `foto`) VALUES (:tipo, :precio, :pais, :foto)");
            $sentencia->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $sentencia->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $sentencia->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
            $sentencia->bindValue(':foto', $this->path, PDO::PARAM_STR);
            $sentencia->execute();
            if($sentencia->rowCount() > 0) {
                $retorno = true;
            }            
        }
        catch(PDOException $e) {
        }
        return $retorno;
    }

    public static function Traer() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=productos_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM televisores");
            $sentencia->execute();
            $arrayTelevisores = array();
            while($row = $sentencia->fetch(PDO::FETCH_OBJ)) {
                array_push($arrayTelevisores, new Televisor($row->tipo, $row->precio, $row->pais, $row->foto));
            }
        }
        catch(PDOException $e) {
            $arrayTelevisores = NULL;
        }
        return $arrayTelevisores;
    }

    public function CalcularIVA() {
        return ($this->precio * 1.21);
    }
}