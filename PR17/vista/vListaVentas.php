<h2>Lista de Ventas</h2>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

    if(isset($lista))
    {            
        if(count($lista) > 0)
        {
            echo "<table class='table'>";
                echo "<thead>";
                    echo "<th><b>ID</b></th>";
                    echo "<th><b>Usuario</b></th>";
                    echo "<th><b>Fecha de Compra</b></th>";
                    echo "<th><b>Cod producto</b></th>";
                    echo "<th><b>Cantidad</b></th>";
                    echo "<th><b>Precio Total (€)</b></th>";
            
                    if($_SESSION["perfil"] == "P_ADMIN")
                    {
                        echo "<th><b>Modificar</b></th>";
                        echo "<th><b>Eliminar</b></th>";
                    }    
                    
                    echo "</thead>";
                    echo "<tbody>";
            
                    foreach ($lista as $value) 
                    {
                        echo "<tr>";
                            echo "<td>" . $value->id_venta . "</td>";
                            echo "<td>" . $value->usuario . "</td>";
                            echo "<td>" . $value->fecha_compra . "</td>";
                            echo "<td>" . $value->cod_producto . "</td>";
                            echo "<td>" . $value->cantidad . "</td>";
                            echo "<td>" . $value->precio_total . "</td>";
        
                            if(isset($_SESSION["validada"]))
                            {
                                if($_SESSION["validada"] == true)
                                {
                                    if($_SESSION["perfil"] == "P_ADMIN")
                                    {
                                        // Modificar Venta
                                        echo
                                            "<td>".
                                            "<form action='". $_SERVER['PHP_SELF']."' method='post'>".
                                            "<input type='submit' title='Modificar Venta' value='Modificar Venta' name='modificar'>".
                                            "<input type='hidden' name='idVenta' value='$value->id_venta'>".
                                            "</form>"
                                            . "</td>";
        
                                        // Eliminar Venta
                                        echo
                                        "<td>".
                                        "<form action='". $_SERVER['PHP_SELF']."' method='post'>".
                                        "<input type='submit' title='Eliminar Venta' value='Eliminar Venta' name='eliminar'>".
                                        "<input type='hidden' name='idVenta' value='$value->id_venta'>".
                                        "</form>"
                                        . "</td>";
        
                                    }
                                }
                            }
                            
                        echo "</tr>";

                        
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
            }
            else
            {
                echo "<h3>No hay ventas</h3>";
            }
    }
    else
    {
        echo "<h3>No hay ventas</h3>";
    }
         
?>


<!-- Volver a Inicio -->
<input type="submit" value="Volver" name="volverInicio">
</form>