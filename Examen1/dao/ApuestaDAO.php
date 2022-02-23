<?php

class ApuestaDAO implements DAO{
    //busca todos
    public static function findAll(){
        $sql = "select * from apuesta;";
        $consulta =ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;
        while($row = $consulta->fetchObject())
        {
            $apuesta = new Apuesta($row->id,
                $row->idProfe,$row->n1,$row->n2,$row->n3,$row->n4,$row->n5);
                $registros[$cont]=$apuesta;
                $cont++;
        }
        return $registros;
    }
    //busca por id(busca por la clave primaria)
    public static function findById($id){
        $sql = "select * from apuesta where idProfe = ?;";
            $consulta =ConexionBD::ejecutaConsulta($sql, [$id]);
            $row = $consulta->fetchObject();
            $apuesta = new Apuesta($row->id,
            $row->idProfe,$row->n1,$row->n2,$row->n3,$row->n4,$row->n5);
            return $apuesta;
    }
    //modifica o actualiza
    public static function update($objeto){
        $sql = "update apuesta set n1=?,n2=?,n3=?,n4=?,n5=? where idProfe = ?";
        
        $arrayParametros = [$objeto->n1,$objeto->n2,$objeto->n3,$objeto->n4,$objeto->n5,$objeto->idProfe];
        ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }
    //crear o insertar
    public static function save($objeto){
        $sql = "insert into apuesta (id,idProfe,n1,n2,n3,n4,n5) values (?,?,?,?,?,?,?);";

        $arrayParametros = [$objeto->id,$objeto->idProfe,$objeto->n1,$objeto->n2,$objeto->n3,$objeto->n4,$objeto->n5];
        ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }
    //borrar
    public static function delete($objeto){

    }
}