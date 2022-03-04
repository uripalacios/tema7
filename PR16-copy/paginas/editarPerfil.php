<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <?php

        // Importaciones //
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/funcionesValidarPerfil.php");

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

            // Si se selecciona 'Guardar Cambios'...
            if(isset($_REQUEST["Enviado"]))
            {
                if($_REQUEST["Enviado"] == "Guardar Cambios")
                {
                    if(validaFormulario())
                    {
                        // Guardo los cambios del usuario en la BBDD
                        modificarUsuario($arrayUsuario["usuario"],$_REQUEST["contraseña"],$_REQUEST["email"],$_REQUEST["fecha"]);
                    }
                }
            }
        }

    ?>

    <!-- Título del Perfil -->
    <h1>Editar Perfil de <?php echo $_SESSION["usuario"];?></h1>
    
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

                <input type="password" name="contraseña" id="idPass" placeholder="Contraseña" value="<?php

                    echo $arrayUsuario["contraseña"];

                    // Si no está vacío, se guarda el texto introducido
                    //validaSiVacio('contraseña');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idPass",'contraseña',"Debe introducir una contraseña");

                    // Valida la contraseña mediante un patrón
                    validaContraseña(true,"contraseña");
                ?>
            </section>

            <!-- Contraseña (Confirmacion) - Input de Password -->
            <section>
                <label for="idPass">Confirmación de Contraseña:</label>
                <input type="password" name="contraseñaConf" id="idPassConf" placeholder="Confirme su Contraseña" value="<?php

                    echo $arrayUsuario["contraseña"];

                    // Si no está vacío, se guarda el texto introducido
                    //validaSiVacio('contraseñaConf');
                
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idPassConf",'contraseñaConf',"Debe introducir una contraseña");

                    // Valida la contraseña mediante un patrón
                    validaContraseña(true,"contraseñaConf");

                    // Comprueba que ambas contraseñas coinciden
                    coincidenContraseñas();
                ?>
            </section>

            <!-- E-mail  -->
            <section>
                <label for="idEmail">E-mail:</label>
                <input type="email" name="email" id="idEmail" size="40" placeholder="E-mail" value="<?php

                    echo $arrayUsuario["email"];

                    // Si no está vacío, se guarda el texto introducido
                    //validaSiVacio('email');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idEmail",'email',"Debe introducir un email");
                ?>
            </section>

            <!-- Fecha de Nacimiento -->
            <section>
                <label for="idFecha">Fecha de Nacimiento:</label>
                <input type="date" name="fecha" id="idfecha" size="40" value="<?php

                    echo $arrayUsuario["fecha_nacimiento"];

                    // Si no está vacío, se guarda el texto introducido
                    //validaSiVacio('fecha');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idFecha",'fecha',"Debe introducir una fecha");
                ?>
            </section>
            <br>

            <!-- Editar Perfil - Input de tipo Submit -->
            <input type="submit" value="Guardar Cambios" name="Enviado">

        </form>
    </div>

    <!-- Volver al Menú -->
    <br>
    <a href="./perfil.php">Volver al Perfil</a>
</body>
</html>