<?php

    $url ="http://dataservice.accuweather.com/forecasts/v1/daily/5day/303121?apikey=f1zGUaQSulZVATLOuWmcLuHtYmjiiYt3&metric=true&language=es";

    $devuelve = file_get_contents($url);

    if($devuelve){
        $json = json_decode($devuelve,true);
    }
    ?>
    <h1>Zamora</h1>
    <table border="1">
        <thead>
            <th>Dia</th>
            <th>T-min</th>
            <th>T-max</th>
            <th>Previsión</th>
        </thead>
        <tbody>
            <?
                foreach ($json['DailyForecasts'] as $key1=>$value1) {
                    echo "<tr><td>";
                    echo $value1['Date'];
                    echo "</td><td>";
                    foreach ($value1['Temperature'] as $value2) {
                        foreach ($value2['Minimum'] as $value3){
                            echo $value3['Value'];
                            echo "</td><td>";
                        }
                        foreach ($value2['Maximum'] as $value3) {
                            echo $value3['Value'];
                            echo "</td><td>";
                        }
                    }
                    foreach ($value1['Day'] as $value2){
                        echo $value2['IconPhrase'];
                    }
                    echo "</td></tr>";
                }
            ?>
        </tbody>
    </table>