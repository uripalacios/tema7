<?php

// Funcion que invoca al resto de funciones que van validando el formulario
function validaFormularioPerfil($nombre)
{
    // Si se ha enviado el formulario...
    if (validaEnviado($nombre)) 
    {
        $correcto = true;

        // Nombre //
        if (empty($_REQUEST['user']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["user"] = "El campo user no puede estar vacío";
        }

        // Contraseña //
        if (empty($_REQUEST['pass']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["pass"] = "El campo contraseña no puede estar vacío";
        }
        else if((validaContraseña(false,"pass") == false))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["pass"] = "La contraseña introducida no cumple el patron";
        }

        // Contraseña (confirmacion) //
        if (empty($_REQUEST['pass2']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["pass2"] = "El campo contraseña de confirmación no puede estar vacío";
        }
        else if((validaContraseña(false,"pass2") == false))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["pass2"] = "La contraseña de confirmacion introducida no cumple el patron";
        }
        else if(!coincidenContraseñas($nombre))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["pass2"] = "Las contraseñas no coinciden";
        }

        // Email
        if (empty($_REQUEST['email']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["email"] = "El campo email no puede estar vacío";
        }
        
        // Fecha de Nacimiento
        if (empty($_REQUEST['fecha_nacimiento']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["fecha_nacimiento"] = "El campo fecha no puede estar vacío";
        }

        // Perfil
        if (empty($_REQUEST['perfil']))
        {
            $correcto = false;
            $_SESSION["erroresPerfil"]["perfil"] = "El campo perfil no puede estar vacío";
        }
        
    }
    // Si no...
    else 
        $correcto = false;
    
    return $correcto;
}

// Funcion que valida la contraseña del usuario con un patrón
function validaContraseña($validando,$campo)
{
    /* // Patrón que valida la contraseña
        - Mínimo 8 carácteres, máximo 20
        -Al final: una mayúscula, una minúscula y un número */
    $patron = "/^[A-Za-z0-9]{5,}([A-Z]{1}[a-z]{1}[0-9]{1})$/";

    $correcto = false;

    if((isset($_REQUEST[$campo])&&(!empty($_REQUEST[$campo]))))
    {
        $contraseña = $_REQUEST[$campo];

        // Si cumple el patrón...
        if(preg_match($patron, $contraseña) == true)
        {
            $correcto = true;
        }
        // Si no...
        else
        {
            $correcto = false;

            // En el caso de que esté validando...
            if($validando)
            {
                ?>
                <label for="<?php  ?>" style="color:red;"><?php echo "Debe introducir una contraseña válida" ?></label>
                <?php
            }
            
        }
    }

    return $correcto;
}

// Funcion que comprueba si ambas contraseñas coinciden
function coincidenContraseñas($nombre)
{

    $coincidentes = false;

    if(validaEnviado($nombre))
    {
        // Si las contraseñas coinciden...
        if($_REQUEST["pass"] == $_REQUEST["pass2"])
            $coincidentes = true;
        // Si no...
        else
        {
            $coincidentes = false;

            if(strlen($_REQUEST["pass"]) > 0)
            {
                ?>
                <label for="<?php echo "idPassConf" ?>" style="color:red;"><?php echo "Las contraseñas no coinciden" ?></label>
                <?php
            }
        }
            
        return $coincidentes;
    }
}
?>