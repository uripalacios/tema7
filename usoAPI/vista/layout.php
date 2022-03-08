<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <header class="navbar">
        <!-- mostratr un boton de ir al login 
    si no esta logueado y dos botontes
    uno de perfil y otro de logout -->

        <h1>MVC</h1>
    </header>    
    <main class="container">
        <div class="row">
            <?php
            
                require_once $vistas;
           
            ?>
        </div>
    </main>
    <footer class="text-center">
        Derecho de autora Uriel
    </footer>

</body>

</html>