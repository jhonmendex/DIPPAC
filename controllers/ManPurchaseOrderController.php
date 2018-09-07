<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ManPurchaseOrderController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('manpurchaseorder' . DS . 'managermanpurchaseorder');
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
        $this->getModel("ManPurchaseOrder");
        $idestado;
        $fechaini;
        $fechafin;
        if (isset($_POST['idestado']) && isset($_POST['dateini']) && isset($_POST['datefin'])) {
            $idestado = $_POST['idestado'];
            $fechaini = $_POST['dateini'];
            $fechafin = $_POST['datefin'];
        } else {
            $idestado = $this->model->primerEstado();
            $fechaini = $this->model->fechaInicial();
            $fechafin = $this->model->fechaFinal();
        }
        if ($idestado == 'pagado') {
            $facturas = $this->model->getFacturas($fechaini, $fechafin);
        } else {
            $ventas = $this->model->getManPurchaseOrders($idestado, $fechaini, $fechafin);
        }
        $nombrebodega = $this->model->getNombrebodega();
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('facturas', $facturas);
        $this->view->setVars('ventas', $ventas);
        $this->view->setVars('fechaini', $fechaini);
        $this->view->setVars('fechafin', $fechafin);
        $this->view->setVars('idestado', $idestado);        
        $this->view->show();
    }

    public function details() {
        $this->view->setTemplate('manpurchaseorder' . DS . 'details');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("ManPurchaseOrder");
        $details = $this->model->getDetails();
        $estilo = 1;
        $this->view->setVars('detalles', $details);
        $this->view->setVars('estilo', $estilo);
        $this->view->show();
    }

    public function detailsinvoices() {
        $this->view->setTemplate('manpurchaseorder' . DS . 'detailsinvoices');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("ManPurchaseOrder");
        $details = $this->model->getDetailsInvoices();
        $estilo = 1;
        $this->view->setVars('detalles', $details);
        $this->view->setVars('estilo', $estilo);
        $this->view->show();
    }

    public function cambiarEstado() {
        $estadoorden = $_POST['estadoorden'];
        $norden = $_POST['norden'];
        $this->getModel("ManPurchaseOrder");
        $this->model->cambiarEstado($estadoorden, $norden);
    }

    public function cambiarEstadoFactura() {
        $estadofactura = $_POST['estadofactura'];
        $idfactura = $_POST['idfactura'];
        $nfactura = $_POST['consecutivo'];
        $this->getModel("ManPurchaseOrder");
        $this->model->cambiarEstadoFactura($estadofactura, $nfactura, $idfactura);
    }

    public function validaStockVenta() {
        $idventa = $_POST['idventa'];
        $this->getModel("ManPurchaseOrder");
        $this->model->verificarDetallesStock($idventa);
    }

}

?>    