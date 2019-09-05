<?php

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;

    public function __construct()
    {
        $this->_color = "black";
        $this->_perimetro = 0;
        $this->_superficie = 0;
    }

    public function GetColor()
    {
        return $this->_color;
    }

    public function SetColor($_color)
    {
        $this->_color = $_color;
    }

    public function ToString()
    {
        return "<br/>Color: " . $this->_color . "<br/>Perimetro: " . $this->_perimetro . "<br/>Superficie: " . $this->_superficie;
    }

    public abstract Dibujar();
    protected abstract CalcularDatos(); 
}