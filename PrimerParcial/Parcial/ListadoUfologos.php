<?php

include "./clases/Ufologo.php";

$arrayUfo = Ufologo::TraerTodos();

echo "[";
for($i = 0; $i < count($arrayUfo); $i++) {
    if($i == count($arrayUfo) - 1) {
        echo $arrayUfo[$i]->ToJSON()."]";
    }
    else {
        echo $arrayUfo[$i]->ToJSON().",<br>";
    }
}

//foreach($arrayUfo as $ufo) {
//    echo $ufo->ToJSON().",<br>";
//}
//echo "]";