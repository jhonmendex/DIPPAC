<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class TestController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('Test' . DS . 'test');
        $this->document->addScript("test");
        $this->document->addScript("font-awesome");
        $this->document->addCss("demo_page");
        $this->document->addCss("orden");
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->setHeader();
        
        //$this->getModel("TestDiscalculia");
        // $objeto = $this->model->getTest();
        // $this->view->setVars('objeto', $objeto);
        $this->view->show();
    }

    public function testResult(){
        $this->view->setTemplate('Test' . DS . 'result');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }



}

?>