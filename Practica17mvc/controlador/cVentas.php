<?php

if(isset($_POST['volver']))
{

    $_SESSION['pagina']='inicio';
    header('Location: index.php');
    exit();

}
elseif(isset($_POST['login']))
{
    $_SESSION['pagina']='login';
    header('Location: index.php');
    exit();
   
}else if(isset($_POST['logout']))
{
    unset($_SESSION['validada']);
    session_destroy();
    if(isset($_COOKIE['recuerdame']))
    {
        setcookie('recuerdame[0]',$_COOKIE['recuerdame'][0], time()-31536000, "/" );
        setcookie('recuerdame[1]',$_COOKIE['recuerdame'][1], time()-31536000, "/" );
    } 

    header("Location: index.php");
    exit();
    
}else if(isset($_POST['perfil']))
{
    $_SESSION["pagina"] = "perfil";
    header("Location: index.php");
    exit();
}elseif(isset($_POST['producto']))
{
    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;
    
}elseif(isset($_POST['verProductos']))
{

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['listaDeseos']))
{
    
    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif (isset($_POST['insertarProductos'])) {

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['modificarProductos']))
{

    $_SESSION["pagina"] = "cProducto";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['mostrarAlbaranes']))
{

    $_SESSION["pagina"] = "cAlbaranes";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}else
{
    if(isset($_POST['modVenta']))
    {
        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoVenta']=$_POST['codigo'];

            if(validarFecha('modificarVenta')==true && validarCantidadModVenta('modificarVenta')==true)
            {
                $idVenta = (int) $_REQUEST['idVenta'];
                $usuario = $_REQUEST['usuario'];
                $fecha = $_REQUEST['fecha'];
                $codProducto = $_REQUEST['codigoProducto'];
                $cantidadAntigua = (int)$_REQUEST['cantidadAntigua'];
                $cantidadNueva = (int) $_REQUEST['cantidadNueva'];
                $producto = ProductoDAO::buscaById($codProducto);
                $precioProducto = $producto->precio;
                $stock= $producto->stock;
                $precioFinal = (float) $precioProducto * $cantidadNueva;
                $venta= new Venta($idVenta, $usuario, $fecha, $codProducto, $cantidadNueva, $precioFinal); 
                
                VentaDAO::update($venta);

                
                $array = recuperarPrecioStockProducto($_REQUEST['codigoProducto']);
                
                $stockFinal=0;

                if($cantidadNueva>$cantidadAntigua)
                {
                    $stockFinal = $stock - ($cantidadNueva - $cantidadAntigua);
                    ProductoDAO::updateStockModVenta($producto, $stockFinal);
                    $_SESSION['vista']= $vistas['verVentas'];
                    require_once $vistas['layout'];
    
                }elseif($cantidadNueva<$cantidadAntigua)
                {
                    $stockFinal = $stock + ($cantidadAntigua - $cantidadNueva);
                    ProductoDAO::updateStockModVenta($producto, $stockFinal);
                    $_SESSION['vista']= $vistas['verVentas'];
                    require_once $vistas['layout'];
                }else
                {
                    $stockFinal = $stock;
                    ProductoDAO::updateStockModVenta($producto, $stockFinal);
                    $_SESSION['vista']= $vistas['verVentas'];
                    require_once $vistas['layout'];
                }
            }   
            else
            {
                $_SESSION['vista']= $vistas['modVenta'];
                require_once $vistas['layout'];
            }

        }else
        {
            $_SESSION['vista']= $vistas['verVentas'];
            require_once $vistas['layout'];
        }

    }elseif(isset($_POST['BorrarVenta']))
    {
        if(isset($_POST['codigo']))
        {
            
            VentaDAO::delete($_POST['codigo']);
            $_SESSION['vista']= $vistas['verVentas'];
            require_once $vistas['layout'];
        }
    }else
    {

        if($_SESSION['vista']==$vistas['modVenta'])
        {
        
            if(isset($_SESSION['codigoVenta']))
            {

                if(validarFecha('modificarVenta')==true && validarCantidadModVenta('modificarVenta')==true)
                {
                    $idVenta = (int) $_REQUEST['idVenta'];
                    $usuario = $_REQUEST['usuario'];
                    $fecha = $_REQUEST['fecha'];
                    $codProducto = $_REQUEST['codigoProducto'];
                    $cantidadAntigua = (int)$_REQUEST['cantidadAntigua'];
                    $cantidadNueva = (int) $_REQUEST['cantidadNueva'];
                    $producto = ProductoDAO::buscaById($codProducto);
                    $precioProducto = $producto->precio;
                    $stock= $producto->stock;
                    $precioFinal = (float) $precioProducto * $cantidadNueva;
                    $venta= new Venta($idVenta, $usuario, $fecha, $codProducto, $cantidadNueva, $precioFinal); 
                    
                    VentaDAO::update($venta);

                    
                    
                    $stockFinal=0;

                    if($cantidadNueva>$cantidadAntigua)
                    {
                        $stockFinal = $stock - ($cantidadNueva - $cantidadAntigua);
                        ProductoDAO::updateStockModVenta($producto, $stockFinal);
                        $_SESSION['vista']= $vistas['verVentas'];
                        require_once $vistas['layout'];
        
                    }elseif($cantidadNueva<$cantidadAntigua)
                    {
                        $stockFinal = $stock + ($cantidadAntigua - $cantidadNueva);
                        ProductoDAO::updateStockModVenta($producto, $stockFinal);
                        $_SESSION['vista']= $vistas['verVentas'];
                        require_once $vistas['layout'];
                    }else
                    {
                        $stockFinal = $stock;
                        ProductoDAO::updateStockModVenta($producto, $stockFinal);
                        $_SESSION['vista']= $vistas['verVentas'];
                        require_once $vistas['layout'];
                    }
                }   
                else
                {
                    $_SESSION['vista']= $vistas['modVenta'];
                    require_once $vistas['layout'];
                }

            }else
            {
                $_SESSION['vista']= $vistas['verVentas'];
                require_once $vistas['layout'];
            }

        }else
        {
            if(isset($_POST['BorrarVenta']))
            {
                if(isset($_POST['codigo']))
                {
                    
                    VentaDAO::delete($_POST['codigo']);
                    $_SESSION['vista']= $vistas['verVentas'];
                    require_once $vistas['layout'];
                }
            }else
            {
                $_SESSION['vista']= $vistas['verVentas'];
                require_once $vistas['layout'];

            }

        }

    }
}


?>