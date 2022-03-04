<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR17 - Ismael Maestre</title>

    <!-- Enlace al css -->
    <link rel="stylesheet" href="./webroot/css/style.css">
    
</head>

<body>
    
    <!-- Cabecera de la Aplicación -->
    <header class="cabecera">
    <div>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

            <!-- Elemento Izquierdo -->
            <!-- Menu desplegable -->
            <div class="menu" id="menu">
                <nav id="navega">

                <!-- Listado de las paginas -->
                <ul>

                    <!-- Productos -->
                    <li>
                        <input type="submit" value="Ver Productos" id="verProductos" name="verProductos">
                    </li>

                    <?php

                    // Si está validada la sesión...
                    if (isset($_SESSION['validada'])) 
                    {
                    ?>
                        <!-- Lista de deseos -->
                        <li>
                            <input type="submit" value="Lista de Deseos" id="listaDeseos" name="listaDeseos">
                        </li>
                    <?php
                    }

                    if(isset($_SESSION['perfil']))
                    {
                        // Si el perfil del usuario es de tipo ADMINISTRADOR...
                        if($_SESSION['perfil'] == 'P_ADMIN')
                        {
                    ?>
                            <!-- Insertar un nuevo producto -->
                            <li>
                                <input type="submit" value="Crear Producto" id="insertarProducto" name="insertarProducto">
                            </li>

                            <!-- Ventas -->
                            <li>
                                <input type="submit" value="Mostrar ventas" id="mostrarVentas" name="mostrarVentas">
                            </li>

                            <!-- Albaranes -->
                            <li>
                                <input type="submit" value="Mostrar albaranes" id="mostrarAlbaranes" name="mostrarAlbaranes">
                            </li>
                    <?php  
                        }                          
                        
                        // Si el perfil del usuario es de tipo MODERADOR...
                        if($_SESSION['perfil'] == 'P_MODERADOR')
                        {
                    ?>
                            <!-- Insertar un nuevo producto -->
                            <li>
                                <input type="submit" value="Insertar productos" id="insertarProductos" name="insertarProductos">
                            </li>

                            <!-- Ventas -->
                            <li>
                                <input type="submit" value="Mostrar ventas" id="mostrarVentas" name="mostrarVentas">
                            </li>

                            <!-- Albaranes -->
                            <li>
                                <input type="submit" value="Mostrar albaranes" id="mostrarAlbaranes" name="mostrarAlbaranes">
                            </li>
                    <?php                            
                        }
                    }
                                
                    ?>
                </ul>
                </nav>
            </div>
        </form>
    </div>

    <!-- Elemento Central -->
    <!-- Titulo -->
    <div>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="submit" value="Inicio" id="titulo" name="volver">   
        </form>
    </div>

    <!-- Elemento Derecho -->
    <!-- Perfil, Login, Logout y Usuario -->
    <div class="user">                     
    
        <?php
            if (isset($_SESSION['validada'])) 
            {
        ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="submit" value="Perfil" name="perfil">
                    <input type="submit" value="Logout" name="logout">
                </form>
        <?php
                // Codigo de Usuario
                echo "<p style='float:left'><b>" . $_SESSION['usuario'] . "</b></p>";
            } 
            else 
            {
        ?>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <input type="submit" value="Login" name="login">
                </form>
        <?php
            }
        ?>
    </div>

    </header>

    <!-- Vista -->
    <?php
        // Si no hay ninguna vista cargada...
        // Se carga la de inicio
        if (!isset($_SESSION['vista'])) 
        {
            require_once $vista['inicio'];
        }
        // Si sí la hay... la carga
        else 
        {
            require_once $_SESSION['vista'];
        }

    ?>

    </main>
    <footer>&copy;&nbsp;Ismael Maestre</footer>

    <!-- Script -->
    <script src="./webroot/js/menuLayout.js"></script>
</body>
</html>