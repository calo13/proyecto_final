<?php
namespace Controllers;
// ignorar este inicio, es por el namespace xD
// Aqui estan todos los controladores version 1.1.1

?>





<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------ -->

<?php

namespace Controllers;

use Exception;
use Model\Candidato;
use MVC\Router;

class CandidatoController
{
    public static function index(Router $router)
    {
        $test = static::buscarTest();
        // Puedes agregar lógica específica si es necesario
        $router->render('candidato/index', [
            'test' => $test
        ]);
    }

    public static function guardarApi()
    {
        try {
            if (isset($_POST['cand_fecha_nacimiento'])) {
                $_POST['cand_fecha_nacimiento'] = date('Y-m-d', strtotime($_POST['cand_fecha_nacimiento']));
            }
    
            $candidato = new Candidato($_POST);
            $resultado = $candidato->crear();
    
            if ($resultado['resultado'] == 1) {
                $new_cand_id = $resultado['id'];  // aqui llamos el ID del candidato que guardamos
    
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,
                    'id' => $new_cand_id  // agregamos para que lo llame en formato json
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
    

    public static function buscarAPI(Router $router) {
        $sql = "SELECT *, (current - cand_fecha_nacimiento)/365.25 AS edad FROM psi_candidato WHERE cand_situacion = 1;";

        try {
            $candidato = Candidato::fetchArray($sql);

            echo json_encode($candidato);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarTest()
    {       
        $sql = "SELECT * FROM psi_test WHERE test_situacion = 1";        
        try {            
            $test = Candidato::fetchArray($sql);
            if ($test) {
                return $test;
            } else {
                return []; // Devuelve un array vacío en caso de no encontrar resultados
            }
        } catch (Exception $e) {
            // Manejo de errores
            return [];
        }
    }
    
    // $test = Candidato::fetchArray($sql);



    public static function modificarAPI()
    {
        try {
          
            $candidato = new Candidato($_POST);
       
           
            $resultado = $candidato->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Dato modificado correctamente',
                    'codigo' => 1
                ]);
            }  
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error excepcion',
                'codigo' => 0
            ]);
        }
    }

    

    public static function guardar_con_testAPI()
    {
        try {
             $nuevoCandidatoID = $_POST['nuevoCandidatoID'];
          
            $test_id = $_POST['cand_test_id'];
            $candidato = Candidato::find($nuevoCandidatoID);
            $candidato->cand_test_id =  $test_id;
            $resultado = $candidato->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Test asignado correctamente',
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


    public static function eliminarAPI()
    {
        try {
            $cand_id = $_POST['cand_id'];
            $candidato = Candidato::find($cand_id);
            $candidato->cand_situacion = '2'; // Cambiar a la situación deseada para eliminar
            $resultado = $candidato->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Dato eliminado correctamente',
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
}

?>









<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------ -->


<?php

namespace Controllers;

use Exception;
use Model\Respuesta;
use MVC\Router;

class RespuestaController {
    public static function epqa(Router $router){
        $router->render('respuesta/epqa', []);
    }
    public static function iac(Router $router){
        $router->render('respuesta/iac', []);
    }
 
    // public static function indexreservaciones(Router $router){
    //     $router->render('reservaciones/index', []);
    // }


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
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    // funcion para buscar las respuestas de la tabla respuestas
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

// falta corregit esta funciones para buscar las preguntas del test
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
    session_start(); // Iniciar sesión
    $indicePregunta = $_SESSION['indice_pregunta'] ?? 0; // Obtener el índice actual

    $sql = "SELECT p.pregunta_id, t.test_nombre, p.pregunta_pregunta, p.pregunta_tipo, p.pregunta_respuesta, p.pregunta_situacion
    FROM psi_preguntas_iac p
    JOIN psi_test t ON p.pregunta_test_id = t.test_id
    WHERE p.pregunta_test_id = 2
    LIMIT 1 OFFSET $indicePregunta;"; // Obtener una pregunta a la vez

    try {
        $pregunta = Respuesta::fetchArray($sql);

        if ($pregunta) {
            // Incrementar el índice para la próxima pregunta
            $indicePregunta++;
            $_SESSION['indice_pregunta'] = $indicePregunta;

            echo json_encode($pregunta);
        } else {
            // No se encontraron más preguntas
            echo json_encode([
                'mensaje' => 'No hay más preguntas',
                'codigo' => 2
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
}

?>



<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------ -->


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

?>