<?php

include "ejer_19_FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica 
{
    private $altura;
    private $base;

    public function __construct($altura, $base)
    {   
        super::__construct();
        $this->altura = $altura;
        $this->base = $base;
        $this->CalcularDatos();
    }

    private function CalcularDatos()
    {
        super::$_perimetro = ($this->altura * 2) + ($this->ladoDos * 2);
        super::$_superficie = ($this->base * $this->altura) / 2;
    }

    public Dibujar()
    {
        $grafico;

        for($i = 0; $i < $this->ladoUno; $i++)
        {
            for($j = 0; $j < $this->ladoDos; $j++)
            {
                $grafico += " * ";
            }
            $grafico += "<br>";
        }
        return $grafico;
    }

    public ToString()
    {
        return "Altura: " . $this->altura . "<br/>Base: " . $this->base . base::ToString() . "<br/><br/>" . $this->Dibujar();
    }
}