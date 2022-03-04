<?php

class ConexionBD
{

        //se le pasa la consulta preparada ?? :
        // y un arrray con todos los parametros que 
        //necesite la consulta preparada
    public static function ejecutaConsulta($sql,$parametros)
    {
        try {
            $con = new PDO("mysql:host=".IP.
            ";dbname=".BBDD, USER,PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $con->prepare($sql);
            $consulta->execute($parametros);
        } catch (PDOException $ex) {
            $consulta = null;
            echo "Error: " .$ex->getMessage();            
        }finally{
            unset($con);
            return $consulta;
        }
    }
}
?>