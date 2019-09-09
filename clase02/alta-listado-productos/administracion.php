<?php
require_once ("clases/producto.php");
include("clases/archivo.php");

$alta = isset($_POST["guardar"]) ? TRUE : FALSE;

if($alta) {

	$p = new Producto($_POST["nombre"], $_POST["codBarra"], "Archivos/".$_FILES["archivo"]["name"]);
	
	if(!Producto::Guardar($p)){
		$mensaje = "Lamentablemente ocurrio un error y no se pudo escribir en el archivo.";
		include("mensaje.php");
	}
	else{
		$mensaje = "El archivo fue escrito correctamente. PRODUCTO agregado CORRECTAMENTE!!!";
		include("mensaje.php");		
	}
	
	if(Archivo::Subir() == true)
	{
		echo "Se incluyo una imagen";
	}
	else
	{
		echo "No se pudo incluir la imagen";
	}
}
?>