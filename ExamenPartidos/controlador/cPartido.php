<?php

// Logout
if(isset($_POST['logout']))
{
    // Cierre de la sesion
    unset($_SESSION['validada']);
    session_destroy();

    $_SESSION['pagina'] = 'login';
    header('Location: index.php');
    exit();
}
//muestro el resultado del partido
else
{
    // Busco los partidos del usuario en la api
    //lo guardo en una variable para despues recorrerla
    $lista=get();
    $lista = json_decode($lista,true);
    // Que sea la primera vez que se entra en inicio tras loguearse //
    $_SESSION['vista'] = $vistas['partido'];
    require_once $vistas['layout'];    
}


?>