<?php
    include_once("BD.php");
    include_once("Mensaje.php");

    header('Content-Type: text/html; charset=UTF-8');
    
    BD::conectar();

    var_dump($_POST);
    var_dump($_FILES);

    if(isset($_POST["user"]) && isset($_POST["msg"]))
    {
        $ultimoId = BD::getUltimoId();
        $m = new Mensaje($ultimoId, $_POST["user"], $_POST["msg"], date('Y-m-d H:i:s'), $_FILES["img"]); // DOLAR FILE SEÑOR DOLAR FILE

        BD::insertaMensaje($m);
        echo "OK";
    }
    else{
        echo "ERROR";
    }
