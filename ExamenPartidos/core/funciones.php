<?php
    // Funcion get
    function get()
    {
        // Objeto de tipo curl para hacer la peticion a la PR18
        // (al no indicarle nada por defecto será de tipo 'get')
        $ch = curl_init();
        //Api
        curl_setopt($ch, CURLOPT_URL, "http://10.1.160.105/tema7/apiPartido/index.php/partido");

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        // Ejecuto la conexion
        $res = curl_exec($ch);

        
        

        // Cierre de la conexión
        curl_close($ch);
        return $res;
    }

    // Funcion post
    function post($objeto)
    {
        // Objeto de tipo curl
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://10.1.160.105/tema7/apiPartido/index.php/partido");

        // Se formatea el array para que lo entienda la cabecera del http
        $datoshttp = http_build_query($objeto);

        // Se le indica que lo queremos hacer por post
        curl_setopt($ch,CURLOPT_POST,true);

        // Se le pasan los parámetros a la cabecera del post
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datoshttp);

        // Ejecuto la conexion
        $res = curl_exec($ch);

        echo "<pre>";
        print_r($res);
        echo "</pre>";

        // Cierre de la conexión
        curl_close($ch);
    }

    // Funcion put
    function put($objeto)
    {
        // Objeto de tipo curl para hacer la peticion a la PR18
        $ch = curl_init();

        // url
        curl_setopt($ch, CURLOPT_URL, "http://10.1.160.105/tema7/apiPartido/index.php/partido/" . $objeto["id"]);

        // Se formatea el array a formato json
        $datosjson = json_encode($objeto);

        // Se le indica que lo queremos hacer por put, indicandole como va a ir la cabecera
        curl_setopt($ch,CURLOPT_HTTPHEADER,
            array("Content-Type: application/json",
                    "Content.length: " . strlen($datosjson)));

        // Se le pasan los parámetros a la cabecera del post
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');

        // Parametros
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datosjson);

        // Quiero respuesta
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        // Ejecuto la conexion
        $res = curl_exec($ch);

        echo "<pre>";
        print_r($res);
        echo "</pre>";

        // Cierre de la conexión
        curl_close($ch);
    }

    // Funcion delete
    function delete($objeto)
    {
        // Objeto de tipo curl para hacer la peticion a la PR18
        $ch = curl_init();

        // url
        curl_setopt($ch, CURLOPT_URL, "http://10.1.160.104/Tema7/miapi/miapi.php/usuarios/" . $objeto["id"]);

        // Se le pasan los parámetros a la cabecera del post
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'DELETE');

        // Quiero respuesta
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        // Ejecuto la conexion
        $res = curl_exec($ch);

        // Cierre de la conexión
        curl_close($ch);
    }

    
?>