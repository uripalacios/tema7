<?php

    class ConexionBD{
            //se le pasa la consulta preparada ?? :
            //y un array con todos los parametros que necesite la consulta preparada
        public static function ejecutaConsulta($sql,$parametros){

            try {
                $con = new PDO("mysql:host=".IP.";dbname=".BBDD,USER,PASS);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $consulta = $con->prepare($sql);
                $consulta->execute($parametros);
            } catch (PDOException $ex) {
                {
                    $consulta = null;
                    //echo "Error: " . $ex->getMessage();
                    $bc = new BaseControlador();
    
                    $bc->sendRespuesta(
                        json_encode(array("error" => "No se ha poddifo conectar a la BBDD")),
                        array("Content-Type: application/json",
                        "HTTP/1.1 500 Fallo en el Servidor")
                    );
    
                    exit();
    
                    return null;
                }
                
            }finally{
                unset($con);
                return $consulta;
            }
        }
    }
?>