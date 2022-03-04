<?php

// Conexion de la BBDD
require_once("./conexionBD.php");

// Funcion que crea la BBDD
function creaBD()
{
    $miConexion = new mysqli();

    // El '@' para que no muestre el error por la pantalla
    @$miConexion->connect(HOST,USER,PASS);

    // Si se ha producideo un error al realizar la conexion...
    if($miConexion->connect_errno != 0)
    {
        echo "Error al realizar la conexión<br>";
        echo "Tipo error: " . $miConexion->connect_error . "<br>";

        // Se sale
        exit();
    }
    // Si la conexion ha ido bien...
    else
    {
        echo "Conexión realizada correctamente.<br>";

        // Importo el fichero .sql 
        require_once("./crearBD.sql");

        $miBD = new mysqli();

        @$miBD->connect(HOST,USER,PASS);

        // SI hay errores...
        if($miBD->connect_errno != 0)
        {
            echo "Error de conexión.";
        }
        else
        {
            $comandosSQL = file_get_contents("./crearBD.sql");
            $miBD->multi_query($comandosSQL);

            // Si la base ya existe...
            if($miBD->errno == 1007)
            {
                echo "Error al crear la BBDD (ya existe).";
            }
            else
            {
                echo "Todo correcto.";
                
            }

            $miBD->close();
            
        }

        // Cierro la conexión
        $miConexion->close();
    }
}

// Invoco a la funcion
creaBD();

// Vuelvo a la página principal
//header("Location: ../index.php");
print "<script>window.setTimeout(function() { window.location = '../index.php' },0);</script>";

?>