<?php
    echo "<h3>Detalle Producto " . $producto->codigo_producto . "</h3>";
?>
<div class="formulario">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    
    <?php
        comprobarUltimasVisitas($producto->codigo_producto,$_SESSION["usuario"]);
    ?>

    <!-- Añadir/Quitar producto a la lista de deseos -->
    <section>
        <label for="deseo">
            <?php
                // Si el producto está deseado
                if(compruebaDeseado($producto->codigo_producto,$usuario->usuario))
                {
                    echo "Quitar de la lista de deseos";
                }
                else
                {
                    echo "Añadir a la lista de deseos";
                }
            ?>
        </label>
            
        <?php 
            
            if(compruebaDeseado($producto->codigo_producto,$usuario->usuario))
            {
                echo "<a href='configurarDeseos.php?cod_p=" . $producto->codigo_producto . "&añadir=false&usuario=" . $_SESSION["usuario"] . "'><img id='imagenCorazon' title='Quitar producto de la lista de deseos' src='./webroot/img/corazonLleno.png'></a>";
            }
            else
                echo "<a href='configurarDeseos.php?cod_p=" . $producto->codigo_producto . "&añadir=true&usuario=" . $_SESSION["usuario"] . "'><img id='imagenCorazon' title='Añadir producto a la lista de deseos' src='./webroot/img/corazonVacio.png'></a>";
        ?>
        <br>
    </section>

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
        <input  type="text" name="descripcion" id="descripcion" placeholder="Descripción" readonly value="<?php 
                
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
        <input type="number" name="precio" id="precio" placeholder="Precio (€)" readonly value="<?php 
            
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

    <!-- Cantidad -->
    <section>
        <label class="form-group" for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" placeholder="Cantidad a comprar" value="<?php

            //echo $producto->stock;

            // Si no está vacío, se guarda el texto introducido
           validaSiVacio('cantidad','comprar');
        ?>">

        <?php
            // En caso de que esté vacío o mal formado, se muestra un error
            imprimeError($_SESSION["erroresComprar"],'cantidad','cantidad');
        ?>
    </section>

    <br><hr><br>
    
    <input type="submit" value="Comprar" name="comprar">

    <?php
        if(isset($_SESSION["perfil"]))
        {
            if($_SESSION["perfil"] == "P_ADMIN")
            {
                echo "<input type='submit' value='Modificar' title='Ir a Modificar' name='modificar'>";
                echo "<input type='submit' value='Incrementar' title='Incrementar el stock de ete producto' name='incrementar'>";            
            }
        }
    ?>

    <input type="submit" value="Volver" name="volver">
    
</form>
</div>