<?php

class UsuarioDAO implements DAO{
        public static function findAll(){
        $sql = "select codUsuario, nombre, Perfil from usuario;";
        $consulta =ConexionBD::ejecutaConsulta($sql, []);
        $cont =0;
        while($row = $consulta->fetchObject())
        {
            $usuario = new Usuario($row->codUsuario,
                $row->nombre,'', $row->Perfil);
                $registros[$cont]=$usuario;
                $cont++;
        }
        return $registros;

    }
        //busca por id(busca por la clave primaria)
        public static function findById($id){
                $sql = "select codUsuario, nombre, Perfil from usuario where codUsuario = ?;";
                $consulta =ConexionBD::ejecutaConsulta($sql, [$id]);
                $row = $consulta->fetchObject();
                $user = new Usuario($row->codUsuario,
                $row->nombre,'', $row->Perfil);
                return $user;
        }
        //modifica o actualiza
        public static function update($objeto){}
        //crear o insertar
        public static function save($objeto){}
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