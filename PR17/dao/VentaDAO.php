<?php

class VentaDAO implements DAO
{

    // Método que lista todas las ventas
    public static function findAll()
    {
        $sql = "select id_venta, usuario, fecha_compra, cod_producto, cantidad, precio_total from venta;";
        $consulta = ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;

        while($row = $consulta->fetchObject())
        {
            $venta = new Venta($row->id_venta,$row->usuario,$row->fecha_compra,$row->cod_producto,$row->cantidad,$row->precio_total);
            $registros[$cont] = $venta;
            $cont++;
        }

        if(isset($registros))
            return $registros;
    }

    // Método que busca una venta por su id
    public static function findById($idVenta)
    {
        $sql = "select id_venta, usuario, fecha_compra, cod_producto, cantidad, precio_total from venta where id_venta=?;";
        $consulta = ConexionBD::ejecutaConsulta($sql,[$idVenta]);

        $row = $consulta->fetchObject();
        
        $venta = new Venta($row->id_venta,$row->usuario,$row->fecha_compra,$row->cod_producto,$row->cantidad,$row->precio_total);
        return $venta;
    }

    // Método que modifica/actualiza una venta
    public static function update($objeto)
    {
        $sql = "update venta set id_venta=?,usuario=?,fecha_compra=?,cod_producto=?,cantidad=?,precio_total=? where id_venta=?";
        
        $arrayParametros = [$objeto->id_venta,$objeto->usuario,$objeto->fecha_compra,$objeto->cod_producto,$objeto->cantidad,$objeto->precio_total,$objeto->id_venta];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que crea una nueva venta
    public static function save($objeto)
    {
        $sql = "insert into venta (id_venta,usuario,fecha_compra,cod_producto,cantidad,precio_total) values (?,?,?,?,?,?);";

        $arrayParametros = [$objeto->id_venta,$objeto->usuario,$objeto->fecha_compra,$objeto->cod_producto,$objeto->cantidad,$objeto->precio_total];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que elimina una venta existente
    public static function delete($objeto)
    {

    }

    // Método que elimina una venta en funcion de su id
    public static function deleteById($idVenta)
    {
        $sql = "delete from venta where id_venta=?;";

        $arrayParametros = [$idVenta];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }
}

?>