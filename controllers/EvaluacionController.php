<?php

namespace Controllers;

use Exception;
use Model\Evaluacion;
use MVC\Router;

class EvaluacionController
{
    public static function epqa(Router $router){
        $router->render('evaluacion/epqa', []);
    }
    public static function iac(Router $router){
        $router->render('evaluacion/iac', []);
    }


    public static function guardarconclusionAPI()
    {
        try {          
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
    
            $cand_id = $data['cand_id'];
            $cand_conclusion = $data['cand_conclusion'];
            
            $candidato = Evaluacion::find($cand_id);
            $candidato->cand_conclusion = $cand_conclusion;
            $resultado = $candidato->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Conclusion asignado correctamente',
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
    
    public static function buscarEPQA(Router $router) {
        $sql = "SELECT 
        c.*, 
        (DATEDIFF(NOW(), c.cand_fecha_nacimiento) / 365.25) AS edad,
        COALESCE(r.Respondidas, 0) AS Respondidas,
        p.Total
    FROM 
        psi_candidato c
    LEFT JOIN 
        (SELECT 
            res_cand_id, 
            COUNT(*) AS Respondidas 
         FROM psi_respuestas 
         WHERE res_test_id = 1 
         GROUP BY res_cand_id) r ON c.cand_id = r.res_cand_id
    CROSS JOIN 
        (SELECT COUNT(*) AS Total FROM psi_preguntas_epqa WHERE pregunta_test_id = 1) p
    WHERE 
        c.cand_situacion = 1 
        AND c.cand_test_id = 1;
    ";

        try {
            $candidato = Evaluacion::fetchArray($sql);

            echo json_encode($candidato);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public static function buscarIAC(Router $router) {
        $sql = "SELECT 
        c.*, 
        (DATEDIFF(NOW(), c.cand_fecha_nacimiento) / 365.25) AS edad,
        COALESCE(r.Respondidas, 0) AS Respondidas,
        p.Total
    FROM 
        psi_candidato c
    LEFT JOIN 
        (SELECT 
            res_cand_id, 
            COUNT(*) AS Respondidas 
         FROM psi_respuestas 
         WHERE res_test_id = 2 
         GROUP BY res_cand_id) r ON c.cand_id = r.res_cand_id
    CROSS JOIN 
        (SELECT COUNT(*) AS Total FROM psi_preguntas_iac WHERE pregunta_test_id = 2) p
    WHERE 
        c.cand_situacion = 1 
        AND c.cand_test_id = 2;
    ";

        try {
            $candidato = Evaluacion::fetchArray($sql);

            echo json_encode($candidato);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

}

?>
