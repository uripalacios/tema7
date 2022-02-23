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
        //guardo el valor de los checks marcados
        $n1 = $_POST["checks"][0];
        $n2 = $_POST["checks"][1];
        $n3 = $_POST["checks"][2];
        $n4 = $_POST["checks"][3];
        $n5 = $_POST["checks"][4];

        //Inserto la nueva apuesta al usuario
        $idInsertar = $_SESSION["user"];

        $newApuesta = new Apuesta(0,$idInsertar,$n1,$n2,$n3,$n4,$n5);

        ApuestaDAO::save($newApuesta);

        $_SESSION['pagina'] = 'apuesta';
        header('Location: index.php');
        exit();
    }
    //si no muestro la apuesta anterior que este ya guardada
    else{
        $apuesta = ApuestaDAO::findById($_SESSION["user"]);
        $_SESSION['vista'] = $vistas['apuesta'];
        require_once $vistas['layout'];
    }
}
//Si se le pasa modificar
else if(isset($_POST['modificar'])){
    //comprobar si estan bien los checkbox
    if(compruebaChecks("checks")){
        $n1 = $_POST["checks"][0];
        $n2 = $_POST["checks"][1];
        $n3 = $_POST["checks"][2];
        $n4 = $_POST["checks"][3];
        $n5 = $_POST["checks"][4];

        //modifico la nueva apuesta
        $apuestaActual = ApuestaDAO::findById($_SESSION["user"]);

        $newApuesta = new Apuesta($apuestaActual->id,$apuestaActual->idProfe,$n1,$n2,$n3,$n4,$n5);

        ApuestaDAO::update($newApuesta);

        $_SESSION['pagina'] = 'apuesta';
        header('Location: index.php');
        exit();
    }
    //si no muestro la apuesta anterior que este ya guardada
    else{
        $apuesta = ApuestaDAO::findById($_SESSION["user"]);
        $_SESSION['vista'] = $vistas['apuesta'];
        require_once $vistas['layout'];
    }
}
//Comprobamos si se ha realizado el sorteo
// elseif(){

// }
//que sea la primera vez que accede el usuario
else{
    
    $apuesta = ApuestaDAO::findById($_SESSION["user"]);
    
    //que sea la primera vez que entra en apuesta despues de loguear
    $_SESSION['vista'] = $vistas['apuesta'];
    require_once $vistas['layout']; 
}
