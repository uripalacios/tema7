<?php

// Funcion que invoca al resto de funciones que van validando el formulario
function validaFormularioCompra($nombre)
{
    // Si se ha enviado el formulario...
    if (validaEnviado($nombre)) 
    {
        $correcto = true;

        // Codigo //
        if (empty($_REQUEST['codigo_producto']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["codigo_producto"] = "El campo codigo no puede estar vacío";
        }

        // Descripcion //
        if (empty($_REQUEST['descripcion']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["descripcion"] = "El campo descripcion no puede estar vacío";
        }

        // Precio //
        if (empty($_REQUEST['precio']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["precio"] = "El campo precio no puede estar vacío";
        }
        
        // Stock //
        if (empty($_REQUEST['stock']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["stock"] = "El campo stock no puede estar vacío";
        }

        // Cantidad //
        if (empty($_REQUEST['cantidad']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["cantidad"] = "Debe introducir una cantidad";
        }
        else if($_REQUEST["cantidad"] > $_REQUEST["stock"])
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["cantidad"] = "La cantidad a comprar no puede ser superior al stock actual";
        }
        else if($_REQUEST["cantidad"] < 1)
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["cantidad"] = "La cantidad mínima debe ser 1";
        }
        
    }
    // Si no...
    else 
        $correcto = false;
    
    return $correcto;
}

// Funcion que invoca al resto de funciones que van validando el formulario
function validaFormularioModificar($nombre)
{
    // Si se ha enviado el formulario...
    if (validaEnviado($nombre)) 
    {
        $correcto = true;

        // Codigo //
        if (empty($_REQUEST['codigo_producto']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["codigo_producto"] = "El campo codigo no puede estar vacío";
        }

        // Descripcion //
        if (empty($_REQUEST['descripcion']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["descripcion"] = "El campo descripcion no puede estar vacío";
        }

        // Precio //
        if (empty($_REQUEST['precio']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["precio"] = "El campo precio no puede estar vacío";
        }
        
        // Stock //
        if (empty($_REQUEST['stock']))
        {
            $correcto = false;
            $_SESSION["erroresComprar"]["stock"] = "El campo stock no puede estar vacío";
        }
        
    }
    // Si no...
    else 
        $correcto = false;
    
    return $correcto;
}

// Funcion que invoca al resto de funciones que van validando el formulario
function validaFormularioInsertar($nombre)
{
    // Si se ha enviado el formulario...
    if (validaEnviado($nombre)) 
    {
        $correcto = true;

        // Codigo //
        if (empty($_REQUEST['codigo_producto']))
        {
            $correcto = false;
            $_SESSION["erroresInsertar"]["codigo_producto"] = "El campo codigo no puede estar vacío";
        }
        else
        {
            $listaProductos = ProductoDAO::findAll();

            foreach ($listaProductos as $producto)
            {
                if($producto->codigo_producto == $_REQUEST["codigo_producto"])
                {
                    $correcto = false;
                    $_SESSION["erroresInsertar"]["codigo_producto"] = "Ya existe un producto con dicho código";
                }
            }
        }

        // Descripcion //
        if (empty($_REQUEST['descripcion']))
        {
            $correcto = false;
            $_SESSION["erroresInsertar"]["descripcion"] = "El campo descripcion no puede estar vacío";
        }

        // Precio //
        if (empty($_REQUEST['precio']))
        {
            $correcto = false;
            $_SESSION["erroresInsertar"]["precio"] = "El campo precio no puede estar vacío";
        }
        
        // Stock //
        if (empty($_REQUEST['stock']))
        {
            $correcto = false;
            $_SESSION["erroresInsertar"]["stock"] = "El campo stock no puede estar vacío";
        }
        
    }
    // Si no...
    else 
        $correcto = false;
    
    return $correcto;
}

// Funcion que invoca al resto de funciones que van validando el formulario
function validaFormularioIncrementar($nombre)
{
    // Si se ha enviado el formulario...
    if (validaEnviado($nombre)) 
    {
        $correcto = true;
        
        // Stock //
        if (empty($_REQUEST['stock']))
        {
            $correcto = false;
            $_SESSION["erroresIncrementar"]["stock"] = "El campo stock no puede estar vacío";
        }

        // Cantidad a incrementar //
        if (empty($_REQUEST['cantidad']))
        {
            $correcto = false;
            $_SESSION["erroresIncrementar"]["cantidad"] = "El campo cantidad no puede estar vacío";
        }
        else if($_REQUEST["cantidad"] < 1)
        {
            $correcto = false;
            $_SESSION["erroresIncrementar"]["cantidad"] = "La cantidad mínima a incrementar es '1'";
        }
        
    }
    // Si no...
    else 
        $correcto = false;
    
    return $correcto;
}
?>