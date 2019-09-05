<?php

include "ejer_19_FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica 
{
    private $ladoUno;
    private $ladoDos;

    public function __construct($ladoUno, $ladoDos)
    {   
        super::__construct();
        $this->ladoUno = $ladoUno;
        $this->ladoDos = $ladoDos;
        $this->CalcularDatos();
    }

    private function CalcularDatos()
    {
        super::$_perimetro = ($this->ladoUno * 2) + ($this->ladoDos * 2);
        super::$_superficie = $this->ladoUno * $this->ladoDos;
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
            $grafico += "<br/>";
        }
        return $grafico;
    }

    public ToString()
    {
        return "Lado uno: " . $this->ladoUno . "<br/>Lado dos: " . $this->ladoDos . base::ToString() . "<br/><br/>" . $this->Dibujar();
    }
}