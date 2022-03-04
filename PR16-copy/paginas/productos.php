<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>
    
    <h1>Productos</h1>

    <?php

        // Importaciones //
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/validaSesion.php");
        
        session_start();

        // Se valida la sesion
        if(validaSesion())
        {
            
            // Se muestra la tabla con todos los productos
            muestraTodosProductos();
            
            // Recojo los datos del usuario con la sesión activa
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);
            
            // Si el usuario es administrador (Perfil = 'P_ADMIN')...
            if($arrayUsuario["perfil"] == "P_ADMIN")
            {
                // Le permito el acceso a 'crearProducto.php'
                echo "<a href='./crearProducto.php'>Crear nuevo producto</a>";
            }
        }
        else
        {
            header("Location: ./error/403.php");
        }
    ?>

        <a href="#">|</a>
        <a href="./menu.php">Volver a Menú</a>
</body>
</html>