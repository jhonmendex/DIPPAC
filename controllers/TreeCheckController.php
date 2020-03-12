<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class TreeCheckController extends ControllerBase {

    public function main() {
        $this->basicTree();
    }

    public function basicTree() {
        $this->view->setTemplate('treeCheck' . DS . 'treeCheck');        
        $this->document->addScript("organizational-chart");
        $this->document->addCss("styletree");
        $this->document->setHeader();        
        $tree = $this->getModel("Tree");
        $this->getModel("User");        
        $idUser = $this->model->getUserId();
        $nameUser = $this->model->getUserName();
        $arbol = $tree->getTree($idUser,$nameUser);     
        $level = $tree->getLevel();
        $this->view->setVars('arbol', $arbol);
        $this->view->setVars('nivel', $level);
        $this->view->setVars('nombrePadre', $nameUser);
        $this->view->show();
    }
    public function dataGetNode() {        
        $tree = $this->getModel("Tree");
        $this->getModel("User");
        $id_user=$tree->getNodeIdAjax();
        $usuario = $this->model->getUserById($id_user);
        $tree->getNodeAjax($usuario);
        
    }

}

?>
