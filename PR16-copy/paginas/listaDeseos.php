<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">
</head>
<body>
    
    <h1>Lista de deseos</h1>

    <?php

        // Importaciones
        require_once("../funciones/funcionesCookies.php");
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/validaSesion.php");
        
        session_start();

        // Se valida la sesion
        if(validaSesion())
        {
            muestraTodosDeseados();
        }
        else
        {
            
        }
    ?>

    <!-- Volver al Menú -->
    <br>
    <a href="./menu.php">Volver al Menú</a>
</body>
</html>