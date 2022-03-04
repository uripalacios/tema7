<?php

class Venta
{
    // Atributos
    private $id_venta;
    private $usuario;
    private $fecha_compra;
    private $cod_producto;
    private $cantidad;
    private $precio_total;

    // Constructor
    function __construct($id_venta,$usuario,$fecha_compra,$cod_producto,$cantidad,$precio_total){
        $this->id_venta = $id_venta;
        $this->usuario = $usuario;
        $this->fecha_compra = $fecha_compra;
        $this->cod_producto = $cod_producto;
        $this->cantidad = $cantidad;
        $this->precio_total = $precio_total;
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