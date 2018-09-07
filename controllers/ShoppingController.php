<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ShoppingController extends ControllerBase {

    public function main() {
        $this->Catalogo();
    }

    public function Catalogo() {
        $this->view->setTemplate('shopping' . DS . 'catalogo');
        $this->document->addScript("jquery.jscroll.min");        
        $this->document->addCss("scroll/style");
        $this->document->addCss("catalogo");
        $this->document->addCss("icomoon/style");
        $this->document->setHeader();
        $this->getModel("Shopping");
        $categ = $this->model->categorias();
        if (isset($_POST['nomProducto']) || isset($_GET['nomProducto']) || isset($_SESSION["filtro"])) {
            if ((isset($_POST["nomProducto"])) && ($_POST["nomProducto"] == "<nombre del producto>" || $_POST["nomProducto"] == "")) {
                $categoria = isset($_GET['cat']) ? $_GET['cat'] : ((isset($_SESSION["categoria"])) ? $_SESSION["categoria"] : "TODAS");
                $order = isset($_GET['order']) ? $_GET['order'] : ((isset($_SESSION["orden"])) ? $_SESSION["orden"] : "nombreasc");
                $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
                $productos = $this->model->productosByCategoria($categoria, $order, $pag);
                $link = $this->model->paginacionProductos($categoria, $order, $pag);
                if ($link[0] == $pag) {
                    $next = false;
                } else {
                    $next = $pag + 1;
                }
                $_SESSION["categoria"] = $categoria;
                $_SESSION["orden"] = $order;
                unset($_SESSION["filtro"]);
                $filtro = false;
            } else if (isset($_SESSION["filtro"]) && !isset($_GET['nomProducto'])&& !isset($_POST['nomProducto'])) {
                $categoria = isset($_GET['cat']) ? $_GET['cat'] : ((isset($_SESSION["categoria"])) ? $_SESSION["categoria"] : "TODAS");
                $order = isset($_GET['order']) ? $_GET['order'] : ((isset($_SESSION["orden"])) ? $_SESSION["orden"] : "nombreasc");
                $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
                $productos = $this->model->productosByCategoria($categoria, $order, $pag);
                $link = $this->model->paginacionProductos($categoria, $order, $pag);
                if ($link[0] == $pag) {
                    $next = false;
                } else {
                    $next = $pag + 1;
                }
                $_SESSION["categoria"] = $categoria;
                $_SESSION["orden"] = $order;
                unset($_SESSION["filtro"]);
                $filtro = false;
            } else {
                if (isset($_POST["nomProducto"])) {
                    $filtro = strtoupper(trim($_POST["nomProducto"]));
                    $order = isset($_SESSION["orden"]) ? $_SESSION["orden"] : "nombreasc";
                } else if (isset($_GET['nomProducto'])) {
                    $filtro = strtoupper(trim($_GET['nomProducto']));
                    $order = isset($_GET["order"]) ? $_GET["order"] : "nombreasc";
                } else if (isset($_SESSION["filtro"])) {
                    $filtro = strtoupper(trim($_SESSION["filtro"]));
                    $order = isset($_SESSION["orden"]) ? $_SESSION["orden"] : "nombreasc";
                }
                $categoria = "TODAS";
                $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
                $productos = $this->model->productosByFilter($filtro, $order, $pag);
                $link = $this->model->paginacionProductosFilter($filtro, $order, $pag);
                if ($link[0] == $pag) {
                    $next = false;
                } else {
                    $next = $pag + 1;
                }
                $_SESSION["categoria"] = $categoria;
                $_SESSION["orden"] = $order;
                $_SESSION["filtro"] = $filtro;
            }
        } else {
            $categoria = isset($_GET['cat']) ? $_GET['cat'] : ((isset($_SESSION["categoria"])) ? $_SESSION["categoria"] : "TODAS");
            $order = isset($_GET['order']) ? $_GET['order'] : ((isset($_SESSION["orden"])) ? $_SESSION["orden"] : "nombreasc");
            $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
            $productos = $this->model->productosByCategoria($categoria, $order, $pag);
            $link = $this->model->paginacionProductos($categoria, $order, $pag);
            if ($link[0] == $pag) {
                $next = false;
            } else {
                $next = $pag + 1;
            }
            $_SESSION["categoria"] = $categoria;
            $_SESSION["orden"] = $order;
            unset($_SESSION["filtro"]);
            $filtro = false;
        }        
        $this->view->setVars('categorias', $categ);
        $this->view->setVars('productos', $productos);
        $this->view->setVars('categoria', $categoria);
        $this->view->setVars('pagina', $next);
        $this->view->setVars('totalpro', $link[1]);        
        $this->view->setVars('orden', $order);
        $this->view->setVars('filtro', $filtro);
        $this->view->show();
    }
    
    public function updateitemtoShop(){
        $cantidad=str_replace(",", ".", $_POST["cantidad"]);
        if(is_numeric($cantidad)){
            if($cantidad==""||$cantidad==0||$cantidad==0.0){
                unset($_SESSION["canasta"][$_POST["idpro"]]);
                echo json_encode(array("respuesta"=>"no"));
            }else{
                if($_POST["unid"]=="und"){
                   $_SESSION["canasta"][$_POST["idpro"]]=(integer) $cantidad; 
                }else{
                   $_SESSION["canasta"][$_POST["idpro"]]=(double) $cantidad;  
                }                
                echo json_encode(array("respuesta"=>"si"));
            }
        }else{
            unset($_SESSION["canasta"][$_POST["idpro"]]);
            echo json_encode(array("respuesta"=>"no"));
        }
    }        

    public function catalogoajax() {
        $this->view->setTemplate('shopping' . DS . 'catalogoajax');              
        $this->document->addCss("scroll/style");
        $this->document->addCss("catalogo");
        $this->document->setHeader();
        $this->getModel("Shopping");
        if (isset($_SESSION["filtro"])) {
            $filtro = strtoupper(trim($_SESSION["filtro"]));
            $order = isset($_SESSION["orden"]) ? $_SESSION["orden"] : "nombreasc";
            $categoria = "TODAS";
            $pag = $_GET['pag'];
            $productos = $this->model->productosByFilter($filtro, $order, $pag);
            $link = $this->model->paginacionProductosFilter($filtro, $order, $pag);
            if ($link[0] == $pag) {
                $next = false;
            } else {
                $next = $pag + 1;
            }           
        }else{
            $categoria = isset($_GET['cat']) ? $_GET['cat'] : ((isset($_SESSION["categoria"])) ? $_SESSION["categoria"] : "TODAS");
            $order = isset($_GET['order']) ? $_GET['order'] : ((isset($_SESSION["orden"])) ? $_SESSION["orden"] : "nombreasc");
            $pag = $_GET['pag'];
            $productos = $this->model->productosByCategoria($categoria, $order, $pag);
            $link = $this->model->paginacionProductos($categoria, $order, $pag);
            if ($link[0] == $pag) {
                $next = false;
            } else {
                $next = $pag + 1;
            }            
        }
        $this->view->setVars('productos', $productos);
        $this->view->setVars('categoria', $categoria);
        $this->view->setVars('pagina', $next);        
        $this->view->setVars('orden', $order);
        $this->view->show();
    }

    public function orden() {
        $this->view->setTemplate('shopping' . DS . 'orden');  
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
        $this->getModel("Shopping");        
        $detalles = $this->model->traerDetalles();              
        $totales = $this->model->traerTotales($detalles);   
        $usuario = $this->model->traerInfoUsuario();   
        $this->view->setVars('detalles', $detalles);             
        $this->view->setVars('totales', $totales); 
        $this->view->setVars('usuario', $usuario); 
        $this->view->show();
    }
    
    public function updateOrden(){
        $this->getModel("Shopping");
        $cantidad=str_replace(",", ".", $_POST["cantidad"]);
        if(is_numeric($cantidad)){
            if($cantidad==""||$cantidad==0||$cantidad==0.0){
                $_SESSION["canasta"][$_POST["idpro"]]=0;
                $_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["cantidad"]= $_SESSION["canasta"][$_POST["idpro"]];
                $totales = $this->model->actualizarTotales($_SESSION["itemsenordenuptodate"]);
                $puntositem=0;
                $totalitem=0;
                echo json_encode(array("respuesta"=>"no",
                    "puntos"=>number_format($puntositem,2,",","."),
                    "item"=>number_format($totalitem,0,",","."),
                    "iva"=>number_format($totales["iva"],0,",","."),
                    "subtotal"=>number_format($totales["subtotal"],0,",","."),
                    "total"=>number_format($totales["total"],0,",","."),
                    "totalpuntos"=>number_format($totales["puntos"],2,",",".")));
            }else{
                if($_POST["unid"]=="und"){
                   $_SESSION["canasta"][$_POST["idpro"]]=(integer) $cantidad; 
                }else{
                   $_SESSION["canasta"][$_POST["idpro"]]=(double) $cantidad;  
                }                
                $_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["cantidad"]= $_SESSION["canasta"][$_POST["idpro"]];
                $totales = $this->model->actualizarTotales($_SESSION["itemsenordenuptodate"]);
                $puntositem=$_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["cantidad"]*$_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["puntos"];
                $totalitem=$_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["precioiva"]*$_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["cantidad"];
                echo json_encode(array("respuesta"=>"si",
                    "puntos"=>number_format($puntositem,2,",","."),
                    "item"=>number_format($totalitem,0,",","."),
                    "iva"=>number_format($totales["iva"],0,",","."),
                    "subtotal"=>number_format($totales["subtotal"],0,",","."),
                    "total"=>number_format($totales["total"],0,",","."),
                    "totalpuntos"=>number_format($totales["puntos"],2,",",".")));
            }
        }else{
            $_SESSION["canasta"][$_POST["idpro"]]=0;
            $_SESSION["itemsenordenuptodate"][$_POST["idpro"]]["cantidad"]= $_SESSION["canasta"][$_POST["idpro"]];
            $totales = $this->model->actualizarTotales($_SESSION["itemsenordenuptodate"]);
            $puntositem=0;
            $totalitem=0;
            echo json_encode(array("respuesta"=>"no",
                "puntos"=>number_format($puntositem,2,",","."),
                "item"=>number_format($totalitem,0,",","."),
                "iva"=>number_format($totales["iva"],0,",","."),
                "subtotal"=>number_format($totales["subtotal"],0,",","."),
                "total"=>number_format($totales["total"],0,",","."),
                "totalpuntos"=>number_format($totales["puntos"],2,",",".")));
        }
    }   
    
    public function deleteItemShop(){
        $this->getModel("Shopping");
        $this->model->deleteItemShop();
    }
    
    public function cancelShop(){
        unset($_SESSION["itemsenordenuptodate"]);
        unset($_SESSION["canasta"]);  
        echo json_encode(array("respuesta"=>"ok"));
    }
            
    public function confirmorden(){
        $continuar=true;
        foreach($_SESSION["canasta"] as $value){
            if($value==0){
               $continuar=false; 
            }
        }
        if($continuar){
            echo json_encode(array("respuesta"=>"si"));
        }else{
            echo json_encode(array("respuesta"=>"no"));
        }
    }
    
    public function shopSell(){
        $this->view->setTemplate('shopping' . DS . 'finCompra');
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
        $shopModel = $this->getModel("Shopping");
        $detalles = $shopModel->traerDetalles();              
        $totales = $shopModel->traerTotales($detalles); 
        $mes = $shopModel->getNameCurrentPeriodo();
        $userModel = $this->getModel("User");
        $idUser = $userModel->getUserId();
        $nombreUser = $userModel->getUserName();
        unset($_SESSION["pdfinfo"]);
        $_SESSION["pdfinfo"]["nombre"] = $nombreUser;
        $_SESSION["pdfinfo"]["codigo"] = $idUser;
        $_SESSION["pdfinfo"]["fecha"] = date("Y-m-d");
        $_SESSION["pdfinfo"]["iva"] = $totales["iva"];
        $_SESSION["pdfinfo"]["subtotal"] = $totales["subtotal"];
        foreach ($detalles as $value) {
            $_SESSION["pdfinfo"]["detalle"][] = array("cantidad" => $value["cantidad"],
            "nombre" => $value["nombre"],
            "referencia" => $value["referencia"],
            "preciounitarioiva" => $value["precioiva"],
            "preciototalitem" => $value["precioiva"]*$value["cantidad"]);
        }
        
        $idfactura = $shopModel->crearFactura($idUser, $detalles, $totales);      
        
        $_SESSION["pdfinfo"]["numeroorden"] = $idfactura;
        
        //$this->model->createAndSavePdf($_SESSION["pdfinfo"]);        
        
        $imagen = IMAGES . SL . 'bancobogota.gif';
        $clase = 1;
        $this->view->setVars('facturaNum', $idfactura);
        $this->view->setVars('subtotal', $subtotal);
        $this->view->setVars('detalles', $detalles);
        $this->view->setVars('nombreUser', $nombreUser);
        $this->view->setVars('idUser', $idUser);
        $this->view->setVars('totales', $totales);        
        $this->view->setVars('mes', $mes);
        $this->view->setVars('bogota', $imagen);
        $this->view->setVars('class', $clase);        
        $this->view->show();
    }        
    
    public function reporteVentas() {
        $this->getModel("Shopping");
        $this->model->ShopReport();
    }
    
}

?>
