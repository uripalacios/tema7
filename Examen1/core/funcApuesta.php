<?php

    function generarCheck($apuesta){
        //Comprueba que haya una apuesta y genero el array con los valores
        if($apuesta){
            //recojo los valores de la apuesta
            $n1 = $apuesta->n1;
            $n2 = $apuesta->n2;
            $n3 = $apuesta->n3;
            $n4 = $apuesta->n4;
            $n5 = $apuesta->n5;

            $arrayApuestas = [];
            
            array_push($arrayApuestas,$n1);
            array_push($arrayApuestas,$n2);
            array_push($arrayApuestas,$n3);
            array_push($arrayApuestas,$n4);
            array_push($arrayApuestas,$n5);

            //genero los checks y marco como checked los que esten en el array

            for ($i=1; $i <= 50; $i++){ 
                if(in_array($i,$arrayApuestas)){
                    echo "<input type='checkbox' name='checks[]' id='" . $i . "' value='" . $i . " checked'>";
                    echo "<label for='".$i."'>" . $i . "</label>";
                }else{
                    echo "<input type='checkbox' name='checks[]' id='" . $i . "' value='" . $i . "'>";
                    echo "<label for='".$i."'>" . $i . "</label>";
                }
            }
        }
        //Si no hay apuesta, genero los checks vacios
        else{
            for ($i=1; $i <= 50; $i++) 
            {
                echo "<input type='checkbox' name='checks[]' id='" . $i . "' value='" . $i . "'>";
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
