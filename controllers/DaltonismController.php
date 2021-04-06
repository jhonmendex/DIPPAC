<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DaltonismController extends ControllerBase
{

    public function main()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'principal');
        $this->document->setHeader();
        $this->view->show();
    }

    public function testStartScreen()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'startingscreen');
        $this->document->addCss('daltonismcss' . DS . 'daltonismstartingscreen');
        $this->document->addScript('daltonismscripts' . DS . 'daltonism');
        $this->document->addScript('jquery');
        $this->getModel("Daltonism");
        $cuestionarios = $this->model->getCuestionarios();
        $this->document->setHeader();
        $this->view->show();
    }
    public function gameScreen()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'gameview');
        $this->document->addCss('daltonismcss' . DS . 'gameview');
        $this->document->addScript('jquery');
        $this->document->addScript('daltonismscripts' . DS . 'daltonism');
        $this->getModel("Daltonism");
        $cuestionarios = $this->model->getCuestionarios();
        $this->document->setHeader();
        $this->view->show();
    }
    public function endGameScreen()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'endgameview');
        $this->document->addCss('daltonismcss' . DS . 'gameview');
        $this->document->addScript('jquery');
        $this->document->addScript('daltonismscripts' . DS . 'daltonism');
        $this->document->setHeader();
        $this->view->show();
    }
    public function testReports()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'reportsview');
        $this->document->setHeader();
        $this->view->show();
    }
    public function tableReport()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'tableview');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript("columnfilter");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->addScript('daltonismscripts' . DS . 'table');
        $this->getModel("Daltonism");
        $reporte = $this->model->getReport();
        $this->view->setVars('reporte', $reporte);
        $this->document->setHeader();
        $this->view->show();
    }
    public function typeReport()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'typeview');
        $this->document->addScript('daltonismscripts' . DS . 'Chart');
        $this->document->addScript('daltonismscripts' . DS . 'typeview');
        $this->getModel("Daltonism");
        $reporte = $this->model->getTypeReport();
        $this->view->setVars('reporte', $reporte);
        $this->document->setHeader();
        $this->view->show();
    }
    public function ageReport()
    {
        $this->view->setTemplate('daltonismviews' . DS . 'ageview');
        $this->document->addScript('daltonismscripts' . DS . 'Chart');
        $this->document->addScript('daltonismscripts' . DS . 'ageview');
        $this->getModel("Daltonism");
        $reporte = $this->model->getAgeReport();
        $this->view->setVars('reporte', $reporte);
        $this->document->setHeader();
        $this->document->setHeader();
        $this->view->show();
    }
    public function saveAnswer()
    {
        $this->getModel("User");
        $idUser = $this->model->getUserId();
        $user = $this->model->getUserById($idUser);
        if ($user != false) {

            $birthDate = $user['fechacumple'];

            $birthDateYear = date("Y", strtotime($birthDate));

            $today = getdate();

            $todayYear = $today['year'];

            $finalDate = $todayYear - $birthDateYear;
        }
        if (isset($_POST['data'])) {
            $datos = $_POST['data'];
            $this->getModel("Daltonism");
            $res = $this->model->addAnswer($datos, $idUser, $finalDate);
            echo json_encode($res);
        } else {
            echo json_encode("Error: No es un método POST");
        }
    }
}
