<?php

class Usuario
{
    // Atributos
    private $usuario;
    private $contraseña;
    private $email;
    private $fecha_nacimiento;
    private $perfil;

    // Constructor
    function __construct($usuario,$contraseña,$email,$fecha_nacimiento,$perfil){
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->email = $email;
        $this->fecha_nacimiento = $fecha_nacimiento;
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