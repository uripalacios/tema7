<?php
    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormularioModificar($nombre)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado($nombre)) 
        {
            $correcto = true;

            // Id Venta //
            if (empty($_REQUEST['id_venta']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["id_venta"] = "El campo id venta no puede estar vacío";
            }

            // Usuario //
            if (empty($_REQUEST['usuario']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["usuario"] = "El campo usuario no puede estar vacío";
            }

            // Fecha de Compra //
            if (empty($_REQUEST['fecha_compra']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["fecha_compra"] = "El campo fecha de compra no puede estar vacío";
            }
            
            // Código del Producto //
            if (empty($_REQUEST['cod_producto']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["cod_producto"] = "El campo código de producto no puede estar vacío";
            }

            // Cantidad //
            if (empty($_REQUEST['cantidad']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["cantidad"] = "El campo cantidad no puede estar vacío";
            }

            // Precio Total //
            if (empty($_REQUEST['precio_total']))
            {
                $correcto = false;
                $_SESSION["erroresVenta"]["precio_total"] = "El campo precio total no puede estar vacío";
            }
            
        }
        // Si no...
        else 
            $correcto = false;
        
        return $correcto;
    }
?>