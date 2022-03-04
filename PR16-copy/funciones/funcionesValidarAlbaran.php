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

            // ID
            if (empty($_REQUEST['id']))
                $correcto = false;
        
            // Fecha
            if (empty($_REQUEST['fecha']))
                $correcto = false;

            // Codigo
            if (empty($_REQUEST['codProducto']))
                $correcto = false;

            // Cantidad
            if (empty($_REQUEST['cantidad']))
                $correcto = false;

            // Usuario
            if (empty($_REQUEST['usuario']))
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

    // Funcion que modifica un albaran existente en la BBDD
    function modificarAlbaran($id,$fecha,$codigoProducto,$cantidad,$usuario)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada
            $preparada = $conexion->prepare("update albaran set id_albaran=?,fecha=?,cod_producto=?,cantidad=?,usuario=? where id_albaran=?");

            $conexion->beginTransaction();

            $preparada->bindParam(1,$id);
            $preparada->bindParam(2,$fecha);
            $preparada->bindParam(3,$codigoProducto);
            $preparada->bindParam(4,$cantidad);
            $preparada->bindParam(5,$usuario);
            $preparada->bindParam(6,$id);

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

        // Se vuelve de nuevo a albaranes.php
        header("Location: ./albaranes.php");        
            
    }

    // Funcion que elimina un albaran existente de la BBDD
    function eliminarAlbaran($id)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada
            $preparada = $conexion->prepare("delete from albaran where id_albaran=?;");
            $conexion->beginTransaction();

            $preparada->bindParam(1,$id);

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
            
    }

    // Funcion que devuelve los datos de un producto dado en forma de array (accediendo a la BBDD)
    function devuelveDatosAlbaran($idAlbaran)
    {

        // DSN
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {

            $conexion = new PDO($dsn,USER,PASS);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta
            $sql = "select * from albaran where id_albaran = :idAlbaran" ;

            // Consulta preparada
            $preparada = $conexion->prepare($sql);

            $preparada->bindParam(":idAlbaran",$idAlbaran);
            
            $preparada->execute();

            // Array que contendrá los datos del albarán en sesión
            $arrayAlbaran = $preparada->fetch();

            // Devuelvo el array con los datos del producto
            return $arrayAlbaran;
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