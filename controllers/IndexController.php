<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class IndexController extends ControllerBase{
    
    public function main(){
        $this->view->setTemplate('frameset');
        $this->getModel("User");
        $menus = $this->model->getMenus();
        $urls[0]="index.php?controlador=Index&accion=Banner";
        $urls[1]="index.php?controlador=Index&accion=Menu";
        $urls[2]="index.php?controlador=Index&accion=Logo";
        $urls[2] = $menus[0]['urlprin'];
        $this->view->setVars('arreglo', $urls);
        $this->view->setVars('idmenu', $menus[0]['idmen']);
        $this->view->setFrame();
    }    
    
    public function Logo(){
        $this->view->setTemplate('logo');
        $this->document->addCss("pos");
        $this->document->setHeader();  
        $logo= IMAGES.SL."plentiful.jpg";        
        $this->view->setVars('imagen',$logo);         
        $this->view->show();        
    }
    
    public function Menu(){
        $this->view->setTemplate('menu');                
        $this->document->addScript("jquery-ui.min");
        $this->document->addCss("jquery-ui");
        $this->document->addCss("menu");
        $this->document->addCss("icomoon/style");
        $this->document->setHeader();  
        $this->getModel("User"); 
        $menus = $this->model->getMenus();
        $permisosUser = $this->model->getSubmenus($menus[0]['idmen']);
        $nombremenu = $this->model->getMenuName($menus[0]['idmen']);  
        $this->view->setVars('submenus',$permisosUser);
        $this->view->setVars('tituloMenu',$nombremenu);
        $this->view->show();        
    }
    
    public function Banner(){
        $this->view->setTemplate('banner');
        $this->document->addScript("jquery.dropdown");
        $this->document->addCss("banner");
        $this->document->addCss("jquery.dropdown");
        $this->document->addCss("menuarriba");
        $this->document->setHeader();   
        $this->getModel("User"); 
        $nameUser=$this->model->getUserName();
        $permisosUser=$this->model->getMenus();
        $perfil=$this->model->getUserProfileName();
        $this->view->setVars('perfil',$perfil);
        $this->view->setVars('nombre',$nameUser);
        $this->view->setVars('menus',$permisosUser);
        $this->view->show(); 
    }
    
}
?>
