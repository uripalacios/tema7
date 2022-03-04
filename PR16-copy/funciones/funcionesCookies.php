<?php

    // Funcion que comprueba si un producto se ha visitado
    function comprobarUltimasVisitas($codProducto,$arrayUsuario)
    {
        //$codProducto = $_REQUEST["cod_p"];
        
        // Si no hay ninguna cookie...
        if(!isset($_COOKIE["visitado" . $arrayUsuario["usuario"]]))
        {
            //Cuando quiero que sea un array
            setcookie("visitado" . $arrayUsuario["usuario"] . "[0]",$codProducto,time()+2592000,'/');
        }
        else
        {
            // Array que contiene las ultimas visitas de productos (array de cookies)
            $arrayCookie = $_COOKIE["visitado" . $arrayUsuario["usuario"]];

            // Longitud del array
            $numero = count($arrayCookie);

            // Si dicho producto no esta en el array...
            if(!in_array($codProducto,$arrayCookie))
            {
                // Si hay menos del máximo permitido...
                if($numero < 4)
                {
                    // Las ordeno poniendo el primero el ultimo codigo
                    array_unshift($arrayCookie,$codProducto);

                    // Las añado
                    foreach ($arrayCookie as $key => $value) 
                    {
                        setcookie("visitado" . $arrayUsuario["usuario"] . "[" . $key . "]",$value,time()+2592000,'/');
                    }

                }
                else
                {
                    // Las ordeno poniendo el primero el ultimo codigo
                    array_unshift($arrayCookie,$codProducto);

                    // Quito la última cookie
                    array_pop($arrayCookie);

                    // Las añado
                    foreach ($arrayCookie as $key => $value) 
                    {
                        setcookie("visitado" . $arrayUsuario["usuario"] . "[" . $key . "]",$value,time()+2592000,'/');
                    }

                }
            }
        }
    }

    // Funcion que muestra los ultimos productos visitados
    function mostrarUltimosVisitados($arrayUsuario)
    {
        $arrayVisitados = array();

        // Si existe la cookie
        if(isset($_COOKIE["visitado" . $arrayUsuario["usuario"]]))
        {
            // Recojo el array de cookies que contiene los ultimos productos visitados
            $arrayCookie = $_COOKIE["visitado" . $arrayUsuario["usuario"]];

            // Los introduzco en el array
            foreach ($arrayCookie as $key => $value) 
            {    
                $datosProducto = devuelveDatosProducto(($value));
                array_push($arrayVisitados,$datosProducto[0]);
            }
            
            // Recorro el array y muestro los enlaces a los productos
            foreach ($arrayVisitados as $producto) 
            {
                $datosProducto = devuelveDatosProducto(($producto));
                echo  "<a href='comprarProducto.php?cod_p=" . $producto . "'>" . $datosProducto["descripcion"] . "</a><br>";
            }

        }
    }

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

    // Funcion que añade o elimina un producto de la lista de deseos
    function configurarDeseos($codigoProducto,$añadir,$arrayUsuario)
    {

        // Si no hay ninguna cookie...
        if(!isset($_COOKIE["deseados" . $arrayUsuario["usuario"]]))
        {
            // Si se quiere añadir...
            if($añadir == "true")
            {
                //Cuando quiero que sea un array
                setcookie("deseados" . $arrayUsuario["usuario"] . "[0]",$codigoProducto,time()+31536000,'/');
            }
        }
        else
        {
            // Si se va a añadir...
            // Array de cookies deseadas por el usuario
            $cookiesDeseados = $_COOKIE["deseados" . $arrayUsuario["usuario"]];

            if($añadir == "true")
            {
                // Añado la cookie al array
                array_push($cookiesDeseados,$codigoProducto);

                foreach ($cookiesDeseados as $key => $value) 
                {
                    setcookie("deseados" . $arrayUsuario["usuario"] . "[" . $key . "]",$value,time()+31536000,'/');
                }
                
            }
            // Si se va a quitar...
            else if($añadir == "false")
            {
                // Quito la cookie de este producto
                foreach ($cookiesDeseados as $key => $value) 
                {
                    // Si el codigo del producto coincide con este valor... la elimino
                    if($value == $codigoProducto)
                        setcookie("deseados" . $arrayUsuario["usuario"] . "[" . $key . "]",$value,time() -100,'/');
                        
                }

            }

        }
    }

    // Funcion que muestra la lista de productos 'deseados' por el usuario
    function muestraTodosDeseados()
    {
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesCookies.php");
            
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
                    if(compruebaDeseado($fila["codigo_producto"],$arrayUsuario["usuario"]))
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
                            echo "<td><a href='configurarDeseos.php?cod_p=" . $fila['codigo_producto'] . "&añadir=false&procedencia=listaDeseos'><img id='imagenCorazon' title='Quitar producto de la lista de deseos' src='../img/corazonLleno.png'></a></td>";
                        else
                            echo "<td><a href='configurarDeseos.php?cod_p=" . $fila['codigo_producto'] . "&añadir=true&procedencia=listaDeseos'><img id='imagenCorazon' title='Añadir producto a la lista de deseos' src='../img/corazonVacio.png'></a></td>";
        
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

?>