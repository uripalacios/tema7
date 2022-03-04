<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Modificar el stock de un producto</h1>
    
    <?php
        // Importaciones //
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/funcionesValidarProducto.php");

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

            // Recojo los datos del producto
            if(isset($_SESSION["arrayProducto"]))
            {
                $arrayProducto = $_SESSION["arrayProducto"];
            }

            // Se valida el usuario
            if(($arrayUsuario["perfil"] == "P_ADMIN")||(($arrayUsuario["perfil"] == "P_MODERADOR")))
            {
                // Si se selecciona 'Guardar Cambios'...
                if(isset($_REQUEST["Enviado"]))
                {
                    if($_REQUEST["Enviado"] == "Guardar Cambios")
                    {
                        if(validaEnviado()) 
                        {
                            // Si se valida el formulario... (si el stock no está vacío y es correcto...)
                            if(!empty($_REQUEST["stock"])&&(validaStock(false)))
                            {
                                // Guardo los cambios del stock del producto en la BBDD
                                modificarProducto($_SESSION["arrayProducto"][0],$_SESSION["arrayProducto"][1],$_SESSION["arrayProducto"][2],$_REQUEST["stock"],true);
                            }
                        }
                    }
                }
            }
            else
            {
                header("Location: ./error/403.php");
            }
        }

    ?>

    <!-- Datos del Producto -->
    <!-- Formulario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="formulario" id="idFormulario"  enctype="multipart/form-data">
            
            <!-- Input oculto que llevará el código del Producto -->
            <input type="hidden" name="inputCodigoProducto"  value="<?php
                if(isset($_REQUEST['cod_p']))
                {
                    // Imprimo el valor actual del cod_p (la primera vez siempre lo lloeva)
                    echo $_REQUEST["cod_p"];
                    
                    // Guardo en la sesión los datos de dicho producto
                    $_SESSION["arrayProducto"] = devuelveDatosProducto($_REQUEST["cod_p"]);
                    //$arrayProducto = $_SESSION["arrayProducto"];
                }
            ?>">

            <!-- Codigo - Alfanumérico (solo lectura) -->
            <section>
                <label for="idCodigo">Codigo del Producto:</label>

                <input type="text" name="codigo" id="idCodigo" size="25" placeholder="Código" readonly value="<?php  
                        // Valor
                        echo $_SESSION["arrayProducto"][0];
                    ?>">

            </section>

            <!-- Stock - Entero -->
            <section>
                <label for="idStock">Stock:</label>

                <input type="number" id="idStock" name="stock" step="any" min="<?php //echo ($_SESSION["arrayProducto"][3] + 1);?>" placeholder="Stock" value="<?php

                    // Valor
                    echo $_SESSION["arrayProducto"][3];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idStock",'stock',"Debe introducir un stock");

                    // Función que comprueba que el stock se haya incrementado
                    validaStock(true);
                ?>
            </section>
            <hr>
            <!-- Guardar Cambios - Input de tipo Submit -->
            <input type="submit" value="Guardar Cambios" id="idGuardarCambios" name="Enviado">
            
        </form>
    </div>

    <!-- Volver al Menú (menu.php) -->
    <br>
    <a href="./productos.php" title="Volver a la página de Productos">Volver a Productos</a>
</body>
</html>