<?

class cUsuarios extends BaseControlador{
    public function general()
    {
        $uri = $this->getUri();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                # code...
                if(isset($uri[2])&& !isset($uri[3]))
                    $datos= UsuarioDAO::findById($uri[2]);
                else if(!isset($uri[2])){
                    $datos = UsuarioDAO::findAll();
                }
                else{
                    //header mal
                    $this->sendRespuesta(
                        json_encode(array('error'=>"Comprueba la URI")),
                        array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                    );
                }
                $datos = json_encode($datos);
                $this->sendRespuesta($datos,array('Content-Type: application/json',"HTTP/1.1  200 OK"));
                break;
            case 'POST':
                # code...
                //lo primero que tenga los parametros necesarios
                if(!isset($_POST['codUsuario'])|| !isset($_POST['nombre'])|| !isset($_POST['password'])|| !isset($_POST['perfil']))
                    $this->sendRespuesta(
                        json_encode(array('error'=>"Nos se han enviado datos")),
                        array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                    );
                else{
                    $usuario = new Usuario($_POST['codUsuario'],$_POST['nombre'],$_POST['password'],$_POST['perfil']);
                    $bien = UsuarioDAO::save($usuario);
                }
                break;
            case 'PUT':
                # code...
                break;
            case 'DELETE':
                # code...
                break;
            default:
                # code...
                break;
        }

    }
}