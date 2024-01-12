<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;


use Controllers\LoginController;
use Controllers\ActivacionController;

// poryecto final
use Controllers\TestController;
use Controllers\PacienteController;
use Controllers\CandidatoController;
use Controllers\CuestionarioController;
use Controllers\RespuestaController;
use Controllers\EvaluacionController;
use Controllers\VerRespuestaController;
use Controllers\VerResultadoController;
use Controllers\InicioController;


$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

// proyecto final
// test
$router->get('/test/epqa', [TestController::class,'epqa']);
$router->get('/test/iac', [TestController::class,'iac']);
$router->get('/API/test/buscar/epqa', [TestController::class,'buscarEPQA']);
$router->get('/API/test/buscar/iac', [TestController::class,'buscarIAC']);



// candidatos

$router->get('/candidato', [CandidatoController::class,'index']);
$router->get('/API/candidato/buscar', [CandidatoController::class,'buscarAPI']);
$router->post('/API/candidato/guardar', [CandidatoController::class,'guardarAPI']);
$router->post('/API/candidato/modificar', [CandidatoController::class,'modificarAPI']);
$router->post('/API/candidato/eliminar', [CandidatoController::class,'eliminarAPI']);
$router->post('/API/candidato/guardar_con_test', [CandidatoController::class,'guardar_con_testAPI']);


//evaluacion
$router->get('/evaluacion/epqa', [EvaluacionController::class,'epqa']);
$router->get('/evaluacion/iac', [EvaluacionController::class,'iac']);
$router->get('/API/evaluacion/buscar/epqa', [EvaluacionController::class,'buscarEPQA']);
$router->get('/API/evaluacion/buscar/iac', [EvaluacionController::class,'buscarIAC']);
$router->get('/API/evaluacion/buscar/resepqa', [EvaluacionController::class,'buscarResEPQA']);
$router->get('/API/evaluacion/buscar/resiac', [EvaluacionController::class,'buscarResIAC']);
$router->post('/API/evaluacion/guardarconclusion', [EvaluacionController::class,'guardarconclusionAPI']);
$router->post('/API/evaluacion/actualizarTiempo', [EvaluacionController::class,'actualizarTiempoAPI']);



// respuestas
$router->get('/respuesta/epqa', [RespuestaController::class,'epqa']);
$router->get('/respuesta/iac', [RespuestaController::class,'iac']);
$router->get('/API/respuesta/buscar/epqa', [RespuestaController::class,'buscarEPQA']);
$router->get('/API/respuesta/buscar/iac', [RespuestaController::class,'buscarIAC']);
$router->get('/API/respuesta/buscar/res', [RespuestaController::class,'buscarRES']);
$router->post('/API/respuesta/guardar', [RespuestaController::class,'guardarAPI']);


//  Ver las Respuestas
$router->get('/verrespuesta/epqa', [VerRespuestaController::class,'epqa']);
$router->get('/verrespuesta/iac', [VerRespuestaController::class,'iac']);
$router->get('/API/verrespuesta/buscar/epqa', [VerRespuestaController::class,'buscarEPQA']);
$router->get('/API/verrespuesta/buscar/iac', [VerRespuestaController::class,'buscarIAC']);
$router->get('/API/verrespuesta/buscar/res', [VerRespuestaController::class,'buscarRES']);


//  Ver los Resultados
$router->get('/verresultado/epqa', [VerResultadoController::class,'epqa']);
$router->get('/verresultado/iac', [VerResultadoController::class,'iac']);
$router->get('/API/verresultado/buscar/epqa', [VerResultadoController::class,'buscarEPQA']);
$router->get('/API/verresultado/buscar/iac', [VerResultadoController::class,'buscarIAC']);
$router->get('/API/verresultado/buscar/res', [VerResultadoController::class,'buscarRES']);


//  INICIO
$router->get('/inicio', [InicioController::class,'index']);


//!Rutas para El Login
$router->get('/', [LoginController::class,'indexinicio']);
$router->get('/login', [LoginController::class,'index']);
$router->get('/menuAdministrador', [LoginController::class,'menuAdministrador']);
$router->get('/menuTecnico', [LoginController::class,'menuTecnico']);
$router->get('/menuCliente', [LoginController::class,'menuCliente']);
$router->get('/logout', [LoginController::class,'logout']);
$router->post('/API/login', [LoginController::class,'loginAPI']);


//!Rutas para El Registro de Usarios
$router->get('/registro', [LoginController::class,'indexx']);
$router->post('/API/registro/guardar', [LoginController::class,'guardarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
