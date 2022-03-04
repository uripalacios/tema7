<?php

    // Método que valida si la sesion está iniciada
    function validaSesion()
    {

        if(isset($_SESSION["validada"]))
        {
            return true;
        }
        else
        {
           return false;
        }
    }

    // Método que valida si un usuario puede acceder a una página
    function validaPagina($nombrePagina)
    {

        if(in_array($nombrePagina,$_SESSION["paginas"]))
            return true;
        else
            return false;
    }
?>