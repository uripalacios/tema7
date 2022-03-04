<?php

class ProductoDAO implements DAO
{

    // Método que lista todos los productos
    public static function findAll()
    {
        $sql = "select codigo_producto, descripcion, precio, stock from productos;";
        $consulta = ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;

        while($row = $consulta->fetchObject())
        {
            $producto = new Producto($row->codigo_producto,$row->descripcion, $row->precio,$row->stock);
            $registros[$cont] = $producto;
            $cont++;
        }

        if(isset($registros))
        return $registros;
    }

    // Método que busca un producto por su codigo_producto
    public static function findById($codigoProducto)
    {
        $sql = "select codigo_producto, descripcion, precio, stock from productos where codigo_producto=?;";
        $consulta = ConexionBD::ejecutaConsulta($sql,[$codigoProducto]);

        $row = $consulta->fetchObject();
        
        $producto = new Producto($row->codigo_producto,$row->descripcion, $row->precio,$row->stock);
        return $producto;
    }

    // Método que modifica/actualiza un producto
    public static function update($objeto)
    {
        $sql = "update productos set codigo_producto=?,descripcion=?,precio=?,stock=? where codigo_producto=?";
        
        $arrayParametros = [$objeto->codigo_producto,$objeto->descripcion,$objeto->precio,$objeto->stock,$objeto->codigo_producto];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que crea un nuevo producto
    public static function save($objeto)
    {
        $sql = "insert into productos (codigo_producto,descripcion,precio,stock) values (?,?,?,?);";

        $arrayParametros = [$objeto->codigo_producto,$objeto->descripcion,$objeto->precio,$objeto->stock];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que elimina un usuario existente
    public static function delete($objeto)
    {
    
    }

    // Método que elimina un usuario en funcion de su id
    public static function deleteById($id)
    {
        $sql = "delete from productos where codigo_producto=?;";

        $arrayParametros = [$id];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

}

?>