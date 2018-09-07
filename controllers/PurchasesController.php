<?php 
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
class PurchasesController extends ControllerBase {

    public function main() {
        $this->purchases();
    } 

    public function purchases() {
        $this->view->setTemplate('purchases' . DS . 'purchases');        
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $usuario = $this->getModel("User");
        $idusuario = $usuario->getUserId();
        $this->getModel("Purshases"); 
        $comprasr = $this->model->getPurshases($idusuario);
        $this->view->setVars('comprasr',$comprasr);  
        $this->view->show();
    }
    
    public function details() {
        $this->view->setTemplate('purchases' . DS . 'details');        
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $usuario = $this->getModel("User");
        $idusuario = $usuario->getUserId();
        $this->getModel("Purshases"); 
        $details = $this->model->getDetails($idusuario);
        $estilo=1;
        $this->view->setVars('detalles',$details);  
        $this->view->setVars('estilo',$estilo);  
        $this->view->show();
    }
}
?>
