<?php
    echo "<h3>Modificar Producto " . $producto->codigo_producto . "</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    
    <!-- Codigo Producto -->
    <section>
        <label  class="form-group"  for="codigo_producto">Código:</label> 
        <input type="text" name="codigo_producto" id="codigo_producto" readonly value="<?php 
            echo $producto->codigo_producto;    
        ?>"> <!-- Lo muestra -->
        <input type="hidden" name="codigo_producto" id="codigo_producto" value="<?php 
            
            echo $producto->codigo_producto;    
        ?>"> <!-- Lo envía -->
        <br><br>
    </section>

    <!-- Descripcion -->
    <section>
        <label class="form-group" for="descripcion">Descripción:</label> 
        <input  type="text" name="descripcion" id="descripcion" placeholder="Descripción" value="<?php 
                
            echo $producto->descripcion;
            
            // Si no está vacío, se guarda el texto introducido
            //validaSiVacio("descripcion","comprar");
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresComprar"],"descripcion",'descripcion');
        ?>
        <br><br>
    </section>

    <!-- Precio -->
    <section>
        <label class="form-group" for="precio">Precio (€):</label> 
        <input type="number" name="precio" id="precio" placeholder="Precio (€)" value="<?php 
            
            echo $producto->precio;
            
            // Si no está vacío, se guarda el texto introducido
            //validaSiVacio("precio","comprar");
        ?>">
        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresComprar"],"precio",'precio');
        ?>
        <br><br>
    </section>

    <!-- Stock -->
    <section>
        <label class="form-group" for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" placeholder="Stock" readonly value="<?php

            echo $producto->stock;

            // Si no está vacío, se guarda el texto introducido
           // validaSiVacio('email','modificar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresComprar"],'stock','stock');
        ?>
    </section>

    <br><br>
    
    <?php
        if(isset($_SESSION["perfil"]))
        {
            if($_SESSION["perfil"] == "P_ADMIN")
            {
                ?>
                <input type='submit' value='Modificar' name='modificarProducto'>
                <?php
            }
        }
    ?>
    <input type="submit" value="Volver" name="volverDetalle">
    
</form>
</div>