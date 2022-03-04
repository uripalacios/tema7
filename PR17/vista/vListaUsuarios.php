<table class="table">
    <thead>
        <th>Usuario</th>
        <th>Email</th>
        <th>Fecha de Nacimiento</th>
        <th>Perfil</th>
        <th>Mostrar</th>
        <th>Eliminar</th>
    </thead>
    <tbody>
    <?php

        foreach ($lista as $value) {
            echo "<tr>";
            echo "<td>" . $value->usuario . "</td>";
            echo "<td>" . $value->email . "</td>";
            echo "<td>" . $value->fecha_nacimiento . "</td>";
            echo "<td>" . $value->perfil . "</td>";

            // Mostrar
            echo "<td>";
                echo "<a href='index.php?mostrar=" . $value->usuario. "'>Mostrar</a>";
            echo "</td>";

            // Eliminar
            echo "<td>";
                echo "<a href='index.php?eliminar=" . $value->usuario. "'>Eliminar</a>";
            echo "</td>";

            echo "</tr>";
        }
    ?>
    </tbody>
</table>