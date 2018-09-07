<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ProfileController extends ControllerBase {

    public function main() {
        $this->editprofile();
    }

    public function editprofile() {
        $this->view->setTemplate('editprofile' . DS . 'editprofile'); 
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("insertForm");        
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $usuario = $this->getModel("User");
        $idusuario = $usuario->getUserId();
        $this->getModel("EditProfile");
        $usuarioprofile = $this->model->getUserProfile($idusuario);
        $departamentos = $this->model->getSelectDepartamentos();
        $traerdepto2 = $this->model->traerDepto($usuarioprofile->getCiudad());
        $traerdepto = json_encode($traerdepto2);
        $traerciudad = json_encode($usuarioprofile->getCiudad());
        $ciudades = $this->model->getSelectCiudades($traerdepto2);        
        $message = null;
        $icon_message=null;
        if (isset($_GET['message'])) {
            if ($_GET['message'] == 'ok') {
                $message = $this->document->t("DATA_UPDATED");
                $icon_message = IMAGES.SL.'iconos_alerta'.SL.'ok.png';
            }elseif ($_GET['message'] == 'error') {
                $message = $this->document->t("DATA_FAILED");
                $icon_message = IMAGES.SL.'iconos_alerta'.SL.'error.png';
            }
        }
        $fecha=explode("-", $usuarioprofile->getFechaNacimiento());        
        $ano2=$fecha[0]; 
        $mes2=$fecha[1]-1; 
        $dia2=$fecha[2];
        $fecha = date("Y-m-d", strtotime(date("Y-m-d") . " -18 year"));
        $fechamax = date("Y-m-d", strtotime($fecha . " -1 day"));
        $arrayfecha = explode("-", $fechamax);
        $dia = $arrayfecha[2];
        $mes = $arrayfecha[1] - 1;
        $ano = $arrayfecha[0];
        $this->view->setVars('dia', $dia);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('ano', $ano);
        $this->view->setVars('ano2', $ano2);
        $this->view->setVars('mes2', $mes2);
        $this->view->setVars('dia2', $dia2);
        $this->view->setVars('usuariop', $usuarioprofile);        
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('tdepto', $traerdepto);
        $this->view->setVars('tciu', $traerciudad);
        $this->view->setVars('message', $message);
        $this->view->setVars('icon_message', $icon_message);        
        $this->view->show();
    }

    public function updateprofile() {
        session_start();
        $usuario = $this->getModel("User");
        $idusuario = $usuario->getUserId();
        $this->getModel("EditProfile");
        $this->model->updateProfile($idusuario);
    }

    public function ajaxCiudades() {
        $this->getModel("EditProfile");
        $ciudades = $this->model->getChangeCiudades();
        echo $ciudades;
    }

}

?>
