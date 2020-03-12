<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class GenerateCommissionController extends ControllerBase {

    public function main() {
        $this->comisiones();
    }
    
    public function comisiones() {
        $this->view->setTemplate('commissions' . DS . 'generateCommissions');     
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
        $tree = $this->getModel("Commissions");              
        $periodos = $this->model->getAvailablePeriods();  
        $comisiones = $this->model->getComissionsGenerated();  
        $this->view->setVars('periodos',$periodos);
        $this->view->setVars('comisiones',$comisiones);
        $this->view->show();
    }    
    
    public function levels(){
        $this->view->setTemplate('commissions' . DS . 'generateDetails');        
      $this->document->addScript("jquery.dataTables");            
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();        
        $periodo= $_GET['periodo'];           
        $tree = $this->getModel("Commissions");          
        $allComission=$tree->getComissionsAll($periodo);
        $periodoname=$tree->getPeriodoName($periodo);
        $this->view->setVars('allComission',$allComission);  
        $this->view->setVars('periodoname',$periodoname); 
        $this->view->show();
    }
}

?>
