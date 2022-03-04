<?php

    // Importaciones //
    require_once("../seguro/conexionBD.php");

    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormulario()
    {
        // Si se ha enviado el formulario...
        if (validaEnviado()) 
        {
            $correcto = true;

            // Nombre
            if (empty($_REQUEST['nombre']))
                $correcto = false;

            // Contraseña
            if (empty($_REQUEST['contraseña'])||(validaContraseña(false,"contraseña") == false))
                $correcto = false;

            // Contraseña (confirmacion)
            if (empty($_REQUEST['contraseñaConf'])||(validaContraseña(false,"contraseñaConf") == false)||(!coincidenContraseñas()))
                $correcto = false;

            // Fecha de Nacimiento
            if (empty($_REQUEST['fecha']))
                $correcto = false;

            // Email
            if (empty($_REQUEST['email']))
                $correcto = false;
            
        }
        // Si no...
        else 
            $correcto = false;
        
        return $correcto;
    }

    // Función que valida que se ha enviado el formulario
    function validaEnviado()
    {
        // Si se ha enviado...
        if (isset($_REQUEST["Enviado"])) 
            $correcto = true;
        else 
            $correcto = false;

        return $correcto;
    }

    // Funcion que valida si está vacío un campo
    function validaSiVacio($campo)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado()) 
        {
            // Si no está vacío
            if (!empty($_REQUEST[$campo])) 
            {
                // Muestro el valor del campo en el input
                echo $_REQUEST[$campo];

                $correcto = true;
            }
            else 
                $correcto = false;

            return $correcto;
        }
    }

    // Funcion que imprime un mensaje de error en el caso de que el campo esté vacío
    function imprimeError($idCampo, $campo, $mensaje)
    {
        // Si se ha enviado el formulario, pero el campo está vacío...
        if (validaEnviado() && empty($_REQUEST[$campo])) 
        {
            // Imprimo un mensaje de error
            ?>
            <label for="<?php echo $idCampo ?>" style="color:red;"><?php echo $mensaje ?></label>
            <?php
        }
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
    function coincidenContraseñas()
    {

        $coincidentes = false;

        if(validaEnviado())
        {
            // Si las contraseñas coinciden...
            if($_REQUEST["contraseña"] == $_REQUEST["contraseñaConf"])
                $coincidentes = true;
            // Si no...
            else
            {
                $coincidentes = false;

                if(strlen($_REQUEST["contraseña"]) > 0)
                {
                    ?>
                    <label for="<?php echo "idPassConf" ?>" style="color:red;"><?php echo "Las contraseñas no coinciden" ?></label>
                    <?php
                }
            }
                
            return $coincidentes;
        }
    }


    // Funcion que modifica un nuevo usuario existente en la BBDD
    function modificarUsuario($usuario,$contraseña,$email,$fechaNacimiento)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada
            $preparada = $conexion->prepare("update usuarios set usuario=?,contraseña=?,email=?,fecha_nacimiento=?,perfil=? where usuario=?");

            $conexion->beginTransaction();

            // Recojo el perfil de dicho usuario (es invariable)
            $arrayUsuario = devuelveDatosUsuario($usuario);
            $perfil = $arrayUsuario["perfil"];;

            $preparada->bindParam(1,$usuario);
            $preparada->bindParam(2,$contraseña);
            $preparada->bindParam(3,$email);
            $preparada->bindParam(4,$fechaNacimiento);
            $preparada->bindParam(5,$perfil);
            $preparada->bindParam(6,$usuario);

            $preparada->execute();

            $conexion->commit();
            $preparada->closeCursor();

        }catch(PDOException $ex)
        {
            // Se deshace la acción
            $conexion->rollBack();
            
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

        // Se vuelve de nuevo a perfil.php
        header("Location: ./perfil.php");        
            
    }


?>