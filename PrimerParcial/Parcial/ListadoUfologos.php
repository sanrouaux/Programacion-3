<?php

include "./clases/Ufologo.php";

$arrayUfo = Ufologo::TraerTodos();
echo "[";
foreach($arrayUfo as $ufo) {
    echo $ufo->ToJSON().",<br>";
}
echo "]";