<?php

    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormularioRegistro($nombre)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado($nombre)) 
        {
            $correcto = true;

            // Nombre //
            if (empty($_REQUEST['nombre']))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["nombre"] = "El campo nombre no puede estar vacío";
            }
            else if(!validaNombreUsuario(false,"nombre"))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["nombre"] = "El nombre del usuario introducido ya existe";
            }

            // Contraseña //
            if(empty($_REQUEST['contraseña']))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["contraseña"] = "El campo contraseña no puede estar vacío";
            }
            else if((validaContraseña(false,"contraseña") == false))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["contraseña"] = "La contraseña introducida no cumple el patron";
            }


            // Contraseña (confirmacion) //
            if (empty($_REQUEST['contraseñaConf']))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["contraseñaConf"] = "El campo contraseña de confirmación no puede estar vacío";
            }
            else if((validaContraseña(false,"contraseñaConf") == false))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["contraseñaConf"] = "La contraseña de confirmacion introducida no cumple el patron";
            }
            else if(!coincidenContraseñas($nombre))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["contraseñaConf"] = "Las contraseñas no coinciden";
            }
            
            // Email
            if (empty($_REQUEST['email']))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["email"] = "El campo email no puede estar vacío";
            }
            
             // Fecha de Nacimiento
            if (empty($_REQUEST['fecha_nacimiento']))
            {
                $correcto = false;
                $_SESSION["erroresRegistro"]["fecha_nacimiento"] = "El campo fecha no puede estar vacío";
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
            -Al final: una mayúscula, una minúscula y un número 
        */
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
            if($_REQUEST["contraseña"] == $_REQUEST["contraseñaConf"])
                $coincidentes = true;
            else
            {
                $coincidentes = false;

                ?>
                <label for="<?php echo "idPassConf" ?>" style="color:red;"><?php echo "Las contraseñas no coinciden" ?></label>
                <?php
            }
                
            return $coincidentes;
        }
    }

    // Funcion que valida si el nombre del usuario es único
    function validaNombreUsuario($validando,$campo)
    {   
        $correcto = true;

        // DSN
        $dsn = "mysql:host=" . IP . ";dbname=" . BBDD;

        try
        {
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta
            $sql = "select * from usuarios;";
            $resultado = $conexion->query($sql);

            // Recorro los resultados -> Mientras haya productos...
            while($fila = $resultado->fetch())
            {
                if(isset($_REQUEST["nombre"]))
                {
                    // Si el codigo de este producto coincide con el que se quiere crear
                    if($_REQUEST["nombre"] == $fila["usuario"])
                    {
                        $correcto = false;
                        $arrayErrores["nombre"] = "El nombre del usuario introducido ya existe";

                        if($validando)
                        {
                            //imprimeError("idNombre","nombre","El nombre del usuario introducido ya existe");

                            ?>
                            <label for="<?php echo "idNombre" ?>" style="color:red;"><?php echo "El nombre del usuario introducido ya existe" ?></label>
                            <?php
                        }
                    }
                    
                }
                
            }

            return $correcto;

        }
        catch(PDOException $ex)
        {
            $numError = $ex->getCode();

            // Si no existe la tabla...
            if($numError == "42S02")
            {
                echo "<br>Error: La tabla no existe.<br>";
            }
            // Error al no reconocer la BBDD
            if($numError == 1049)
            {
                echo "<br>Error: No se reconoce la BBDD.<br>";
            }
            // Error al conectar con el servidor...
            else if($numError == 2002)
            {
                echo "<br>Error: Error al conectar con el servidor.<br>";
            }
            // Error de autenticación...
            else if($numError == 1045)
            {
                echo "<br>Error: Error en la autenticación.<br>";
            }
        }
        finally
        {
            // Cierro la conexion
            unset($conexion);
        }
        
    }
?>