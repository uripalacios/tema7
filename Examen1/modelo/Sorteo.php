<?php

class Apuesta{
    private $id;
    private $fecha;
    private $n1;
    private $n2;
    private $n3;
    private $n4;
    private $n5;
    //private $fechaUltConexion;

    function __construct($id,$fecha,$n1,$n2,$n3,$n4,$n5)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->n1 = $n1;
        $this->n2 = $n2;
        $this->n3 = $n3;
        $this->n4 = $n4;
        $this->n5 = $n5;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name,$valor)
    {
        $this->$name = $valor;
    }
}