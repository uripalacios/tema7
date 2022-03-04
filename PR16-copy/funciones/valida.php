<?php

    // Aquí se debería validar el formulario y poner los errores (si existe, tamaño, etc)
    if(!true)
    {
        header(("Location: ../login.php?mensaje="));
        exit;
    }

    // Valida si existe el usuario en la BBDD //

    // Conexion a la BBDD
    require_once("../seguro/conexionBD.php");
    require_once("../funciones/consultas.php");

    // usuario
    $usuario = $_REQUEST["user"];
    $pass = $_REQUEST["pass"];

    // Si el usuario y la pass son correctos
    if(valida($usuario,$pass))
    {
        header("Location: ../paginas/menu.php");
        exit;
    }
    else
    {
        header("Location: ../paginas/error/usuarioIncorrecto.php");
        //echo "Error: El usuario y la contraseña son incorrectos.";
    }
?>