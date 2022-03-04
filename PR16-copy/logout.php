
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="./webroot/css/style.css">

    <!-- @author - Ismael Maestre Carracedo  -->
</head>
<body>

    <h1>La sesión se ha cerrado</h1>
    
    <?php
        // Utilizamos la sesion activa para posteriormente destruirla
        session_start();

        // Cerramos la sesion
        session_destroy();
    ?>

    <a href="./login.php" title="Volver a la página de Login">Volver a Login</a>
</body>
</html>