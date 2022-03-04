<?php

class AlbaranDAO implements DAO
{

    // Método que lista todos los albaranes
    public static function findAll()
    {
        $sql = "select id_albaran, fecha, cod_producto, cantidad, usuario from albaran;";
        $consulta = ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;

        while($row = $consulta->fetchObject())
        {
            $albaran = new Albaran($row->id_albaran,$row->fecha, $row->cod_producto,$row->cantidad,$row->usuario);
            $registros[$cont] = $albaran;
            $cont++;
        }

        if(isset($registros))
            return $registros;
    }

    // Método que busca un albarán por su id_albaran
    public static function findById($idAlbaran)
    {
        $sql = "select id_albaran, fecha, cod_producto, cantidad, usuario from albaran where id_albaran=?;";
        $consulta = ConexionBD::ejecutaConsulta($sql,[$idAlbaran]);

        $row = $consulta->fetchObject();
        
        $albaran = new Albaran($row->id_albaran,$row->fecha, $row->cod_producto,$row->cantidad,$row->usuario);
        return $albaran;
    }

    // Método que modifica/actualiza un albaran
    public static function update($objeto)
    {
        $sql = "update albaran set id_albaran=?,fecha=?,cod_producto=?,cantidad=?,usuario=? where id_albaran=?";
        
        $arrayParametros = [$objeto->id_albaran,$objeto->fecha,$objeto->cod_producto,$objeto->cantidad,$objeto->usuario,$objeto->id_albaran];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que crea un nuevo albaran
    public static function save($objeto)
    {
        $sql = "insert into albaran (id_albaran,fecha,cod_producto,cantidad,usuario) values (?,?,?,?,?);";

        $arrayParametros = [$objeto->id_albaran,$objeto->fecha,$objeto->cod_producto,$objeto->cantidad,$objeto->usuario];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que elimina un usuario existente
    public static function delete($objeto)
    {
    
    }

    // Método que elimina un albaran en funcion de su id
    public static function deleteById($idAlbaran)
    {
        $sql = "delete from albaran where id_albaran=?;";

        $arrayParametros = [$idAlbaran];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

}

?>