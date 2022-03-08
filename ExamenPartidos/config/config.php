<?php



//validacion
include './core/funciones.php';

require './config/datosBD.php';
require './modelo/ConexionBD.php';
require './dao/DAO.php';
require './modelo/Usuario.php';
require './dao/UsuarioDAO.php';

$controladores = [
    'login' => 'controlador/cLogin.php',
    'partido' => 'controlador/cPartido.php',
    'admin' => 'controlador/cAdmin.php'
];

$vistas = [
    'login' => 'vista/vLogin.php',
    'layout' => 'vista/vLayout.php',
    'partido' => 'vista/vPartido.php',
    'admin' => 'vista/vAdmin.php',
    'modificar' => 'vista/vModificar',
    'insertar' => 'vista/vInsertar'
];
?>