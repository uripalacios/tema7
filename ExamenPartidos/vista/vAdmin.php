<table class="table">
    <thead>
        <th>Fecha</th>
        <th>Jugador1</th>
        <th>Jugador2</th>
        <th>Resultado</th>
        <th>Modificar</th>
        <th>Borrar</th>
    </thead>
    <tbody>
    <?php
        foreach ($lista as $value) {
            echo "<tr>";
            echo "<td>".$value->fecha."</td>";
            echo "<td>".$value->jug1."</td>";
            echo "<td>".$value->jug2."</td>";
            echo "<td>".$value->resultado."</td>";
            echo "<td> <a href='index.php?modificar='".$value->id."'>Modificar</a></td>";
            echo "<td> <a href='index.php?borrar='".$value->id."'>Borrar</a></td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>