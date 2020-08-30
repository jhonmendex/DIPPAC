<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DaltonismController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('daltonismviews' . DS . 'principal');
        $this->document->addScript("test");
        $this->document->addScript("font-awesome");
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("daltonismstartingscreen");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->setHeader();
        $this->view->show();
    }

    public function testStartScreen(){
        $this->view->setTemplate('daltonismviews' . DS . 'startingscreen');
        $this->document->addCss('daltonismcss' . DS . 'daltonismstartingscreen');   
        $this->document->addScript('daltonismscripts' . DS . 'startscreen');   
        $this->document->setHeader();
        $this->view->show();
    }
    public function gameScren(){
        $this->view->setTemplate('daltonismviews' . DS . 'gameview');
        $this->document->addCss('daltonismcss' . DS . 'gameview');       
         $this->document->setHeader();
        $this->view->show();
    }



}

?>