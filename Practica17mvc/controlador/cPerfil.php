<?php

if(isset($_POST['logout']))
{

    unset($_SESSION['validada']);
    session_destroy();

    if(isset($_COOKIE['recuerdame']))
    {
        setcookie('recuerdame[0]',$_COOKIE['recuerdame'][0], time()-31536000, "/" );
        setcookie('recuerdame[1]',$_COOKIE['recuerdame'][1], time()-31536000, "/" );

    }

    header("Location: index.php");
    exit();

}elseif(isset($_POST['volver']))
{
    
    $_SESSION['pagina']='inicio';
    header('Location: index.php');
    exit();
}
elseif(isset($_POST['modificarPerfil']))
{
    //al modificar vuelve a la misma
    //pagina pero con los datos nuevos

    $boton ='modificarPerfil';

    if(validarNombreComp($boton)==true && validarMail($boton) == true && validarFecha($boton) ==true && validarPass($boton)==true)
    {
        

        $user=$_REQUEST['user'];
        $encrip = sha1($_REQUEST['pass']);
        $nCompleto=$_REQUEST['nCompleto'];
        $cElectronico=$_REQUEST['correo'];
        $fecha=$_REQUEST['fecha'];
        $perfil=$_SESSION['perfil'];
        $_SESSION['nombre']=$nCompleto;
        $usuarioAct = new Usuario($user, $nCompleto, $encrip, $cElectronico, $fecha, $perfil);
        UsuarioDAO::update($usuarioAct);

        $_SESSION['pagina']='perfil';
        header('Location: index.php');



       
    }else
    {
        $_SESSION['vista']= $vistas['perfil'];
        require_once $vistas['layout'];
    }   
   
   
}elseif(isset($_GET['mostrar']))
{

    if($_SESSION['perfil']=='admini')
    {
        $codUsuario = $_GET['mostrar'];
        $usuario = UsuarioDAO::buscaById($codUsuario);
        $_SESSION['vista']=$vistas['perfil'];
        require_once $vistas['layout'];
    }



}elseif(isset($_POST['verProductos']))
{

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['listaDeseos']))
{
    
    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif (isset($_POST['insertarProductos'])) {

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['modificarProductos']))
{

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['mostrarVentas']))
{

    $_SESSION["pagina"] = "cVentas";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['mostrarAlbaranes']))
{

    $_SESSION["pagina"] = "cAlbaranes";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}else
{

    //Suponiendo que es mi perfil

    $_SESSION['vista']= $vistas['perfil'];
    require_once $vistas['layout'];
        
    
    
}


?>