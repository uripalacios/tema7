<?php
//si se ha pulsado el registro

if(isset($_POST['crearCuenta']))
{
    $_SESSION['pagina']='registro';
    header('Location: index.php');
    exit();
}elseif(isset($_POST['valida']))
{
    //que haya rellenado los campos y verifique si existe el usuario
    
    //llamamos al valida y retorna true/false

    if($_POST['user']!='' && $_POST['pass']!='')
    {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        //$pass = hash("SHA256", $pass);
        $encrip = sha1($pass);

        $usuario = UsuarioDAO::validaUser($user, $encrip);

        if($usuario != null)
        {
                
                $_SESSION['validada']=true;
                $_SESSION['user']=$usuario->usuario;
                $_SESSION['nombre']=$usuario->nombre;
                $_SESSION['perfil']=$usuario->perfil;
                
                if(isset($_REQUEST['recordarme']))
                {
                    recuerdame();
                }
                $_SESSION['pagina']='inicio';
                header('Location: index.php');
        }else
        {
           $_SESSION['mensaje'] = "Error. El usuario o la contraseña son incorrectos";
           $_SESSION['vista'] = $vistas['login']; 
           require_once $vistas['layout'];
        }

    }else
    {
        $_SESSION['mensaje'] = "Rellene los campos para acceder";
        $_SESSION['vista'] = $vistas['login']; 
        require_once $vistas['layout'];
    }

}elseif(isset($_POST['volver']))
{
    $_SESSION['pagina']='inicio';
    header('Location: index.php');
    exit();
}elseif(isset($_POST['verProductos']))
{
    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;
}else
{
    //que sea la primera vez que se entra en login
    $_SESSION['vista'] = $vistas['login']; 
    require_once $vistas['layout'];
}

?>