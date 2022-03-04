<?php

    // Importaciones //
    require_once("../funciones/funcionesValidarVenta.php");
    require_once("../funciones/validaSesion.php");
    require_once("../funciones/funcionesBBDD.php");

    // Compruebo la sesion
    session_start();
        
    // Se valida la sesion
    if(!validaSesion())
    {
        header("Location: ./error/403.php");
    }
    else
    {
        // Recojo los datos del usuario
        $arrayUsuario = devuelveDatosUsuario($_SESSION["usuario"]);

        // Se valida el usuario
        if($arrayUsuario["perfil"] == "P_ADMIN")
        {
            if(isset($_REQUEST["id_venta"]))
            {
                // Recojo el id de la venta a eliminar
                $idVenta = $_REQUEST["id_venta"];

                // La elimino
                eliminarVenta($idVenta);
            }

            // Vuelvo de nuevo a 'ventas.php'
            header("Location: ./ventas.php");
        }
        else
        {
            header("Location: ./error/403.php");
        }
    }
?>