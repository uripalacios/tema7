<?php

class Usuario{
    private $id;
    private $nombre;
    private $password;
    private $perfil;
    //private $fechaUltConexion;

    function __construct($codU,$nom,$pass,$perfil)
    {
        $this->id = $codU;
        $this->nombre = $nom;
        $this->password = $pass;
        $this->perfil = $perfil;
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



