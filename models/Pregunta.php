<?php

namespace Model;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'psi_test';
    protected static $columnasDB = ['pregunta_pregunta', 'pregunta_tipo', 'pregunta_respuesta', 'pregunta_situacion', 'pregunta_pregunta_id'];
    protected static $idTabla = 'pregunta_id';

    public $pregunta_id;
    public $pregunta_pregunta;
    public $pregunta_tipo;
    public $pregunta_respuesta;
    public $pregunta_situacion;
    public $pregunta_pregunta_id;

    public function __construct($args = [])
    {
        $this->pregunta_id = $args['pregunta_id'] ?? null;
        $this->pregunta_pregunta = utf8_encode($args['pregunta_pregunta']) ?? '';
        $this->pregunta_tipo = $args['pregunta_tipo'] ?? '';
        $this->pregunta_respuesta = utf8_encode($args['pregunta_respuesta']) ?? '';
        $this->pregunta_situacion = $args['pregunta_situacion'] ?? '';
        $this->pregunta_pregunta_id = $args['pregunta_pregunta_id'] ?? '1';
    }
}
