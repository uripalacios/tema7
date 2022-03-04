<?php

class UsuarioDAO implements DAO
{

    // Método que lista todos los usuarios
    public static function findAll()
    {
        $sql = "select usuario, email, fecha_nacimiento, perfil from usuarios;";
        $consulta = ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;

        while($row = $consulta->fetchObject())
        {
            $usuario = new Usuario($row->usuario,
                '', $row->email,$row->fecha_nacimiento,$row->perfil);
                $registros[$cont]=$usuario;
                $cont++;
        }

        return $registros;
    }

    // Método que busca un usuario por su id
    public static function findById($id)
    {
        $sql = "select usuario, contraseña, email, fecha_nacimiento, perfil from usuarios where usuario=?;";
        $consulta = ConexionBD::ejecutaConsulta($sql,[$id]);

        $row = $consulta->fetchObject();
        
        $user = new Usuario($row->usuario,'',$row->email,$row->fecha_nacimiento,$row->perfil);
        return $user;
    }

    // Método que modifica/actualiza un usuario
    public static function update($objeto)
    {
        $sql = "update usuarios set usuario=?,contraseña=?,email=?,fecha_nacimiento=?,perfil=? where usuario=?";
        
        $arrayParametros = [$objeto->usuario,$objeto->contraseña,$objeto->email,$objeto->fecha_nacimiento,$objeto->perfil,$objeto->usuario];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que crea un nuevo usuario
    public static function save($objeto)
    {
        $sql = "insert into usuarios (usuario,contraseña,email,fecha_nacimiento,perfil) values (?,?,?,?,?);";

        $arrayParametros = [$objeto->usuario,$objeto->contraseña,$objeto->email,$objeto->fecha_nacimiento,$objeto->perfil];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que elimina un usuario existente
    public static function delete($objeto)
    {

    }

    // Método que elimina un usuario en funcion de su id
    public static function deleteById($id)
    {
        $sql = "delete from usuarios where usuario=?;";

        $arrayParametros = [$id];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }


    // Método que valida si existe un usuario
    public static function validaUser($user,$pass)
    {
        $sql = "select * from usuarios where usuario=? and contraseña=?";

        $consulta = ConexionBD::ejecutaConsulta($sql,[$user,$pass]);
        $usuario = null;

        // Por cada row...
        while($row = $consulta->fetchObject())
        {
            $usuario = new Usuario($row->usuario,$row->contraseña,$row->email,$row->$fecha_nacimiento,$row->perfil);
        }

        return $usuario;
    }
}

?>