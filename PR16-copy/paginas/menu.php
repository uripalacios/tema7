<?php
    require_once("../funciones/validaSesion.php");
    require_once("../funciones/funcionesBBDD.php");
    require_once("../funciones/funcionesValidarProducto.php");
    require_once("../funciones/funcionesCookies.php");

    // Aquí se deberñia comprobar si hay sesion
    session_start();
    
    // Se valida la sesion
    if(!validaSesion())
    {
        header("Location: ../login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">
    <link rel="stylesheet" href="../webroot/css/menuStyle.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>
    
    <header>
        <h1>Menú</h1>

        <!-- Usuario actual, Perfil del usuario y cierre de sesión -->
        <div id="divUsuario" style="position: relative;float:right;margin:20px;">
                <?php
                    echo "Usuario: <b>" . $_SESSION["usuario"] . "</b>";
                ?>
                <br>
                <a href="./perfil.php">Perfil</a>
                <a href="#">|</a>
                <a href="../logout.php">Log out</a>
        </div>
    </header>
        
    <!-- Páginas disponibles para este usuario -->
    <nav class="menu">
        <ul class="listaPrincipal">
            <?php
                // Imprimo los enlaces a las páginas a las que puede acceder este usuario 
                foreach ($_SESSION["paginas"] as $key => $value) 
                {
                    echo "<li>";
                    echo "<a href='./". $value . "'>" . $key . "</a><br>";
                    echo "</li>";
                }
            ?>
        </ul>
    </nav>
    
    <!-- Ultimos productos visitados -->
    <br><br>
    <div id="idUltimosProductos">
        
        <h2>Últimos productos visitados</h2>
        <?php 

            // Recojo los datos del usuario
            $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);

            // Muestro los ultimos productos visitados
            mostrarUltimosVisitados($arrayUsuario);

        ?>
    </div>

</body>
</html>