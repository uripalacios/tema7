<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>
    
    <h1>Ventas</h1>
    
    <?php
        // Importaciones //
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/validaSesion.php");
        
        // Compruebo la sesion
        session_start();
        
        // Se valida la sesion
        if(!validaSesion())
        {
            header("Location: ./error/403.php");
        }
        else
        {
            // Recojo los datos del usuario
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);
            
            // Se valida el usuario
            if(($_SESSION["arrayUsuario"][4] == "P_ADMIN")||($_SESSION["arrayUsuario"][4] == "P_MODERADOR"))
            {
                // Se muestra una tabla con todas las ventas
                muestraTodasVentas();
            }
            else
            {
                header("Location: ./error/403.php");
            }
        }
    ?>

    <a href="./menu.php">Volver a Menú</a>
</body>
</html>