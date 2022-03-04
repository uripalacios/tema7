<h2>Lista de Deseos</h2>

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

            $contadorDeseados = 0;

            foreach ($lista as $value) 
            {
                if(compruebaDeseado($value->codigo_producto,$_SESSION["usuario"]))
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
                                // Ver Producto
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

                    $contadorDeseados++;
                }

            }

            if($contadorDeseados == 0)
            {
                echo "<h3>No hay productos en tu lista de deseos</h3>";
            }

            echo "</tbody>";
            echo "</table>";
        }
        else
        {
            echo "<h3>No hay productos en tu lista de deseos</h3>";
        }
    }
    else
    {
        echo "<h3>No hay productos en tu lista de deseos</h3>";
    }
?>
</form>
    