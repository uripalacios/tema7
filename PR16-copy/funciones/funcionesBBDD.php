<?php

require_once("../seguro/conexionBD.php");

//PR16/funciones/funcionesCookies.php
// Usuarios //

// Funcion que devuelve los datos de un usuario dado en forma de array (accediendo a la BBDD)
function devuelveDatosUsuario($usuario)
{

    // DSN
    $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

    $arrayUsuario = [];

    try
    {

        $conexion = new PDO($dsn,USER,PASS);

        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta
        $sql = "select * from usuarios where usuario = :nombreUsuario" ;

        // Consulta preparada
        $preparada = $conexion->prepare($sql);

        $preparada->bindParam(":nombreUsuario",$usuario);
        
        $preparada->execute();

        // Array que contendrá los datos del usuario en sesión
        $arrayUsuario = $preparada->fetch();

        // Guardo el array en la sesion
        $_SESSION["arrayUsuario"] = $arrayUsuario;

        // Devuelvo el array con los datos del usuario
        return $arrayUsuario;
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

// Productos //

// Funcion que muestra la tabla con todos los productos
function muestraTodosProductos()
{
    require_once("../funciones/validaSesion.php");
    require_once("../funciones/funcionesCookies.php");

    // Compruebo la sesion
    //session_start();
        
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

            // Tabla
            echo "<br><br>";
            echo "<table border='1'>";
            echo "<thead>";

            // Primera Fila
            echo "<th><b>CÓDIGO PRODUCTO</b></th>";
            echo "<th><b>DESCRIPCIÓN</b></th>";
            echo "<th><b>PRECIO</b></th>";
            echo "<th><b>STOCK</b></th>";
            echo "<th><b>COMPRAR</b></th>";
            echo "<th><b>LISTA DE DESEOS</b></th>";

            // Recojo los datos del usuario con la sesión activa
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);
            
            // Si el usuario es administrador (Perfil = 'P_ADMIN')...
            if($arrayUsuario["perfil"] == "P_ADMIN")
            {
                echo "<td><b>STOCK</b></td>";
                echo "<td><b>MODIFICAR</b></td>";
                //echo "<td><b>ELIMINAR</b></td>";
            }

            // Si el usuario es moderador (Perfil = 'P_MODERADOR')...
            if($arrayUsuario["perfil"] == "P_MODERADOR")
            {
                echo "<td><b>STOCK</b></td>";
            }

            echo "</thead>";
            echo "<tr>";

            // Recorro los resultados -> Mientras haya productos...
            while($fila = $resultado->fetch())
            {
                // CODIGO_PRODUCTO
                echo "<td>";
                echo $fila["codigo_producto"];
                echo "</td>";

                // DESCRIPCION
                echo "<td>";
                echo $fila["descripcion"];
                echo "</td>";
                
                // PRECIO
                echo "<td>";
                echo $fila["precio"];
                echo " €</td>";
            
                // STOCK
                echo "<td>";
                echo $fila["stock"];
                echo "</td>";
                
                // Comprar
                echo "<td><a href='comprarProducto.php?cod_p=" . $fila['codigo_producto'] . "'>Comprar</a></td>";

                // Lista de Deseos

                if(compruebaDeseado($fila["codigo_producto"],$arrayUsuario["usuario"]))
                {
                    echo "<td><a href='configurarDeseos.php?cod_p=" . $fila['codigo_producto'] . "&añadir=false&procedencia=productos'><img id='imagenCorazon' title='Quitar producto de la lista de deseos' src='../img/corazonLleno.png'></a></td>";
                }
                else
                    echo "<td><a href='configurarDeseos.php?cod_p=" . $fila['codigo_producto'] . "&añadir=true&procedencia=productos'><img id='imagenCorazon' title='Añadir producto a la lista de deseos' src='../img/corazonVacio.png'></a></td>";

                // Si el usuario es administrador (Perfil = 'P_ADMIN')...
                if($arrayUsuario["perfil"] == "P_ADMIN")
                {
                    // Stock
                    echo "<td><a href='../paginas/añadirProducto.php?cod_p=" . $fila["codigo_producto"] . "'>Stock</a></td>";

                    // Modificar
                    echo "<td><a href='../paginas/modificarProducto.php?cod_p=" . $fila["codigo_producto"] . "'>Modificar</a></td>";
                    
                }

                // Si el usuario es moderador (Perfil = 'P_MODERADOR')...
                if($arrayUsuario["perfil"] == "P_MODERADOR")
                {
                    // Stock
                    echo "<td><a href='../paginas/añadirProducto.php?cod_p=" . $fila["codigo_producto"] . "'>Modificar Stock</a></td>";
                }

                echo "</tr>";
            }

            echo "</tr>";

            // Fin de la tabla        
            echo"</table>";
            echo "<br><br>";

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

/* Albaranes */

// Funcion que muestra la tabla con todos los albaranes
function muestraTodosAlbaranes()
{
    require_once("../funciones/validaSesion.php");
        
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
            $sql = "select * from albaran;";

            $resultado = $conexion->query($sql);

            // Tabla
            echo "<br><br>";
            echo "<table border='1'>";
            echo "<thead>";

            // Primera Fila
            echo "<th><b>ID</b></th>";
            echo "<th><b>FECHA</b></th>";
            echo "<th><b>CÓDIGO DEL PRODUCTO</b></th>";
            echo "<th><b>CANTIDAD</b></th>";
            echo "<th><b>USUARIO</b></th>";

            // Recojo los datos del usuario con la sesión activa
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);
            
            // Si el usuario es administrador (Perfil = 'P_ADMIN')...
            if($arrayUsuario["perfil"] == "P_ADMIN")
            {
                echo "<td><b>MODIFICAR</b></td>";
                echo "<td><b>ELIMINAR</b></td>";
            }

            echo "</thead>";
            echo "<tr>";

            // Recorro los resultados -> Mientras haya productos...
            while($fila = $resultado->fetch())
            {
                // ID
                echo "<td>";
                echo $fila["id_albaran"];
                echo "</td>";

                // FECHA
                echo "<td>";
                echo $fila["fecha"];
                echo "</td>";
                
                // CODIGO DEL PRODUCTO
                echo "<td>";
                echo $fila["cod_producto"];
                echo "</td>";
            
                // CANTIDAD
                echo "<td>";
                echo $fila["cantidad"];
                echo "</td>";

                // USUARIO
                echo "<td>";
                echo $fila["usuario"];
                echo "</td>";

                // Si el usuario es administrador (Perfil = 'P_ADMIN')...
                if($arrayUsuario["perfil"] == "P_ADMIN")
                {

                    // Modificar
                    echo "<td><a href='../paginas/modificarAlbaran.php?id_albaran=" . $fila["id_albaran"] . "'>Modificar</a></td>";
                    
                    // ELiminar
                    echo "<td><a href='eliminarAlbaran.php?id_albaran=" . $fila['id_albaran'] . "'>Eliminar</a></td>";
                }
               
                echo "</tr>";
            }

            echo "</tr>";

            // Fin de la tabla        
            echo"</table>";
            echo "<br><br>";

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

// Ventas //

// Funcion que muestra la tabla con todos los productos
function muestraTodasVentas()
{
    require_once("../funciones/validaSesion.php");
        
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
            $sql = "select * from venta;";

            $resultado = $conexion->query($sql);

            // Tabla
            echo "<br><br>";
            echo "<table border='1'>";
            echo "<thead>";

            // Primera Fila
            echo "<td><b>ID</b></td>";
            echo "<td><b>USUARIO</b></td>";
            echo "<td><b>FECHA</b></td>";
            echo "<td><b>CODIGO PRODUCTO</b></td>";
            echo "<td><b>CANTIDAD</b></td>";
            echo "<td><b>PRECIO TOTAL</b></td>";

            // Recojo los datos del usuario con la sesión activa
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);
            
            // Si el usuario es administrador (Perfil = 'P_ADMIN')...
            if($arrayUsuario["perfil"] == "P_ADMIN")
            {
                echo "<td><b>MODIFICAR</b></td>";
                echo "<td><b>ELIMINAR</b></td>";
            }

            echo "</thead>";
            echo "<tr>";

            // Recorro los resultados -> Mientras haya productos...
            while($fila = $resultado->fetch())
            {
                // ID VENTA
                echo "<td>";
                echo $fila["id_venta"];
                echo "</td>";

                // USUARIO
                echo "<td>";
                echo $fila["usuario"];
                echo "</td>";
                
                // FECHA COMPRA
                echo "<td>";
                echo $fila["fecha_compra"];
                echo "</td>";
            
                // CODIGO DE PRODUCTO
                echo "<td>";
                echo $fila["cod_producto"];
                echo "</td>";

                // CANTIDAD
                echo "<td>";
                echo $fila["cantidad"];
                echo "</td>";

                // PRECIO TOTAL
                echo "<td>";
                echo $fila["precio_total"];
                echo " €</td>";

                // Si el usuario es administrador (Perfil = 'P_ADMIN')...
                if($arrayUsuario["perfil"] == "P_ADMIN")
                {
                    // Modificar
                    echo "<td><a href='../paginas/modificarVenta.php?id_venta=" . $fila["id_venta"] . "'>Modificar</a></td>";
                    
                    // ELiminar
                    echo "<td><a href='eliminarVenta.php?id_venta=" . $fila['id_venta'] . "'>Eliminar</a></td>";
                }
               
                echo "</tr>";
            }

            echo "</tr>";

            // Fin de la tabla        
            echo"</table>";
            echo "<br><br>";

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
/*
// Funcion que comprueba si un producto es deseado por el usuario
function compruebaDeseado($producto,$usuario)
{
    $deseado = false;

    // Si existe la cookie
    if(isset($_COOKIE["deseados" . $usuario]))
    {
        $arrayCookies = $_COOKIE["deseados" . $usuario];

        foreach ($arrayCookies as $codigoProducto) {
            
            if($producto == $codigoProducto)
                $deseado = true;
        }
    }

    return $deseado;
}
*/

?>