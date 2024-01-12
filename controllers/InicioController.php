<?php

namespace Controllers;

use Exception;
// use Model\Inicio;
use MVC\Router;



class InicioController {
public static function index(Router $router) {
        $router->render('inicio/index', []);
    }
}
