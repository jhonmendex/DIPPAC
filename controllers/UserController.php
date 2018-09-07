<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class UserController extends ControllerPublic {

    public function main() {
        $this->Login();
    }

    public function Login() {
        if ($this->isLoggedNoRedirect()) {
            header('location: index.php');
        } else {
            $this->view->setTemplate('user' . DS . 'login');
            $this->document->addScript("jquery");
            $this->document->addScript("jquery.backstretch");
            
            $this->document->addScript("jquery.mousewheel-3.0.4.pack");
            $this->document->addScript("jquery.fancybox-1.3.4.pack");
            
            
                  
            $this->document->addCss("jquery.fancybox-1.3.4");
            $this->document->addCss('assets/bootstrap.min');
            $this->document->addCss('assets/font-awesome.min');
            $this->document->addCss('assets/login-soft');
            $this->document->addCss('assets/style');
            $this->document->addCss('assets/style-metro');
            $this->document->addCss('assets/style-responsive');
            $this->document->setHeader();
            $message = null;
            $icon_message = null;
            if (isset($_GET['message'])) {
                if ($_GET['message'] == 'error') {
                    $message = $this->document->t("LOGIN_FAILED");
                    $icon_message = IMAGES . SL . 'iconos_alerta' . SL . 'warning.png';
                }
            }
            $this->view->setVars('message', $message);
            $this->view->setVars('icon_message', $icon_message);
            $this->view->show();
        }
    }

    public function validacion() {        
        $this->getModel("User");
        $this->model->LoginUser();
    }

    public function salir() {
        $this->getModel("User");
        $this->model->LogoutUser();
    }

    private function isLoggedNoRedirect() {
        session_start();
        if (isset($_SESSION['user']) && isset($_SESSION['autentificado']) && isset($_SESSION['certifed'])) {
            $usuario = unserialize($_SESSION['user']);
            if ($_SESSION['autentificado'] == "si" && $_SESSION['certifed'] === str_repeat(strrev(sha1($usuario->getIpUser() . "@pPliccati0N" . date("Y-m-d"))), 6)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>