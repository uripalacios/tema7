<?php
    echo "<h3>Modificar Albaran " . $albaran->id_albaran . "</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    
    <!-- Id Albaran -->
    <section>
        <label  class="form-group"  for="id_albaran">Id:</label> 
        <input type="text" name="id_albaran" id="id_albaran" readonly value="<?php 
            echo $albaran->id_albaran;    
        ?>"> <!-- Lo muestra -->
        <input type="hidden" name="id_albaran" id="id_albaran" value="<?php 
            
            echo $albaran->id_albaran;    
        ?>"> <!-- Lo envía -->
        <br><br>
    </section>

    <!-- Fecha -->
    <section>
        <label class="form-group" for="fecha">Fecha:</label> 
        <input type="date" name="fecha" id="fecha" value="<?php 
            
            echo $albaran->fecha;
            
            // Si no está vacío, se guarda el texto introducido
            //validaSiVacio("precio","comprar");
        ?>">
        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresAlbaran"],"fecha",'fecha');
        ?>
        <br><br>
    </section>

    <!-- Codigo del producto -->
    <section>
        <label class="form-group" for="cod_producto">Código del Producto:</label>
        <input type="text" name="cod_producto" id="cod_producto" placeholder="Código del producto" readonly value="<?php

            echo $albaran->cod_producto;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresAlbaran"],'cod_producto','cod_producto');
        ?>
    </section>

    <!-- Cantidad -->
    <section>
        <label class="form-group" for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" value="<?php

            echo $albaran->cantidad;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresAlbaran"],'cantidad','cantidad');
        ?>
    </section>

    <!-- Usuario -->
    <section>
        <label class="form-group" for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario" readonly value="<?php

            echo $albaran->usuario;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresAlbaran"],'usuario','usuario');
        ?>
    </section>
    <br>
    
    <hr>
    <!-- Volver a la lista de Albaranes -->
    <input type="submit" value="Volver" name="volverAlbaranes">

    <!-- Modificar el Albaran -->
    <input type="submit" value="Modificar" name="modificarAlbaran">
    
</form>
</div>