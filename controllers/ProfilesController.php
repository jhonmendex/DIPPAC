<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ProfilesController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('user' . DS . 'profiles');
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
        $message = null;
        $icono = null;
        $orderby = 'id';
        $maytomin = false;        
        $profiles = $this->getModel("Profiles");
        $listaperfiles = $profiles->getPerfiles($orderby, $maytomin);
        $this->view->setVars('perfiles', $listaperfiles);
        $this->view->setVars('mensaje', $message);
        $this->view->setVars('icono', $icono);
        $this->view->setVars('orderby', $orderby);
        $this->view->setVars('order', $maytomin);        
        $this->view->show();
    }

    public function assingPermissions() {
        $this->view->setTemplate('user' . DS . 'editpermissions');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $profiles = $this->getModel("Profiles");
        $menus = $profiles->getMenusAndSubmenus($_GET['profile']);
        $currentProfile = $profiles->getPerfil($_GET['profile']);
        $this->view->setVars('menus', $menus);
        $this->view->setVars('profile', $currentProfile);
        $this->view->show();
    }

    public function createProfile() {
        $this->view->setTemplate('user' . DS . 'createprofile');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $profiles = $this->getModel("Profiles");
        $menus = $profiles->getMenusAndSubmenus();
        $defaultgroup = 'Administrador';
        if (isset($_GET['groupselect'])) {
            $defaultgroup = $_GET['groupselect'];
        }
        $this->view->setVars('menus', $menus);
        $this->view->setVars('group', $defaultgroup);
        $this->view->show();
    }

    public function addSubMenu() {
        $profiles = $this->getModel("Profiles");
        $profiles->addSubmenusProfile();
    }

    public function delSubMenu() {
        $profiles = $this->getModel("Profiles");
        $profiles->removeSubmenusProfile();
    }

    public function deleteProfile() {
        $profiles = $this->getModel("Profiles");
        $profiles->removeProfile();
    }

    public function createNewProfile() {
        $profiles = $this->getModel("Profiles");
        $profiles->createProfile();
    }

}

?>