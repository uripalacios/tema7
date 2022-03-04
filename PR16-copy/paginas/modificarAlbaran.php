<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Albarán</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Modificar Albarán</h1>

    <?php
        // Importaciones //
        require_once("../funciones/validaSesion.php");
        require_once("../funciones/funcionesBBDD.php");
        require_once("../funciones/funcionesValidarAlbaran.php");

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
                             // Guardo los cambios del albaran en la BBDD
                            modificarAlbaran($_REQUEST["id"],$_REQUEST["fecha"],$_REQUEST["codProducto"],$_REQUEST["cantidad"],$_REQUEST["usuario"]);
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

    <!-- Datos del Albaran -->
    <!-- Formulario -->
    <div class="formulario">

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="formulario" id="idFormulario"  enctype="multipart/form-data">

            <!-- Input oculto que llevará el id del Albaran -->
            <input type="hidden" name="inputIdAlbaran"  value="<?php
                if(isset($_REQUEST['id_albaran']))
                {
                    echo $_REQUEST["id_albaran"];
                    
                    $_SESSION["arrayAlbaran"] = devuelveDatosAlbaran($_REQUEST["id_albaran"]);
                }
            ?>">

            <!-- ID - Alfanumérico (solo lectura) -->
            <section>
                <label for="idId">ID:</label>

                <input type="text" name="id" id="idId" size="25" placeholder="ID" readonly value="<?php  
                        
                        // Valor
                        echo $_SESSION["arrayAlbaran"][0];
                    ?>">

            </section>

            <!-- Fecha - Date -->
            <section>
                <label for="idFecha">Fecha:</label>

                <input type="date" id="idFecha" name="fecha" size="50" placeholder="Fecha" value="<?php

                    // Valor
                    echo $_SESSION["arrayAlbaran"][1];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idFecha",'fecha',"Debe introducir una fecha");
                ?>
            </section>

            <!-- Código del Producto -->
            <section>
                <label for="idCodProducto">Código del producto:</label>

                <input type="text" id="idCodProducto" name="codProducto" placeholder="Código del producto" value="<?php

                    // Valor
                    echo $_SESSION["arrayAlbaran"][2];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idCodProducto",'codProducto',"Debe introducir un código de producto");
                ?>
            </section>

            <!-- Cantidad - Entero -->
            <section>
                <label for="idCantidad">Cantidad:</label>

                <input type="number" id="idCantidad" name="cantidad" step="any" min="1" placeholder="Cantidad" value="<?php

                    // Valor
                    echo $_SESSION["arrayAlbaran"][3];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idCantidad",'cantidad',"Debe introducir una cantidad");
                ?>
            </section>

            <!-- Usuario -->
            <section>
                <label for="idUsuario">Usuario:</label>

                <input type="text" id="idUsuario" name="usuario" placeholder="Usuario" value="<?php

                    // Valor
                    echo $_SESSION["arrayAlbaran"][4];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idUsuario",'usuario',"Debe introducir un usuario");
                ?>
            </section>
            <hr>

            <!-- Guardar Cambios - Input de tipo Submit -->
            <input type="submit" value="Guardar Cambios" id="idGuardarCambios" name="Enviado">
        </form>
    </div>
    <!-- Volver a Albaranes -->
    <br>
    <a href="./albaranes.php">Volver a Albaranes</a>
    
</body>
</html>