<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <?php

        // Importaciones //
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesBBDD.php");

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

            // Si se selecciona editar el perfil...
            if(isset($_REQUEST["Enviado"]))
            {
                // Accedo a editarPerfil.php
                header("Location: editarPerfil.php");
            }
        }

    ?>

    <!-- Título del Perfil -->
    <h1>Perfil de <?php echo $_SESSION["usuario"];?></h1>
    
    <!-- Datos del Usuario -->
    <!-- Formulario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="formulario" id="idFormulario"  enctype="multipart/form-data">
            
            <!-- Nombre - Alfabetico -->
            <section>
                <label for="idNombre">Nombre:</label>

                <input type="text" name="nombre" id="idNombre" size="40" placeholder="Nombre" readonly value="<?php  
                        echo $arrayUsuario["usuario"];
                    ?>">
            </section>

            <!-- Contraseña - Input de Password -->
            <section>
                <label for="idPass">Contraseña:</label>

                <input type="password" name="contraseña" id="idPass" placeholder="Contraseña" readonly value="<?php

                    echo $arrayUsuario["contraseña"];
                ?>">
            </section>

            <!-- E-mail  -->
            <section>
                <label for="idEmail">E-mail:</label>
                <input type="email" name="email" id="idEmail" size="40" placeholder="E-mail" readonly value="<?php

                    echo $arrayUsuario["email"];
                ?>">
            </section>

            <!-- Fecha de Nacimiento -->
            <section>
                <label for="idFecha">Fecha de Nacimiento:</label>
                <input type="date" name="fecha" id="idfecha" size="40" readonly value="<?php

                    echo $arrayUsuario["fecha_nacimiento"];
                ?>">
            </section>
            <br>

            <!-- Editar Perfil - Input de tipo Submit -->
            <input type="submit" value="Editar Perfil" name="Enviado">
            
        </form>
    </div>

    <!-- Volver al Menú -->
    <br>
    <a href="./menu.php">Volver al Menú</a>
</body>
</html>