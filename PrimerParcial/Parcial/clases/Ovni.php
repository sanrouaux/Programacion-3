<?php

include 'IParte2.php';

class Ovni implements IParte2{

    public $tipo;
    public $velocidad;
    public $planetaOrigen;
    public $pathFoto;

    public function __construct($tipo = "", $velocidad = 0, $planetaOrigen = "", $pathFoto = "") {
        $this->tipo = $tipo;
        $this->velocidad = $velocidad;
        $this->planetaOrigen = $planetaOrigen;
        $this->pathFoto = $pathFoto;
    }

    public function ToJSON() {
        return '{"tipo": "'.$this->tipo.'", "velocidad": "'.$this->velocidad.'", "planetaOrigen": "'.$this->planetaOrigen.'" , "pathFoto": "'.$this->pathFoto.'"}';
    }

    public function Agregar() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("INSERT INTO ovnis (`tipo`, `velocidad`, `planeta`, `foto`) VALUES (:tipo, :velocidad, :planeta, :foto)");
            $sentencia->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
            $sentencia->bindParam(':velocidad', $this->velocidad);
            $sentencia->bindParam(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
            $sentencia->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);
            $respuesta = $sentencia->execute();
        }
        catch(PDOException $e) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public static function Traer() {        
        $ovnis = array();
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM ovnis");
            $sentencia->execute();
            if($sentencia->rowCount() > 0) {
                while($row = $sentencia->fetch(PDO::FETCH_OBJ)) {
                $ovni = new Ovni($row->tipo, $row->velocidad, $row->planeta, $row->foto);
                array_push($ovnis, $ovni);
                }
            }            
            return $ovnis;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public static function TraerPorId($id) {        
        try {
            $ovni = NULL;
            $pdo = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM ovnis WHERE id = :id");
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            if($sentencia->rowCount() > 0) {
                $row = $sentencia->fetch(PDO::FETCH_OBJ);
                $ovni = new Ovni($row->tipo, $row->velocidad, $row->planeta, $row->foto);
            }            
            return $ovni;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }        
    }

    public function ActivarVelocidadWarp() {
        return $this->velocidad * 10.45;
    }

    public function Existe($arrayOvnis) {
        foreach($arrayOvnis as $ovni) {
            if($this->tipo == $ovni->tipo 
            && $this->velocidad == $ovni->velocidad 
            && $this->planetaOrigen == $ovni->planetaOrigen) {
               return true;
            }
        }
        return false;
    }

    public function Modificar($id) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("SELECT * FROM ovnis WHERE id = :id");
            $sentencia->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $sentencia->bindValue(':velocidad', $this->velocidad);
            $sentencia->bindValue(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
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
            $pdo = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            $sentencia = $pdo->prepare("DELETE FROM ovnis WHERE tipo = :tipo AND velocidad = :velocidad AND planeta = :planeta AND foto = :foto");
            $sentencia->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
            $sentencia->bindParam(':velocidad', $this->velocidad);
            $sentencia->bindParam(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
            $sentencia->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);
            $respuesta = $sentencia->execute();
        }
        catch(PDOException $e) {
            $respuesta = false;
        }
        return $respuesta;
    }

    public function GuardarEnArchivo() {
        
        $array = explode("/", $this->pathFoto);
        $arrayInvertido = array_reverse($array);
        $arrayNombreFoto = explode(".", $arrayInvertido[0]);
        $arrayInvertido = array_reverse($arrayNombreFoto);
        $extension = $arrayInvertido[0];

        $nuevoDestino = "./ovnisBorrados/id.".$this->tipo.".borrado.".date("His").".".$extension;        
        $fotoMovida = rename($this->pathFoto, $nuevoDestino);
        $this->pathFoto = $nuevoDestino;
        
        $pArchivo = fopen("./ovnisBorrados/ovnis_borrados.txt", "a");
        $respuesta = fwrite($pArchivo, $this->ToJSON()."\r\n");
        if($respuesta > 0 && $fotoMovida == true) {
            $retorno = true;
        }
        else {
            $retorno = false;
        }        
        fclose($pArchivo);
        return $retorno;
    }

    public static function MostrarBorrados() {
        $pArchivo = fopen("./ovnisBorrados/ovnis_borrados.txt", "r");
        $texto = fread($pArchivo, filesize("./ovnisBorrados/ovnis_borrados.txt")); 
        fclose($pArchivo);
        return $texto;
    }
}