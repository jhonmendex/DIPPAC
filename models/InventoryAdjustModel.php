<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class InventoryAdjustModel extends ModelBase {

    public function getCategorias() {
        $consulta = $this->db->executeQue("select * from categoriasp order by nombrecategoria");
        while ($row = $this->db->arrayResult($consulta)) {
            $categorias[$row['idcategoria']] = $row['nombrecategoria'];
        }
        return $categorias;
    }

    public function getProductosStock($idcategoria) {
        $idbodega = $this->getUserBodega();
        $consulta = $idcategoria == 0 ? $this->db->executeQue("select p.idproducto, p.referencia, p.nombreproducto, p.idcategoria, b.stock, b.costo, b.idbodegaproductos, p.unidadmedida
                from productos p, bodegasproductos b
                where b.idproducto=p.idproducto
                and p.estado='activo'
                and b.idbodega=$idbodega
                order by p.idcategoria, p.nombreproducto asc") : $this->db->executeQue("select  p.idproducto, p.referencia, p.nombreproducto, p.idcategoria, b.stock, b.costo, b.idbodega, p.unidadmedida
                    from productos p, bodegasproductos b
                    where b.idproducto=p.idproducto
                    and p.estado='activo'
                    and b.idbodega=$idbodega
                    and p.idcategoria=$idcategoria
                    order by p.idcategoria, p.nombreproducto asc");
        $cat = 0;
        while ($row = $this->db->arrayResult($consulta)) {
            $cattemporal = $row['idcategoria'];
            if ($cattemporal == $cat) {
                if (isset($_SESSION["ajustefisico"]["quitar"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "quitar", "cantidad" => $_SESSION["ajustefisico"]["quitar"][$row['idproducto']]["cantfisica"]);
                } else if (isset($_SESSION["ajustefisico"]["agregar"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "agregar", "cantidad" => $_SESSION["ajustefisico"]["agregar"][$row['idproducto']]["cantfisica"]);
                } else if (isset($_SESSION["ajustefisico"]["igual"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "igual", "cantidad" => $_SESSION["ajustefisico"]["igual"][$row['idproducto']]["cantfisica"]);
                } else {
                    $infosession = null;
                }
                $productosstock[] = array("id" => $row['idproducto'],
                    "idbp" => $row['idbodegaproductos'],
                    "referencia" => $row['referencia'],
                    "nombre" => $row['nombreproducto'],
                    "stock" => $row['stock'],
                    "costo" => $row['costo'],
                    "unidad" => $row['unidadmedida'],
                    "cantidad" => !$infosession ? null : $infosession["cantidad"],
                    "proceso" => !$infosession ? null : $infosession["procedimiento"]);
            } else {
                $productosstock[] = array("id" => null,
                    "nombrecat" => $this->getNombreCategoria($row['idcategoria']));
                if (isset($_SESSION["ajustefisico"]["quitar"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "quitar", "cantidad" => $_SESSION["ajustefisico"]["quitar"][$row['idproducto']]["cantfisica"]);
                } else if (isset($_SESSION["ajustefisico"]["agregar"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "agregar", "cantidad" => $_SESSION["ajustefisico"]["agregar"][$row['idproducto']]["cantfisica"]);
                } else if (isset($_SESSION["ajustefisico"]["igual"][$row['idproducto']])) {
                    $infosession = array("procedimiento" => "igual", "cantidad" => $_SESSION["ajustefisico"]["igual"][$row['idproducto']]["cantfisica"]);
                } else {

                    $infosession = null;
                }
                $productosstock[] = array("id" => $row['idproducto'],
                    "idbp" => $row['idbodegaproductos'],
                    "referencia" => $row['referencia'],
                    "nombre" => $row['nombreproducto'],
                    "stock" => $row['stock'],
                    "costo" => $row['costo'],
                    "unidad" => $row['unidadmedida'],
                    "cantidad" => !$infosession ? null : $infosession["cantidad"],
                    "proceso" => !$infosession ? null : $infosession["procedimiento"]);
                $cat = $row['idcategoria'];
            }
        }
        return $productosstock;
    }

    public function getNombreBodega() {
        $idbod = $this->getUserBodega();
        $consulta = $this->db->executeQue("select * from bodegas where bodegaid=$idbod");
        $row = $this->db->arrayResult($consulta);
        return $row["nombrebodega"];
    }

    private function getNombreCategoria($idcategoria) {
        $consulta = $this->db->executeQue("select * from categoriasp where idcategoria=$idcategoria");
        $row = $this->db->arrayResult($consulta);
        return $row["nombrecategoria"];
    }

    public function getProductosToDownload() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select p.idproducto, p.referencia, p.nombreproducto, p.idcategoria, b.stock, b.costo, b.idbodegaproductos, p.unidadmedida
                from productos p, bodegasproductos b
                where b.idproducto=p.idproducto
                and p.estado='activo'
                and b.idbodega=$idbodega
                order by p.idcategoria, p.nombreproducto asc");
        while ($row = $this->db->arrayResult($consulta)) {
            $productosstock[] = array("id" => $row['idproducto'],
                "referencia" => $row['referencia'],
                "nombre" => $row['nombreproducto']);
        }
        return $productosstock;
    }

    public function createDataSessionInventory() {
        $destino = 'tmp' . SL . $_FILES["exceldatos"]["name"];
        copy($_FILES["exceldatos"]["tmp_name"], $destino);
        $objPHPExcel = PHPExcel_IOFactory::load($destino);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $noit = 1;
        $arrayRespuesta = null;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            if ($noit == 1) {
                $highestRow = $worksheet->getHighestRow();
                $cont = 0;
                for ($row = 0; $row <= $highestRow; $row++) {
                    $nombreproducto = (string) trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $referencia = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $cantidad = str_replace(",", ".", trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()));
                    if ($cantidad == "" || $referencia == "" || $nombreproducto == "") {
                        $cont++;
                    } else {
                        if ($referencia != 'REFERENCIA') {
                            if ($cantidad == null || $cantidad == '') {
                                
                            } else {
                                $producto = $this->existeProducto($referencia);
                                if ($producto) {
                                    if (is_numeric($cantidad)) {
                                        $valida = explode(".", $cantidad);
                                        if ($producto["unidad"] == "und" && $valida[1]) {
                                            $arrayRespuesta[] = array($nombreproducto, $referencia, $cantidad, 'El formato de la cantidad no es valido para la medida en ' . $producto["unidad"]);
                                        } else {
                                            if ($cantidad < 0) {
                                                $arrayRespuesta[] = array($nombreproducto, $referencia, $cantidad, 'La cantidad fisica debe ser mayor o igual a 0');
                                            } else {
                                                $diff = $cantidad - $producto["stock"];
                                                if ($diff < 0) {
                                                    $_SESSION["ajustefisico"]["quitar"][$producto["id"]]["diferencia"] = abs($diff);
                                                    $_SESSION["ajustefisico"]["quitar"][$producto["id"]]["cantfisica"] = $cantidad;
                                                    $_SESSION["ajustefisico"]["quitar"][$producto["id"]]["stock"] = $producto["stock"];
                                                    $_SESSION["ajustefisico"]["quitar"][$producto["id"]]["costo"] = $producto["costo"];
                                                } else if ($diff > 0) {
                                                    $_SESSION["ajustefisico"]["agregar"][$producto["id"]]["diferencia"] = $diff;
                                                    $_SESSION["ajustefisico"]["agregar"][$producto["id"]]["cantfisica"] = $cantidad;
                                                    $_SESSION["ajustefisico"]["agregar"][$producto["id"]]["stock"] = $producto["stock"];
                                                    $_SESSION["ajustefisico"]["agregar"][$producto["id"]]["costo"] = $producto["costo"];
                                                } else if ($diff == 0) {
                                                    $_SESSION["ajustefisico"]["igual"][$producto["id"]]["diferencia"] = $diff;
                                                    $_SESSION["ajustefisico"]["igual"][$producto["id"]]["cantfisica"] = $cantidad;
                                                    $_SESSION["ajustefisico"]["igual"][$producto["id"]]["stock"] = $producto["stock"];
                                                    $_SESSION["ajustefisico"]["igual"][$producto["id"]]["costo"] = $producto["costo"];
                                                }
                                                $arrayRespuesta[] = array($nombreproducto, $referencia, $cantidad, 'Correcto');
                                            }
                                        }
                                    } else {
                                        $arrayRespuesta[] = array($nombreproducto, $referencia, $cantidad, 'Formato de cantidad incorrecta');
                                    }
                                } else {
                                    $arrayRespuesta[] = array($nombreproducto, $referencia, $cantidad, 'Referencia incorrecta o producto no existe');
                                }
                            }
                        }
                    }
                    if ($cont > 3) {
                        $highestRow = 0;
                    }
                }
                $noit = 2;
            }
        }
        return $arrayRespuesta;
    }

    private function existeProducto($referencia) {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select p.idproducto, p.referencia, p.nombreproducto, p.idcategoria, b.stock, b.costo, b.idbodegaproductos, p.unidadmedida
                from productos p, bodegasproductos b
                where b.idproducto=p.idproducto
                and p.estado='activo'
                and b.idbodega=$idbodega
                and p.referencia='$referencia'
                order by p.idcategoria, p.nombreproducto asc");
        if ($this->db->numRows($consulta) == 0) {
            return false;
        } else {
            $row = $this->db->arrayResult($consulta);
            $productosstock = array("id" => $row['idproducto'],
                "referencia" => $row['referencia'],
                "nombre" => $row['nombreproducto'],
                "stock" => $row['stock'],
                "costo" => $row['costo'],
                "unidad" => $row['unidadmedida']);
            return $productosstock;
        }
    }

    public function finishAdjust() {
        $ajuste1 = false;
        $ajuste2 = false;
        if (isset ($_SESSION["ajustefisico"]["quitar"])) {
            $document = $this->generateDocument("AJU.INV.FIS.SA");
            if ($document) {
                $this->insertDetails($document, "AJU.INV.FIS.SA");
                $ajuste1 = true;
            } else {
                $ajuste1 = false;
            }
        }else{
            $ajuste1 = true;
        }
        if (isset ($_SESSION["ajustefisico"]["agregar"])) {
            $document = $this->generateDocument("AJU.INV.FIS.EN");
            if ($document) {
                $this->insertDetails2($document, "AJU.INV.FIS.EN");
                $ajuste2 = true;
            } else {
                $ajuste2 = false;
            }
        }else{
            $ajuste2 = true;
        }
        if ($ajuste2 && $ajuste1) {
            unset($_SESSION["ajustefisico"]);
            echo json_encode(array("respuesta" => "ok"));
        }
    }

    private function generateDocument($tipo) {
        $idocumento = $this->getIdSecuencia("nextval('documentos_iddocumento_seq'::regclass)");
        $fecha = date("Y-m-d H:i:s");
        $prefijo = $tipo=="AJU.INV.FIS.EN"?"AIFE":"AIFS";
        $tipodocuento = $tipo;
        $idbodega = $this->getUserBodega();
        $nombredoc =  $tipo=="AJU.INV.FIS.EN"?"AJUSTE DE INVENTARIO FISICO ENTRADA":"AJUSTE DE INVENTARIO FISICO SALIDA";
        $idperiodo = $this->getCurrentPeriodo();
        $numdoc = $this->internalCode($idbodega, $prefijo);
        $query = "insert into documentos values($idocumento,'$prefijo','$fecha',NULL" .
                ",'$tipodocuento',$numdoc,NULL,$idbodega,'$nombredoc',NULL,NULL,$idperiodo)";
        if ($this->db->executeQue($query)) {
            return $idocumento;
        } else {
            return false;
        }
    }

    //Insertar detalles documento movimientos de salida
    private function insertDetails($iddocumento, $tipo) {
        $salidas = $_SESSION["ajustefisico"]["quitar"];
        foreach ($salidas as $key=>$value) {
            if ($this->createDetail($iddocumento, $key, $value["costo"], $value["diferencia"])) {
                $idbodega = $this->getUserBodega();
                $bodegaproducto = $this->getUltimoCostoStock($key, $idbodega);
                $newstock = $bodegaproducto['stock'] - $value["diferencia"];
                $vrtotaldetalle = number_format($value["diferencia"] * $value["costo"], 2, '.', '');
                $newvalortotal = $newstock==0?:$bodegaproducto['vrtotal'] - $vrtotaldetalle;
                $nuevocosto = $newstock==0?:number_format($newvalortotal / $newstock, 2, '.', '');
                if ($this->createMovimiento($bodegaproducto['id'], $iddocumento, $idbodega, $newstock, $nuevocosto, $tipo)) {
                    $queryupdate = "update bodegasproductos set costo=$nuevocosto, stock=$newstock where idbodega=$idbodega and idproducto=" . $key;
                    if ($this->db->executeQue($queryupdate)) {
                        
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //Insertar detalles documento movimientos de entrada
    private function insertDetails2($iddocumento,$tipo) {
        $salidas = $_SESSION["ajustefisico"]["agregar"];
        foreach ($salidas as $key=>$value) {
            if ($this->createDetail($iddocumento, $key, $value["costo"], $value["diferencia"])) {
                $idbodega = $this->getUserBodega();
                $bodegaproducto = $this->getUltimoCostoStock($key, $idbodega);
                $newstock = $bodegaproducto['stock'] + $value["diferencia"];
                $vrtotaldetalle = number_format($value["diferencia"] * $value["costo"], 2, '.', '');
                $newvalortotal = $bodegaproducto['vrtotal'] + $vrtotaldetalle;
                $nuevocosto = number_format($newvalortotal / $newstock, 2, '.', '');
                if ($this->createMovimiento($bodegaproducto['id'], $iddocumento, $idbodega, $newstock, $nuevocosto, $tipo)) {
                    $queryupdate = "update bodegasproductos set costo=$nuevocosto, stock=$newstock where idbodega=$idbodega and idproducto=" . $key;
                    if ($this->db->executeQue($queryupdate)) {
                        
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    private function createDetail($iddocumento, $idproducto, $costo, $cantidad) {
        $idetalle = $this->getIdSecuencia("nextval('detalledocumentos_iddetallecodumentos_seq'::regclass)");
        $query = "insert into detalledocumentos values($idetalle,$cantidad,$costo,$idproducto,$iddocumento)";
        if ($this->db->executeQue($query)) {
            return true;
        } else {
            return false;
        }
    }

    private function getUltimoCostoStock($idproducto, $idbodega) {
        $query = "select * from bodegasproductos where idbodega=$idbodega and idproducto=$idproducto";
        $consulta = $this->db->executeQue($query);
        $bodegaproducto = null;
        while ($row = $this->db->arrayResult($consulta)) {
            $bodegaproducto = array('id' => $row['idbodegaproductos'],
                'costo' => $row['costo'],
                'stock' => $row['stock'],
                'vrtotal' => number_format($row['stock'] * $row['costo'], 2, '.', ''));
        }
        return $bodegaproducto;
    }

    private function createMovimiento($idbodegaproducto, $idocumento, $idbodega, $saldostock, $costo, $tipo) {
        $idmovimiento = $this->getIdSecuencia("nextval('movimientos_idmovimiento_seq'::regclass)");
        $fecha = date("Y-m-d");
        $tipodocumento = $tipo;
        $query = "insert into movimientos values($idmovimiento,$idbodegaproducto,'$fecha','$tipodocumento',NULL,$idocumento,$idbodega,$saldostock,$costo)";
        if ($this->db->executeQue($query)) {
            return true;
        } else {
            return false;
        }
    }

    private function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

    private function getIdSecuencia($secuencia) {
        $idquery = "select $secuencia limit 1";
        $consult = $this->db->executeQue($idquery);
        $idelemnto = 0;
        while ($row = $this->db->arrayResult($consult)) {
            $idelemnto = $row['nextval'];
        }
        return $idelemnto;
    }

    private function getCurrentPeriodo() {
        $query = 'select * from periodos where \'' . date("Y-m-d") . '\' BETWEEN fechainicio AND fechafin';
        $consulta = $this->db->executeQue($query);
        $idperiodo = 0;
        while ($row = $this->db->arrayResult($consulta)) {
            $idperiodo = $row['idperiodo'];
        }
        return $idperiodo;
    }

    private function internalCode($bodega, $prefijo) {
        $query = "select * from documentos where prefijo='$prefijo' and idbodega=$bodega";
        $consulta = $this->db->executeQue($query);
        $codigointerno = $this->db->numRows($consulta) + 1;
        return $codigointerno;
    }

}
?>

