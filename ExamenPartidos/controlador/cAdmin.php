<?
// Logout
if(isset($_POST['logout']))
{
    // Cierre de la sesion
    unset($_SESSION['validada']);
    session_destroy();

    $_SESSION['pagina'] = 'login';
    header('Location: index.php');
    exit();
}elseif(isset($_GET['modificar'])){
    $_SESSION['vista'] = $vistas['modificar'];
    require_once $vistas['layout'];
        
}elseif(isset($_POST['Insertar'])){
    $_SESSION['vista'] = $vistas['insertar'];
    require_once $vistas['layout'];
}elseif(isset($_GET['borrar'])){
    delete($_SESSION['id']);
    $_SESSION['vista'] = $vistas['admin'];
    require_once $vistas['layout']; 
}
//muestro el resultado del partido
else
{
    

    // Que sea la primera vez que se entra en inicio tras loguearse //
    $_SESSION['vista'] = $vistas['admin'];
    require_once $vistas['layout'];    
}


?>