<?php

class cPartido extends BaseControlador{

    public function general(){
        $uri = $this->getUri();
        $filtros = $this->getParametros();

        //ver el metodo que pide
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //existe un codigo en la uri
                if(isset($uri[2])){
                    $partido = PartidoDAO::findById($uri[2]);

                }else{
                    if(count($filtros)>0){
                        //busqueda con filtros
                    }else{
                        $partido = PartidoDAO::findAll();
                    }
                }
                $enviarJSON = json_encode($partido);
                $this->sendRespuesta(
                    $enviarJSON,
                    array('Content-Type: application/json',"HTTP/1.1  200 OK"));
                //pida id
                //filtros
                break;
            case 'POST':
                if(!isset($_POST['jug1'])||!isset($_POST['jug2'])||!isset($_POST['fecha'])||!isset($_POST['resultado'])){
                    $this->sendRespuesta(
                        json_encode('error'),
                        array('Content-Type: application/json',"HTTP/1.1 400 No ha enviadao los parametros necesarios")
                    );
                }else{
                    $partido = new Partido(($_POST['jug1']),($_POST['jug2']),($_POST['fecha']),($_POST['resultado']));
                    $partido1 = PartidoDAO::save($partido);
                    json_encode($partido1);

                }
                break;
            case 'PUT':
                # code...
                $put = file_get_contents("php://input");
                $json = json_decode($put,true);
                if(!isset($json['jug1'])||!isset($json['jug2'])||!isset($json['fecha'])||!isset($json['resultado'])){
                    $this->sendRespuesta(
                        json_encode('error'),
                        array('Content-Type: application/json',"HTTP/1.1 400 No ha enviadao los parametros necesarios")
                    );
                }else{
                    $partido = new Partido($uri[2],($_POST['jug1']),($_POST['jug2']),($_POST['fecha']),($_POST['resultado']));
                    $partido1 = PartidoDAO::update($partido);
                    json_encode($partido1);

                }
                break;

            case 'DELETE':
                # code...
                if(isset($uri[2])){
                    $producto = PartidoDAO::delete($uri[2]);
                    if($producto->rowCount()>0){
                        $this->sendRespuesta(
                            json_encode('Hemos borrado el producto'),
                            array('Content-Type: application/json',"HTTP/1.1 200 OK")
                        );
                    }

                }else{
                    $this->sendRespuesta(
                        json_encode('error hace falta insertar el id'),
                        array('Content-Type: application/json',"HTTP/1.1 400 No ha enviadao los parametros necesarios")
                    );
                }
                break;
            default:
                header("HTTP/1.1 400 BAD REQUEST");
        }
    }
}