<?php

require_once './vendor/autoload.php';
require_once 'AccesoDatos.php';
use Firebase\JWT\JWT;

class Token
{
private static $claveSecreta = 'zF9h5ghF5js3GPVa@';
private static $tipoEncriptacion = ['HS256'];
private static $aud = NULL;

    public static function JWT($datos)
    {
        ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
        $fecha=date("Y-m-d H:i:s");
     
            $payload = array(
                'iat'=>$fecha,              //CUANDO SE CREO EL JWT (OPCIONAL)
                'aud' => self::Aud(),       //IDENTIFICA DESTINATARIOS (OPCIONAL)
                'data' => $datos,           //DATOS DEL JWT
                'app'=> "API REST 2017"     //INFO DE LA APLICACION (PROPIO)
            );
        
            //CODIFICO A JWT
            $token=JWT::encode($payload, self::$claveSecreta);

            $conexion=AccesoDatos::DameUnObjetoAcceso();// CREO CONEXION A LA BASE DE DATOS
            $resultados = $conexion->RetornarConsulta("INSERT INTO `tokens`(`token`) VALUES ('".$token."')");
            $resultados->execute();
    }

    private static function Aud() {
        
                $aud = '';
                
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $aud = $_SERVER['HTTP_CLIENT_IP'];
                } 
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } 
                else {
                    $aud = $_SERVER['REMOTE_ADDR'];
                }
                
                $aud .= @$_SERVER['HTTP_USER_AGENT'];
                $aud .= gethostname();
        
                return sha1($aud);
            }
}