<table>
    <thead>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Ver</th>
        <th>Modificar</th>
        <th>Eliminar</th>
    </thead>
    <tbody>
        <?
            $productos = json_decode($productos,true);
            foreach ($productos as $value) {
                # code...
                echo "<tr>";
                echo "<td>".$value['codigo']."</td>";
                echo "<td>".$value['nombre']."</td>";
                echo "<form action='./index.php' method='post'>";
                echo "<input type='hidden' name ='codigo' value='".$value['codigo']."'>";
                echo "<td><input type='submit' name ='Ver' value='Ver'></td>";
                echo "<td><input type='submit' name ='modificar' value='Modificar'></td>";
                echo "<td><input type='submit' name ='eliminar' value='Eliminar'></td>";
            }

        ?>
    </tbody>
</table>

<?

print_r($productos);
echo "mostrar";