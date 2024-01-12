<?php

namespace Model;

// CREATE TABLE psi_test (
//     test_id SERIAL PRIMARY KEY,
//     test_nombre VARCHAR(50),
//     test_situacion SMALLINT DEFAULT 1
// );

class Test extends ActiveRecord{
    protected static $tabla = 'psi_test';
    protected static $columnasDB = ['test_nombre','test_situacion'];
    protected static $idTabla = 'test_id';

    public $test_id;
    public $test_nombre;
    public $test_situacion;

    public function __construct($args = [])
    {
        $this->pregunta_id = $args['test_id'] ?? null;
        $this->pregunta_pregunta = $args['test_nombre'] ?? '';
        $this->pregunta_tipo = $args['test_situacion'] ?? 1;
    }
}