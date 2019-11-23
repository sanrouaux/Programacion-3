<?php

class Archivo
{
    public static function Subir()
    {
        $retorno;

        if($_FILES["archivo"]["size"] < 5000000)
        {
            move_uploaded_file($_FILES["archivo"]["tmp_name"], "./Archivos/".$_FILES["archivo"]["name"]);
            $retorno = true;
        }
        else
        {
            $retorno = false;
        }     
        return $retorno;   
    }
}