<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ProductsController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('products' . DS . 'manager');
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
        $this->getModel("Product");
        $categorias = $this->model->categorias();
        if (isset($_POST['idcat'])) {
            $idcat = $_POST['idcat'];
        } else {
            if (isset($_GET['idcat'])) {
                $idcat = $_GET['idcat'];
            } else {
                $idcat = $this->model->primeraCategoria();
            }
        }
        $perfilgrupe = $this->model->getPerfilGrupe();
        if ($idcat) {
            if ($perfilgrupe == "Superadministrador") {
                $productos = $this->model->getProducts($idcat, false);
            } else {
                $productos = $this->model->getProducts($idcat, true);
            }
        } else {
            $productos = array();
            $idcat = 9999999;
        }        
        $nombrebodega = $perfilgrupe != "Superadministrador"?$this->model->getNombrebodega():null;
        $create = isset($_GET["create"]) ? $_GET["create"] : false;
        $this->view->setVars('productos', $productos);
        $this->view->setVars('create', $create);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('categoriaselected', $idcat);
        $this->view->setVars('perfilgrupe', $perfilgrupe);
        $this->view->show();
    }

    public function crearproducto() {
        $this->view->setTemplate('products' . DS . 'crearproducto');
        $this->document->addScript("jquery-ui.min");
        $this->document->addScript("jquery_002");
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("ImageOverlay");
        $this->document->setHeader();
        $this->getModel("Product");
        $categorias = $this->model->categorias();
        $idcategoria = $_GET["idcat"];
        $perfilgrupe = $this->model->getPerfilGrupe();
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('perfilgrupe', $perfilgrupe);
        $this->view->setVars('selected', $idcategoria);
        $this->view->show();
    }

    public function editarproducto() {
        $this->view->setTemplate('products' . DS . 'editarproducto');
        $this->document->addScript("jquery-ui.min");
        $this->document->addScript("jquery_002");
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("ImageOverlay");
        $this->document->setHeader();
        $this->getModel("Product");
        $categorias = $this->model->categorias();
        $primeraCategoria = $this->model->primeraCategoria();
        $producto = $this->model->getProduct($_GET['idpro']);
        $perfilgrupe = $this->model->getPerfilGrupe();        
        $this->view->setVars('producto', $producto);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('perfilgrupe', $perfilgrupe);
        $this->view->setVars('selected', $primeraCategoria);
        $this->view->show();
    }

    public function createCategory() {
        $this->view->setTemplate('products' . DS . 'crearCategoria');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->view->show();
    }

    public function imageManager() {
        $this->view->setTemplate('products' . DS . 'manageImage');
        $this->document->addCss("stylesdropdrag");
        $this->document->addCss("jquery.si");
        $this->document->addScript("jquery.filedrop");
        $this->document->addScript("script");
        $this->document->addScript("jquery.si");
        $this->document->setHeader();
        $this->view->show();
    }

    public function subirimagenAjax() {
        $this->getModel("Product");
        $this->model->uploadPicture();
    }

    public function subirimagen() {
        $this->view->setTemplate('products' . DS . 'manageImage');
        $this->document->setHeader();
        $this->getModel("Product");
        $this->model->uploadPicture();
    }

    public function insertProduct() {
        $this->getModel("Product");
        $this->model->crearProducto();
    }

    public function viewProveedores() {
        $this->view->setTemplate('products' . DS . 'suppliersToProducts');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Product");
        $proveedores = $this->model->getProveedoresProducto();
        $this->view->setVars('proveedores', $proveedores);
        $this->view->show();
    }

    public function updateProduct() {
        $this->getModel("Product");
        $this->model->updateProduct();
    }

    public function adminCategorys() {
        $this->view->setTemplate('products' . DS . 'managerCats');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Product");
        $categorias = $this->model->getCategoriasComplete();
        $this->view->setVars('categorias', $categorias);
        $this->view->show();
    }

    public function deleteCat() {
        $this->getModel("Product");
        $this->model->deleteCategoria();
    }

    public function newCategory() {
        $this->view->setTemplate('products' . DS . 'newCategoria');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->view->show();
    }

    public function editarCat() {
        $this->view->setTemplate('products' . DS . 'updateCategorias');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Product");
        $idcategoria = $_GET["idcat"];
        $nombrecategoria = $this->model->getNameCatByName($idcategoria);
        $this->view->setVars('idcategoria', $idcategoria);
        $this->view->setVars('nombrecategoria', $nombrecategoria);
        $this->view->show();
    }

    public function insertTwoCategoria() {
        $this->getModel("Product");
        $this->model->insertCategoryAjax();
    }

    public function updateCategoryAjax() {
        $this->getModel("Product");
        $this->model->updateCategoryAjax();
    }

    public function disablePro() {
        $this->getModel("Product");
        $this->model->disablePro();
    }

    public function enablePro() {
        $this->getModel("Product");
        $this->model->enablePro();
    }

}

?>
