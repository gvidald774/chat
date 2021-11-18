<?php
    include_once("BD.php");
    include_once("Mensaje.php");

    header('Content-Type: text/html; charset=UTF-8');
    
    BD::conectar();

    var_dump($_POST);
    var_dump($_FILES);

    if(isset($_POST["user"]) && isset($_POST["msg"]))
    {
        if(isset($_FILES["archivo"]))
        {
            $img = file_get_contents($_FILES["archivo"]["tmp_name"]);
            $img = base64_encode($img);
        }
        else
        {
            $img = "";
        }
        $ultimoId = BD::getUltimoId();
        $m = new Mensaje($ultimoId, $_POST["user"], $_POST["msg"], date('Y-m-d H:i:s'), $img);

        BD::insertaMensaje($m);
        echo "OK";
    }
    else{
        echo "ERROR";
    }
