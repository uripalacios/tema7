<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="./webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>
    
    <h1>Registrarse</h1>

    <?php

        // Importo los ficheros
        require_once("./funciones/funcionesValidarRegistro.php");

        // Se validan los datos del formulario //
        // Si se selecciona 'Registrar Usuario'...
        if(isset($_REQUEST["Enviado"]))
        {
            if($_REQUEST["Enviado"] == "Registrar Usuario")
            {
                if(validaFormulario())
                {
                     // Se inserta el nuevo usuario en la BBDD
                    insertarUsuario($_REQUEST["nombre"],$_REQUEST["contraseña"],$_REQUEST["email"],$_REQUEST["fecha"]);
                }
            }
        }

    ?>

    <!-- Formulario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="formulario" id="idFormulario"  enctype="multipart/form-data">

            <!-- Nombre - Alfabetico -->
            <section>
                <label for="idNombre">Nombre:</label>

                <input type="text" name="nombre" id="idNombre" size="40" placeholder="Nombre" value="<?php
                        // Si no está vacío, se guarda el texto introducido
                        validaSiVacio('nombre');
                    ?>">

                    <?php
                        // En caso de que esté vacío, se muestra un error
                        imprimeError("idNombre",'nombre',"Debe introducir un nombre");

                        // Valida el nombre de usuario mediante un patrón
                        validaNombreUsuario(true);
                    ?>
            </section>

            <!-- Contraseña - Input de Password -->
            <section>
                <label for="idPass">Contraseña:</label>

                <input type="password" name="contraseña" id="idPass" placeholder="Contraseña" value="<?php

                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('contraseña');
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

                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('contraseñaConf');
                
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

                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('email');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idEmail",'email',"Debe introducir un email");

                    // Valida el email mediante un patrón
                    //validaEmail(true);
                ?>
            </section>

            <!-- Fecha de Nacimiento -->
            <section>
                <label for="idFecha">Fecha de Nacimiento:</label>
                <input type="date" name="fecha" id="idfecha" size="40" value="<?php

                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('fecha');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idFecha",'fecha',"Debe introducir una fecha");

                    // Valida la fecha mediante un patrón
                    //validaFecha(true);
                ?>
            </section>
            <hr>

            <!-- Input de tipo Submit -->
            <!-- Se le pone el atributo name para evitar ataques -->
            <input type="submit" value="Registrar Usuario" name="Enviado">

        </form>
    </div>
   
    <!-- Volver a 'login.php' -->
    <br>
    <a href="./login.php" title="Volver a la página de Login">Volver al Login</a>
</body>
</html>