<?php

include ("AccesoDatos.php");

class usuario
{
    private $id;
    private $nombre;
    private $apellido;
    private $clave;
    private $perfil;
    private $estado;
    private $correo;

    public function MostrarUsuario()
    {
            return $this->id." - ".$this->nombre." - ".$this->apellido." - ".$this->perfil." - ".$this->estado." - ".$this->correo;
    }

    public static function ExisteEnBD($usuario)
    {
        $retorno = new stdClass();

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo =".$usuario->correo);
        $consulta->execute();
        $row = $consulta->fetch(PDO::FETCH_OBJ);
        if($consulta->row_count() > 0 && $row->clave == $usuario->clave) {
            $retorno->existeEnBd = true;
        }
        else {
            $retorno->existeEnBd = false;
        }   
        return $retorno;     
    }
    
    public static function TraerTodosLosUsuarios()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, nombre, apellido, perfil, estado, correo FROM usuarios");        
        
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new usuario);                                                

        return $consulta; 
    }
    
    public function AltaUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (id, nombre, apellido, clave, perfil, estado, correo)"
                                                    . "VALUES(:id, :nombre, :apellido, :clave, :perfil, :estado, :correo)");
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->anio, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $this->clave, PDO::PARAM_STR);

        $consulta->execute();   

    }
    
    public static function ModificarUsuario($id, $nombre, $apellido, $clave, $perfil, $estado, $correo)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET nombre = :nombre, apellido = :apellido,
                                                        clae = :clave 
                                                        jahr = :anio WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':titulo', $titulo, PDO::PARAM_INT);
        $consulta->bindValue(':anio', $anio, PDO::PARAM_INT);
        $consulta->bindValue(':cantante', $cantante, PDO::PARAM_STR);

        return $consulta->execute();

    }

    public static function EliminarUsuario($usuario)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM cds WHERE id = :id");
        
        $consulta->bindValue(':id', $usuario->id, PDO::PARAM_INT);

        return $consulta->execute();

    }
    

}