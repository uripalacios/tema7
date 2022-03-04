<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Venta</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Modificar Venta</h1>

    <?php
        // Importaciones //
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/funcionesValidarVenta.php");

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
                // Si se selecciona 'Guardar Cambios'...
                if(isset($_REQUEST["Enviado"]))
                {
                    if($_REQUEST["Enviado"] == "Guardar Cambios")
                    {
                        if(validaFormulario())
                        {
                            // Guardo los cambios de la venta en la BBDD
                            modificarVenta($_REQUEST["id"],$_REQUEST["usuario"],$_REQUEST["fecha"],$_REQUEST["codigoProducto"],$_REQUEST["cantidad"],$_REQUEST["precio"]);
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

    <!-- Datos de la Venta -->
    <!-- Formulario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="formulario" id="idFormulario"  enctype="multipart/form-data">

            <!-- Input oculto que llevará el id de la Venta -->
            <input type="hidden" name="inputIdAlbaran"  value="<?php
                if(isset($_REQUEST['id_venta']))
                {
                    echo $_REQUEST["id_venta"];
                    
                    $_SESSION["arrayVenta"] = devuelveDatosVenta($_REQUEST["id_venta"]);
                }
            ?>">

            <!-- ID - Alfanumérico (solo lectura) -->
            <section>
                <label for="idId">ID:</label>

                <input type="text" name="id" id="idId" size="25" placeholder="ID" readonly value="<?php  
                        
                        // Valor
                        echo $_SESSION["arrayVenta"][0];
                    ?>">

            </section>

            <!-- Usuario -->
            <section>
                <label for="idUsuario">Usuario:</label>

                <input type="text" id="idUsuario" name="usuario" size="50" placeholder="Usuario" value="<?php

                    // Valor
                    echo $_SESSION["arrayVenta"][1];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idUsuario",'usuario',"Debe introducir un usuario");
                ?>
            </section>

            <!-- Fecha -->
            <section>
                <label for="idFecha">Fecha:</label>

                <input type="date" id="idFecha" name="fecha" placeholder="Fecha" value="<?php

                    // Valor
                    echo $_SESSION["arrayVenta"][2];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idFecha",'fecha',"Debe introducir una fecha");
                ?>
            </section>

            <!-- Código de producto -->
            <section>
                <label for="idCodProducto">Código de producto:</label>

                <input type="text" id="idCodProducto" name="codigoProducto" placeholder="Código de producto" value="<?php

                    // Valor
                    echo $_SESSION["arrayVenta"][3];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idCodProducto",'codigoProducto',"Debe introducir un código de producto");
                ?>
            </section>

            <!-- Cantidad - Entero -->
            <section>
                <label for="idCantidad">Cantidad:</label>

                <input type="number" id="idCantidad" name="cantidad" step="any" min="1" placeholder="Cantidad" value="<?php

                    // Valor
                    echo $_SESSION["arrayVenta"][4];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idCantidad",'cantidad',"Debe introducir una cantidad");
                ?>
            </section>

            <!-- Precio Total -->
            <section>
                <label for="idPrecio">Precio (€):</label>

                <input type="number" id="idPrecio" name="precio" placeholder="Precio Total (€)" value="<?php

                    // Valor
                    echo $_SESSION["arrayVenta"][5];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idPrecio",'precio',"Debe introducir un precio (€)");
                ?>
            </section>
            <hr>

            <!-- Guardar Cambios - Input de tipo Submit -->
            <input type="submit" value="Guardar Cambios" id="idGuardarCambios" name="Enviado">
            
        </form>
    </div>

    <!-- Volver a 'ventas.php' -->
    <br>
    <a href="./ventas.php">Volver a Ventas</a>
    
</body>
</html>