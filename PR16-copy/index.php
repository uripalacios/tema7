<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="./webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>

<body>

    <h1>PR16 - Ismael Maestre</h1>

    <h2>Pagina Principal Tienda</h2>
    <br>
    
    <!-- PHP -->
    <?php

    // Importo los ficheros
    require_once("./seguro/conexionBD.php");

    // Si al acceder no existe la BBDD, se crea y se insertan datos //
    $dsn = "mysql:host=" . HOST . ";dbname=" . BBDD;

    try
    {
        $conexion = new PDO($dsn, USER, PASS);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $ex) 
    {
        $numError = $ex->getCode();

        // Error al no reconocer la BBDD
        if ($numError == 1049) 
        {
            // Se crea la BBDD y se introducen datos por defecto
            header("Location: ./seguro/crearBD.php");
        }
        // Error al conectar con el servidor...
        else if ($numError == 2002) {
            echo "<br>Error: Error al conectar con el servidor.<br>";
        }
        // Error de autenticación...
        else if($numError == 1045)
        {
            echo "<br>Error: Error en la autenticación.<br>";
        }
    } finally {
        // Cierro la conexion
        unset($conexion);
    }

    ?>

    <!-- Login -->
    <a href="./login.php" title="Acceso al Login de Usuario">Acceso al Login</a>

</body>

</html>