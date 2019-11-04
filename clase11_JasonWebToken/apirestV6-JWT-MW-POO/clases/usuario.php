<?php

class usuario {

    public $id;
 	public $nombre;
  	public $contraseña;
    public $perfil;
      
    public static function TraerUnUsuario($nombre, $contraseña) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where nombre ='" .$nombre. "' AND contraseña = '".$contraseña."'");
			$consulta->execute();
			$usuBuscado= $consulta->fetchObject('usuario');
			return $usuBuscado;						
    }
    

    /*public static function TraerUnCdUsuarioParamNombre($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios WHERE id=:id AND jahr=:anio");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('cd');
      		return $cdBuscado;							
	}*/
}
