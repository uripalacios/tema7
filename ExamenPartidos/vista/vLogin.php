<?php
    if(isset($_SESSION["mensaje"]))
    {
        echo $_SESSION["mensaje"];
    }
?>

<!-- Formulario de Login del Usuario -->
<div class="formulario">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <section>
            <label for="nombre">Nombre:</label> 
            <input type="text" name="nombre" id="nombre" placeholder="Nombre de Usuario" value="<?php 
            
                // Si se quiere recordar el usuario...
                if(isset($_COOKIE["recordarUsuario"]))
                    echo $_COOKIE["recordarUsuario"];
            ?>">
        </section><br>

        <section>
            <label for="pass">Contraseña:</label> 
            <input type="password" name="pass" id="pass" placeholder="contraseña">
        </section>
        <br>

        <!-- Recordar usuario -->
        <section>
            <label for="check">Recordar Usuario</label>
            <input type="checkbox" name="check" id="check" <?php 
            
                // Si esxiste la cookie... recuerdo el check
                if(isset($_COOKIE["recordarUsuario"]))
                    echo "checked";
                
            ?>>
        </section><br>

        <input type="submit" value="Iniciar Sesión" name="iniciar">
        
    </form>
</div>
<?php
    if(isset($_SESSION["mensaje"]))
    {
        unset($_SESSION["mensaje"]);
    }
?>