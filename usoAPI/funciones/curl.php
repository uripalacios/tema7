<?
function get(){
    //Para pedir por curl
    $ch = curl_init();
    
    //mi conexion
    //curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/tema7/miapi/miapi.php/usuarios");
    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/usoAPI/index.php/producto");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $res = curl_exec($ch);
    
    curl_close($ch);
    return($res);

}

function post($producto){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/usoAPI/index.php/producto");
    $datosU = array('codigo'=>$producto->codigo,'nombre'=>$producto->nombre,'descripcion'=>$producto->descripcion);
    $datoshttp = http_build_query($datosU);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datoshttp);
    $res = curl_exec($ch);
    $producto = json_decode($res,true);
    return $producto;
    curl_close($ch);
}

function put($producto){
    $ch = curl_init();
    //url
    $datosU = array('codigo'=>$producto->codigo,'nombre'=>$producto->nombre,'descripcion'=>$producto->descripcion);
    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/usoAPI/index.php/producto/".$datosU['codigo']);
    $datosjson = json_encode($datosU);
    //cabecera que voy a enviar json/xml
    curl_setopt($ch,CURLOPT_HTTPHEADER,
        array('Content-Type: application/json','Content-Length: '.strlen($datosjson)));
    //put
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
    //parametros
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datosjson);
    //quiero respuesta
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //ejecuto
    $res = curl_exec($ch);
    print_r($res);
    curl_close($ch);
}

//pruebas para ejecutar
// get();
// post();
put();
?>