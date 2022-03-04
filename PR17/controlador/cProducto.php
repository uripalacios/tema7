<?php

include './core/funcionesProducto.php';

// Login
if (isset($_POST['login'])) 
{
    $_SESSION['pagina'] = 'login';
    header('Location: index.php');
    exit();
}
// Logout
else if(isset($_POST['logout']))
{
    // Cierre de la sesion
    unset($_SESSION['validada']);
    session_destroy();

    //$_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();
}
// Perfil
else if(isset($_POST['perfil']))
{
    $_SESSION['pagina'] = 'perfil';
    header('Location: index.php');
    exit();
}
// Ventas
else if(isset($_POST['mostrarVentas']))
{
    $lista = VentaDAO::findAll();

    $_SESSION['pagina'] = 'venta';
    header('Location: index.php');
    exit();
}
// Albaranes
else if(isset($_POST['mostrarAlbaranes']))
{
    $lista = AlbaranDAO::findAll();

    $_SESSION['pagina'] = 'albaran';
    header('Location: index.php');
    exit();
}
// Ver todos los productos
else if(isset($_POST['verProductos']))
{
    $_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();
}
// Volver (general)
else if(isset($_POST['volverInicio'])) 
{
    $_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();
}
// Crear Producto
else if(isset($_POST['insertarProducto']))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresInsertar"] = $arrayErrores;

    if(validaFormularioInsertar("insertarProducto"))
    {
        // Creo el producto
        $producto = new Producto($_REQUEST["codigo_producto"],$_REQUEST["descripcion"],$_REQUEST["precio"],$_REQUEST["stock"]);

        // Actualizo el stock del producto
        ProductoDAO::save($producto);

        $_SESSION['pagina'] = 'inicio';
        header('Location: index.php');
        exit();
    }
    else
    {
        // Me quedo en el detalle
        $_SESSION['vista'] = $vistas['insertarProducto'];
        require_once $vistas['layout'];
    }
    
}
else
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresInsertar"] = $arrayErrores;

    $_SESSION['vista'] = $vistas['insertarProducto'];
    require_once $vistas['layout'];
}