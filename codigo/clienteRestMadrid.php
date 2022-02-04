<?php

    $url ="https://datos.madrid.es/egob/catalogo/206974-0-agenda-eventos-culturales-100.json";

    $devuelve = file_get_contents($url);

    if($devuelve){
        $json = json_decode($devuelve,true);
    }
    ?>

    <table border="1">
        <thead>
            <th>Titulo</th>
            <th>Fecha</th>
        </thead>
        <tbody>
            <?
                foreach ($json['@graph'] as $value) {
                    echo "<tr><td>";
                    echo $value['title'];
                    echo "</td><td>";
                    if(isset($value['dtstart']))
                        echo $value['dtstart'];
                    echo "</td></tr>";
                }
            ?>
        </tbody>
    </table>