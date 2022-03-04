<?php

if(isset($_POST['login']))
{
    $_SESSION["pagina"] = "login";
    header("Location: index.php");
    exit();
}else if(isset($_POST['logout']))
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
    
}else if(isset($_POST['perfil']))
{

    $_SESSION["pagina"] = "perfil";
    header("Location: index.php");
    exit();
    
}elseif(isset($_POST['producto']))
{
    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;
    
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
    crearBD();
    $_SESSION['vista'] =$vistas['inicio'];
    require_once $vistas['layout'];


}


?>
