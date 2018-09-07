<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class InventoryAdjustController extends ControllerBase {

    public function main() {
        $this->view->setTemplate('InventoryAdjust' . DS . 'adjustmain');
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
        $this->getModel("InventoryAdjust");
        $categoriaactual = !$_POST["categoria"] ? 0 : $_POST["categoria"];
        $bodega = $this->model->getNombreBodega();
        $minimunsession = !$_SESSION["ajustefisico"] || (sizeof($_SESSION["ajustefisico"]["quitar"]) == 0 && sizeof($_SESSION["ajustefisico"]["agregar"]) == 0 && sizeof($_SESSION["ajustefisico"]["igual"]) == 0) ? false : true;
        $categorias = $this->model->getCategorias();
        $productosstock = $this->model->getProductosStock($categoriaactual);
        $mensagge = !$_GET["respuesta"] ? null : $_GET["respuesta"];
        $this->view->setVars('productosstock', $productosstock);
        $this->view->setVars('mensagge', $mensagge);
        $this->view->setVars('categoriaactual', $categoriaactual);
        $this->view->setVars('categorias', $categorias);
        $this->view->setVars('bodega', $bodega);
        $this->view->setVars('validacion', $minimunsession);
        $this->view->show();
    }

    public function removeItem() {
        unset($_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]);
        unset($_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]);
        unset($_SESSION["ajustefisico"]["igual"][$_POST["producto"]]);
        if (sizeof($_SESSION["ajustefisico"]["quitar"]) == 0 &&
                sizeof($_SESSION["ajustefisico"]["agregar"]) == 0 &&
                sizeof($_SESSION["ajustefisico"]["igual"]) == 0) {
            echo json_encode(array("res" => "none"));
        } else {
            echo json_encode(array("res" => "si"));
        }
    }

    public function addItem() {
        $diff = $_POST["cantfisica"] - $_POST["cantsitema"];
        if ($diff < 0) {
            unset($_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["igual"][$_POST["producto"]]);
            $_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]["diferencia"] = abs($diff);
            $_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]["cantfisica"] = $_POST["cantfisica"];
            $_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]["stock"] = $_POST["cantsitema"];
            $_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]["costo"] = $_POST["costo"];
        } else if ($diff > 0) {
            unset($_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["igual"][$_POST["producto"]]);
            $_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]["diferencia"] = $diff;
            $_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]["cantfisica"] = $_POST["cantfisica"];
            $_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]["stock"] = $_POST["cantsitema"];
            $_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]["costo"] = $_POST["costo"];
        } else if ($diff == 0) {
            unset($_SESSION["ajustefisico"]["quitar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["agregar"][$_POST["producto"]]);
            unset($_SESSION["ajustefisico"]["igual"][$_POST["producto"]]);
            $_SESSION["ajustefisico"]["igual"][$_POST["producto"]]["diferencia"] = $diff;
            $_SESSION["ajustefisico"]["igual"][$_POST["producto"]]["cantfisica"] = $_POST["cantfisica"];
            $_SESSION["ajustefisico"]["igual"][$_POST["producto"]]["stock"] = $_POST["cantsitema"];
            $_SESSION["ajustefisico"]["igual"][$_POST["producto"]]["costo"] = $_POST["costo"];
        }
    }

    public function cancelAdjust() {
        unset($_SESSION["ajustefisico"]);
        echo json_encode(array("respuesta" => "ok"));
    }

    public function finishAdjust() {
        $this->getModel("InventoryAdjust");
        $this->model->finishAdjust();
    }

    public function massiveupload() {
        $this->view->setTemplate('InventoryAdjust' . DS . 'uploadAll');
        $this->document->addCss("style");
        $this->document->addCss("orden");
        $this->document->setHeader();
        $this->getModel("InventoryAdjust");
        $_SESSION["list_of_products"] = $this->model->getProductosToDownload();
        $this->view->show();
    }

    public function updateAllStock() {
        if ($_FILES['exceldatos']['size'] != 0) {
            if ($_FILES['exceldatos']['type'] == 'application/excel' ||
                    $_FILES['exceldatos']['type'] == 'application/vnd.ms-excel' ||
                    $_FILES['exceldatos']['type'] == 'application/x-excel' ||
                    $_FILES['exceldatos']['type'] == 'application/x-msexcel' ||
                    $_FILES['exceldatos']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $this->getModel('InventoryAdjust');
                $misdatos = $this->model->createDataSessionInventory();
                $_SESSION['resultados'] = $misdatos;
                $respuesta['respuesta'] = 'si';
                echo json_encode($respuesta);
            } else {
                $respuesta['respuesta'] = 'no';
                $respuesta['error'] = 'Tipo de archivo incorrecto';
                echo json_encode($respuesta);
            }
        } else {
            $respuesta['respuesta'] = 'no';
            $respuesta['error'] = 'Debe seleccionar un archivo';
            echo json_encode($respuesta);
        }
    }

    public function WriteExcelResult() {
        error_reporting(E_ALL);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Listado_productos_' . date("Y") . '_' . date("m") . '_' . date("d") . '.xlsx"');
        header('Cache-Control: max-age=0');
        // ini_set('include_path', ini_get('include_path') . ';../Classes/');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Redsol S.A.S.");
        $objPHPExcel->getProperties()->setLastModifiedBy("Redsol S.A.S.");
        $objPHPExcel->getProperties()->setSubject("Listado de productos Redsol S.A.S.");
        $objPHPExcel->getProperties()->setDescription("Listado de productos Redsol S.A.S.");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "NOMBRE DEL PRODUCTO");
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', "REFERENCIA");
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', "CANTIDAD FISICA");
        $cont = 2;
        foreach ($_SESSION["list_of_products"] as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $value["nombre"]);            
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $cont, (string) $value["referencia"]); 
            //$objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $cont, $value["nombre"], PHPExcel_Cell_DataType::TYPE_STRING);            
            //$objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $cont, (string) $value["referencia"], PHPExcel_Cell_DataType::TYPE_STRING);  
            $objPHPExcel->getActiveSheet()->getStyle('B' . $cont)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $cont++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Productos');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true)->setSize(15);
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }

    public function WriteExcelNotify() {
        error_reporting(E_ALL);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Resultado_carga_masiva_' . date("Y") . '_' . date("m") . '_' . date("d") . '.xlsx"');
        header('Cache-Control: max-age=0');
        // ini_set('include_path', ini_get('include_path') . ';../Classes/');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Redsol S.A.S.");
        $objPHPExcel->getProperties()->setLastModifiedBy("Redsol S.A.S.");
        $objPHPExcel->getProperties()->setSubject("Resultado carga masiva Redsol S.A.S.");
        $objPHPExcel->getProperties()->setDescription("Resultado carga masiva Redsol S.A.S.");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "NOMBRE DEL PRODUCTO");
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', "REFERENCIA");
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', "CANTIDAD FISICA");
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', "RESULTADO CARGA");
        $cont = 2;
        foreach ($_SESSION["resultados"] as $value) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $value[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $cont, $value[1]);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $cont)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, $value[2]);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $cont)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $cont, $value[3]);
            $cont++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Resultado');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true)->setSize(15);
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
    }

}

?>
