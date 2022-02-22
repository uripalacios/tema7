<?php

    function generarCheck($apuesta){
        //Comprueba que haya una apuesta y genero el array con los valores
        if($apuesta){
            
        }
        //Si no hay apuesta, genero los checks vacios
        else{
            for ($i=1; $i <= 50; $i++) 
            {
                echo "<input type='checkbox' name='checks[]' id='" . $i . "' value='" . $i . "' "  . ">";
                echo "<label for='".$i."'>" . $i . "</label>";
            }
        }
    }

    function compruebaChecks($campo){
        $correcto = true;
        // Si no se ha seleccionado ningun check...
        if ((!isset($_REQUEST[$campo]))){
            $correcto = false;

            // Muestro un mensaje de error
            ?>
                <label style="color:red;"><?php echo "Debe seleccionar 5 checks" ?></label>
            <?php
        }
        // 5 check maximo
        else if (isset($_REQUEST[$campo])){
            
            if ((count($_REQUEST[$campo]) > 5) || (count($_REQUEST[$campo]) < 1)){
                $correcto = false;

                ?>
                    <label style="color:red;"><?php echo "Debe seleccionar 5 checks" ?></label>
                <?php
            }
              
        
        }
        return $correcto;
    }
