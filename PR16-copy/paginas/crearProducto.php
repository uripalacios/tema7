<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo Producto</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="../webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>Crear un nuevo Producto</h1>

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
            header("Location: ../login.php");
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
                    if($_REQUEST["Enviado"] == "Crear Producto")
                    {
                        if(validaFormulario(true))
                        {
                            // Creo el producto y lo inserto en la BBDD
                            crearProducto($_REQUEST["codigo"],$_REQUEST["descripcion"],$_REQUEST["precio"],$_REQUEST["stock"]);
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

            <!-- Codigo - Alfanumérico (solo lectura) -->
            <section>
                <label for="idCodigo">Codigo:</label>

                <input type="text" name="codigo" id="idCodigo" size="25" placeholder="Código" value="<?php  
                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('codigo');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idCodigo",'codigo',"Debe introducir un código");

                    validaCodigoProducto(true);
                ?>
            </section>

            <!-- Descripción - Alfanumérico -->
            <section>
                <label for="idDescripcion">Descripción:</label>

                <input type="text" id="idDescripcion" name="descripcion" size="50" placeholder="Descripción" value="<?php
                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('descripcion');
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
                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('precio');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idPrecio",'precio',"Debe introducir un precio (€)");
                ?>
            </section>

            <!-- Stock - Entero (solo lectura) -->
            <section>
                <label for="idStock">Stock:</label>

                <input type="number" id="idStock" name="stock" step="any" min="0" placeholder="Stock" value="<?php
                    // Si no está vacío, se guarda el texto introducido
                    validaSiVacio('stock');
                ?>">

                <?php
                    // En caso de que esté vacío, se muestra un error
                    imprimeError("idStock",'stock',"Debe introducir un stock");
                ?>
            </section>
            <hr>

            <!-- Editar Perfil - Input de tipo Submit -->
            <input type="submit" value="Crear Producto" id="idGuardarCambios" name="Enviado">

        </form>
    </div>

    <br>
    <a href="./productos.php">Volver a Productos</a>
</body>
</html>