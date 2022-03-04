<?php

class Albaran
{
    // Atributos
    private $id_albaran;
    private $fecha;
    private $cod_producto;
    private $cantidad;
    private $usuario;

    // Constructor
    function __construct($id_albaran,$fecha,$cod_producto,$cantidad,$usuario){
        $this->id_albaran = $id_albaran;
        $this->fecha = $fecha;
        $this->cod_producto = $cod_producto;
        $this->cantidad = $cantidad;
        $this->usuario = $usuario;
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