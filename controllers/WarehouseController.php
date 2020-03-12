<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class WarehouseController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('warehouse' . DS . 'warehouse');
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
        $this->getModel("WareHouse");
        $bodegas = $this->model->getWareHouse();
        $this->view->setVars('bodega', $bodegas);
        $this->view->show();
    }

    public function editwarehouse() {
        $this->view->setTemplate('warehouse' . DS . 'editwarehouse');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("WareHouse");
        $bodega = $this->model->getWareHousebyId();
        $this->getModel("EditProfile");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades($bodega['departamento']);
        $this->getModel("Associated");
        $localidadvin = $this->model->getSelectLocalidades('locvin');
        $barriovin = $this->model->getSelectBarrios($bodega['localidad'], 'barrvin');
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('locvin', $localidadvin);
        $this->view->setVars('barrvin', $barriovin);
        $this->view->setVars('bodega', $bodega);
        $this->view->show();
    }

    public function createwarehouse() {
        $this->view->setTemplate('warehouse' . DS . 'createwarehouse');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("EditProfile");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades(6);
        $this->getModel("Associated");
        $localidadvin = $this->model->getSelectLocalidades('locvin');
        $barriovin = $this->model->getSelectBarrios(0, 'barrvin');
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('locvin', $localidadvin);
        $this->view->setVars('barrvin', $barriovin);
        $this->view->show();
    }

    public function editUsers() {
        $this->view->setTemplate('warehouse' . DS . 'admonwarehouseuser');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("WareHouse");
        $usuarios = $this->model->getUserWareHouse();
        $perfiles = $this->model->getPerfiles();
        $usuariosPerfil = $this->model->getUsuarios($perfiles[0]['id']);
        $warehouse = $_GET['idware'];
        $bodega = $this->model->getWareHousebyId();
        $this->view->setVars('usuariobodega', $usuarios);
        $this->view->setVars('perfiles', $perfiles);
        $this->view->setVars('perfilesUsers', $usuariosPerfil);
        $this->view->setVars('idbodega', $warehouse);
        $this->view->setVars('bodega', $bodega);
        $this->view->show();
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

    public function ajaxUsuarios() {
        $this->getModel("WareHouse");
        $usuarios = $this->model->getUsuarios($_POST['idperfil']);
        echo json_encode($usuarios);
    }

    public function createwarehouses() {
        $this->getModel("WareHouse");
        $this->model->createWareHouse();
    }

    public function createPermission() {
        $this->getModel("WareHouse");
        $this->model->createPermissionWareHouse();
    }

    public function deleteUserWarehouse() {
        $this->getModel("WareHouse");
        $this->model->deletePermissionWareHouse();
    }

    public function updatewarehouse() {
        $this->getModel("WareHouse");
        $this->model->updateWareHouse();
    }

    public function deleteWarehouse() {
        $this->getModel("WareHouse");
        $this->model->deleteWareHouse();
    }

}

?>