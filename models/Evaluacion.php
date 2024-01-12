<?php
namespace Model;

class Evaluacion extends ActiveRecord
{
    protected static $tabla = 'psi_candidato';
    protected static $columnasDB = ['cand_primer_nombre', 'cand_segundo_nombre', 'cand_primer_apellido', 'cand_segundo_apellido', 'cand_sexo', 'cand_fecha_nacimiento', 'cand_fecha_evaluacion_terminada', 'cand_time', 'cand_centro', 'cand_estado', 'cand_conclusion', 'cand_test_id', 'cand_situacion'];
    protected static $idTabla = 'cand_id';

    public $cand_id;
    public $cand_primer_nombre;
    public $cand_segundo_nombre;
    public $cand_primer_apellido;
    public $cand_segundo_apellido;
    public $cand_sexo;
    public $cand_fecha_nacimiento;
    // public $cand_fecha_evaluacion;
    public $cand_fecha_evaluacion_terminada;
    public $cand_time;
    public $cand_centro;
    public $cand_estado;
    public $cand_conclusion;
    public $cand_test_id;
    public $cand_situacion;

    public function __construct($args = [])
    {
        $this->cand_id = $args['cand_id'] ?? null;
        $this->cand_primer_nombre = $args['cand_primer_nombre'] ?? '';
        $this->cand_segundo_nombre = $args['cand_segundo_nombre'] ?? '';
        $this->cand_primer_apellido = $args['cand_primer_apellido'] ?? '';
        $this->cand_segundo_apellido = $args['cand_segundo_apellido'] ?? '';
        $this->cand_sexo = $args['cand_sexo'] ?? '';
        $this->cand_fecha_nacimiento = $args['cand_fecha_nacimiento'] ?? '';
        // $this->cand_fecha_evaluacion = $args['cand_fecha_evaluacion'] ?? null;
        $this->cand_fecha_evaluacion_terminada = $args['cand_fecha_evaluacion_terminada'] ?? null;        
        $this->cand_time = $args['cand_time'] ?? null;
        $this->cand_centro = $args['cand_centro'] ?? 'ETMA';
        $this->cand_estado = $args['cand_estado'] ?? 'RESPONDIENDO';
        $this->cand_conclusion = $args['cand_conclusion'] ?? 'PENDIENTE';
        $this->cand_test_id = $args['cand_test_id'] ?? null;
        $this->cand_situacion = $args['cand_situacion'] ?? 1;
    }
}
