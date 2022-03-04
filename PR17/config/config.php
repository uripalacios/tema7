<?php

define ('IMAGENES', "/Tema6/PR17/webroot/img/");

include './core/funcionesValidarGenericas.php';
include './core/funcionesCookies.php';
require './config/datosBD.php';
require './modelo/ConexionBD.php';
require './dao/DAO.php';
require './modelo/Usuario.php';
require './dao/UsuarioDAO.php';
require './modelo/Producto.php';
require './dao/ProductoDAO.php';
require './modelo/Venta.php';
require './dao/VentaDAO.php';
require './modelo/Albaran.php';
require './dao/AlbaranDAO.php';
//require './core/crearBD.php';
//require './config/sesiones.sql';

$controladores = [
    'inicio' => 'controlador/cInicio.php',
    'login' => 'controlador/cLogin.php',
    'registro' => 'controlador/cRegistro.php',
    'perfil' => 'controlador/cPerfil.php',
    'producto' => 'controlador/cProducto.php',
    'venta' => 'controlador/cVenta.php',
    'albaran' => 'controlador/cAlbaran.php',
    'detalleProducto' => 'controlador/cDetalleProducto.php',
    'deseos' => 'controlador/cListaDeseos.php',
];

$vistas = [
    'inicio' => 'vista/vInicio.php',
    'login' => 'vista/vLogin.php',
    'layout' => 'vista/vLayout.php',
    'registro' => 'vista/vRegistro.php',
    'perfil' => 'vista/vPerfil.php',
    'listaUsuarios' => 'vista/vListaUsuarios.php',
    'listaProductos' => 'vista/vListaProductos.php',
    'detalleProducto' => 'vista/vDetalleProducto.php',
    'modificarProducto' => 'vista/vModificarProducto.php',
    'ventas' => 'vista/vListaVentas.php',
    'albaranes' => 'vista/vListaAlbaranes.php',
    'modificarVenta' => 'vista/vModificarVenta.php',
    'modificarAlbaran' => 'vista/vModificarAlbaran.php',
    'insertarProducto' => 'vista/vInsertarProducto.php',
    'incrementarStock' => 'vista/vIncrementarStock.php',
    'listaDeseos' => 'vista/vListaDeseos.php'
];

// Funcion que crea la BBDD
function crearBD()
{
    // Si al acceder no existe la BBDD, se crea y se insertan datos //
    $dsn = "mysql:host=" . IP . ";dbname=" . BBDD;

    try
    {
        $conexion = new PDO($dsn, USER, PASS);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $ex) 
    {
        $numError = $ex->getCode();

        // Error al no reconocer la BBDD
        if ($numError == 1049) 
        {
            // Se crea la BBDD y se introducen datos por defecto
            $conexion = new PDO("mysql:host=" . IP, USER,PASS);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $commands = file_get_contents("./config/sesiones.sql");
            $conexion->exec($commands);
        }
        // Error al conectar con el servidor...
        else if ($numError == 2002) {
            echo "<br>Error: Error al conectar con el servidor.<br>";
        }
        // Error de autenticación...
        else if($numError == 1045)
        {
            echo "<br>Error: Error en la autenticación.<br>";
        }
    } finally {
        // Cierro la conexion
        unset($conexion);
    }
}
?>