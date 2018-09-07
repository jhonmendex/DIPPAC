<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class FrontController {

    static function run() {
        require (LIBS . DS . 'Config.php');
        require (INCLUDES . DS . 'configuration.php');
        require (INCLUDES . DS . 'DataBase.php');
        require (INCLUDES . DS . 'GUser.php');
        require (LIBS . DS . 'Validacion.php');
        require (INCLUDES . DS . 'Document.php');
        require (INCLUDES . DS . 'Imagen.php');
        require (INCLUDES . DS . 'smpt' . DS . 'Correo.php');
        require (INCLUDES . DS . 'pdf' . DS . 'fpdf.php');
        require (INCLUDES . DS . 'pdf' . DS . 'contractpdf.php');
        require_once(INCLUDES . DS . 'Excel' . DS . 'PHPExcel.php');
        require_once(INCLUDES . DS . 'Excel' . DS . 'PHPExcel' . DS . 'Reader' . DS . 'Excel2007.php');
        require_once(INCLUDES . DS . 'Excel' . DS . 'PHPExcel' . DS . 'Writer' . DS . 'Excel2007.php');
        require_once(INCLUDES . DS . 'Excel' . DS . 'PHPExcel' . DS . 'IOFactory.php');
        require (LIBS . DS . 'View.php');
        require (LIBS . DS . 'ModelBase.php');
        require (LIBS . DS . 'ControllerBase.php');
        require (LIBS . DS . 'ControllerPublic.php');       
        if (!empty($_POST['cont'])) {
            $controlador = $_POST['cont'] . 'Controller';
            if (!empty($_POST['act'])) {
                $action = $_POST['act'];
                $controllerPath = CONTROLLERS . DS . $controlador . '.php';
                require $controllerPath;
                $controlleruser = new $controlador();
                $controlleruser->$action();
            }
        } else {

            if (!empty($_GET['controlador'])) {
                $controllerName = $_GET['controlador'] . 'Controller';
            } else {
                $controllerName = "IndexController";
            }

            if (!empty($_GET['accion'])) {
                $actionName = $_GET['accion'];
            } else {
                $actionName = "main";
            }
            $controllerPath = CONTROLLERS . DS . $controllerName . '.php';
            error_log(" \n" . "Ruta: " . $controllerPath . " \n", 3, LOG);
            error_log("Controlador: " . $controllerName . " \n", 3, LOG);
            error_log("Accion: " . $actionName . " \n", 3, LOG);
            if (is_file($controllerPath)) {
                require $controllerPath;
                $controller = new $controllerName();                
                if (method_exists($controller, $actionName) == false) {
                    die('404 not found');
                } else {
                    $controller->$actionName();
                }
            } else {
                die('404 not found');
            }
        }
    }

}

?>