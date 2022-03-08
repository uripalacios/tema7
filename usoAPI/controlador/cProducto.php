<?php
require "./funciones/curl.php";

if(isset($_POST['modificar'])){
    $vista = "./vista/formulario.php";
    require "./vista/layout.php";
}else if(isset($_POST['InsertarF'])){
    
    $vista = "./vista/mostrar.php";
    require "./vista/layout.php";
    exit;
}elseif($_POST['InsertarF']){
    //peticion de save
    //primero comprobar que esta todo
    if($_POST['codigo'] !='' && $_POST['nombre'] && $_POST['descripcion']){
         
    }else{
    $productos = get();
    $vista = "./vista/mostrar.php";
    require "./vista/layout.php";
    exit;
    
}
}else if(isset($_GET['mostrarUno'])){
   
}
else{
    $productos = get();
    $vista = "./vista/mostrar.php";
    require "./vista/layout.php";
}