<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ReorganizationController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('reorganization' . DS . 'reorganization');
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("pos");
        $this->document->setHeader();
        $this->getModel("Reorganization");
        $nombrebodega = $this->model->getNombrebodega();
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->show();
    }

    public function reorganizarProducto() {
        $this->view->setTemplate('reorganization' . DS . 'reorganizarProducto');
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Reorganization");
        $categorias = $this->model->categorias();
        $idbodega = $this->model->getUserBodega();
        $idcat;
        if (isset($_GET["idcat"])) {
            $idcat = $_GET["idcat"];
        } else {
            $idcat = $this->model->primeraCategoria();
        }
        $items = $_SESSION['reorganizacionsesion'] ? $_SESSION['reorganizacionsesion'] : null;
        $this->view->setVars('items', $items);
        $detalles = $this->model->getProducts($idcat, $idbodega);
        $this->view->setVars('detalles', $detalles);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->show();
    }

    public function reorganizarProductos() {
        $this->view->setTemplate('reorganization' . DS . 'reorganizarProductos');
        $this->document->addScript("jquery.dataTables");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Reorganization");
        $categorias = $this->model->categorias();
        $idbodega = $this->model->getUserBodega();
        $idcat;
        if (isset($_GET["idcat"])) {
            $idcat = $_GET["idcat"];
        } else {
            $idcat = $this->model->primeraCategoria();
        }
        $items = $_SESSION['reorganizacionsesionps'] ? $_SESSION['reorganizacionsesionps'] : null;
        $this->view->setVars('items', $items);
        $detalles = $this->model->getProducts($idcat, $idbodega);
        $this->view->setVars('detalles', $detalles);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->show();
    }

    public function addNewItem() {
        $this->getModel("Reorganization");
        $this->model->addItemToSession();
    }

    public function addNewItemps() {
        $this->getModel("Reorganization");
        $this->model->addItemToSessionps();
    }

    public function addReorganization() {
        $this->getModel("Reorganization");
        $this->model->addReorgSession();
    }

    public function addReorganizationps() {
        $this->getModel("Reorganization");
        $this->model->addReorgSessionps();
    }

    public function verifyReorganization() {
        $this->view->setTemplate('reorganization' . DS . 'verifyReorganization');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $items = $_SESSION['Reorgsesion'] ? $_SESSION['Reorgsesion'] : null;
        $items2 = $_SESSION['reorganizacionsesion'] ? current($_SESSION['reorganizacionsesion']) : null;
        $items3 = $_SESSION['Reorgsesionps'] ? $_SESSION['Reorgsesionps'] : null;
        $items4 = $_SESSION['reorganizacionsesionps'] ? current($_SESSION['reorganizacionsesionps']) : null;
        $items2["cantidad"] = $_SESSION['cantsesion'];
        $items4["cantidad"] =$_SESSION['cantsesionps'];
        $this->view->setVars('items2', $items2);
        $this->view->setVars('items', $items);
        $this->view->setVars('items3', $items3);
        $this->view->setVars('items4', $items4);
        $this->view->show();
    }

    public function cancelarsesion() {
        $this->getModel("Reorganization");
        $this->model->deleteSession();
    }

    public function cancelarsesionps() {
        $this->getModel("Reorganization");
        $this->model->deleteSessionps();
    }

    public function deleteItem() {
        $this->getModel("Reorganization");
        $this->model->deleteItemToSession();
    }

    public function deleteItemps() {
        $this->getModel("Reorganization");
        $this->model->deleteItemToSessionps();
    }

    public function deleteItemp() {
        $this->getModel("Reorganization");
        $this->model->deleteItemToSessionp();
    }

    public function deleteItempps() {
        $this->getModel("Reorganization");
        $this->model->deleteItemToSessionpps();
    }

    public function guardarCant() {
        $_SESSION['cantsesion'] = $_POST['cajas'];
    }

    public function guardarCantps() {
        $_SESSION['cantsesionps'] = $_POST['cajas'];
    }

    public function finalizarReorganizacionp() {
        $this->getModel("Reorganization");
        $this->model->finalizarReorganizacionp();
    }

    public function finalizarReorganizacionps() {
        $this->getModel("Reorganization");
        $this->model->finalizarReorganizacionps();
    }

    public function verifysession() {
        $cantidadentrada;
        foreach ($_SESSION['Reorgsesion'] as $value) {
            $cantidadentrada+=$value["cantid"];
        }
        $cantidadsalida = $_SESSION['cantsesion'];
        if (sizeof($_SESSION['Reorgsesion'])) {
            if ($cantidadsalida <= $cantidadentrada) {
                echo json_encode(array("res" => "si"));
            } else {
                echo json_encode(array("res" => "no", "error" => "La cantidad de los productos seleccionados es menor a la del producto a reorganizar"));
            }
        } else {
            echo json_encode(array("res" => "no", "error" => "No hay productos para hacer la reorganizaci&oacute;n"));
        }
    }
    
    public function verifysessionps() {
        $cantidadsalida;
        foreach ($_SESSION['Reorgsesionps'] as $value) {
            $cantidadsalida+=$value["cantid"];
        }
        $cantidadentrada = $_SESSION['cantsesionps'];
        if (sizeof($_SESSION['Reorgsesionps'])) {
            if ($cantidadentrada <= $cantidadsalida) {
                echo json_encode(array("res" => "si"));
            } else {
                echo json_encode(array("res" => "no", "error" => "La cantidad del producto seleccionado es mayor a la de los productos a reorganizar"));
            }
        } else {
            echo json_encode(array("res" => "no", "error" => "Debe seleccionar por lo menos un producto para reorganizar"));
        }
    }

}

?>
