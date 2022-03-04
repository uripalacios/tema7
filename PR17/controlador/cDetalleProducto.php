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
// Volver (general)
else if(isset($_POST['volver'])) 
{
    
    $_SESSION['pagina'] = 'inicio';
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
// Insertar un nuevo Producto
else if(isset($_POST['insertarProducto']))
{
    //$lista = VentaDAO::findAll();

    $_SESSION['pagina'] = 'producto';
    header('Location: index.php');
    exit();
}
// Volver (a detalle)
else if(isset($_POST['volverDetalle'])) 
{
    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    $usuario = $_SESSION["usuario"];
    $usuario = UsuarioDAO::findById($usuario);

    $_SESSION['vista'] = $vistas['detalleProducto'];
    require_once $vistas['layout'];
}
// Comprar Producto
else if(isset($_POST['comprar']))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresComprar"] = $arrayErrores;

    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    $usuario = $_SESSION["usuario"];
    $usuario = UsuarioDAO::findById($usuario);

    if(validaFormularioCompra("comprar"))
    {
        $stockNuevo = $_REQUEST["stock"] - $_REQUEST["cantidad"];
        $nuevoProducto = new Producto($_REQUEST["codigo_producto"],$_REQUEST["descripcion"],$_REQUEST["precio"],$stockNuevo);

        // Actualizo el stock del producto
        ProductoDAO::update($nuevoProducto);

        // Genero la venta //
        $usuario = $_SESSION["usuario"];
        $fecha = date('Y-m-d');
        $codProducto = $codProducto;
        $cantidad = $_REQUEST["cantidad"];
        $precioTotal = $_REQUEST["cantidad"] * $_REQUEST["precio"];

        $venta = new Venta(0,$usuario,$fecha,$codProducto,$cantidad,$precioTotal);
        VentaDAO::save($venta);

        $_SESSION['pagina'] = 'inicio';
        header('Location: index.php');
        exit();
    }
    else
    {
        // Me quedo en el detalle
        $_SESSION['vista'] = $vistas['detalleProducto'];
        require_once $vistas['layout'];
       
    }
    
}
// Modificar Producto (acceso a pagina de modificar)
else if(isset($_POST["modificar"]))
{
    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    $_SESSION['vista'] = $vistas['modificarProducto'];
    require_once $vistas['layout'];
}
// Incrmentar stock (acceso a pagina de incrementar)
else if(isset($_POST["incrementar"]))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresIncrementar"] = $arrayErrores;

    $codProducto = $_SESSION["codigo_producto"];

    // Actualizo el stock del producto
    $producto = ProductoDAO::findById($codProducto);

    $_SESSION['vista'] = $vistas['incrementarStock'];
    require_once $vistas['layout'];
}
// Modificar Producto (acción)
else if(isset($_POST["modificarProducto"]))
{
    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    if(validaFormularioModificar("modificarProducto"))
    {
        // Modifico el Producto en cuestion
        $producto = new Producto($_REQUEST["codigo_producto"],$_REQUEST["descripcion"],$_REQUEST["precio"],$_REQUEST["stock"]);
        ProductoDAO::update($producto);

        $_SESSION['vista'] = $vistas['detalleProducto'];
        require_once $vistas['layout'];
    }
    else
    {
        $_SESSION['vista'] = $vistas['modificarProducto'];
        require_once $vistas['layout'];
    }

}
// Incrementar Stock (acción)
else if(isset($_POST["incrementarStock"]))
{
    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    $usuario = $_SESSION["usuario"];
    $usuario = UsuarioDAO::findById($usuario);

    if(validaFormularioIncrementar("incrementarStock"))
    {
        // Modifico el Producto en cuestion
        $nuevoStock = (int)($_REQUEST["stock"]) + (int)($_REQUEST["cantidad"]);

        $producto = new Producto($producto->codigo_producto,$producto->descripcion,$producto->precio,$nuevoStock);
        ProductoDAO::update($producto);

        // Genero el albarán
        $id = 0;
        $fecha = date('Y-m-d');
        $codProducto = $codProducto;
        $cantidad = $_REQUEST["cantidad"];
        $codUsuario = $_SESSION["usuario"];

        $albaran = new Albaran($id,$fecha,$codProducto,$cantidad,$codUsuario);
        AlbaranDAO::save($albaran);

        $_SESSION['vista'] = $vistas['detalleProducto'];
        require_once $vistas['layout'];
    }
    else
    {
        $_SESSION['vista'] = $vistas['incrementarStock'];
        require_once $vistas['layout'];
    }

}
else
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresComprar"] = $arrayErrores;

    $codUsuario = $_SESSION["usuario"];
    $usuario = UsuarioDAO::findById($codUsuario);

    $codProducto = $_SESSION["codigo_producto"];
    $producto = ProductoDAO::findById($codProducto);

    $_SESSION['vista'] = $vistas['detalleProducto'];
    require_once $vistas['layout'];
}
?>