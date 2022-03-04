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

}elseif(isset($_POST['mostrarVentas']))
{

    $_SESSION["pagina"] = "cVentas";
    $controlador=$controladores[$_SESSION['pagina']];
    require_once $controlador;

}else
{
    
    if(isset($_POST['modAlbaran']))
    {
        if(isset($_POST['codigo']))
        {
            $_SESSION['codigoAlbaran']=$_POST['codigo'];

            if(validarModFechaAlbaran('modificarAlbaran')==true && validarCantidadModAlbaran('modificarAlbaran')==true)
            {
                
                $idAlbaran = (int) $_REQUEST['idAlbaran'];
                $fecha = $_REQUEST['fechaAlbaran'];
                $codProducto = $_REQUEST['codigoProducto'];
                $cantidad = (int) $_REQUEST['cantidad'];
                $usuario = $_REQUEST['usuarioNickA'];
                $albaranModifica = new Albaran($idAlbaran, $fecha, $codProducto, $cantidad, $usuario);
                AlbaranDAO::update($albaranModifica);
                ProductoDAO::updateStockModAlbaran($cantidad, $codProducto);  
                $_SESSION['vista']= $vistas['verAlbaranes'];
                require_once $vistas['layout'];
            }   
            else
            {
                $_SESSION['vista']= $vistas['modAlbaran'];
                require_once $vistas['layout'];
            }

        }else
        {
            $_SESSION['vista']= $vistas['verAlbaranes'];
            require_once $vistas['layout'];
        }

    }elseif(isset($_POST['BorrarAlbaran']))
    {
        if(isset($_POST['codigo']))
        {
            AlbaranDAO::delete($_POST['codigo']);
            $_SESSION['vista']= $vistas['verAlbaranes'];
            require_once $vistas['layout'];
        }else
        {
            $_SESSION['vista']= $vistas['verAlbaranes'];
            require_once $vistas['layout'];
        }
    }else
    {
        if($_SESSION['vista']==$vistas['modAlbaran'])
        {
        
            if(isset($_SESSION['codigoAlbaran']))
            {

                if(validarModFechaAlbaran('modificarAlbaran')==true && validarCantidadModAlbaran('modificarAlbaran')==true)
                {
                    
                    $idAlbaran = (int) $_REQUEST['idAlbaran'];
                    $fecha = $_REQUEST['fechaAlbaran'];
                    $codProducto = $_REQUEST['codigoProducto'];
                    $cantidad = (int) $_REQUEST['cantidad'];
                    $usuario = $_REQUEST['usuarioNickA'];
                    $albaranModifica = new Albaran($idAlbaran, $fecha, $codProducto, $cantidad, $usuario);
                    AlbaranDAO::update($albaranModifica);
                    ProductoDAO::updateStockModAlbaran($cantidad, $codProducto);  
                    $_SESSION['vista']= $vistas['verAlbaranes'];
                    require_once $vistas['layout'];
                }   
                else
                {
                    $_SESSION['vista']= $vistas['modAlbaran'];
                    require_once $vistas['layout'];
                }

            }else
            {
                $_SESSION['vista']= $vistas['modAlbaran'];
                require_once $vistas['layout'];
            }

        }else
        {
            if(isset($_POST['BorrarAlbaran']))
            {
                if(isset($_POST['codigo']))
                {
                    
                    AlbaranDAO::delete($_POST['codigo']);
                    $_SESSION['vista']= $vistas['verAlbaranes'];
                    require_once $vistas['layout'];
                }
            }else
            {
                $_SESSION['vista']= $vistas['verAlbaranes'];
                require_once $vistas['layout'];

            }

        }
    }

}


?>