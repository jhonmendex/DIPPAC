<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class SuppliersController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('suppliers' . DS . 'suppliers');
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
        $this->getModel("Supplier");
        $encompra=isset($_SESSION['cabeceracompra']['idproveedor'])?$_SESSION['cabeceracompra']['idproveedor']:0;
        $terceros = $this->model->getSuppliers();
        $this->view->setVars('tercero', $terceros);
        $this->view->setVars('encompra', $encompra);
        $this->view->show();
    }

    public function editsupplier() {
        $this->view->setTemplate('suppliers' . DS . 'editsupplier');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Supplier"); 
        $tercero = $this->model->getSupplier();
        $this->getModel("EditProfile");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades($tercero['departamento']);
        $this->view->setVars('tercero', $tercero);
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->show();
    }

    public function createsupplier() {
        $this->view->setTemplate('suppliers' . DS . 'createsupplier');                
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("EditProfile");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades(6);
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->show();
    }

    public function createsuppliers() {
        $this->getModel("Supplier");
        $this->model->createSupplier();
    }

    public function ajaxCiudades() {
        $this->getModel("Associated");
        $ciudades = $this->model->getChangeCiudades();
        echo $ciudades;
    }

    public function updatesupplier() {
        $this->getModel("Supplier");
        $tercero = $this->model->updateSupplier();
    }

    public function deleteSupplier() {
        $this->getModel("Supplier");
        $this->model->deleteSupplier();
    }
    
    public function ViewProductos(){
        $this->view->setTemplate('suppliers' . DS . 'productsTosuppliers');        
        $this->document->addScript("jquery.dataTables");        
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Supplier");
        $productsSup = $this->model->getProductosSupplier();
        $proveedor = $this->model->getSupplier();
        $this->view->setVars('productos', $productsSup);
        $this->view->setVars('proveedor', $proveedor);
        $this->view->show();
    }

}

?>