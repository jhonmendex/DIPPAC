<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ReportsController extends ControllerBase {

    public function resumenSaldos() {
        $this->view->setTemplate('Reports' . DS . 'resumenSaldos');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("catalogo");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Reports");
        $categorias = $this->model->categorias();
        $sadministrador = $this->model->validarUsuario();
        $bodegas = $this->model->getWareHouse();
        $idcat;
        if (isset($_POST["idcat"]) && isset($_POST["idbodega"])) {
            $idcat = $_POST["idcat"];
            $idbodega = $_POST["idbodega"];
        } else {
            $idbodega = $this->model->bodegaDefecto();
            $idcat = $this->model->categoriaDefecto();
        }
        $resumens = $this->model->resumenSaldos($idbodega, $idcat);
        $this->view->setVars('resumens', $resumens);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('bodegas', $bodegas);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->setVars('bodegaselected', $idbodega);
        $this->view->setVars('sadministrador', $sadministrador);
        $this->view->show();
    }

    public function reporteVentas() {
        $this->view->setTemplate('Reports' . DS . 'reporteVentas');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("catalogo");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Reports");
        $sadministrador = $this->model->validarUsuario();
        $bodegas = $this->model->getWareHouse();
        if (isset($_POST["idbodega"]) && isset($_POST["dateini"]) && isset($_POST["datefin"])) {
            $idbodega = $_POST["idbodega"];
            $finicial = $_POST["dateini"];
            $ffinal = $_POST["datefin"];
        } else {
            $idbodega = $this->model->bodegaDefecto();
            $finicial = date("Y-m-d");
            $ffinal = date("Y-m-d");
        }
        $reportev = $this->model->reporteVentas($idbodega, $finicial, $ffinal);
        $this->view->setVars('reportev', $reportev);
        $this->view->setVars('bodegas', $bodegas);
        $this->view->setVars('finicial', $finicial);
        $this->view->setVars('ffinal', $ffinal);
        $this->view->setVars('sadministrador', $sadministrador);
        $this->view->setVars('bodegaselected', $idbodega);
        $this->view->show();
    }

    public function resumenCompras() {
        $this->view->setTemplate('Reports' . DS . 'resumenCompras');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("catalogo");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Reports");
        $sadministrador = $this->model->validarUsuario();
        $bodegas = $this->model->getWareHouse();
        if (isset($_POST["idbodega"]) && isset($_POST["dateini"]) && isset($_POST["datefin"])) {
            $idbodega = $_POST["idbodega"];
            $finicial = $_POST["dateini"];
            $ffinal = $_POST["datefin"];
        } else {
            $idbodega = $this->model->bodegaDefecto();
            $finicial = date("Y-m-d");
            $ffinal = date("Y-m-d H:i:s");
        }
        $reportev = $this->model->reporteCompras($idbodega, $finicial, $ffinal);
        $this->view->setVars('reportev', $reportev);
        $this->view->setVars('bodegas', $bodegas);
        $this->view->setVars('finicial', $finicial);
        $this->view->setVars('ffinal', $ffinal);
        $this->view->setVars('sadministrador', $sadministrador);
        $this->view->setVars('bodegaselected', $idbodega);
        $this->view->show();
    }

}

?>
