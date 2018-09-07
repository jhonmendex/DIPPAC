<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class NovinculadoController extends ControllerPublic {

    public function main() {
        $this->frmnovinculado();
    } 

    public function frmnovinculado() {
        $this->view->setTemplate('novinculado');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("insertForm");
        $this->document->addCss("style");
        $this->document->setHeader(); //encabezado
        $this->getModel("Associated");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades(6);
        $localidadvin = $this->model->getSelectLocalidades('locvin');
        $barriovin = $this->model->getSelectBarrios(0, 'barrvin');
        $fecha=date("Y-m-d", strtotime(date("Y-m-d")." -18 year"));
        $fechamax=date("Y-m-d", strtotime($fecha." -1 day"));
        $arrayfecha=explode("-",$fechamax);
        $dia=$arrayfecha[2];
        $mes=$arrayfecha[1]-1;
        $ano=$arrayfecha[0]; 
        $this->view->setVars('locvin', $localidadvin);
        $this->view->setVars('barrvin', $barriovin);
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('dia', $dia);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('ano', $ano);
        $this->view->show(0);
    }

    public function frmrecordarpass() {
        $this->view->setTemplate('recordarpass');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("insertForm");
        $this->document->addCss("style");
        $this->document->setHeader(); //encabezado
        $this->view->show(0);
    }

    public function enviarfrm() {
        $this->getModel("NoVinculado");
        if ($this->model->noVinculado()) {
            $respuesta['result'] = "ok";
            $respuesta['mensaje'] = $this->document->t("CORRECT_NO_VINCULATE");
            echo json_encode($respuesta);
        } else {
            $respuesta['result'] = "error";
            $respuesta['mensaje'] = $this->document->t("FAIL_NO_VINCULATE");
            echo json_encode($respuesta);
        }
    }

    public function valUser() {
        $this->getModel("NoVinculado");
        if ($this->model->valAlias()) {
            $respuesta['result'] = "ok";
            $respuesta['mensaje'] = $this->document->t("CORRECT_RECOVERY");
            echo json_encode($respuesta);
        } else {
            $respuesta['result'] = "error";
            $respuesta['mensaje'] = $this->document->t("FAIL_RECOVERY");
            echo json_encode($respuesta);
        }
    }
    
     public function ajaxCiudades() {
        $this->getModel("Associated");
        $ciudades = $this->model->getChangeCiudades();
        echo $ciudades;
    }

    public function ajaxBarrios() {
        $this->getModel("Associated");
        $barrios = $this->model->getChangeBarrios();
        echo $barrios;
    }

}

?>
