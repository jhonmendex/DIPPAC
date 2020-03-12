<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class TestController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('Test' . DS . 'test');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript("test");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("test"); 
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("WareHouse");
        $bodegas = $this->model->getWareHouse();
        $this->view->setVars('bodega', $bodegas);
        $this->view->show();
    }



}

?>