<?php

class SorteoDAO implements DAO{
    //busca todos
    public static function findAll(){

    }
    //busca por id(busca por la clave primaria)
    public static function findById($id){

    }
    //modifica o actualiza
    public static function update($objeto){
        $sql = "update sorteo set n1=?,n2=?,n3=?,n4=?,n5=?,fecha=current_date()";
        
        $arrayParametros = [$objeto->fecha,$objeto->n1,$objeto->n2,$objeto->n3,$objeto->n4,$objeto->n5];
        ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }
    //crear o insertar
    public static function save($objeto){
        $sql = "insert into sorteo (id,fecha,n1,n2,n3,n4,n5) values (id,current_date(),?,?,?,?,?);";

        $arrayParametros = [$objeto->id,$objeto->fecha,$objeto->n1,$objeto->n2,$objeto->n3,$objeto->n4,$objeto->n5];
        ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }
    //borrar
    public static function delete($objeto){
        
    }
}