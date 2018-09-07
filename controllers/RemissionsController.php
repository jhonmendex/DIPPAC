<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class RemissionsController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('Remissions' . DS . 'AllRemissions');
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
        $this->getModel("Remissions");
        $remisionbodega = $this->model->getRemissionsWarehouse();
        $nombrebodega = $this->model->getNombreBodega();
        $cantidadbodegas = $this->model->getCantidadBodegas();  
        $detailsremissions = $this->model->getDetailsRemissions($idremision);
        $mensaje = isset($_GET["mensaje"])?$_GET["mensaje"]:"";
        $this->view->setVars('mensaje', $mensaje);
        $this->view->setVars('cantidadbodegas', $cantidadbodegas);
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('remisionbodega', $remisionbodega);
        $this->view->show();
    }

    public function inizialiteRemision() {
        $this->view->setTemplate('Remissions' . DS . 'remissions');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript('expandirdivs' . SL . 'jquery.collapse');
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss('expandirdivs' . SL . 'demo');
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Remissions");
        $categorias = $this->model->categorias();
        $grupoperfil = $this->model->getUserProfile();
        if (isset($_GET["bodorigen"]) && isset($_GET["idcat"])) {
            $idbodega = $_GET["bodorigen"];
            $idcat = $_GET["idcat"];
        } else {
            $idbodega = $this->model->getUserBodega();
            $idcat = $this->model->primeraCategoria();
        }
        if (isset($_GET["boddes"])) {
            $idbodegades = $_GET["boddes"];
        }
        $mensaje = isset($_GET["mensaje"])?$_GET["mensaje"]:"";
        $this->view->setVars('mensaje', $mensaje);
        $bodegaslocal = $this->model->getWareHouseLocal();
        $detalles = $this->model->getProducts($idcat, $idbodega);
        $this->view->setVars('detalles', $detalles);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->setVars('grupoperfil', $grupoperfil);
        $usuario = $this->model->getUsuarios();
        $this->view->setVars('usuario', $usuario);
        $bodegas = $this->model->getWareHouse();
        $this->view->setVars('bodegas', $bodegas);
        $this->view->setVars('bodegaslocal', $bodegaslocal);
        $this->view->setVars('idbodega', $idbodega);
        $this->view->setVars('idbodegades', $idbodegades);
        if (isset($_SESSION['remision'])) {
            $remisiones = $this->model->getRemissionsSesion($idbodega);
            $this->view->setVars('remisiones', $remisiones);
        }if (isset($_SESSION['cajasesion'])) {
            $cajas = $_SESSION['cajasesion'];
            $this->view->setVars('cajas', $cajas);
        }
        $this->view->show();
    }

    public function agregarItem() {
        if (isset($_SESSION['remision'][$_POST['idproducto']])) {
            echo json_encode(array('respuesta' => 'sisi'));
            $_SESSION['remision'][$_POST['idproducto']] = $_POST['cantidad'];
        } else {
            $_SESSION['remision'][$_POST['idproducto']] = $_POST['cantidad'];
            $idbodega = $_GET["bodorigen"];
            $this->getModel("Remissions");
            $this->model->getRemissions($_POST['idproducto'], $_POST['cantidad'], $idbodega);
        }
    }

    public function eliminardetalle() {
        $idproducto = $_POST['producto'];
        unset($_SESSION['remision'][$_POST['producto']]);
        $respuesta['res'] = 'si';
        $respuesta['idrow'] = $idproducto;
        echo json_encode($respuesta);
    }

    public function cancelarsesion() {
        unset($_SESSION['remision']);
        unset($_SESSION['cajasesion']);
        echo json_encode(array('respuesta' => 'ok'));
    }

    public function confirmarRemision() {
        //$bodegaorigen = $_GET["bodorigen"];
        $bodegadestino = $_GET["boddestino"];
        //$cajas = $_GET["cajas"];
        //$usuariodestino = $_GET["usuario"];
        $this->getModel("Remissions");
        $this->model->remissionRegister($bodegadestino);
    }

    public function getDetailsRemissions() {
        $this->view->setTemplate('Remissions' . DS . 'detailsRemissions');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Remissions");
        $idremision = $_GET["idremission"];
        $detailsremissions = $this->model->getDetailsRemissions($idremision);
        $mensaje = isset($_GET["mensaje"])?$_GET["mensaje"]:"";
        $this->view->setVars('mensaje', $mensaje);
        $this->view->setVars('detailsremissions', $detailsremissions);
        $this->view->setVars('idremision', $idremision);
        $this->view->show();
    }

    public function aceptarRemision() {
        $this->getModel("Remissions");
        $idremision = $_GET["idremision"];
        $this->model->aceptRemission($idremision);
    }

    public function validarRemision() {
        $this->getModel("Remissions");
        $this->model->validateRemission();
    }

    public function guardarcajas() {
        $_SESSION['cajasesion'] = $_POST['cajas'];
    }

    public function rechazarRemision() {
        $this->getModel("Remissions");
        $idremision = $_GET["idremision"];
        $this->model->rejectRemission($idremision);
    }

}

?>
  
