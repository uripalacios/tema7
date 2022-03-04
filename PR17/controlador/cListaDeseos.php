<?php

include './core/funcionesVenta.php';

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
// Volver (general)
else if(isset($_POST['volverInicio'])) 
{
    $_SESSION['pagina'] = 'inicio';
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
// Insertar un nuevo Producto
else if(isset($_POST['insertarProducto']))
{
    $_SESSION['pagina'] = 'producto';
    header('Location: index.php');
    exit();
}
if (isset($_POST['volver'])) 
{
    $_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();
}
// Ver detalle del Producto
else if(isset($_POST["verProducto"]))
{
    // Recojo el id del producto
    if(isset($_POST["codigoProducto"]))
    {
        $codigoProducto = $_POST["codigoProducto"];
        $_SESSION["codigo_producto"] = $codigoProducto;

        // Recojo el producto con ese id
        $producto = ProductoDAO::findById($codigoProducto);
    }
    
    $_SESSION['pagina'] = 'detalleProducto';
    header('Location: index.php');
    exit();
}
else
{
    
    $lista = ProductoDAO::findAll();

    $_SESSION['vista'] = $vistas['listaDeseos'];
    require_once $vistas['layout'];
}
?>