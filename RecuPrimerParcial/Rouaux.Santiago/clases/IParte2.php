<?php
interface IParte2 {
    public function Agregar();
    public static function Traer();
    public function CalcularIVA();
    public function Existe($arrayProd);
    public function Modificar($id);
    public function Eliminar();
}