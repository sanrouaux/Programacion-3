<?php

include_once "ejer_19_FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica 
{
    private $altura;
    private $base;

    public function __construct($altura, $base)
    {   
        parent::__construct();
        $this->altura = $altura;
        $this->base = $base;
        $this->CalcularDatos();
    }

    protected function CalcularDatos()
    {
        $this->_perimetro = $this->base * 3;
        $this->_superficie = ($this->base * $this->altura) / 2;
    }

    public function Dibujar()
    {
        $grafico;
        $grafico .= '<h1 style="color:'.$this->_color.'">    *    </h1>';
        $grafico .= '<h1 style="color:'.$this->_color.'">  * * *  </h1>';
        $grafico .= '<h1 style="color:'.$this->_color.'">* * * * *</h1>';

        return $grafico;
    }

    public function ToString()
    {
        return "Altura: " . $this->altura . "<br/>Base: " . $this->base . parent::ToString() . "<br/><br/>" . $this->Dibujar();
    }
}