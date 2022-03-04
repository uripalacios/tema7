<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Modificar Producto</h1>

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
            if($arrayUsuario["perfil"] == "P_ADMIN")
            {
                // Si se selecciona 'Guardar Cambios'...
                if(isset($_REQUEST["Enviado"]))
                {
                    if($_REQUEST["Enviado"] == "Guardar Cambios")
                    {
                        if(validaFormulario(false))
                        {
                            // Guardo los cambios del usuario en la BBDD
                            modificarProducto($_REQUEST["codigo"],$_REQUEST["descripcion"],$_REQUEST["precio"],$_REQUEST["stock"],false);
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
                    echo $_REQUEST["cod_p"];
                    
                    $_SESSION["arrayProducto"] = devuelveDatosProducto($_REQUEST["cod_p"]);
                }
            ?>">

            <!-- Codigo - Alfanumérico (solo lectura) -->
            <section>
                <label for="idCodigo">Codigo:</label>

                <input type="text" name="codigo" id="idCodigo" size="25" placeholder="Código" readonly value="<?php  
                        
                        // Valor
                        echo $_SESSION["arrayProducto"][0];
                    ?>">
            </section>

            <!-- Descripción - Alfanumérico -->
            <section>
                <label for="idDescripcion">Descripción:</label>

                <input type="text" id="idDescripcion" name="descripcion" size="50" placeholder="Descripción" value="<?php

                    // Valor
                    echo $_SESSION["arrayProducto"][1];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idDescripcion",'descripcion',"Debe introducir una descripción");
                ?>
            </section>

            <!-- Precio - Float -->
            <section>
                <label for="idPrecio">Precio (€):</label>

                <input type="number" id="idPrecio" name="precio" step="any" min="0" placeholder="Precio (€)" value="<?php

                    // Valor
                    echo $_SESSION["arrayProducto"][2];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idPrecio",'precio',"Debe introducir un precio (€)");
                ?>
            </section>

            <!-- Stock - Entero (solo lectura) -->
            <section>
                <label for="idStock">Stock:</label>

                <input type="number" id="idStock" name="stock" step="any" min="0" placeholder="Stock" readonly value="<?php

                    // Valor
                    echo $_SESSION["arrayProducto"][3];
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idStock",'stock',"Debe introducir un stock");
                ?>
            </section>
            <hr>
            <!-- Guardar Cambios - Input de tipo Submit -->
            <input type="submit" value="Guardar Cambios" id="idGuardarCambios" name="Enviado">
            
        </form>
    </div>

    <!-- Volver al Menú -->
    <br>
    <a href="./productos.php">Volver a Productos</a>
    
</body>
</html>