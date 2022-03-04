<?php

class Producto
{
    // Atributos
    private $codigo_producto;
    private $descripcion;
    private $precio;
    private $stock;
    //private $imagen;

    // Constructor
    function __construct($codigo_producto,$descripcion,$precio,$stock){
        $this->codigo_producto = $codigo_producto;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    // Getter genérico
    public function __get($name)
    {
        return $this->$name;
    }

    // Setter genérico
    public function __set($name,$valor)
    {
        $this->$name = $valor;
    }

}

?>