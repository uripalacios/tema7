<?php

    // Función que valida que se ha enviado el formulario
    function validaEnviado($nombre)
    {
        // Si se ha enviado...
        if (isset($_REQUEST[$nombre])) 
            $correcto = true;
        else 
            $correcto = false;

        return $correcto;
    }

    // Funcion que valida si está vacío un campo
    function validaSiVacio($campo,$nombre)
    {
        // Si se ha enviado el formulario...
        if (validaEnviado($nombre)) 
        {
            // Si no está vacío
            if (!empty($_REQUEST[$campo])) 
            {
                // Muestro el valor del campo en el input
                echo $_REQUEST[$campo];

                $correcto = true;
            }
            else 
                $correcto = false;

            return $correcto;
        }
    }

    // Funcion que imprime un mensaje de error en el caso de que el campo esté vacío
    function imprimeError($arrayErrores,$idCampo,$nombre)
    {
        // Si el array de errores contiene un error de este campo
        if(isset($arrayErrores[$nombre]))
        {
            ?>
            <label for="<?php echo $idCampo ?>" style="color:red;"><?php echo $arrayErrores[$nombre] ?></label>
            <?php
        }
        
    }
?>