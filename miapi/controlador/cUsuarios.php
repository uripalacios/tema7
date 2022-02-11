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
                    if($bien){
                        $datosr = json_encode($bien);
                        $this->sendRespuesta(
                            $datosr,
                            array('Content-Type: application/json',"HTTP/1.1 200 OK")
                        );
                    }else{
                        $this->sendRespuesta(
                            json_encode(array('error'=>"Error al enviar")),
                            array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                        );
                    }
                }
                break;
            case 'PUT':
                //recoger el id
                if(!isset($uri[2])){
                    $this->sendRespuesta(
                        json_encode(array('error'=>"No tiene el id del usuario a modificar")),
                        array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                    );
                }else{
                    $put = file_get_contents("php://input");
                    $array = json_decode($put,true);
                    if(!isset($array['nombre']) || !isset($array['perfil']) || !isset($array['password'])){
                        $this->sendRespuesta(
                            json_encode(array('error'=>"No se han introducido  por put todos los parametros")),
                            array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                        );
                    }else{
                        $usuario = new Usuario($uri[2],$_POST['nombre'],$_POST['password'],$_POST['perfil']);
                        $objeto = UsuarioDAO::update($usuario);
                        if(!$objeto){
                            $this->sendRespuesta(
                                json_encode(array('error'=>"No existe el usuario")),
                                array('Content-Type: application/json',"HTTP/1.1 400 Error en el formato de la peticion")
                            );
                        }else{
                            $datosr = json_encode($objeto);
                            $this->sendRespuesta(
                                $datosr,
                                array('Content-Type: application/json',"HTTP/1.1 200 OK")
                        );
                        }
                    }
                }
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