<?php


if(isset($_POST['accion']))
    {

        if($_POST['accion']=="true")
        {
            addDeseo($_POST['codigo']);
        }else
        {
            deleteDeseo($_POST['codigo']);
        }

    }

function addDeseo()
{
    if(isset($_POST['codigo']))
    {
        session_start();
        $codigo = $_POST['codigo'];
        $usuario = $_SESSION['user'];

        if(!isset($_COOKIE[$usuario]))
        {
            setcookie($usuario.'[0]',$codigo, time()+31536000, "/" );
            //setcookie('visitado['.$key.']',$value, time()+31536000, "/");
            $prueba =0;
            echo $prueba;
        }else
        {
            $arrayDeseos=$_COOKIE[$usuario];
            array_unshift($arrayDeseos, $codigo);

            foreach ($arrayDeseos as $key => $value) {
                setcookie($usuario.'['.$key.']',$value, time()+31536000, "/" );
            }

        }
    }
}

function deleteDeseo()
{
    if(isset($_POST['codigo']))
    {
        session_start();
        $codigo = $_POST['codigo'];
        $usuario = $_SESSION['user'];
        $arrayDeseos=$_COOKIE[$usuario];
        if(in_array($codigo, $arrayDeseos))
        {
            foreach ($arrayDeseos as $key => $value) {
                if($codigo==$value)
                {
                    setcookie($usuario.'['.$key.']',$value, time()-31536000, "/" );
                }
            }
        }
    }
}

?>