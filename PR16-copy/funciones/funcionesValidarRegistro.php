<?php

    // Importaciones //
    require_once("./seguro/conexionBD.php");
    //require_once("./valida.php");

    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormulario()
    {

        // Si se ha enviado el formulario...
        if (validaEnviado()) 
        {
            $correcto = true;

            // Nombre
            if (empty($_REQUEST['nombre'])||(!validaNombreUsuario(false)))
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

    // Función que muestra los datos del formulario
    function muestraDatosFormulario()
    {
        // Nombre
        if (!empty($_REQUEST['nombre']))
            echo "El nombre es: <b>" . $_REQUEST["nombre"] . "</b><br>";

        // Contraseña
        if (!empty($_REQUEST['contraseña']))
            echo "La contraseña es: <b>" . $_REQUEST["contraseña"] . "</b><br>";

        // Contraseña (confirmacion)
        if (!empty($_REQUEST['contraseñaConf']))
            echo "La contraseña (confirmada) es: <b>" . $_REQUEST["contraseñaConf"] . "</b><br>";
            
        // Email
        if (!empty($_REQUEST['email']))
            echo "El email es: <b>" . $_REQUEST["email"] . "</b><br>";

        // Fecha de nacimiento
        if (!empty($_REQUEST['fecha']))
            echo "La fecha de nacimiento es: <b>" . $_REQUEST["fecha"] . "</b><br>";

    }

    // Funcion que valida la contraseña del usuario con un patrón
    function validaContraseña($validando,$campo)
    {
        /* // Patrón que valida la contraseña
            - Mínimo 8 carácteres, máximo 20
            -Al final: una mayúscula, una minúscula y un número */
        $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$/";
        
        $patron2 = "/^[A-Za-z09]{5,}[A-Z]{1,}[a-z][\d]$/";

        //"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"
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

    // Funcion que inserta (registra) un nuevo usuario la BBDD
    function insertarUsuario($usuario,$contraseña,$email,$fechaNacimiento)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada
            $preparada = $conexion->prepare("insert into usuarios (usuario,contraseña,email,fecha_nacimiento,perfil) values (?,?,?,?,?);");

            $conexion->beginTransaction();

            // El perfil de los usuario creados manualmente será, por defecto, Normal (P_NORMAL)
            $perfil = "P_NORMAL";

            $preparada->bindParam(1,$usuario);
            $preparada->bindParam(2,$contraseña);
            $preparada->bindParam(3,$email);
            $preparada->bindParam(4,$fechaNacimiento);
            $preparada->bindParam(5,$perfil);

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

        // Se vuelve de nuevo a login.php
        header("Location: login.php");        
            
    }

    // Funcion que valida si el nombre del usuario es único
    function validaNombreUsuario($validando)
    {
                
        $correcto = true;

        // DSN
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

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