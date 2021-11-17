<?php
    include_once("Mensaje.php");

class BD {

    private static $con;
    public static function conectar()
    {
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
        self::$con = new PDO('mysql:host=localhost;dbname=foro', 'root', '', $opciones);
    }

    public static function cogeTodosMsg()
    {
        $arr = array();
        $registros = self::$con->query("SELECT * FROM mensajes");
        while($registro = $registros.fetch(PDO::FETCH_OBJ))
        {
            $m = new Mensaje($registro->id, $registro->user, $registro->mensaje, $registro->fecha);
            $arr[] = $m;
        }

        return $arr;
    }

    public static function insertaMensaje($mensaje)
    {
        $consulta = self::$con->prepare("INSERT INTO mensajes (user, mensaje, fecha, imgblob) VALUES (:user,:mensaje,NOW(), :img)");

        $user = $mensaje->getUser();
        $msg = $mensaje->getMsg();
        $img = $mensaje->getImg();

        $consulta->bindParam(':user',$user);
        $consulta->bindParam(':mensaje',$msg);
        $consulta->bindParam(':img',$img);

        $consulta->execute();
    }

    public static function getUltimoID()
    {
        $resultado = self::$con->query("SELECT LAST_INSERT_ID()");
        return $resultado->fetchColumn();
    }

    public static function pedirMensajesNuevos($id)
    {
        $consulta = self::$con->prepare("SELECT * FROM mensajes WHERE id>=:id");

        $consulta->bindParam(':id',$id);
        $consulta->execute();

        $arr = array();
        while($registro = $consulta->fetch(PDO::FETCH_OBJ))
        {
            $m = new Mensaje($registro->id, $registro->user, $registro->mensaje, $registro->fecha, $registro->imgblob);
            $arr[] = $m;
        }
        return $arr;
    }

}