<?php
    // Funcion que invoca al resto de funciones que van validando el formulario
    function validaFormularioModificar($nombre)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado($nombre)) 
        {
            $correcto = true;

            // Id Albaran //
            if (empty($_REQUEST['id_albaran']))
            {
                $correcto = false;
                $_SESSION["erroresAlbaran"]["id_albaran"] = "El campo id no puede estar vacío";
            }

            // Fecha //
            if (empty($_REQUEST['fecha']))
            {
                $correcto = false;
                $_SESSION["erroresAlbaran"]["fecha"] = "El campo fecha no puede estar vacío";
            }
            
            // Código del Producto //
            if (empty($_REQUEST['cod_producto']))
            {
                $correcto = false;
                $_SESSION["erroresAlbaran"]["cod_producto"] = "El campo código de producto no puede estar vacío";
            }

            // Cantidad //
            if (empty($_REQUEST['cantidad']))
            {
                $correcto = false;
                $_SESSION["erroresAlbaran"]["cantidad"] = "El campo cantidad no puede estar vacío";
            }

            // Usuario //
            if (empty($_REQUEST['usuario']))
            {
                $correcto = false;
                $_SESSION["erroresAlbaran"]["usuario"] = "El campo usuario no puede estar vacío";
            }

        }
        // Si no...
        else 
            $correcto = false;
        
        return $correcto;
    }
?>