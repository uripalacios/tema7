<?php

    // Importaciones //
    require_once("../seguro/conexionBD.php");

    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormulario($creando)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado()) 
        {
            $correcto = true;

            // Cantidad
            if (empty($_REQUEST['cantidad'])||(!validaCantidad(false)))
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

    // Funcion que modifica el stock de producto (tras comprarlo)
    function compraProducto($codigo,$descripcion,$precio,$cantidad)
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

            // Nuevo stock //
            $cantidadFinal = $productoPrevio[3] - $cantidad;

            // Consulta preparada
            $preparada = $conexion->prepare("update productos set codigo_producto=?,descripcion=?,precio=?,stock=? where codigo_producto=?");

            //
            $conexion->beginTransaction();

            $preparada->bindParam(1,$codigo);
            $preparada->bindParam(2,$descripcion);
            $preparada->bindParam(3,$precio);
            $preparada->bindParam(4,$cantidadFinal);
            $preparada->bindParam(5,$codigo);

            $preparada->execute();

            // Se genera la línea de Venta //
            // Datos de la tabla 'venta' //
            // Usuario //
            $usuario = $_SESSION["arrayUsuario"][0];

            // Fecha //
            $fecha = date('Y-m-d');

            // Codigo del producto //
            $codigoProducto = $_SESSION["arrayProducto"][0];

            // Cantidad //
            $cantidad = $_REQUEST["cantidad"];

            // Precio total (€) //
            $precioTotal = ($_SESSION["arrayProducto"][2] * $cantidad);

            // Consulta preparada
            $preparada = $conexion->prepare("insert into venta (id_venta,usuario,fecha_compra,cod_producto,cantidad,precio_Total) values (0,?,?,?,?,?);");

            $preparada->bindParam(1,$usuario);
            $preparada->bindParam(2,$fecha);
            $preparada->bindParam(3,$codigoProducto);
            $preparada->bindParam(4,$cantidad);
            $preparada->bindParam(5,$precioTotal);

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

    // Funcion que comprueba si hay la suficiente cantidad de stock para comprar
    function validaCantidad($validando)
    {
        $correcto = true;

        if(isset($_REQUEST["cantidad"]))
        {
            // Si se quiere comprar una cantidad mayor a la existente...
            if($_SESSION["arrayProducto"][3] < $_REQUEST["cantidad"])
            {
                $correcto = false;

                // Si estoy validando, muestro el mensaje de error...
                if($validando)
                {
                    ?>
                    <label for="<?php echo "idStock" ?>" style="color:red;"><?php echo "Puede comprar como máximo " . ($_SESSION["arrayProducto"][3]) . " unidades."; ?></label>
                    <?php
                }
            }
        }

        return $correcto;
        
    }

?>