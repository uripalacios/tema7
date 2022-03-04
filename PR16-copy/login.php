<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="./webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Login</h1>

    <?php
        // Importaciones
        require_once("./funciones/validaSesion.php");

        // Llama a verificar sesión
        session_start();

        // Si la sesion está activa...
        if(validaSesion())
        {
            // Se accede directamente al menú de la aplicación
            header("Location: ./paginas/menu.php");
        }

        // Si se ha enviado el formulario...
        if(sizeof($_REQUEST) > 0)
        {
            // Si se selecciona 'Iniciar Sesión'...
            if(isset($_REQUEST["valida"]))
            {
                if($_REQUEST['valida'] == "Iniciar Sesión")
                {
                    
                    // Compruebo si se desea recordar el usuario
                    if(isset($_REQUEST["check"]))
                    {
                        // Si está activado...
                        if($_REQUEST["check"] == "on")
                        {
                            
                            // Guardo el usuario en una cookie (durará un año)
                            setcookie("recordarUsuario",$_REQUEST["user"],time()+31536000 ,'/');
                        }
                    }
                    // Si no... borro la cookie de recordar usuario
                    else
                    {
                        setcookie("recordarUsuario",$_REQUEST["user"],time() - 100 ,'/');
                    }
                    
                    // Accedo a 'valida' y compruebo las credenciales
                    header("Location: ./funciones/valida.php?user=" . $_REQUEST["user"] . "&pass=" . $_REQUEST["pass"]);   
                }
            }
            // Si se selecciona 'Registrarse'...
            else if(isset($_REQUEST["registrar"]))
            {
                if($_REQUEST['registrar'] == "Registrarse")
                    header("Location: ./registro.php");   
            }
        }
        
    ?>

    <!-- Formulario de Login del Usuario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

            <!-- Usuario -->
            <section>
                <label for="user">Usuario:</label>
                <input type="text" name="user" id="user" placeholder="Nombre de usuario" value="<?php 
                
                    // Si se quiere recordar el usuario...
                    if(isset($_COOKIE["recordarUsuario"]))
                        echo $_COOKIE["recordarUsuario"];
                ?>">
            </section>

            <!-- Contraseña -->
            <section>
                <label for="pass">Contraseña:</label>
                <input type="password" name="pass" id="pass" placeholder="Contraseña">
            </section>

            <!-- Recordar usuario -->
            <section>
                <label for="check">Recordar Usuario</label>
                <input type="checkbox" name="check" id="check" <?php 
                
                    // Si esxiste la cookie... recuerdo el check
                    if(isset($_COOKIE["recordarUsuario"]))
                        echo "checked";
                    
                ?>>
            </section>

            <hr>

            <input type="submit" value="Iniciar Sesión" name="valida" title="Iniciar sesión">
            <input type="submit" value="Registrarse" name="registrar" title="Registrar un nuevo usuario">
            
        </form>
    </div>

    <!-- Volver a la Página de Inicio -->
    <br><a href="./index.php" title="Volver a la página de Inicio">Volver a Inicio</a>
</body>
</html>