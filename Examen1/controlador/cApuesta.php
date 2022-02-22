<?php


//Si se le envia logout
if(isset($_POST['logout'])){

    //Cerramos la sesion
    unset($_SESSION['validada']);
    session_destroy();

    //le pasamos al index login para que se logee de nuevo o cambie de usuario
    $_SESSION['pagina'] = 'login';
    header('Location: index.php');
    exit();


}
//si no hay nada,se inserta
else if(isset($_POST['insertar'])){
    //comprobar si estan bien los checkbox
    if(compruebaChecks("checks")){

    }
    //si no muestro la apuesta anterior que este ya guardada
    else{
        $apuesta = ApuestaDAO::findById($_SESSION["usuario"]);
        $_SESSION['vista'] = $vistas['apuesta'];
        require_once $vistas['layout'];
    }
}
//Si se le pasa modificar
else if(isset($_POST['modificar'])){
    //comprobar si estan bien los checkbox
    if(compruebaChecks("checks")){

    }
    //si no muestro la apuesta anterior que este ya guardada
    else{
        $apuesta = ApuestaDAO::findById($_SESSION["usuario"]);
        $_SESSION['vista'] = $vistas['apuesta'];
        require_once $vistas['layout'];
    }
}
//Comprobamos si se ha realizado el sorteo
// elseif(){

// }
//que sea la primera vez que accede el usuario
else{
    
    $apuesta = ApuestaDAO::findById($_SESSION["usuario"]);
    
    //que sea la primera vez que entra en apuesta despues de loguear
    $_SESSION['vista'] = $vistas['apuesta'];
    require_once $vistas['layout']; 
}
