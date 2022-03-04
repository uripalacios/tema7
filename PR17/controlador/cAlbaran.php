<?php

include './core/funcionesAlbaran.php';

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
if (isset($_POST['volver'])) 
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
    //$lista = VentaDAO::findAll();

    $_SESSION['pagina'] = 'producto';
    header('Location: index.php');
    exit();
}
// Volver (a todos los albaranes)
else if(isset($_POST['volverAlbaranes'])) 
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresAlbaran"] = $arrayErrores;

    $lista = AlbaranDAO::findAll();

    $_SESSION['vista'] = $vistas['albaranes'];
    require_once $vistas['layout'];
}
// Modificar Albaran (acceso a pagina de modificar)
else if(isset($_POST["modificar"]))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresAlbaran"] = $arrayErrores;

    $idAlbaran = $_REQUEST["idAlbaran"];
    $_SESSION["idAlbaran"] = $idAlbaran;

    $albaran = AlbaranDAO::findById($idAlbaran);

    $_SESSION['vista'] = $vistas['modificarAlbaran'];
    require_once $vistas['layout'];
}
// Eliminar Albaran 
else if(isset($_POST["eliminar"]))
{
    $idAlbaran = $_REQUEST["idAlbaran"];
    $_SESSION["idAlbaran"] = $idAlbaran;

    // Elimino la venta
    AlbaranDAO::deleteById($idAlbaran);

    $lista = AlbaranDAO::findAll();

    $_SESSION['vista'] = $vistas['albaranes'];
    require_once $vistas['layout'];
}
// Modificar Albaran (acción)
else if(isset($_POST["modificarAlbaran"]))
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresAlbaran"] = $arrayErrores;

    $idAlbaran = $_SESSION["idAlbaran"];
    $albaran = AlbaranDAO::findById($idAlbaran);

    $lista = AlbaranDAO::findAll();
    
    if(validaFormularioModificar("modificarAlbaran"))
    {
        // Modifico el Albaran en cuestion
        $usuario = $_SESSION["usuario"];

        $albaran = new Albaran($_REQUEST["id_albaran"],$_REQUEST["fecha"],$_REQUEST["cod_producto"],$_REQUEST["cantidad"],$usuario);
        AlbaranDAO::update($albaran);

        $_SESSION['pagina'] = 'albaran';
        header('Location: index.php');
        exit();
    }
    else
    {
        $_SESSION['vista'] = $vistas['modificarAlbaran'];
        require_once $vistas['layout'];
    }
    
}
else
{
    // Array que contendra los errores
    $arrayErrores = Array();
    $_SESSION["erroresAlbaran"] = $arrayErrores;

    $lista = AlbaranDAO::findAll();

    $_SESSION['vista'] = $vistas['albaranes'];
    require_once $vistas['layout'];
}
?>