<?php
    echo "<h3>Modificar Venta " . $venta->id_venta . "</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    
    <!-- Id Venta -->
    <section>
        <label  class="form-group"  for="id_venta">Id Venta:</label> 
        <input type="text" name="id_venta" id="id_venta" readonly value="<?php 
            echo $venta->id_venta;    
        ?>"> <!-- Lo muestra -->
        <input type="hidden" name="id_venta" id="id_venta" value="<?php 
            
            echo $venta->id_venta;    
        ?>"> <!-- Lo envía -->
        <br><br>
    </section>

    <!-- Usuario -->
    <section>
        <label class="form-group" for="usuario">Usuario:</label> 
        <input  type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php 
                
            echo $venta->usuario;
            
            // Si no está vacío, se guarda el texto introducido
            //validaSiVacio("descripcion","comprar");
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresVenta"],"usuario",'usuario');
        ?>
        <br><br>
    </section>

    <!-- Fecha de Compra -->
    <section>
        <label class="form-group" for="fecha_compra">Fecha de Compra:</label> 
        <input type="date" name="fecha_compra" id="fecha_compra" value="<?php 
            
            echo $venta->fecha_compra;
            
            // Si no está vacío, se guarda el texto introducido
            //validaSiVacio("precio","comprar");
        ?>">
        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresVenta"],"fecha_compra",'fecha_compra');
        ?>
        <br><br>
    </section>

    <!-- Codigo del producto -->
    <section>
        <label class="form-group" for="cod_producto">Código del Producto:</label>
        <input type="text" name="cod_producto" id="cod_producto" placeholder="Código del producto" readonly value="<?php

            echo $venta->cod_producto;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresVenta"],'cod_producto','cod_producto');
        ?>
    </section>

    <!-- Cantidad -->
    <section>
        <label class="form-group" for="cantidad">Cantidad:</label>
        <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" value="<?php

            echo $venta->cantidad;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresVenta"],'cantidad','cantidad');
        ?>
    </section>

    <!-- Precio Total (€) -->
    <section>
        <label class="form-group" for="precio_total">Precio Total (€):</label>
        <input type="number" name="precio_total" id="precio_total" placeholder="Precio Total (€)" value="<?php

            echo $venta->precio_total;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresVenta"],'precio_total','precio_total');
        ?>
    </section>
    <br>
    
    <hr>
    <!-- Volver a la lista de Ventas -->
    <input type="submit" value="Volver" name="volverVentas">

    <!-- Modificar la Venta -->
    <input type="submit" value="Modificar" name="modificarVenta">
    
</form>
</div>