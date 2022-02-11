<?php

use UsuarioDAO as GlobalUsuarioDAO;

class UsuarioDAO implements DAO{
        public static function findAll(){
                $sql = "select codUsuario, nombre, Perfil from usuario;";
                $consulta =ConexionBD::ejecutaConsulta($sql, []);
                $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $registros;
        }
        //busca por id(busca por la clave primaria)
        public static function findById($id){
                $sql = "select codUsuario, nombre, Perfil from usuario where codUsuario = ?;";
                $consulta =ConexionBD::ejecutaConsulta($sql, [$id]);
                $row = $consulta->fetchObject();
                return $row;
        }
        //modifica o actualiza
        public static function update($objeto){
                $sql = "update usuario set nombre =?,password =?,Perfil = ? where codUsuario =?);";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->nombre,hash("sha256",$objeto->password),$objeto->perfil,$objeto->codUsuario]);
                //si el numero de filas afectadas es 1 busca y lo devulve
                if($consulta->rowCount()==1){
                        return UsuarioDAO::findById($objeto->codUsuario);
                }else{
                        return null;
                }

        }
        //crear o insertar
        public static function save($objeto){
        
                $sql = "insert into usuario values(?,?,?,0,null,?);";
                $consulta = ConexionBD::ejecutaConsulta($sql, [$objeto->codUsuario,hash("sha256",$objeto->password),$objeto->nombre,$objeto->perfil]);
                //si !$consulta->rowCount()==1
                if(!$consulta){
                        return null;
                }
                return UsuarioDAO::findById($objeto->codUsuario);
        }
        //borrar
        public static function delete($objeto){}

        public static function validaUser($user,$pass){
                $sql = "select * from usuario where codUsuario = ? and password = ?";
                $consulta = ConexionBD::ejecutaConsulta($sql,[$user,$pass]);
                $cont = 0;
                $usuario = null;
                while ($row = $consulta->fetchObject()) {
                        $usuario  = new Usuario($row->codUsuario,$row->nombre,$row->password,$row->Perfil);
                }
                return $usuario;
            }
        
}

?>