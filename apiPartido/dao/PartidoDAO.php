<?php

class PartidoDAO implements DAO{
        public static function findAll(){
                $sql = "select id, jug1, jug2, fecha, resultado from partido;";
                $consulta =ConexionBD::ejecutaConsulta($sql, []);
                $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $registros;
        }
        //busca por id(busca por la clave primaria)
        public static function findById($id){
                $sql = "select id, jug1, jug2, fecha, resultado from partido where id = ?;";
                $consulta =ConexionBD::ejecutaConsulta($sql, [$id]);
                $row = $consulta->fetchObject();
                return $row;
        }
        //busca por id(busca por la clave primaria)
        public static function findFiltro($jug){
                $sql = "select id, jug1, jug2, fecha, resultado from partido where jug1=? or jug2 = ?;";
                $consulta =ConexionBD::ejecutaConsulta($sql, [$jug,$jug]);
                $row = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $row;
        }
        //modifica o actualiza
        public static function update($objeto){
                $sql = "update partido set jug1 =?,jug2 =?,fecha=?,resultado=? where id =?);";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->jug1,$objeto->jug2,$objeto->fecha,$objeto->resultado,$objeto->id]);
                //si el numero de filas afectadas es 1 busca y lo devulve
                if($consulta->rowCount()==1){
                        return PartidoDAO::findById($objeto->id);
                }else{
                        return null;
                }

        }
        //crear o insertar
        public static function save($objeto){
        
                $sql = "insert into partido values(id,?,?,?,?);";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->jug1,$objeto->jug2,$objeto->fecha,$objeto->resultado]);
                //si !$consulta->rowCount()==1
                if(!$consulta){
                        return null;
                }
                return ProductoDAO::findById($objeto->id);
        }
        //borrar
        public static function delete($objeto){
                $sql = "delete from partido where id = ?";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto]);
                return $consulta;
        }

        public static function validaUser($user,$pass){
                
        }
        public static function deleteById($id)
        {
                $sql = "delete from partido where id=?;";

                $arrayParametros = [$id];
                $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
        }
        
}

?>