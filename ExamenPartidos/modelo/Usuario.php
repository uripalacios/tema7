<?php

class Usuario
{
    // Atributos
    private $id;
    private $nombre;
    private $password;
    private $perfil;

    // Constructor
    function __construct($id,$nombre,$password,$perfil){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->perfil = $perfil;
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