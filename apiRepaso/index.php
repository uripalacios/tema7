<?
require "./config/config.php";
//ver que contiene y que sta pidiendo

//si existe string
if(substr($_SERVER['PATH_INFO'],0,9)==="/producto"){
    $producto = new cProducto();
    $producto->general();
}
else{
    header("HTTP/1.1 400 Error en el formato de la peticion");
    exit;
}
?>