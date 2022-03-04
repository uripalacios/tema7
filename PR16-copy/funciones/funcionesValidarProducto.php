<?php

    // Importaciones //
    require_once("../seguro/conexionBD.php");
    //require_once("./funcionesCookies.php");

    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormulario($creando)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado()) 
        {
            $correcto = true;

            // Codigo
            if($creando)
                if (empty($_REQUEST['codigo'])||(!validaCodigoProducto(false)))
                    $correcto = false;
            else
                if (empty($_REQUEST['codigo']))
                        $correcto = false;

            // Descripcion
            if (empty($_REQUEST['descripcion']))
                $correcto = false;

            // Precio
            if (empty($_REQUEST['precio']))
                $correcto = false;

            // Stock
            if (empty($_REQUEST['stock']))
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

    // Funcion que modifica un producto existente en la BBDD
    function modificarProducto($codigo,$descripcion,$precio,$stock,$añadiendo)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recojo los datos del producto antes de ser modificado
            $productoPrevio = devuelveDatosProducto($codigo);

            // Consulta preparada
            $preparada = $conexion->prepare("update productos set codigo_producto=?,descripcion=?,precio=?,stock=? where codigo_producto=?");

            $conexion->beginTransaction();

            $preparada->bindParam(1,$codigo);
            $preparada->bindParam(2,$descripcion);
            $preparada->bindParam(3,$precio);
            $preparada->bindParam(4,$stock);
            $preparada->bindParam(5,$codigo);

            $preparada->execute();

            // En el caso de que se esté añadiendo el stock de un producto
            if($añadiendo)
            {
                // Se genera un albaran (en la BBDD)

                // Datos de la tabla 'albaran' //
                // Fecha //
                $fecha = date('Y-m-d');
                
                // Codigo del producto //
                $codigoProducto = $productoPrevio[0];
                
                // Cantidad (diferencia de Stock) //
                // Recojo el stock previo a su modificacion
                $stockPrevio = $productoPrevio[3];
                $cantidad = $stock - $stockPrevio;

                // Usuario //
                $usuario = $_SESSION["arrayUsuario"][0];

                // Consulta preparada
                $preparada = $conexion->prepare("insert into albaran (id_albaran,fecha,cod_producto,cantidad,usuario) values (0,?,?,?,?);");

                $preparada->bindParam(1,$fecha);
                $preparada->bindParam(2,$codigoProducto);
                $preparada->bindParam(3,$cantidad);
                $preparada->bindParam(4,$usuario);

                $preparada->execute();

            }

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

        // Se vuelve de nuevo a productos.php
        header("Location: ./productos.php");        
            
    }

    // Funcion que valida si se ha incrementado el stock respecto a su valor previo
    function validaStock($validando)
    {
        $correcto = true;

        if(isset($_REQUEST["stock"]))
        {
            // Si no se ha incrementado el valor del stock...
            if($_SESSION["arrayProducto"][3] >= $_REQUEST["stock"])
            {
                $correcto = false;

                // Si estoy validando, muestro el mensaje de error...
                if($validando)
                {
                    ?>
                    <label for="<?php echo "idStock" ?>" style="color:red;"><?php echo "El stock debe ser superior o igual a " . ($_SESSION["arrayProducto"][3] + 1); ?></label>
                    <?php
                }
            }
        }

        return $correcto;
        
    }

    // Funcion que crea un nuevo producto en la BBDD
    function crearProducto($codigo,$descripcion,$precio,$stock)
    {   
        // Configuración de la conexión (dsn)
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {
            // Conexión
            $conexion = new PDO($dsn,USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta preparada
            $preparada = $conexion->prepare("insert into productos (codigo_producto,descripcion,precio,stock) values (?,?,?,?);");

            $conexion->beginTransaction();

            $preparada->bindParam(1,$codigo);
            $preparada->bindParam(2,$descripcion);
            $preparada->bindParam(3,$precio);
            $preparada->bindParam(4,$stock);

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

        // Se vuelve de nuevo a productos.php
        header("Location: ./productos.php");        
            
    }

    // Funcion que valida si el código del producto es único
    function validaCodigoProducto($validando)
    {
                
        $correcto = true;

        // Se valida la sesion
        if(validaSesion())
        {
            // DSN
            $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

            try
            {
                $conexion = new PDO($dsn,USER,PASS);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta
                $sql = "select * from productos;";
                $resultado = $conexion->query($sql);

                // Recorro los resultados -> Mientras haya productos...
                while($fila = $resultado->fetch())
                {
                    if(isset($_REQUEST["codigo"]))
                    {
                        // Si el codigo de este producto coincide con el que se quiere crear
                        if($_REQUEST["codigo"] == $fila["codigo_producto"])
                        {
                            $correcto = false;

                            if($validando)
                            {
                                imprimeError("idCodigo","codigo","El codigo del producto introducido ya existe");

                                ?>
                                <label for="<?php echo "idCodigo" ?>" style="color:red;"><?php echo "El codigo del producto introducido ya existe" ?></label>
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
        else
        {
            // Se vuelve al login.php
            header("Location: ../login.php");
        }
    }

    // Funcion que devuelve los datos de un producto dado en forma de array (accediendo a la BBDD)
    function devuelveDatosProducto($codigoProducto)
    {

        // DSN
        $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

        try
        {

            $conexion = new PDO($dsn,USER,PASS);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta
            $sql = "select * from productos where codigo_producto = :codigoProducto" ;

            // Consulta preparada
            $preparada = $conexion->prepare($sql);

            $preparada->bindParam(":codigoProducto",$codigoProducto);
            
            $preparada->execute();

            // Array que contendrá los datos del producto en sesión
            $arrayProducto = $preparada->fetch();

            // Devuelvo el array con los datos del producto
            return $arrayProducto;
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