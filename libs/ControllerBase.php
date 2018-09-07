<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ControllerBase {

    protected $view;
    protected $model; 
    protected $document;
 
    function __construct() {
        $validacion = Validacion::singleton();
        if ($validacion->isLogged()) {
            $this->document = Document::singleton(); 
            $this->view = new View();
            $this->document->addScript('expandirdivs' .SL. 'jquery-1.8.1');      
            $this->document->addScript("cal");
            $this->document->addScript("aplication");
            $this->document->addCss("calendar");
            $this->view->setVars('doc', $this->document);
            $this->view->setVars('view', $this->view);
        }
    }

    function getModel($nameModel) {
        $model = $nameModel . 'Model';
        $path = MODELS . DS . $nameModel . 'Model.php';
        require ($path);
        $this->model = new $model();
        return $this->model;
    }
   
}

?>