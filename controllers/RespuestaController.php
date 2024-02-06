<?php

namespace Controllers;

use Exception;
use Model\Respuesta;
use Model\Candidato;
use MVC\Router;

// aqui todo bien-------------------------punto de control buen estado------------------------------

class RespuestaController {
    public static function epqa(Router $router){
        $router->render('respuesta/epqa', []);
    }
    public static function iac(Router $router){
        $router->render('respuesta/iac', []);
    }


    public static function actualizarTiempoAPI(){
        try {
            $cand_id = $_POST['cand_id'] ?? null;
            $tiempo = $_POST['tiempo'] ?? null;
            
            if (!$cand_id || $tiempo === null) {
                throw new Exception("Datos incompletos");
            }

            $candidato = Candidato::find($cand_id);
            $candidato->cand_time = $tiempo;
            $resultado = $candidato->actualizar();

            echo json_encode([
                'mensaje' => 'Tiempo actualizado correctamente',
                'codigo' => 1
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function guardarAPI(){
     
        try {
          
            $respuesta = new Respuesta($_POST);
            $resultado = $respuesta->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }        
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarRES(Router $router) {
        $sql = "SELECT * FROM psi_respuestas where res_situacion = 1;";
    
        try {
            $pruebas = Respuesta::fetchArray($sql);
    
            echo json_encode($pruebas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    
public static function buscarEPQA(Router $router) {
    $sql = "SELECT p.pregunta_id, t.test_nombre, p.pregunta_pregunta, p.pregunta_tipo, p.pregunta_respuesta, p.pregunta_situacion
    FROM psi_preguntas_epqa p
    JOIN psi_test t ON p.pregunta_test_id = t.test_id
    WHERE p.pregunta_test_id = 1;";

    try {
        $pruebas = Respuesta::fetchArray($sql);

        echo json_encode($pruebas);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function buscarIAC(Router $router) {
    $sql = "SELECT p.pregunta_id, t.test_nombre, p.pregunta_pregunta, p.pregunta_tipo, p.pregunta_respuesta, p.pregunta_situacion
    FROM psi_preguntas_iac p
    JOIN psi_test t ON p.pregunta_test_id = t.test_id
    WHERE p.pregunta_test_id = 2;";

    try {
        $pruebas = Respuesta::fetchArray($sql);

        echo json_encode($pruebas);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

}