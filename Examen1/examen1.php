<?

require_once "./config/config.php";

session_start();

//si esta la sesion validada y la pagina 
if(isset($_SESSION['validada'])&& isset($_SESSION['pagina'])){

    $controlador = $controladores[$_SESSION['pagina']];
    require $controlador;
    exit();
}else{
    $controlador = $controladores['login'];
    require $controlador;
    exit();
}