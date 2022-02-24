<?php

class cProducto extends BaseControlador{

    public function general(){
        $uri = $this->getUri();
        $filtros = $this->getParametros();

        //ver el metodo que pide
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //existe un codigo en la uri
                if(isset($uri[2])){
                    $producto = ProductoDAO::findById($uri[2]);

                }else{
                    if(count($filtros)>0){
                        //busqueda con filtros
                    }else{
                        $producto = ProductoDAO::findAll();
                    }
                }
                $enviarJSON = json_encode($producto);
                $this->sendRespuesta(
                    $enviarJSON,
                    array('Content-Type: application/json',"HTTP/1.1  200 OK"));
                //pida id
                //filtros
                break;
            case 'POST':
                if(!isset($_POST['codigo'])||!isset($_POST['nombre'])||!isset($_POST['descripcion'])){
                    $this->sendRespuesta(
                        json_encode('error'),
                        array('Content-Type: application/json',"HTTP/1.1 400 No ha enviadao los parametros necesarios")
                    );
                }else{
                    $producto = new Producto(($_POST['codigo']),($_POST['nombre']),($_POST['descripcion']));
                    $productoI = ProductoDAO::save($producto);
                    json_encode($productoI);

                }
                break;
            case 'PUT':
                # code...
                $put = file_get_contents("php://input");
                $json = json_decode($put,true);
                if(!isset($json['codigo'])||!isset($json['nombre'])||!isset($json['descripcion'])){
                    $this->sendRespuesta(
                        json_encode('error'),
                        array('Content-Type: application/json',"HTTP/1.1 400 No ha enviadao los parametros necesarios")
                    );
                }else{
                    $producto = new Producto(($_POST['codigo']),($_POST['nombre']),($_POST['descripcion']));
                    $productoI = ProductoDAO::update($producto);
                    json_encode($productoI);

                }
                break;

            case 'DELETE':
                # code...
                if(isset($uri[2])){
                    $producto = ProductoDAO::delete($uri[2]);
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