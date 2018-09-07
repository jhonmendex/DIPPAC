<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class PosController extends ControllerBase {

    public function main() {
        unset($_SESSION['ventapos']);
        $this->caja();
    }

    public function caja() {
        $this->view->setTemplate('pos' . DS . 'caja');
        $this->document->addScript("jquery.mousewheel-3.0.4.pack");
        $this->document->addScript("jquery.fancybox-1.3.4.pack");              
        $this->document->addCss("jquery.fancybox-1.3.4");
        $this->document->addScript("jquery.autocomplete");
        $this->document->addCss("pos");
        $this->document->addCss("jquery.autocomplete");
        $this->document->setHeader();
        $_SESSION['clienteventa']=null;        
        $_SESSION['clienteventacedula']=null; 
        $_SESSION['clienteventanombre']=null; 
        unset($_SESSION['clienteventa']);        
        unset($_SESSION['clienteventacedula']); 
        unset($_SESSION['clienteventanombre']); 
        $this->view->show();
    }

    public function getProductsByName() {
        $this->getModel("Pos");
        $this->model->getProductsByName();
    }

    public function deleteitemcesta() {
        unset($_SESSION['ventapos'][$_POST['id']]);
    }

    public function isertItem() {
        $this->getModel("Pos");
        $producto = $this->model->getProduct(trim($_POST['buscador']));
        if ($producto) {
            if (isset($_SESSION['ventapos'][$producto['id']])) {
                $_SESSION['ventapos'][$producto['id']]['nuevo'] = 'no';
                if ($producto['unidad'] == 'und') {
                    $_SESSION['ventapos'][$producto['id']]['cantidad'] = $_SESSION['ventapos'][$producto['id']]['cantidad'] + 1;
                    $_SESSION['ventapos'][$producto['id']]['subtotal'] = $_SESSION['ventapos'][$producto['id']]['cantidad'] * $producto['precio'];
                    $_SESSION['ventapos'][$producto['id']]['total'] = $producto['iva'] != 0 ? ($producto['precio'] + (($producto['precio'] * $producto['iva']) / 100)) * $_SESSION['ventapos'][$producto['id']]['cantidad'] : $producto['precio'] * $_SESSION['ventapos'][$producto['id']]['cantidad'];
                    $_SESSION['ventapos'][$producto['id']]['subtotalformato'] = number_format($_SESSION['ventapos'][$producto['id']]['subtotal'], 0, ",", ".");
                    $_SESSION['ventapos'][$producto['id']]['totalformato'] = number_format($_SESSION['ventapos'][$producto['id']]['total'], 0, ",", ".");
                } else {
                    $_SESSION['ventapos'][$producto['id']]['cantidad'] = null;
                    $_SESSION['ventapos'][$producto['id']]['total'] = null;
                    $_SESSION['ventapos'][$producto['id']]['subtotal'] = null;
                    $_SESSION['ventapos'][$producto['id']]['subtotalformato'] = null;
                    $_SESSION['ventapos'][$producto['id']]['totalformato'] = null;
                }
                echo json_encode($_SESSION['ventapos'][$producto['id']]);
            } else {
                unset($_SESSION['ventapos'][$producto['id']]['nuevo']);
                $_SESSION['ventapos'][$producto['id']] = $producto;
                if ($producto['unidad'] == 'und') {
                    $_SESSION['ventapos'][$producto['id']]['cantidad'] = 1;
                    $_SESSION['ventapos'][$producto['id']]['subtotal'] = 1 * $producto['precio'];
                    $_SESSION['ventapos'][$producto['id']]['total'] = $producto['iva'] != 0 ? ($producto['precio'] + (($producto['precio'] * $producto['iva']) / 100)) * 1 : $producto['precio'] * 1;
                    $_SESSION['ventapos'][$producto['id']]['subtotalformato'] = number_format($_SESSION['ventapos'][$producto['id']]['subtotal'], 0, ",", ".");
                    $_SESSION['ventapos'][$producto['id']]['totalformato'] = number_format($_SESSION['ventapos'][$producto['id']]['total'], 0, ",", ".");
                } else {
                    $_SESSION['ventapos'][$producto['id']]['cantidad'] = null;
                    $_SESSION['ventapos'][$producto['id']]['total'] = null;
                    $_SESSION['ventapos'][$producto['id']]['subtotal'] = null;
                    $_SESSION['ventapos'][$producto['id']]['subtotalformato'] = null;
                    $_SESSION['ventapos'][$producto['id']]['totalformato'] = null;
                }
                echo json_encode($_SESSION['ventapos'][$producto['id']]);
            }
        } else {
            echo json_encode(array("error" => "error"));
        }
    }

    public function getTotalAjax() {
        $totalarticulos = 0;
        $totalprecio = 0;
        $subtotalprecio = 0;
        if (isset($_SESSION['ventapos'])) {
            foreach ($_SESSION['ventapos'] as $value) {
                $totalprecio+=$value['total'];
                $subtotalprecio+=$value['subtotal'];
                $totalarticulos++;
            }
        }
        $total = number_format($totalprecio, 0, ",", ".");
        $subtotal = number_format($subtotalprecio, 0, ",", ".");
        $respuesta['total'] = $totalprecio;
        $respuesta['subtotal'] = $subtotalprecio;
        $respuesta['totalformato'] = $total;
        $respuesta['subtotalformato'] = $subtotal;
        $respuesta['articulos'] = $totalarticulos;
        echo json_encode($respuesta);
    }

    public function actualizarCantidadAjax() {
        if ($_POST['cantidad']) {
            $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] = trim($_POST['cantidad']);
            $_SESSION['ventapos'][$_POST['idpro']]['subtotal'] = $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] * $_SESSION['ventapos'][$_POST['idpro']]['precio'];
            $_SESSION['ventapos'][$_POST['idpro']]['total'] = $_SESSION['ventapos'][$_POST['idpro']]['iva'] != 0 ? ($_SESSION['ventapos'][$_POST['idpro']]['precio'] + (($_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['iva']) / 100)) * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] : $_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'];
            $_SESSION['ventapos'][$_POST['idpro']]['subtotalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['subtotal'], 0, ",", ".");
            $_SESSION['ventapos'][$_POST['idpro']]['totalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['total'], 0, ",", ".");
        } else {
            $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] = 0;
            $_SESSION['ventapos'][$_POST['idpro']]['subtotal'] = $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] * $_SESSION['ventapos'][$_POST['idpro']]['precio'];
            $_SESSION['ventapos'][$_POST['idpro']]['total'] = $_SESSION['ventapos'][$_POST['idpro']]['iva'] != 0 ? ($_SESSION['ventapos'][$_POST['idpro']]['precio'] + (($_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['iva']) / 100)) * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] : $_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'];
            $_SESSION['ventapos'][$_POST['idpro']]['subtotalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['subtotal'], 0, ",", ".");
            $_SESSION['ventapos'][$_POST['idpro']]['totalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['total'], 0, ",", ".");
        }
        echo json_encode($_SESSION['ventapos'][$_POST['idpro']]);
    }

    public function actualizarCantidadtwoAjax() {
        if ($_POST['cantidad']) {
            $cantidad = str_replace(",", ".", number_format(trim($_POST['cantidad']), 3,".",""));
            $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] = $cantidad;
            $totaltmp = $_SESSION['ventapos'][$_POST['idpro']]['iva'] != 0 ? ($_SESSION['ventapos'][$_POST['idpro']]['precio'] + (($_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['iva']) / 100)) * $cantidad : $_SESSION['ventapos'][$_POST['idpro']]['precio'] * $cantidad;
            $_SESSION['ventapos'][$_POST['idpro']]['total'] = ceil(number_format($totaltmp, 0,"","") / 50) * 50;
            $_SESSION['ventapos'][$_POST['idpro']]['subtotal'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['total'] / (($_SESSION['ventapos'][$_POST['idpro']]['iva'] / 100) + 1), 0,"","");
            $_SESSION['ventapos'][$_POST['idpro']]['subtotalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['subtotal'], 0, ",", ".");
            $_SESSION['ventapos'][$_POST['idpro']]['totalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['total'], 0, ",", ".");
        } else {
            $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] = 0;
            $_SESSION['ventapos'][$_POST['idpro']]['subtotal'] = $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] * $_SESSION['ventapos'][$_POST['idpro']]['precio'];
            $_SESSION['ventapos'][$_POST['idpro']]['total'] = $_SESSION['ventapos'][$_POST['idpro']]['iva'] != 0 ? ($_SESSION['ventapos'][$_POST['idpro']]['precio'] + (($_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['iva']) / 100)) * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'] : $_SESSION['ventapos'][$_POST['idpro']]['precio'] * $_SESSION['ventapos'][$_POST['idpro']]['cantidad'];
            $_SESSION['ventapos'][$_POST['idpro']]['subtotalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['subtotal'], 0, ",", ".");
            $_SESSION['ventapos'][$_POST['idpro']]['totalformato'] = number_format($_SESSION['ventapos'][$_POST['idpro']]['total'], 0, ",", ".");
        }
        echo json_encode($_SESSION['ventapos'][$_POST['idpro']]);
    }
    
    public function framefinal(){
        $this->view->setTemplate('pos' . DS . 'preventa');
        $this->document->addCss("pos");        
        $this->document->setHeader();
        $this->view->show();
    }

    public function pagoCaja() {
        $this->view->setTemplate('pos' . DS . 'pagocaja');         
        $this->document->addCss("pos");
        $this->document->addCss("print","print");
        $this->document->setHeader();
        $this->getModel('User');
        $cajero=$this->model->getUserName();       
        $total = $this->getTotalCaja();  
        if(isset ($_SESSION['clienteventa'])){
            $cliente["nombre"]=$_SESSION['clienteventanombre'];
            $cliente["codigo"]=$_SESSION['clienteventa'];
            $cliente["cedula"]=$_SESSION['clienteventacedula'];
        }else{
            $cliente=false;
        }
        
        $this->view->setVars('cliente', $cliente);
        $this->view->setVars('total', $total['totalformato']);
        $this->view->setVars('subtotal', $total['subtotalformato']);
        $this->view->setVars('items', $_SESSION['ventapos']);
        $this->view->setVars('cajero', $cajero);
        $this->view->setVars('iva10', $this->getgravado(10));
        $this->view->setVars('iva16', $this->getgravado(16));
        $this->view->setVars('iva0', $this->getgravado(0));
        $this->view->setVars('efectivo', $_GET['efectivo']);
        $this->view->setVars('cambio',number_format($_GET['cambio'],0,",","."));
        $this->view->show();
    }
    
    public function getClientes(){
        $this->view->setTemplate('pos' . DS . 'getClientList');  
        $this->document->addScript("jquery.dataTables");
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->addCss("demo_page");
        $this->document->addCss("demo_table");
        $this->document->setHeader();
        $this->getModel('Pos');
        $clientes=$this->model->getClientes();                        
        $this->view->setVars('clientes', $clientes);
        $this->view->show();
    }
    
    public function AddToPos(){
        $_SESSION['clienteventa']=$_POST['id_cliente'];        
        $_SESSION['clienteventacedula']=$_POST['cedula_cliente'];
        $_SESSION['clienteventanombre']=$_POST['nombre_cliente'];
        
        echo json_encode(array("nombre"=>$_POST['nombre_cliente'],"id"=>$_POST['id_cliente']));
    }
    
    private function getTotalCaja() {
        $totalarticulos = 0;
        $totalprecio = 0;
        $subtotalprecio = 0;
        if (isset($_SESSION['ventapos'])) {
            foreach ($_SESSION['ventapos'] as $value) {
                $totalprecio+=$value['total'];
                $subtotalprecio+=$value['subtotal'];
                $totalarticulos++;
            }
        }
        $total = number_format($totalprecio, 0, ",", ".");
        $subtotal = number_format($subtotalprecio, 0, ",", ".");
        $respuesta['total'] = $totalprecio;        
        $respuesta['totalformato'] = $total;  
        $respuesta['subtotal'] = $subtotalprecio;        
        $respuesta['subtotalformato'] = $subtotal; 
        return $respuesta;
    }

    public function getCambio() {
        $total= $this->getTotalCaja();
        $cambio['cambio']=($_POST['efectivo']-$total['total'])<0?0:$_POST['efectivo']-$total['total'];
        $cambio['cambioformato']=number_format($cambio['cambio'],0,",",".");
        $cambio['efectivoformato']=number_format($_POST['efectivo'],0,",",".");
        echo json_encode($cambio);
    }
    
    private function getgravado($iva){
        $totaliva=0;
        $totalbase=0;
        if (isset($_SESSION['ventapos'])) {
            foreach ($_SESSION['ventapos'] as $value) {
                if($value['iva']==$iva){ 
                   $totaliva=$totaliva+($value['total']-$value['subtotal']);
                   $totalbase=$totalbase+$value['subtotal'];
                }            
            }
        }
        return array('iva'=>$totaliva,'base'=>$totalbase);        
    }
    
    public function finishall(){
        $this->getModel("Pos");
        $this->model->finishShop();
        unset($_SESSION['ventapos']);
    }

}

?>
