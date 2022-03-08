<?
class UsuarioDAO implements DAO
{

    // Método que lista todos los usuarios
    public static function findAll()
    {
        $sql = "select id, nombre, password, perfil from usuarios;";
        $consulta = ConexionBD::ejecutaConsulta($sql, []);
        $cont = 0;

        while($row = $consulta->fetchObject())
        {
            $usuario = new Usuario($row->id,
                $row->nombre,$row->password,$row->perfil);
                
                $registros[$cont]=$usuario;
                $cont++;
        }

        return $registros;
    }

    // Método que busca un usuario por su id
    public static function findById($id)
    {
        $sql = "select id, nombre, password, perfil from usuarios where id=?;";
        $consulta = ConexionBD::ejecutaConsulta($sql,[$id]);

        $row = $consulta->fetchObject();
        
        $user = new Usuario($row->id,$row->nombre,$row->password,$row->perfil);
        return $user;
    }

    // Método que modifica/actualiza un usuario
    public static function update($objeto)
    {
        $sql = "update usuarios set id=?,nombre=?,password=?,perfil=? where id=?";
        
        $arrayParametros = [$objeto->id,$objeto->nombre,$objeto->password,$objeto->perfil,$objeto->id];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que crea un nuevo usuario
    public static function save($objeto)
    {
        $sql = "insert into usuarios (id,nombre,password,perfil) values (?,?,?,?);";

        $arrayParametros = [$objeto->id,$objeto->nombre,$objeto->password,$objeto->perfil];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }

    // Método que elimina un usuario existente
    public static function delete($objeto)
    {

    }

    // Método que elimina un usuario en funcion de su id
    public static function deleteById($id)
    {
        $sql = "delete from usuarios where id=?;";

        $arrayParametros = [$id];
        $consulta = ConexionBD::ejecutaConsulta($sql,$arrayParametros);
    }


    // Método que valida si existe un usuario
    public static function validaUser($user,$pass)
    {
        $sql = "select * from usuarios where nombre=? and password=?";

        $consulta = ConexionBD::ejecutaConsulta($sql,[$user,$pass]);
        $usuario = null;

        // Por cada row...
        while($row = $consulta->fetchObject())
        {
            $usuario = new Usuario($row->id,$row->nombre,$row->password,$row->perfil);
        }

        return $usuario;
    }
}

?>