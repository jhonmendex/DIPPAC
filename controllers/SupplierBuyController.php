<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class SupplierBuyController extends ControllerBase {

    public function main() {
        $this->allBuysSupplier();
    }            

    public function inizialiteBuy() {
        $this->view->setTemplate('supplierbuy' . DS . 'supplierbuy');
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
        if(isset($_GET["option"])&&$_GET["option"]=="new"){
            unset($_SESSION['facturacompra']);
            unset($_SESSION['cabeceracompra']);
            unset($_SESSION['subtotalcompra']);
            unset($_SESSION['precioivacompra']);
            unset($_SESSION['totalproveedor']);
        }
        $compras = null;
        $nit = null;
        $idsup = null;
        $nomsup = null;
        $nofact = null;
        $subtotalfactcom = 0.0;
        $ivafactcom = 0.0;
        $totalllcom = 0.0;
        if (isset($_SESSION['facturacompra'])) {
            $compras = $_SESSION['facturacompra'];
        }
        if (isset($_SESSION['cabeceracompra'])) {
            if (isset($_SESSION['cabeceracompra']['nitproveedor'])) {
                $nit = $_SESSION['cabeceracompra']['nitproveedor'];
                $idsup = $_SESSION['cabeceracompra']['idproveedor'];
                $nomsup = $_SESSION['cabeceracompra']['nombreproveedor'];
            }
            if (isset($_SESSION['cabeceracompra']['NumeroFact'])) {
                $nofact = $_SESSION['cabeceracompra']['NumeroFact'];
            }
        }
        if (isset($_SESSION['subtotalcompra'])) {
            $subtotalfactcom = $_SESSION['subtotalcompra'];
        }
        if (isset($_SESSION['precioivacompra'])) {
            $ivafactcom = $_SESSION['precioivacompra'];
        }

        if (isset($_SESSION['totalproveedor'])) {
            $totalllcom = $_SESSION['totalproveedor'];
        }
        $facturafechadate = $_SESSION['cabeceracompra']['FechaFact'] != null ? $_SESSION['cabeceracompra']['FechaFact'] : null;
        $this->view->setVars('compras', $compras);
        $this->view->setVars('facturafechadate', $facturafechadate);
        $this->view->setVars('nit', $nit);
        $this->view->setVars('nomsup', $nomsup);
        $this->view->setVars('idsup', $idsup);
        $this->view->setVars('nofact', $nofact);
        $this->view->setVars('ivafactcom', $ivafactcom);
        $this->view->setVars('subtotalfactcom', $subtotalfactcom);
        $this->view->setVars('totalllcom', $totalllcom);
        $this->view->show();
    }

    public function getProvedoresList() {
        $this->view->setTemplate('supplierbuy' . DS . 'getProvedoresList');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel("Supplier");
        $proveedores = $this->model->getSuppliers();
        $this->view->setVars('proveedores', $proveedores);
        $this->view->show();
    }

    public function verifySupplier() {
        $this->view->setTemplate('supplierbuy' . DS . 'verifySupplier');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->view->show();
    }

    public function verifyExistSupplier() {
        $this->getModel('SupplierBuy');
        $this->model->getSupplier();
    }

    public function createSupplier() {
        $this->view->setTemplate('supplierbuy' . DS . 'createsupplier');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $nit = $_GET['nit'];
        $this->getModel("EditProfile");
        $departamentos = $this->model->getSelectDepartamentos();
        $ciudades = $this->model->getSelectCiudades(6);
        $this->view->setVars('deps', $departamentos);
        $this->view->setVars('cids', $ciudades);
        $this->view->setVars('nit', $nit);
        $this->view->show();
    }

    public function insertsupplier() {
        $this->getModel('SupplierBuy');
        $this->model->newSupplier();
    }

    public function addDetail() {
        $this->view->setTemplate('supplierbuy' . DS . 'verifyProduct');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->view->show();
    }

    public function verifyExistProducto() {
        $this->getModel('SupplierBuy');
        $this->model->getProducto();
    }

    public function createProduct() {
        $this->view->setTemplate('supplierbuy' . DS . 'createproduct');
        $this->document->addScript("jquery.fancybox-1.3.4.pack");
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("ImageOverlay");
        $this->document->setHeader();
        $this->getModel("SupplierBuy");
        $categorias = $this->model->categorias();
        $primeraCategoria = $this->model->primeraCategoria();
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('referencia', $_GET["ref"]);
        $this->view->setVars('selected', $primeraCategoria);
        $this->view->show();
    }

    public function insertProduct() {
        $this->getModel("SupplierBuy");
        $this->model->crearProducto();
    }

    public function ajaxtotal() {
        $cant = str_replace(",", ".", $_POST['cantidad']);
        $cost = str_replace(",", ".", $_POST['costo']);
        $idpro = $_POST['idpro'];
        $iva = $_SESSION['facturacompra'][$idpro]['iva'];

        $_SESSION['facturacompra'][$idpro]['cantidad'] = $cant;
        $_SESSION['facturacompra'][$idpro]['costo'] = $cost;
        $_SESSION['facturacompra'][$idpro]['costoiva'] = (($cost * $iva) / 100) + $cost;

        $subtotalfactcom = 0;
        $ivafactcom = 0;
        foreach ($_SESSION['facturacompra'] as $value) {
            $ivatemporal = (($value['costoiva'] - $value['costo']) * $value['cantidad']);
            $subtotalfactcom+= ($value['costo'] * $value['cantidad']);
            $ivafactcom+=$ivatemporal;
        }

        $_SESSION['subtotalcompra'] = number_format($subtotalfactcom, 0, ',', '.');
        $_SESSION['precioivacompra'] = number_format($ivafactcom, 0, ',', '.');
        $_SESSION['totalproveedor'] = number_format($subtotalfactcom + $ivafactcom, 0, ',', '.');

        $respuesta['respuesta2'] = number_format((($cost * $iva) / 100) + $cost, 0, ',', '.');
        $respuesta['respuesta'] = number_format(((($cost * $iva) / 100) + $cost) * $cant, 0, ',', '.');
        $respuesta['respuesta3'] = number_format($subtotalfactcom + $ivafactcom, 0, ',', '.');
        $respuesta['respuesta4'] = number_format($subtotalfactcom, 0, ',', '.');
        $respuesta['respuesta5'] = number_format($ivafactcom, 0, ',', '.');
        echo json_encode($respuesta);
    }

    public function deleteItemShop() {
        $this->getModel("SupplierBuy");
        $this->model->deleteItemshop();
    }

    public function ajaxsessFactura() {
        $_SESSION['cabeceracompra']['NumeroFact'] = $_POST['NumeroFact'];
    }

    public function ajaxFechaFact() {
        $fecha = $_POST['fecha'];
        if (strtotime(date('Y-m-d')) < strtotime($fecha)) {
            $_SESSION['cabeceracompra']['FechaFact'] = null;
            $respuesta['respuesta'] = 'no';
            echo json_encode($respuesta);
        } else if (strtotime($fecha) < strtotime('-1 year')) {
            $_SESSION['cabeceracompra']['FechaFact'] = null;
            $respuesta['respuesta'] = 'nono';
            echo json_encode($respuesta);
        } else {
            $_SESSION['cabeceracompra']['FechaFact'] = $fecha;
            $respuesta['respuesta'] = 'si';
            echo json_encode($respuesta);
        }
    }

    public function ajaxFecha() {
        $fecha = $_POST['fecha'];
        $idpro = $_POST['idpro'];
        if (strtotime(date('Y-m-d')) < strtotime($fecha)) {
            $_SESSION['facturacompra'][$idpro]['fechavence'] = $fecha;
            $respuesta['respuesta'] = 'si';
            echo json_encode($respuesta);
        } else {
            $_SESSION['facturacompra'][$idpro]['fechavence'] = null;
            $respuesta['respuesta'] = 'no';
            echo json_encode($respuesta);
        }
    }

    public function finishbuy() {
        $this->getModel("SupplierBuy");
        $this->model->finishBuy();
    }

    public function allBuysSupplier() {
        $this->view->setTemplate('supplierbuy' . DS . 'AllSupplierBuy');
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
        $this->getModel("SupplierBuy");
        $compras = $this->model->getAllBoughtsSupplier();
        $messs = null;
        $continue = false;
        if (isset($_GET['messageok'])) {
            $messs = 'mensajeok';
        }
        if (isset($_SESSION['facturacompra']) || isset($_SESSION['cabeceracompra'])) {
           $continue = true;
        } 
        $nombrebodega = $this->model->getNombrebodega();
        $this->view->setVars('nombrebodega', $nombrebodega);
        $this->view->setVars('mensajito', $messs);
        $this->view->setVars('compras', $compras);
        $this->view->setVars('continue', $continue);
        $this->view->show();
    }

    public function Cancelbuy() {
        unset($_SESSION['facturacompra']);
        unset($_SESSION['cabeceracompra']);
        unset($_SESSION['subtotalcompra']);
        unset($_SESSION['precioivacompra']);
        unset($_SESSION['totalproveedor']);
        echo json_encode(array('respuesta' => 'ok'));
    }

    public function getdetailsdocSupplierbuy() {
        $this->view->setTemplate('supplierbuy' . DS . 'detailsDoc');
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $iddocument = $_GET['iddoc'];
        $this->getModel("SupplierBuy");
        unset($_SESSION['devolucionc']);
        unset($_SESSION['devolucioncosto']);
        $docinfo = $this->model->getdocumentByid($iddocument);
        $itemsdoc = $this->model->getdetailsBoughtsup($iddocument);
        $estilo = 1;
        $this->view->setVars('docinfo', $docinfo);
        $this->view->setVars('detallesdoc', $itemsdoc);
        $this->view->setVars('estilo', $estilo);
        $this->view->show();
    }

    public function cancelarsesion() {
        unset($_SESSION['devolucionc']);
        unset($_SESSION['devolucioncosto']);
    }

    public function registrarDevolucion() {
        $_SESSION['devolucionc'][$_POST['idproducto']] = $_POST['cantidad'];
        $_SESSION['devolucioncosto'][$_POST['idproducto']] = $_POST['costo'];
    }

    public function eliminardetalle() {
        unset($_SESSION['devolucionc'][$_POST['detalleventa']]);
        unset($_SESSION['devolucioncosto'][$_POST['detalleventa']]);
    }

    public function finalizarDevolucion() {
        $this->getModel("SupplierBuy");
        $codigo = $_GET["iddocumento"];
        $tercero = $_GET["tercero"];
        $this->model->registrarDevolucion($codigo, $tercero);
    }

}

?>
