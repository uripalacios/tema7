<?php 

if (isset($_POST['iniciar']))
{
    $todoOk = true;

    // llamamos a valida si vacio y devuelve true o false (implementar)
    if($todoOk)
    {

        // Recojo los datos del formulario
        $user = $_POST["nombre"];
        $pass = $_POST["pass"];

        // Compruebo si se desea recordar el usuario
        if(isset($_REQUEST["check"]))
        {
            // Si está activado...
            if($_REQUEST["check"] == "on")
            {
                
                // Guardo el usuario en una cookie (durará un año)
                setcookie("recordarUsuario",$_REQUEST["nombre"],time()+31536000 ,'/');
            }
        }
        // Si no... borro la cookie de recordar usuario
        else
        {
            setcookie("recordarUsuario",$_REQUEST["nombre"],time() - 100 ,'/');
        }

        // Compruebo si existe el usuario en la BBDD
        $usuario = UsuarioDAO::validaUser($user,$pass);

        // Si existe el usuario...
        if($usuario != null)
        {
            
            echo "todo ok";

            // Guardo los datos del usuario en la sesion
            $_SESSION["validada"] = true;
            $_SESSION["usuario"] = $usuario->id;
            $_SESSION["nombre"] = $usuario->nombre;
            $_SESSION["password"] = $usuario->password;
            $_SESSION["perfil"] = $usuario->perfil;

            // Si el usuario es administrador...
            if($_SESSION["perfil"] == "admin")
            {
                // Voy al sorteo
                $_SESSION["pagina"] = "admin";   
                header("Location: index.php");
                exit();
            }
            // Si es un usuario normal...
            else if($_SESSION["perfil"] == "user")
            {
                // Voy a la apuesta
                $_SESSION["pagina"] = "partido";
                header("Location: index.php");
                exit();
            }

            
        }
        else
        {
            $_SESSION["mensaje"] = "No existe el usuario o contraseña";

            $_SESSION["vista"] = $vistas["login"];
            require_once $vistas["layout"];
        }

    }
}
else
{
    //que sea la primera vez que se entra en login
    $_SESSION['vista'] = $vistas['login'];
    require_once $vistas['layout'];
}
