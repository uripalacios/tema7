<?php

// Funcion que comprueba si el usuario y la contraseña son correctos (accediendo a la BBDD) 
function valida($user,$pass)
{

    try
    {

        // Nos conectamos a la BBDD
        $con = new PDO("mysql:host=" . HOST . ";dbname=" . BBDD,USER,PASS);

        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        // Consulta
        $sql = $con->prepare("select * from usuarios where usuario = :user and contraseña = :pass;");

        // Se le pasan los parámetros
        $sql->bindParam(":user",$user);
        
        //$encriptada = sha1($pass);
        $sql->bindParam(":pass",$pass);

        // Ejecuto 
        $sql->execute();

        // Aprovechamos a coger el nombre y el perfil

        // Si ha habido registros... (existe el usuario)
        if($sql->rowCount() == 1)
        {
            // Inicio sesion
            session_start();

            // Guardamos en el array de session el nombre, usuario y perfil
            $row = $sql->fetch();

            $_SESSION["validada"] = true;
            $_SESSION["usuario"] = $row["usuario"];
            $_SESSION["perfil"] = $row["perfil"];

            // Páginas a las que puede acceder //
            $sqlPaginas = $con->prepare("select descripcion,url from paginas p join accede a on (p.codigo=a.codigoPagina) where codigoPerfil = :perfil");
            $sqlPaginas->bindParam(":perfil",$_SESSION["perfil"]);
            $sqlPaginas->execute();

            // Array que almacenará las páginas
            $arrayPaginas = array();

            // Se recorre el resultado
            while($row = $sqlPaginas->fetch())
            {
                // Añado el array asociativo  ($row[0] es el nombre de la pagina, y $row[1] es la url)
                $arrayPaginas[$row[0]] = $row[1];
            }

            // Guardo el array de páginas en la sesión
            $_SESSION["paginas"] = $arrayPaginas;

            // Cierre de conexion
            unset($con);
            
            return true;
        }
        else
        {
            // Cierre de conexion
            unset($con);

            return false;
        }

    }
    catch(PDOException $ex)
    {
        echo "Error: " . $ex;
    }
}

?>