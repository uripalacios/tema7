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
// Volver (a todas las ventas)
else if(isset($_POST['volverVentas'])) 
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresVenta"] = $arrayErrores;

    $lista = VentaDAO::findAll();

    $_SESSION['vista'] = $vistas['ventas'];
    require_once $vistas['layout'];
}
// Modificar Venta (acceso a pagina de modificar)
else if(isset($_POST["modificar"]))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresVenta"] = $arrayErrores;

    $idVenta = $_REQUEST["idVenta"];
    $_SESSION["idVenta"] = $idVenta;

    $venta = VentaDAO::findById($idVenta);

    $_SESSION['vista'] = $vistas['modificarVenta'];
    require_once $vistas['layout'];
}
// Eliminar Venta 
else if(isset($_POST["eliminar"]))
{
    $idVenta = $_REQUEST["idVenta"];
    $_SESSION["idVenta"] = $idVenta;

    // Elimino la venta
    VentaDAO::deleteById($idVenta);

    $lista = VentaDAO::findAll();

    $_SESSION['vista'] = $vistas['ventas'];
    require_once $vistas['layout'];
}
// Modificar Venta (acción)
else if(isset($_POST["modificarVenta"]))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresComprar"] = $arrayErrores;

    $idVenta = $_SESSION["idVenta"];
    $venta = VentaDAO::findById($idVenta);

    $lista = VentaDAO::findAll();
    
    if(validaFormularioModificar("modificarVenta"))
    {
        // Modifico la Venta en cuestion
        $usuario = $_SESSION["usuario"];

        $venta = new Venta($_REQUEST["id_venta"],$usuario,$_REQUEST["fecha_compra"],$_REQUEST["cod_producto"],$_REQUEST["cantidad"],$_REQUEST["precio_total"]);
        VentaDAO::update($venta);

        $_SESSION['pagina'] = 'venta';
        header('Location: index.php');
        exit();
    }
    else
    {
        $_SESSION['vista'] = $vistas['modificarVenta'];
        require_once $vistas['layout'];
    }
    
}
if (isset($_POST['volver'])) 
{
    $_SESSION['pagina'] = 'inicio';
    header('Location: index.php');
    exit();
}
else
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresVenta"] = $arrayErrores;

    $lista = VentaDAO::findAll();

    $_SESSION['vista'] = $vistas['ventas'];
    require_once $vistas['layout'];
}
?>