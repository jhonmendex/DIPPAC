<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
 
class ReturnSalesController extends ControllerBase {
   
    public function main() {   
        $this->view->setTemplate('returnsales' . DS . 'returnsales');
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
        $this->getModel("ReturnSales");
        $facturas = $this->model->getFacturas();
        $nombrebodega = $this->model->getNombrebodega();
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('facturas', $facturas);
        $this->view->show();
    }

    public function detailsreturnsales() {
        $this->view->setTemplate('returnsales' . DS . 'detailsreturnsales');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table"); 
        $this->document->setHeader();
        $this->getModel("ReturnSales");
        $details = $this->model->getDetailsInvoices();
        $_SESSION['devolucionventa']=$_GET["idfactura"];
        $estilo = 1;
        $this->view->setVars('detalles', $details);
        $this->view->setVars('estilo', $estilo);
        $this->view->show(); 
    }   

    public function registrarDevolucion() { 
        $_SESSION['devolucion'][$_POST['idproducto']] = $_POST['cantidad'];    
    }
  
    public function eliminardetalle() { 
        unset($_SESSION['devolucion'][$_POST['detalleventa']]);
    }  

    public function finalizarDevolucion(){  
       $this->getModel("ReturnSales");
       $idfactura = $_GET["idfactura"];  
       $this->model->registrarDevolucion($idfactura); 
    }     
        public function cancelarsesion() {   
        unset($_SESSION['devolucion']); 
    }
}

?>

