<?php

namespace Controllers;

use Exception;
use Model\Test;
use MVC\Router;

class TestController {
    public static function epqa(Router $router) {
        $router->render('test/epqa', []);
    }
    public static function iac(Router $router) {
        $router->render('test/iac', []);
    }

    public static function buscarEPQA(Router $router) {
        $sql = "SELECT p.pregunta_id, t.test_nombre, p.pregunta_pregunta, p.pregunta_tipo, p.pregunta_respuesta, p.pregunta_situacion
        FROM psi_preguntas_epqa p
        JOIN psi_test t ON p.pregunta_test_id = t.test_id
        WHERE p.pregunta_test_id = 1;";

        try {
            $pruebas = Test::fetchArray($sql);

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
            $pruebas = Test::fetchArray($sql);

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
