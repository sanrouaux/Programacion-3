<?php

include_once "ejer_19_FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica 
{
    private $ladoUno;
    private $ladoDos;

    public function __construct($ladoUno, $ladoDos)
    {   
        parent::__construct();
        $this->ladoUno = $ladoUno;
        $this->ladoDos = $ladoDos;
        $this->CalcularDatos();
    }

    protected function CalcularDatos()
    {
        $this->_perimetro = ($this->ladoUno * 2) + ($this->ladoDos * 2);
        $this->_superficie = $this->ladoUno * $this->ladoDos;
    }

    public function Dibujar()
    {
        $grafico = "";

        for($i = 0; $i < $this->ladoUno; $i++)
        {
            for($j = 0; $j < $this->ladoDos; $j++)
            {
                $grafico .= '<i style="color:'.$this->_color.'"> * </i>';
            }
            $grafico .= "<br/>";
        }
        return $grafico;
    }

    public function ToString()
    {
        return "Lado uno: " . $this->ladoUno . "<br/>Lado dos: " . $this->ladoDos . parent::ToString() . "<br/><br/>" . $this->Dibujar();
    }
}