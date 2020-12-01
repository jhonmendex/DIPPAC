<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DislexyaController extends ControllerBase {
     public function main() {
        $this->view->setTemplate('dislexya' . DS . 'testDislexya');
        $this->document->addCss('dislexya/introStyle');
        $this->document->addCss('dislexya/bootstrap');
        $this->document->setHeader();
        
        //$this->getModel("TestDiscalculia");
        // $objeto = $this->model->getTest();
        // $this->view->setVars('objeto', $objeto);
        $this->view->show();
    }

    public function testResult(){
        $this->view->setTemplate('dislexya'.DS.'result');
        $this->getModel("User");
        $nameUser = $this->model->getUserId(); 
        $this->view->setVars('nameSpon', $nameUser);
        echo($nameUser);
        $this->document->addCss('dislexya/style');
        $this->document->addCss('dislexya/bootstrap');
        $this->document->addScript('dislexya/firebase-app');
        $this->document->addScript('dislexya/firebase-analytics');
        $this->document->addScript('dislexya/firebase-database');     
        $this->document->addScript('dislexya/firebaseConfig');
        $this->document->addScript('dislexya/detailRepository');
        $this->document->addScript('dislexya/detail');
        $this->document->addScript('dislexya/reporteRepository');
        $this->document->setHeader();
        $this->view->show();
    }

    
    public function testResultDetail(){
        $this->view->setTemplate('dislexya'.DS.'resultDetail');
        if (isset($_GET['idparticipant'])) {
            $idParticipant = $_GET['idparticipant'];
            }
        $this->view->setVars('idparticipant', $idParticipant);
        $this->document->addCss('dislexya/style');
        $this->document->addCss('dislexya/bootstrap');
        $this->document->addScript('dislexya/Chart.min');
        $this->document->addScript('dislexya/firebase-app');
        $this->document->addScript('dislexya/firebase-analytics');
        $this->document->addScript('dislexya/firebase-database');
        $this->document->addScript('dislexya/firebaseConfig');
        $this->document->addScript('dislexya/detailRepository');
        $this->document->addScript('dislexya/detail');
        $this->document->setHeader();
        $this->view->show();
    }
}

?>