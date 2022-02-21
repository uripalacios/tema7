<?php


//que haya rellenado y verifica si existe el usuario
if(isset($_POST['iniciar'])){
    //el usuario
    //validar que hay datos en los input
    $todoOk = true;
    //llamamos al valida y retornna true/false
    if($todoOk){
        $user = $_POST['nombre'];
        $pass = $_POST['pass'];
        

        $usuario =  UsuarioDAO::validaUser($user,$pass);
        if($usuario != null){
            $_SESSION['validada'] = true;
            $_SESSION['user'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['perfil'] = $usuario->perfil;
           // $_SESSION['pagina'] = 'login';
            if($_SESSION['perfil']=='admin'){
                //si es administrados pagina a sorteo
                $_SESSION['pagina']= 'sorteo';
           }else{
               //si es usuario normal a apuesta
                $_SESSION['pagina']= 'apuesta';
           }
            header('Location: index.php');
            exit();
        }else{
            $_SESSION['mensaje'] = "No existe el usuario o contraseña";
            $_SESSION['vista'] = $vistas['login'];
        }
    }

}
//que sea la primera vez que se entra en login
else{
    $_SESSION['vista'] = $vistas['login'];
    require $vistas['layout'];
}


?>