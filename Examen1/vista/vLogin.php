<?php
if(isset($_SESSION['mensaje'])){
    echo $_SESSION['mensaje'];
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="">Inicio Sesion</label>
    <label for="nombre">Nombre:
        <input type="text" name="nombre" id="nombre">
    </label>
    <label for="pass">Contraseña:
        <input type="password" name="pass" id="pass">
    </label>
    <label for="recuerdame">
        <input type="checkbox" name="recuerdame" id="recuerdame">
    </label>
    <input type="submit" value="Iniciar Sesión" name="iniciar">

</form>