
    <h1>Apuestas</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <?
            //generar los checks dinamicamente
                generarCheck($apuesta);

                
            //comprobar que el usuario ya haya realizado una apuesta
                //mostrar boton de modificar
            if($apuesta != null){
    ?>
        <input type="submit" value="Modificar" name="modificar">
    <?php
            }
            //Para mostrar el boton de insertar
            else{
    ?>
                <input type="submit" value="Insertar" name="insertar">
    <?php            
            }

    ?>
    </form>