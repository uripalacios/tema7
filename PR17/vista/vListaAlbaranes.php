<h2>Lista de Albaranes</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php
    if(isset($lista))
    {
        if(count($lista) > 0)
        {

            echo "<table class='table'>";
                echo "<thead>";
                    echo "<th><b>ID</b></th>";
                    echo "<th><b>Fecha</b></th>";
                    echo "<th><b>Cod producto</b></th>";
                    echo "<th><b>Cantidad</b></th>";
                    echo "<th><b>Cod Usuario</b></th>";

                    // Si el usuario es administrador...
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
                            echo "<td>" . $value->id_albaran . "</td>";
                            echo "<td>" . $value->fecha . "</td>";
                            echo "<td>" . $value->cod_producto . "</td>";
                            echo "<td>" . $value->cantidad . "</td>";
                            echo "<td>" . $value->usuario . "</td>";
        
                            if(isset($_SESSION["validada"]))
                            {
                                if($_SESSION["validada"] == true)
                                {
                                    if($_SESSION["perfil"] == "P_ADMIN")
                                    {
                                        // Modificar Albaran
                                        echo
                                            "<td>".
                                            "<form action='". $_SERVER['PHP_SELF']."' method='post'>".
                                            "<input type='submit' title='Modificar Albaran' value='Modificar Albaran' name='modificar'>".
                                            "<input type='hidden' name='idAlbaran' value='$value->id_albaran'>".
                                            "</form>"
                                            . "</td>";
        
                                        // Eliminar Albaran
                                        echo
                                        "<td>".
                                        "<form action='". $_SERVER['PHP_SELF']."' method='post'>".
                                        "<input type='submit' title='Eliminar Albaran' value='Eliminar Albaran' name='eliminar'>".
                                        "<input type='hidden' name='idAlbaran' value='$value->id_albaran'>".
                                        "</form>"
                                        . "</td>";
                                    }
                                }
                            }
                            
                        echo "</tr>";
                    }
        }
        else
        {
            echo "<h3>No hay albaranes</h3>";
        }
    }
    else
    {
        echo "<h3>No hay albaranes</h3>";
    }
            
    ?>

</tbody>
</table>
<!-- Volver a Inicio -->
<input type="submit" value="Volver" name="volverInicio">
</form>