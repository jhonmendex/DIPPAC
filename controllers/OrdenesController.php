<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class OrdenesController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('ordenes' . DS . 'index');
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
         
 
        $this->view->show();
    }

  

}

?>
