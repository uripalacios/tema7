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
}
?>