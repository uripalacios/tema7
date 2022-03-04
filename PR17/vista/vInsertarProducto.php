<?php
    echo "<h3>Crear nuevo Producto</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    
    <!-- Codigo Producto -->
    <section>
        <label  class="form-group"  for="codigo_producto">Código:</label> 
        <input type="text" name="codigo_producto" id="codigo_producto" placeholder="Código" value="<?php 
            // Si no está vacío, se guarda el texto introducido
            validaSiVacio("codigo_producto","insertarProducto");    
        ?>"> <!-- Lo muestra -->

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresInsertar"],"codigo_producto",'codigo_producto');
        ?>
        <br><br>
    </section>

    <!-- Descripcion -->
    <section>
        <label class="form-group" for="descripcion">Descripción:</label> 
        <input  type="text" name="descripcion" id="descripcion" placeholder="Descripción" value="<?php             
            // Si no está vacío, se guarda el texto introducido
            validaSiVacio("descripcion","insertarProducto");    
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresInsertar"],"descripcion",'descripcion');
        ?>
        <br><br>
    </section>

    <!-- Precio -->
    <section>
        <label class="form-group" for="precio">Precio (€):</label> 
        <input type="number" name="precio" id="precio" placeholder="Precio (€)" value="<?php             
            // Si no está vacío, se guarda el texto introducido
            validaSiVacio("precio","insertarProducto");
        ?>">
        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresInsertar"],"precio",'precio');
        ?>
        <br><br>
    </section>

    <!-- Stock -->
    <section>
        <label class="form-group" for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" placeholder="Stock" value="<?php
            // Si no está vacío, se guarda el texto introducido
           validaSiVacio('stock','insertarProducto');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresInsertar"],'stock','stock');
        ?>
    </section>
    <br>
    <hr>
    
    <input type="submit" value="Crear" name="insertarProducto">
    <input type="submit" value="Volver" name="volverInicio">
    
</form>
</div>