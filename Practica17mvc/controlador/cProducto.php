<?php
//si se ha pulsado el registro
if(isset($_POST['comprarProducto']))
{
    if(validarCompra($_REQUEST['cantidad'], $_REQUEST['stock'])==true)
        {
            //si la compra es correcta se comprueba si la sesion ha
            //ya ha sido validada si ha sido validada se genera la venta
            //sino te lleva login

            if(comprobarSesion()==false)
            {
                $_SESSION["pagina"] = "login";
                header("Location: index.php");
                exit();

            }else
            {
                $_SESSION["pagina"] = "finalizarCompra";
                $controlador=$controladores[$_SESSION['pagina']];
                require_once $controlador;

                //header("location: ./finalizarCompra.php?codigo=".$_REQUEST['codigo']."&stock=".$_REQUEST['stock']."&precio=".$_REQUEST['precio']."&unidades=".$_REQUEST['cantidad']."&descripcion=".$_REQUEST['descripcion']."&imagen=".$_REQUEST['imagen']);
            }

        }else
        {
            $_SESSION['vista'] = $vistas['comprarProducto'];
            require_once $vistas['layout'];
        }
}
elseif(isset($_POST['volver']))
{

    $_SESSION['pagina']='inicio';
    header('Location: index.php');
    exit();

}
elseif(isset($_POST['login']))
{

    $_SESSION["pagina"] = "login";
    header("Location: index.php");
    exit();

}
else if(isset($_POST['perfil']))
{

    $_SESSION["pagina"] = "perfil";
    header("Location: index.php");
    exit();

}
else if(isset($_POST['logout']))
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
    
}
elseif(isset($_POST['producto']))
{

    if(isset($_POST['codigo']))
    {
        $_SESSION['codigoProducto']=$_POST['codigo'];

    }

    $_SESSION['vista'] = $vistas['comprarProducto'];
    require_once $vistas['layout'];
    
}
elseif(isset($_POST['listaDeseos']))
{
    
    $_SESSION['vista'] = $vistas['listaDeseos'];
    require_once $vistas['layout'];

}
elseif(isset($_POST['verProductos']))
{

    $_SESSION['vista'] = $vistas['verProductos']; 
    require_once $vistas['layout'];

}
elseif (isset($_POST['insertarProductos'])) {

    if(comprobarCodigoControlador()==true && validarDescripcionInsertProdu() == true && validarPrecioInsertProdu() == true && validarStockInsertProdu() ==true)
    {
            $codigo = $_REQUEST['codigo'];
            $descripcion = $_REQUEST['descripcion'];
            $precio = (float)$_REQUEST['precio']; 
            $stock = (int)$_REQUEST['stock'];
            $imagenAlta="";
            $imagenBaja="";

            $fecha = date ('Y-m-d', time());
            $cantidad = (int)$_REQUEST['stock'];
            $usuario= $_SESSION['user'];

            $insertarProducto = new Producto($codigo, $descripcion, $precio, $stock, $imagenAlta, $imagenBaja);
            $insertarAlbaran = new Albaran(0, $fecha, $codigo, $stock, $usuario);    
            ProductoDAO::save($insertarProducto);
            AlbaranDAO::save($insertarAlbaran);
            $_SESSION['pagina']='inicio';
            header('Location: index.php');
            exit();

    }else
    {
        $_SESSION['vista'] = $vistas['insertarProducto'];
        require_once $vistas['layout'];
    }


}
elseif(isset($_POST['modificarProductos']))
{
    if(isset($_POST['modProducto']))
    {
        //modOneProducto

        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoProducto']=$_POST['codigo'];

            if(validarDescripcionModProdu()==true && validarPrecioModProdu()==true && validarStockModProdu() ==true)
            {

                $codigo = $_REQUEST['codigo'];
                $descripcion = $_REQUEST['descripcion'];
                $precio = $_REQUEST['precio'];
                $stock = $_REQUEST['stock'];
                $imagenAlta = $_REQUEST['imagenAlta'];
                $imagenBaja = $_REQUEST['imagenBaja'];
                $actualizaProducto = new Producto($codigo, $descripcion, $precio, $stock, $imagenAlta, $imagenBaja);
                
                ProductoDAO::update($actualizaProducto);

                $_SESSION['vista'] = $vistas['modificarProducto'];
                require_once $vistas['layout'];


            }else
            {
                $_SESSION['vista'] = $vistas['modOneProducto'];
                require_once $vistas['layout'];
            }   
        }else
        {
            $_SESSION['vista'] = $vistas['modificarProducto'];
                require_once $vistas['layout'];
        }
        

    }else
    {
        $_SESSION['vista'] = $vistas['modificarProducto'];
        require_once $vistas['layout'];
    }

}elseif(isset($_POST['mostrarVentas']))
{

    $_SESSION["pagina"] = "cVentas";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}elseif(isset($_POST['mostrarAlbaranes']))
{

    $_SESSION["pagina"] = "cAlbaranes";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}else
{
    
    if($_SESSION['vista']==$vistas['listaDeseos'])
    {
       
        $_SESSION['vista'] = $vistas['listaDeseos'];
        require_once $vistas['layout'];

    }
    elseif($_SESSION['vista']==$vistas['comprarProducto'])
    {

        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoProducto']=$_POST['codigo'];

        }

        $_SESSION['vista'] = $vistas['comprarProducto'];
        require_once $vistas['layout'];

    }elseif($_SESSION['vista']==$vistas['insertarProducto'])
    {

    
    if(comprobarCodigoControlador()==true && validarDescripcionInsertProdu() == true && validarPrecioInsertProdu() == true && validarStockInsertProdu() ==true)
    {
            $codigo = $_REQUEST['codigo'];
            $descripcion = $_REQUEST['descripcion'];
            $precio = (float)$_REQUEST['precio']; 
            $stock = (int)$_REQUEST['stock'];
            $imagenAlta="";
            $imagenBaja="";

            $fecha = date ('Y-m-d', time());
            $cantidad = (int)$_REQUEST['stock'];
            $usuario= $_SESSION['user'];

            $insertarProducto = new Producto($codigo, $descripcion, $precio, $stock, $imagenAlta, $imagenBaja);
            $insertarAlbaran = new Albaran(0, $fecha, $codigo, $stock, $usuario);    
            ProductoDAO::save($insertarProducto);
            AlbaranDAO::save($insertarAlbaran);
            $_SESSION['pagina']='inicio';
            header('Location: index.php');
            exit();



    }else
    {
        $_SESSION['vista'] = $vistas['insertarProducto'];
        require_once $vistas['layout'];
    }
    
    }elseif($_SESSION['vista']==$vistas['modificarProducto'])
    {

        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoProducto']=$_POST['codigo'];

            if(validarDescripcionModProdu()==true && validarPrecioModProdu()==true && validarStockModProdu() ==true)
            {

                $codigo = $_REQUEST['codigo'];
                $descripcion = $_REQUEST['descripcion'];
                $precio = $_REQUEST['precio'];
                $stock = $_REQUEST['stock'];
                $imagenAlta = $_REQUEST['imagenAlta'];
                $imagenBaja = $_REQUEST['imagenBaja'];
                $actualizaProducto = new Producto($codigo, $descripcion, $precio, $stock, $imagenAlta, $imagenBaja);
                
                ProductoDAO::update($actualizaProducto);

                $_SESSION['vista'] = $vistas['modificarProducto'];
                require_once $vistas['layout'];


            }else
            {
                $_SESSION['vista'] = $vistas['modOneProducto'];
                require_once $vistas['layout'];
            }   
        }else
        {
            $_SESSION['vista'] = $vistas['modificarProducto'];
                require_once $vistas['layout'];
        }

            
    
    }elseif($_SESSION['vista']==$vistas['modOneProducto'])
    {
        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoProducto']=$_POST['codigo'];

            if(validarDescripcionModProdu()==true && validarPrecioModProdu()==true && validarStockModProdu() ==true)
            {

                $codigo = $_REQUEST['codigo'];
                $descripcion = $_REQUEST['descripcion'];
                $precio = $_REQUEST['precio'];
                $stock = $_REQUEST['stock'];
                $imagenAlta = $_REQUEST['imagenAlta'];
                $imagenBaja = $_REQUEST['imagenBaja'];
                $actualizaProducto = new Producto($codigo, $descripcion, $precio, $stock, $imagenAlta, $imagenBaja);
                
                ProductoDAO::update($actualizaProducto);

                $_SESSION['vista'] = $vistas['modificarProducto'];
                require_once $vistas['layout'];


            }else
            {
                $_SESSION['vista'] = $vistas['modOneProducto'];
                require_once $vistas['layout'];
            }   
        }else
        {
            $_SESSION['vista'] = $vistas['modOneProducto'];
                require_once $vistas['layout'];
        }

    }elseif(isset($_POST['mostrarVentas']))
    {
    
        $_SESSION["pagina"] = "cVentas";
        $controlador=$controladores[$_SESSION['pagina']];
        require_once $controlador;
    
    }elseif(isset($_POST['mostrarAlbaranes']))
    {
    
        $_SESSION["pagina"] = "cAlbaranes";
        $controlador=$controladores[$_SESSION['pagina']];
        require_once $controlador;
    
    }

    else
    {
        
        $_SESSION['vista'] = $vistas['verProductos']; 
        require_once $vistas['layout'];

    }

    
}

?>