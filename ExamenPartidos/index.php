<?php

require './config/config.php';

session_start();

//si el usuario esta logeado inicioLogueado
if(isset($_SESSION['validada']))
{
    //enviar a donde haga falta
    $controlador = $controladores[$_SESSION['pagina']];
    require_once $controlador;
    exit();
}
//si el usuario esta logeado y ha solicita algo 
//si el usuario ha peiddo ir al login
else
{  
    if(isset($_SESSION['pagina']))
    {
        $controlador = $controladores[$_SESSION['pagina']];
        require_once $controlador;
        exit();
    }
}

// Que sea la primera vez que se entra en login //
$_SESSION['vista'] = $vistas['login'];
$_SESSION['pagina'] = 'login';

require_once $vistas['layout'];    

?>