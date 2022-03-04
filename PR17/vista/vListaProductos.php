<h2>Lista de Productos</h2>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

    if(isset($lista))
    {
        if(count($lista) > 0)
        {
            echo "<table class='table'>";
                echo "<thead>";
                    echo "<th><b>Código</b></th>";
                    echo "<th><b>Descripción</b></th>";
                    echo "<th><b>Precio</b></th>";
                    echo "<th><b>Stock</b></th>";
                    
                    
                    if(isset($_SESSION["validada"]))
                    {
                        if($_SESSION["validada"] == true)
                        {
                            echo "<th><b>Ver</b></th>";
                        }
                    }
    
                    echo "</thead>";
                    echo "<tbody>";

                    foreach ($lista as $value) 
                    {
                        echo "<tr>";
                            echo "<td>" . $value->codigo_producto . "</td>";
                            echo "<td>" . $value->descripcion . "</td>";
                            echo "<td>" . $value->precio . "</td>";
                            echo "<td>" . $value->stock . "</td>";

                            if(isset($_SESSION["validada"]))
                            {
                                if($_SESSION["validada"] == true)
                                {
                                    echo
                                        "<td>".
                                        "<form action='". $_SERVER['PHP_SELF']."' method='post'>".
                                        "<input type='submit' title='Ver Producto' value='Ver Producto' name='verProducto'>".
                                        "<input type='hidden' name='codigoProducto' value='$value->codigo_producto'>".
                                        "</form>"
                                        . "</td>";
                                }
                            }
                            
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
        }
        else
        {
            echo "<h3>No hay productos</h3>";
        }
    }
    else
    {
        echo "<h3>No hay productos</h3>";
    }
            
    ?>

</form>
<br>

<!-- Ultimos productos visitados -->
<div>
    <?php
        if(isset($_SESSION["validada"]))
        {
            echo "<h3>Últimos visitados</h3>";
            mostrarUltimosVisitados($_SESSION["usuario"]);
        }
    ?>
</div>