<?php

namespace Controllers;

use Exception;
use Model\VerRespuesta;
use MVC\Router;

class VerRespuestaController
{
    public static function epqa(Router $router){
        $router->render('verrespuesta/epqa', []);
    }
    public static function iac(Router $router){
        $router->render('verrespuesta/iac', []);
    }  
    
// aqui funciona pero trae todas las respuestas
public static function buscarEPQA(Router $router) {
    $nuevoCandidatoID = $_GET['nuevoCandidatoID'];

    if (!$nuevoCandidatoID) {
        echo json_encode([
            'mensaje' => 'No se proporcionó un ID de candidato',
            'codigo' => 0
        ]);
        return;
    }

    $sql = "SELECT c.cand_id, c.cand_primer_nombre, c.cand_segundo_nombre, c.cand_primer_apellido, c.cand_segundo_apellido, c.cand_fecha_evaluacion, t.test_nombre, p.pregunta_id, p.pregunta_pregunta, r.res_respuesta,
    CASE WHEN r.res_respuesta = p.pregunta_respuesta THEN 'Correcto' ELSE 'Incorrecto' END AS resultado
FROM
    psi_respuestas r
JOIN
    psi_candidato c ON r.res_cand_id = c.cand_id
JOIN
    psi_test t ON r.res_test_id = t.test_id
JOIN
    psi_preguntas_epqa p ON r.res_pregunta_id = p.pregunta_id
WHERE
    c.cand_id = $nuevoCandidatoID;";

    try {
        $pruebas = VerRespuesta::fetchArray($sql, ['cand_id' => $nuevoCandidatoID]);

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
    $nuevoCandidatoID = $_GET['nuevoCandidatoID'];

    if (!$nuevoCandidatoID) {
        echo json_encode([
            'mensaje' => 'No se proporcionó un ID de candidato',
            'codigo' => 0
        ]);
        return;
    }

    $sql = "SELECT c.cand_id, c.cand_primer_nombre, c.cand_segundo_nombre, c.cand_primer_apellido, c.cand_segundo_apellido, c.cand_fecha_evaluacion, t.test_nombre, p.pregunta_id, p.pregunta_pregunta, r.res_respuesta,
    CASE WHEN r.res_respuesta = p.pregunta_respuesta THEN 'Correcto' ELSE 'Incorrecto' END AS resultado
FROM
    psi_respuestas r
JOIN
    psi_candidato c ON r.res_cand_id = c.cand_id
JOIN
    psi_test t ON r.res_test_id = t.test_id
JOIN
    psi_preguntas_iac p ON r.res_pregunta_id = p.pregunta_id
WHERE
    c.cand_id = $nuevoCandidatoID;";

    try {
        $pruebas = VerRespuesta::fetchArray($sql, ['cand_id' => $nuevoCandidatoID]);

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

?>
