<?php

include "Rectangulo.php";
include "Triangulo.php";

$rectangulo = new Rectangulo(5, 7);

$rectangulo->SetColor("blue");

echo $rectangulo->ToString();

$triangulo = new Triangulo(10, 5);

$triangulo->SetColor("red");

echo $triangulo->ToString();
