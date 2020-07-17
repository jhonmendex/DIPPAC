<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DyscalculiaIndexController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('DyscalculiaViews' . DS . 'dyscalculiaIndex');
        $this->document->addScript("test");
        $this->document->addScript("font-awesome");
        $this->document->addCss('indexStyle');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addCss("orden");
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
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
        $this->view->setTemplate('DyscalculiaViews' . DS . 'result');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function test(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'test');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic1(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic16(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic17(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic18(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic19(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic267(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_6_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic28(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Ideognostic29(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'IdeognosticTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical16(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical178(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_7_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical19(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest1_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical26(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_6y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical27(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_7y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical28(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_8y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }

    public function Lexical29(){
        $this->view->setTemplate('DyscalculiaViews' . DS . 'LexicalTest2_9y');
        $this->document->addCss('dyscaulculiaCss' . DS . 'discalculia');
        $this->document->addScript('dyscalculiaScripts' . DS . 'Time');
        $this->document->setHeader();
        $this->getModel("TestDiscalculia");
        $this->view->show();
    }


}

?>