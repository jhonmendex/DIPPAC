<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ShoppingController extends ControllerBase {

    public function main() {
        $this->Catalogo();
    }

    public function Catalogo() {
        $this->view->setTemplate('shopping' . DS . 'catalogo');
        $this->document->addCss("style");
        $this->document->addCss("catalogo");
        $this->document->addCss("icomoon/style");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $categ = $this->model->categorias();
        $prod = $this->model->productosByCategoria();
        $links = $this->model->paginacionProductos();
        $selected = $this->model->categoriaSelected();
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        $this->view->setVars('categorias', $categ);
        $this->view->setVars('productos', $prod);
        $this->view->setVars('paginacion', $links);
        $this->view->setVars('categoriaactual', $selected);
        $this->view->setVars('page', $pag);
        $this->view->show();
    }

    public function orden() {
        $this->view->setTemplate('shopping' . DS . 'orden');
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $this->model->agregarItem();
        $detalles = $this->model->traerDetalles();
        $subtotal = $this->model->traerSubtotal();
        $iva = $this->model->traerIva();
        $puntos = $this->model->traerPuntos();
        $categoria = $this->model->traerCategoriaActual();
        $class = 1;
        $pagin = $_GET['paginaact'];
        $this->view->setVars('detail', $detalles);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('puntos', $puntos);
        $this->view->setVars('iva', $iva);
        $this->view->setVars('estilo', $class);
        $this->view->setVars('categoriaA', $categoria);
        $this->view->setVars('page', $pagin);
        $this->view->show();
    }

    public function factura() {
        $this->view->setTemplate('shopping' . DS . 'facturaVenta');
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $detalles = $this->model->traerDetalles();
        $subtotal = $this->model->traerSubtotal();
        $puntos = $this->model->traerPuntos();
        $categoria = $this->model->traerCategoriaActual();
        $iva = $this->model->traerIva();
        $envios = $this->model->getEnvios();
        $class = 1;
        $this->view->setVars('detail', $detalles);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('puntos', $puntos);
        $this->view->setVars('estilo', $class);
        $this->view->setVars('categoriaA', $categoria);
        $this->view->setVars('totaliva', $iva);
        $this->view->setVars('envios', $envios);
        $this->view->show();
    }

    public function delItem() {

        $this->view->setTemplate('shopping' . DS . 'orden');
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $this->model->eliminarItem();
        $detalles = $this->model->traerDetalles();
        $subtotal = $this->model->traerSubtotal();
        $iva = $this->model->traerIva();
        $puntos = $this->model->traerPuntos();
        $categoria = $this->model->traerCategoriaActual();
        $class = 1;
        $eliminado = 'ok';
        $pagin = $_GET['paginaact'];
        $this->view->setVars('detail', $detalles);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('puntos', $puntos);
        $this->view->setVars('estilo', $class);
        $this->view->setVars('categoriaA', $categoria);
        $this->view->setVars('iva', $iva);
        $this->view->setVars('eliminado', $eliminado);
        $this->view->setVars('page', $pagin);
        $this->view->show();
    }

    public function resultado() {
        $this->view->setTemplate('shopping' . DS . 'catalogo');
        $this->document->addCss("style");
        $this->document->addCss("catalogo");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $categ = $this->model->categorias();
        $prod = $this->model->productosByNombre();
        $links = $this->model->paginacionProductosResultado();
        $selected = $this->model->traerCategoriaActual();
        $this->view->setVars('categorias', $categ);
        $this->view->setVars('productos', $prod);
        $this->view->setVars('paginacion', $links);
        $this->view->setVars('categoriaactual', $selected);
        $this->view->show();
    }

    public function cancelar() {
        $this->view->setTemplate('shopping' . DS . 'catalogo');
        $this->document->addCss("catalogo");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $categ = $this->model->eliminarOrden();
        $categ = $this->model->categorias();
        $prod = $this->model->productosByCategoria();
        $links = $this->model->paginacionProductos();
        $selected = $this->model->categoriaSelected();
        $this->view->setVars('categorias', $categ);
        $this->view->setVars('productos', $prod);
        $this->view->setVars('paginacion', $links);
        $this->view->setVars('categoriaactual', $selected);
        $this->view->show();
    }

    public function genFactura() {
        $this->view->setTemplate('shopping' . DS . 'finCompra');
        $this->document->addCss("factura");
        $this->document->setHeader();
        $shopModel = $this->getModel("Shopping");
        $details = $shopModel->traerDetalles();
        $subtotal = $shopModel->traerSubtotal();
        $puntos = $shopModel->traerPuntos();
        $iva = $shopModel->traerIva();
        $mes = $shopModel->getNameCurrentPeriodo();
        $userModel = $this->getModel("User");
        $idUser = $userModel->getUserId();
        $nombreUser = $userModel->getUserName();
        $idfactura = $shopModel->crearFactura($idUser, $details, $subtotal, $puntos, $iva);
        $tipoenvio = $shopModel->getTipoEnvio();
        $imagen = IMAGES . SL . 'bancobogota.gif';
        $clase = 1;
        $this->view->setVars('facturaNum', $idfactura);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('detalles', $details);
        $this->view->setVars('nombreUser', $nombreUser);
        $this->view->setVars('idUser', $idUser);
        $this->view->setVars('iva', $iva);
        $this->view->setVars('puntos', $puntos);
        $this->view->setVars('mes', $mes);
        $this->view->setVars('bogota', $imagen);
        $this->view->setVars('class', $clase);
        $this->view->setVars('tipoenvio', $tipoenvio);
        $this->view->show();
    }

    function itemsVarious() {
        $arr = $_POST['items'];
        $this->getModel("Shopping");
        foreach ($arr as $key => $value) {
            $this->model->agregarItems($key, $value);
        }
    }

    public function reporteVentas() {
        $this->getModel("Shopping");
        $this->model->ShopReport();
    }

    public function edit_item() {
        $this->getModel("Shopping");
        $valor = $_POST['cantidad'];
        $producto = $_POST['id'];
        $this->model->refrescarItem($valor, $producto);
        $detalle = $this->model->traerDetalle($producto);
        $subtotal = $this->model->traerSubtotal();
        $iva = $this->model->traerIva();
        $puntos = $this->model->traerPuntos();
        $totalmostrar = '&#36;' . number_format($subtotal + $iva, 0, ',', '.');
        $totalpuntosmostrar = number_format($puntos, 2, ',', '.');
        $totalnew = '';
        $points = number_format($detalle->getCantidad() * $detalle->getProducto()->getPuntos(), 2, ',', '.');
        if ($detalle->getProducto()->getIva() == 0) {
            $totalnew = '&#36;' . number_format($detalle->getCantidad() *
                            $detalle->getProducto()->getPrecio(), 0, ',', '.');
        } else {
            $totalnew = '&#36;' . number_format($detalle->getCantidad() *
                            ((($detalle->getProducto()->getPrecio() * $detalle->getProducto()->getIva())
                            / 100) + $detalle->getProducto()->getPrecio()), 0, ',', '.');
        }
        $respuesta['result'] = "true";
        $respuesta['points'] = $points;
        $respuesta['totalpoints'] = $totalpuntosmostrar;
        $respuesta['totalitem'] = $totalnew;
        $respuesta['totalShop'] = $totalmostrar;
        echo json_encode($respuesta);
    }

}

?>
