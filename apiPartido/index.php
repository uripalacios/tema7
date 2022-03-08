<?
require "./config/config.php";
//ver que contiene y que sta pidiendo

//si existe string
if(substr($_SERVER['PATH_INFO'],0,8)==="/partido"){
    $producto = new cPartido();
    $producto->general();
}
else{
    header("HTTP/1.1 400 Error en el formato de la peticion");
    exit;
}
?>