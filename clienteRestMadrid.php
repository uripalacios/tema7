<?php

    $url ="https://datos.madrid.es/egob/catalogo/206974-0-agenda-eventos-culturales-100.json";

    $devuelve = file_get_contents($url);

    if($devuelve){
        $json = json_decode($devuelve);
        print_r($devuelve);
    }