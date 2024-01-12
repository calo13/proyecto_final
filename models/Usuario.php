<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['usu_nombre','usu_dpi','usu_password','usu_email','usu_telefono','usu_rol','usu_situacion'];
    protected static $idTabla = 'usu_id';

    public $usu_id;
    public $usu_nombre;
    public $usu_dpi;
    public $usu_password;
    public $usu_email;
    public $usu_telefono;
    public $usu_rol;
    public $usu_situacion;

    public function __construct($args = [])
    {
        $this->usu_id = $args['usu_id'] ?? null;
        $this->usu_nombre = $args['usu_nombre'] ?? '';
        $this->usu_dpi = $args['usu_dpi'] ?? '';
        $this->usu_password = $args['usu_password'] ?? '';
        $this->usu_email = $args['usu_email'] ?? '';
        $this->usu_telefono = $args['usu_telefono'] ?? '';
        $this->usu_rol = $args['usu_rol'] ?? '2';
        $this->usu_situacion = $args['usu_situacion'] ?? '2';
    }
}
