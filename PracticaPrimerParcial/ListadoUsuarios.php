<?php

include "./clases/Usuario.php";

$arrayUsuarios = Usuario::TraerTodos();

foreach($arrayUsuarios as $usu) {
    echo $usu->ToJSON()."<br>";
}