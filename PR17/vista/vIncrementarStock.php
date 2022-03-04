<?php
    echo "<h3>Incrementar stock del Producto " . $producto->codigo_producto . "</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

    <!-- Stock -->
    <section>
        <label class="form-group" for="stock">Stock Actual:</label>
        <input type="number" name="stock" id="stock" placeholder="Stock" readonly value="<?php

            echo $producto->stock;
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresIncrementar"],'stock','stock');
        ?>
    </section>

    <!-- Cantidad a incrementar -->
    <section>
        <label class="form-group" for="cantidad">Cantidad a incrementar:</label>
        <input type="number" name="cantidad" step="1" id="cantidad" placeholder="Cantidad a incrementar" value="<?php

            echo $producto->stock;
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresIncrementar"],'cantidad','cantidad');
        ?>
    </section>

    <br><hr>
    
    <input type="submit" value="Guardar" name="incrementarStock">
    <input type="submit" value="Volver" name="volverDetalle">
    
</form>
</div>