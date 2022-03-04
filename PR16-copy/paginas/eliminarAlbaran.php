<?php

// Importaciones //
require_once("../funciones/funcionesValidarAlbaran.php");
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
        if(isset($_REQUEST["id_albaran"]))
        {
            // Recojo el id del albarán a eliminar
            $idAlbaran = $_REQUEST["id_albaran"];
    
            // Lo elimino
            eliminarAlbaran($idAlbaran);
        }
    
        // Vuelvo de nuevo a 'albaranes.php'
        header("Location: ./albaranes.php");
    }
    else
    {
        header("Location: ./error/403.php");
    }
}
?>