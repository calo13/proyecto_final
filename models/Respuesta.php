<?php

namespace Model;

class Respuesta extends ActiveRecord 
{
    public static $tabla = 'psi_respuestas';
    public static $columnasDB = ['res_cand_id', 'res_test_id', 'res_pregunta_id', 'res_respuesta', 'res_situacion'];
    public static $idTabla = 'res_id';

    public $res_id;
    public $res_cand_id;
    public $res_test_id;
    public $res_pregunta_id;
    public $res_respuesta;
    public $res_situacion;

    public function __construct($args = []) {
        $this->res_id = $args['res_id'] ?? null;
        $this->res_cand_id = $args['res_cand_id'] ?? '';
        $this->res_test_id = $args['res_test_id'] ?? '';
        $this->res_pregunta_id = $args['res_pregunta_id'] ?? '';
        $this->res_respuesta = $args['res_respuesta'] ?? '';
        $this->res_situacion = $args['res_situacion'] ?? 1;
    }
}