<?
function get(){
    //Para pedir por curl
    $ch = curl_init();
    
    //mi conexion
    //curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/tema7/miapi/miapi.php/usuarios");
    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.100/miapi/miapi.php/usuarios");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $res = curl_exec($ch);
    print_r($res);
    curl_close($ch);

}

function post(){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/tema7/miapi/miapi.php/usuarios");
    $datosU = array('codUsuario'=>'curl','nombre'=>'curl','perfil'=>'curl','password'=>'curl');
    $datoshttp = http_build_query($datosU);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datoshttp);
    $res = curl_exec($ch);
    print_r($res);
    curl_close($ch);
}

function put(){
    $ch = curl_init();
    //url
    $datosU = array('codUsuario'=>'curl','nombre'=>'curl','perfil'=>'curl','password'=>'curl');
    curl_setopt($ch,CURLOPT_URL,"http://10.1.160.105/tema7/miapi/miapi.php/usuarios/".$datosU['codUsuario']);
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