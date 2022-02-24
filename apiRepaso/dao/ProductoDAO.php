<?php

class ProductoDAO implements DAO{
        public static function findAll(){
                $sql = "select codigo, nombre, descripcion from producto;";
                $consulta =ConexionBD::ejecutaConsulta($sql, []);
                $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $registros;
        }
        //busca por id(busca por la clave primaria)
        public static function findById($id){
                $sql = "select codigo, nombre, descripcion from producto where codigo = ?;";
                $consulta =ConexionBD::ejecutaConsulta($sql, [$id]);
                $row = $consulta->fetchObject();
                return $row;
        }
        //busca por id(busca por la clave primaria)
        public static function findFiltro($array){
                
        }
        //modifica o actualiza
        public static function update($objeto){
                $sql = "update producto set nombre =?,descripcion =? where codigo =?);";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->nombre,$objeto->codigo]);
                //si el numero de filas afectadas es 1 busca y lo devulve
                if($consulta->rowCount()==1){
                        return ProductoDAO::findById($objeto->codigo);
                }else{
                        return null;
                }

        }
        //crear o insertar
        public static function save($objeto){
        
                $sql = "insert into producto  values(?,?,?,'alta','baja');";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->codigo,$objeto->nombre,$objeto->descripcion]);
                //si !$consulta->rowCount()==1
                if(!$consulta){
                        return null;
                }
                return ProductoDAO::findById($objeto->codUsuario);
        }
        //borrar
        public static function delete($objeto){
                $sql = "delete from producto where codigo = ?";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto]);
                return $consulta;
        }

        public static function validaUser($user,$pass){
               
            }
        
}

?>