<?php
    
    // Funcion que comprueba si un producto es deseado por el usuario
    function compruebaDeseado($producto,$usuario)
    {
        $deseado = false;

        //$arrayCookies = $_COOKIE["deseados" . $usuario];

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

    // Funcion que muestra los ultimos productos visitados
    function mostrarUltimosVisitados($usuario)
    {
        $arrayVisitados = array();

        // Si existe la cookie
        if(isset($_COOKIE["visitado" . $usuario]))
        {
            // Recojo el array de cookies que contiene los ultimos productos visitados
            $arrayCookie = $_COOKIE["visitado" . $usuario];

            // Los introduzco en el array
            foreach ($arrayCookie as $key => $value) 
            {    
                $producto = ProductoDAO::findById($value);
                array_push($arrayVisitados,$producto->codigo_producto);
            }
            
            // Recorro el array y muestro los últimos productos visitados (su descripcion)
            foreach ($arrayVisitados as $codP) 
            {
                $p = ProductoDAO::findById($codP);
                
                echo $p->descripcion;
                echo "<br>";
            }
            

        }
    }

    // Funcion que comprueba si un producto se ha visitado
    function comprobarUltimasVisitas($codProducto,$usuario)
    {
        //$codProducto = $_REQUEST["cod_p"];
        
        // Si no hay ninguna cookie...
        if(!isset($_COOKIE["visitado" . $usuario]))
        {
            //Cuando quiero que sea un array
            setcookie("visitado" . $usuario . "[0]",$codProducto,time()+2592000,'/');
        }
        else
        {
            // Array que contiene las ultimas visitas de productos (array de cookies)
            $arrayCookie = $_COOKIE["visitado" . $usuario];

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
                        setcookie("visitado" . $usuario . "[" . $key . "]",$value,time()+2592000,'/');
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
                        setcookie("visitado" . $usuario . "[" . $key . "]",$value,time()+2592000,'/');
                    }

                }
            }
        }
    }
?>