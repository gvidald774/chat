<?php
    include_once("BD.php");
    include_once("Mensaje.php");

    BD::conectar();
    $arr = array();

    if (isset($_GET["ultimo"]))
    {
        $siguiente=$_GET["ultimo"]+1;
    }
    else
    {
        $siguiente=1;
    }

    $ultimo = $siguiente-1;

    $arr[] = BD::pedirMensajesNuevos($siguiente);

    $object = new stdClass();
    $object->mensajes = array();

    for($i = 0; $i < count($arr[0]); $i++)
    {
        $object->mensajes[]=$arr[0][$i];
        $ultimo=$arr[0][$i]->getId();
        /*// $cadena = $arr[0][$i]."<br />";
        $cadena = "<div class=\"mensaje-individual\">".$arr[0][$i]."</div>";
        echo $cadena;*/
    }
    $object->ultimo=$ultimo;

    echo json_encode($object);