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
                $new_cand_id = $resultado['id']; 
    
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,
                    'id' => $new_cand_id  
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
        $sql = "SELECT *, TIMESTAMPDIFF(YEAR, cand_fecha_nacimiento, CURDATE()) AS edad
        FROM psi_candidato
        WHERE cand_situacion = 1;
        ";

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
                return []; 
            }
        } catch (Exception $e) {
            // Manejo de errores
            return [];
        }
    }
    
   
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
            $candidato->cand_situacion = '2';
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
