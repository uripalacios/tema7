<?php 

//si se ha pulsado el registro
if(isset($_POST['registro']))
{
    $_SESSION['pagina'] = 'registro';
    header('Location: index.php');
    exit();
}
// 
else if (isset($_POST['iniciar']))
{
    $todoOk = true;

    // llamamos a valida si vacio y devuelve true o false (implementar)
    if($todoOk)
    {
        // Aqui supuestamente se ha rellenado bien //

        // Recojo los datos del formulario
        $user = $_POST["nombre"];
        $pass = $_POST["pass"];

        // Se encripta la contraseña (mediante 'SHA1')
        $pass = sha1($pass);

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
            $_SESSION["usuario"] = $usuario->usuario;
            $_SESSION["email"] = $usuario->email;
            $_SESSION["fecha_nacimiento"] = $usuario->fecha_nacimiento;
            $_SESSION["perfil"] = $usuario->perfil;
            
            // Se accede al inicio
            $_SESSION["pagina"] = "inicio";
            header("Location: index.php");
        }
        else
        {
            $_SESSION["mensaje"] = "No existe el usuario o contraseña";
            $_SESSION["vista"] = $vistas["login"];
            require_once $vistas["layout"];
        }

    }
}
else if (isset($_POST['volver']))
{//que haya rellenado y verifica si existe 
    $_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();   
}
else
{
    //que sea la primera vez que se entra en login
    $_SESSION['vista'] = $vistas['login'];
    require_once $vistas['layout'];
}

?>