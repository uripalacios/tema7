<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Deseos</title>
</head>
<body>

    <?php

        // Importaciones
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesCookies.php");

        // Compruebo la sesion
        session_start();
        
        // Se valida la sesion
        if(!validaSesion())
        {
            header("Location: ../login.php");
        }
        else
        {

            // Recojo los datos del usuario
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);

            // Si se han pasado tanto el codigo del producto como la opcion a realizar...
            if(isset($_REQUEST["cod_p"])&&(isset($_REQUEST["añadir"])&&(isset($_REQUEST["procedencia"]))))
            {

                // Recojo el producto y el usuario a tratar
                $codigoProducto = $_REQUEST["cod_p"];
                $añadir = $_REQUEST["añadir"];
                $procedencia = $_REQUEST["procedencia"];

                // Se añade o se quita el producto de la lista de deseos
                configurarDeseos($codigoProducto,$añadir,$arrayUsuario);

                if($procedencia == "productos")
                {
                    // Se vuelve a la lista de productos
                    header("Location: ./productos.php");
                }
                else if($procedencia == "listaDeseos")
                {
                    // Se vuelve a la lista de deseos
                    header("Location: ./listaDeseos.php");
                }

            }

            
        }

        
    ?>

</body>
</html>