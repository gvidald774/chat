<?php

class Mensaje implements JsonSerializable {
    protected $id;
    protected $user;
    protected $msg;
    protected $fecha;
    protected $img;

    public function __construct($i, $u, $m, $f, $imgblob = "")
    {
        $this->id = $i;
        $this->user = $u;
        $this->msg = $m;
        $this->fecha = $f;
        $this->img = $imgblob;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getMsg()
    {
        return $this->msg;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getImg()
    {
        return $this->img;
    }

    public function __toString()
    {
        return "".$this->fecha." - ".$this->user.": ".$this->msg;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'msg' => $this->msg,
            'fecha' => $this->fecha,
            'imgblob' => $this->img
        ];
    }
}