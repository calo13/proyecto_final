<?php

namespace Controllers;

use Exception;
use Model\VerResultado;
use MVC\Router;

class VerResultadoController
{
    public static function epqa(Router $router)
    {
        $router->render('verresultado/epqa', []);
    }
    public static function iac(Router $router)
    {
        $router->render('verresultado/iac', []);
    }


    public static function buscarEPQA(Router $router)
    {
        $nuevoCandidatoID = $_GET['nuevoCandidatoID'];

        if (!$nuevoCandidatoID) {
            echo json_encode([
                'mensaje' => 'No se proporcionó un ID de candidato',
                'codigo' => 0
            ]);
            return;
        }

        $sql = "WITH PuntuacionPorTipo AS (
        SELECT
            r.res_cand_id,
            p.pregunta_tipo,
            SUM(CASE WHEN r.res_respuesta = p.pregunta_respuesta THEN 1 ELSE 0 END) AS puntuacion_por_tipo
        FROM psi_respuestas AS r
        INNER JOIN psi_preguntas_epqa AS p ON r.res_pregunta_id = p.pregunta_id
        WHERE r.res_respuesta = p.pregunta_respuesta
        GROUP BY r.res_cand_id, p.pregunta_tipo
    )
    
    SELECT
        r.res_cand_id,
        'N' AS tipo_pregunta,
        (SELECT MAX(bare_percentiles) FROM psi_baremos_epqa AS b
         WHERE b.bare_sexo = c.cand_sexo AND b.bare_n <= (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'N' AND p.res_cand_id = r.res_cand_id) AND b.bare_test_id = 1) AS percentiles,
        (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'N' AND p.res_cand_id = r.res_cand_id) AS puntuacion_por_tipo
    FROM psi_respuestas AS r
    INNER JOIN psi_candidato AS c ON r.res_cand_id = c.cand_id
    WHERE r.res_cand_id = $nuevoCandidatoID
    GROUP BY r.res_cand_id, percentiles
    
    UNION ALL
    
    SELECT
        r.res_cand_id,
        'E' AS tipo_pregunta,
        (SELECT MAX(bare_percentiles) FROM psi_baremos_epqa AS b
         WHERE b.bare_sexo = c.cand_sexo AND b.bare_e <= (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'E' AND p.res_cand_id = r.res_cand_id) AND b.bare_test_id = 1) AS percentiles,
        (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'E' AND p.res_cand_id = r.res_cand_id) AS puntuacion_por_tipo
    FROM psi_respuestas AS r
    INNER JOIN psi_candidato AS c ON r.res_cand_id = c.cand_id
    WHERE r.res_cand_id = $nuevoCandidatoID
    GROUP BY r.res_cand_id, percentiles
    
    UNION ALL
    
    SELECT
        r.res_cand_id,
        'S' AS tipo_pregunta,
        (SELECT MAX(bare_percentiles) FROM psi_baremos_epqa AS b
         WHERE b.bare_sexo = c.cand_sexo AND b.bare_s <= (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'S' AND p.res_cand_id = r.res_cand_id) AND b.bare_test_id = 1) AS percentiles,
        (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'S' AND p.res_cand_id = r.res_cand_id) AS puntuacion_por_tipo
    FROM psi_respuestas AS r
    INNER JOIN psi_candidato AS c ON r.res_cand_id = c.cand_id
    WHERE r.res_cand_id = $nuevoCandidatoID
    GROUP BY r.res_cand_id, percentiles
    
    UNION ALL
    
    SELECT
        r.res_cand_id,
        'P' AS tipo_pregunta,
        (SELECT MAX(bare_percentiles) FROM psi_baremos_epqa AS b
         WHERE b.bare_sexo = c.cand_sexo AND b.bare_p <= (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'P' AND p.res_cand_id = r.res_cand_id) AND b.bare_test_id = 1) AS percentiles,
        (SELECT puntuacion_por_tipo FROM PuntuacionPorTipo AS p WHERE p.pregunta_tipo = 'P' AND p.res_cand_id = r.res_cand_id) AS puntuacion_por_tipo
    FROM psi_respuestas AS r
    INNER JOIN psi_candidato AS c ON r.res_cand_id = c.cand_id
    WHERE r.res_cand_id = $nuevoCandidatoID
    GROUP BY r.res_cand_id, percentiles
    ORDER BY res_cand_id, tipo_pregunta;";

        try {

            $pruebas = VerResultado::fetchArray($sql, ['cand_id' => $nuevoCandidatoID]);

            echo json_encode($pruebas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarIAC(Router $router)
    {
        $nuevoCandidatoID = $_GET['nuevoCandidatoID'];

        if (!$nuevoCandidatoID) {
            echo json_encode([
                'mensaje' => 'No se proporcionó un ID de candidato',
                'codigo' => 0
            ]);
            return;
        }

        $sql = "WITH PuntuacionPorTipo AS (
        SELECT
            r.res_cand_id,
            p.pregunta_tipo,
            SUM(CASE WHEN r.res_respuesta = p.pregunta_respuesta THEN 1 ELSE 0 END) AS puntuacion_por_tipo
        FROM psi_respuestas AS r
        INNER JOIN psi_preguntas_iac AS p ON r.res_pregunta_id = p.pregunta_id
        WHERE r.res_respuesta = p.pregunta_respuesta
        GROUP BY r.res_cand_id, p.pregunta_tipo
    )
    
    SELECT
        r.res_cand_id,
        p.pregunta_tipo AS tipo_pregunta,
        MAX(b.pd_pc) AS percentiles,
        MAX(p.puntuacion_por_tipo) AS puntuacion_por_tipo,
        MAX(b.pd_s) AS puntuacion_bare_s
    FROM psi_respuestas AS r
    INNER JOIN PuntuacionPorTipo AS p ON r.res_cand_id = p.res_cand_id
    INNER JOIN psi_baremos_iac AS b ON
        CASE p.pregunta_tipo
            WHEN 'PERSONAL' THEN b.pd_personal
            WHEN 'FAMILIAR' THEN b.pd_familiar
            WHEN 'ESCOLAR' THEN b.pd_escolar
            WHEN 'SOCIAL' THEN b.pd_social
        END <= p.puntuacion_por_tipo
        AND b.pd_test_id = 2
    WHERE r.res_cand_id = $nuevoCandidatoID
    GROUP BY r.res_cand_id, p.pregunta_tipo
    ORDER BY r.res_cand_id, tipo_pregunta;
    ";

        try {
            $pruebas = VerResultado::fetchArray($sql, ['cand_id' => $nuevoCandidatoID]);

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