<?php

include "./clases/Ufologo.php";

$arrayUfo = Ufologo::TraerTodos();

$retorno = "[";

for($i = 0; $i < count($arrayUfo); $i++) {
    if($i != count($arrayUfo) - 1) { 
        $retorno .= $arrayUfo[$i]->ToJSON().",<br>";        
    }
    else {
        $retorno .= $arrayUfo[$i]->ToJSON()."]";
    }
}

echo $retorno;