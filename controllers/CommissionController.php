<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class CommissionController extends ControllerBase {

    public function main() {
        $this->comisiones();
    }
    
    public function comisiones() {
        $this->view->setTemplate('commissions' . DS . 'commissions');     
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();        
        $tree = $this->getModel("Commissions");
        $this->getModel("User");        
        $idUser = $this->model->getUserId();         
        $arbol = $tree->getMyComissions($idUser);   
        $this->view->setVars('info',$arbol);
        $this->view->show(); 
    }
    
    public function reporteComision() {        
       // $this->view->setTemplate('commissions' . DS . 'reporte');     
       // $this->document->setHeader();  
        $id_user=$_GET['ID'];
       $this->getModel("User");       
        $usuario = $this->model->getUserById($id_user);
        $tree = $this->getModel("Commissions");       
        $arbol = $tree->getReporte($usuario['nombre'],$usuario['id']);  
        //$this->view->setVars('info',$arbol);
        //$this->view->show();        
    }
    
    public function generateComision() {               
        $idperiodo=$_POST['periodo'];      
        $tree = $this->getModel("Commissions");       
        $tree->generateTree($idperiodo);              
    }
    
    public function levels(){
        $this->view->setTemplate('commissions' . DS . 'details');        
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $periodo= $_GET['periodd'];           
        $usuario = $this->getModel("User");
        $idusuario = $usuario->getUserId();        
        $tree = $this->getModel("Commissions");          
        $level0=$tree->comLevel0($periodo,$idusuario);
        $level1=$tree->comLevel1($periodo,$idusuario);
        $level2=$tree->comLevel2($periodo,$idusuario);
        $level3=$tree->comLevel3($periodo,$idusuario);        
        $level4=$tree->comLevel4($periodo,$idusuario);                
          
        $this->view->setVars('level0',$level0);  
        $this->view->setVars('level1',$level1);  
        $this->view->setVars('level2',$level2);  
        $this->view->setVars('level3',$level3);   
        $this->view->setVars('level4',$level4);  
        $this->view->show();
    }
}

?>
