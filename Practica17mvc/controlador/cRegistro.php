<?php

if(isset($_POST['volver']))
{

    $_SESSION['pagina']='inicio';
    header('Location: index.php');
    exit();

}elseif(isset($_POST['crearCuenta']))
{
    //que sea la primera vez que se entra en login
    //Usaremos la libreria de validar
    //intentar insertar el usuario nuevo

    $boton = 'crearCuenta';
    
    if(validarUsuario($boton)==false && validarNombreComp($boton)==true && 
    validarFecha($boton)==true && validarMail($boton)==true && validarPass($boton)==true)
    {
        $user=$_REQUEST['user'];
        $nCompleto=$_REQUEST['nCompleto'];
        $correo=$_REQUEST['correo'];
        $fecha=$_REQUEST['fecha'];
        $encrip = sha1($_REQUEST['pass']);
        $perfil = "USR01";
        
        $usuarioNuevo = new Usuario($user, $nCompleto, $encrip, $correo, $fecha, $perfil);
        UsuarioDAO::save($usuarioNuevo);
        
        $_SESSION['validada']=true;
        $_SESSION['user']=$user;
        $_SESSION['nombre']=$nCompleto;
        $_SESSION['perfil']=$perfil;
        
        $_SESSION['pagina']='inicio';
        header('Location: index.php');

    
    
    }else
    {
        $_SESSION['vista']= $vistas['registro'];
        require_once $vistas['layout'];
    }
            
   
}
elseif(isset($_POST['login']))
{
    $_SESSION['pagina']='login';
    header('Location: index.php');
    exit();
   
}elseif(isset($_POST['verProductos']))
{
    $_SESSION["pagina"] = "verProductos";
    header("Location: index.php");
    exit();
}else
{
    $_SESSION['vista']= $vistas['registro'];
    require_once $vistas['layout'];
}


?>