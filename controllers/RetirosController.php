<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class RetirosController extends ControllerBase {

    public function main() {
        $this->allRetiros();
    }

    public function allRetiros() {
        $this->view->setTemplate('retiros' . DS . 'AllRetiros');
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
        $this->document->setHeader();
        $this->getModel("Retiros");
        $retiros = $this->model->getAllRetiros();
        $messs = null;
        if (isset($_GET['messageok'])) {
            $messs = 'mensajeok';
        }
        unset($_SESSION['retirosesion']);
        $nombrebodega = $this->model->getNombrebodega();
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('mensajito', $messs);
        $this->view->setVars('retiros', $retiros);
        $this->view->show();
    }

    public function getdetailsRetiro() {
        $this->view->setTemplate('retiros' . DS . 'detailsRetiro');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $iddocument = $_GET['iddoc'];
        $this->getModel("Retiros");
        $docinfo = $this->model->getdocumentByid($iddocument);
        $itemsdoc = $this->model->getdetailsRetiro($iddocument);
        $estilo = 1;
        $this->view->setVars('docinfo', $docinfo);
        $this->view->setVars('detallesdoc', $itemsdoc);
        $this->view->setVars('estilo', $estilo);
        $this->view->show();
    }

    public function newRetiro() {
        $this->view->setTemplate('retiros' . DS . 'newRetiro');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $items = $_SESSION['retirosesion'] ? $_SESSION['retirosesion'] : null;
        $this->view->setVars('items', $items);
        $this->view->show();
    }

    public function getProducts() {
        $this->view->setTemplate('retiros' . DS . 'selectProducto');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Product");
        $categorias = $this->model->categorias();
        $idcat;
        if (isset($_POST['idcat'])) {
            $idcat = $_POST['idcat'];
            if ($idcat == "all") {
                $productos = $this->model->getProductsTodos();
            } else {
                $productos = $this->model->getProducts($idcat, true);
            }
        } else {
            $productos = $this->model->getProductsTodos();
            $idcat = "all";
        }
        $this->view->setVars('productos', $productos);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->show();
    }

    public function addNewItem() {
        $this->getModel("Retiros");
        $this->model->addItemToSession();
    }

    public function deleteItem() {
        $this->getModel("Retiros");
        $this->model->deleteItemToSession();
    }

    public function updateItem() {
        $this->getModel("Retiros");
        $this->model->updateItem();
    }

    public function createRetiro() {
        $this->getModel("Retiros");
        $this->model->createRetiro();
    }

    public function Cancelretiro() {
        unset($_SESSION['retirosesion']);
        echo json_encode(array("respuesta" => "ok"));
    }

}

?>
