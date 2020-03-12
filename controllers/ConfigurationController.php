<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ConfigurationController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('configuration' . DS . 'configuration');
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $this->getModel("Configuration");
        $settigs = $this->model->getInfromation();
        $this->view->setVars("settigs",$settigs);
        $this->view->show();
    }
    
    public function updateData(){
        $this->getModel("Configuration");
        $settigs = $this->model->updateData();
    }
    
}
?>
