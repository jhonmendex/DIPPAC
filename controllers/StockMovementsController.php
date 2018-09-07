<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class StockMovementsController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('Movements' . DS . 'StockMovements');  
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
        $this->getModel("StockMovements");
        if (isset($_POST["codigopro"]) && isset($_POST['dateini']) && isset($_POST['datefin']) && $_POST['datefin'] != '' && $_POST['dateini'] != '') {
            $fechainicial = $_POST['dateini'];
            $fechafinal = $_POST['datefin'];
            $referencia = $_POST['codigopro'];
            $movimientos = $this->model->getMovements($fechainicial, $fechafinal, trim($referencia));
            $producto = $this->model->traernombreproducto(trim($referencia));
        } else if (isset($_POST["codigopro"]) && isset($_POST['dateini']) && isset($_POST['datefin']) && $_POST["codigopro"] != '') {
            $fechainicial = $this->model->fechaInicial();
            $fechafinal = $this->model->fechaFinal();
            $referencia = $_POST['codigopro'];
            $movimientos = $this->model->getMovements($fechainicial, $fechafinal, trim($referencia));
            $producto = $this->model->traernombreproducto(trim($referencia));
        }
        $this->view->setVars('movimientos', $movimientos);
        $this->view->setVars('referencia', $referencia);
        $this->view->setVars('producto', $producto);
        $this->view->setVars('fechainicial', $fechainicial);
        $this->view->setVars('fechafinal', $fechafinal);
        $this->view->show();
    }

}

?>