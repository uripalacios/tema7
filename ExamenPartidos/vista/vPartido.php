<table class="table">
    <thead>
        <th>Fecha</th>
        <th>Jugador1</th>
        <th>Jugador2</th>
        <th>Resultado</th>
    </thead>
    <tbody>
    <?php
        foreach ($lista as $value) {
            echo "<tr>";
            echo "<td>".$value['fecha']."</td>";
            echo "<td>".$value['jug1']."</td>";
            echo "<td>".$value['jug2']."</td>";
            echo "<td>".$value['resultado']."</td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>