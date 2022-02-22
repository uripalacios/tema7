<?php
if(isset($_SESSION['mensaje'])){
    echo $_SESSION['mensaje'];
}
echo "<h1>Iniciar Sesion</h1>";
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="">Inicio Sesion</label>
    <label for="nombre">Nombre:
        <input type="text" name="nombre" id="nombre">
    </label>
    <br>
    <label for="pass">Contraseña:
        <input type="password" name="pass" id="pass">
    </label>
    <br>
    <label for="recuerdame">Recordar
        <input type="checkbox" name="recuerdame" id="recuerdame">
    </label>
    <br>
    <input type="submit" value="Ir a apuestas" name="iniciar">

</form>