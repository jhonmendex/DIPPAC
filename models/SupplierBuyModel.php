<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class SupplierBuyModel extends ModelBase {

    public function getSupplier() {
        $nit = $_POST["nit_supplier"];
        $idquery = "select * from terceros where nit=$nit";
        $consult = $this->db->executeQue($idquery);
        $total = $this->db->numRows($consult);
        if ($total == 0) {
            echo "<script>parent.message('El proveedor no existe, por favor cree uno nuevo','images/iconos_alerta/error.png');" .
            "parent.crearproveedor('$nit');" .
            "parent.$.fancybox.close();</script>";
        } else {
            $row = $this->db->arrayResult($consult);
            $idsup = $row['idtercero'];
            $nomsup = $row['nombretercero'];
            $_SESSION['cabeceracompra']['nitproveedor'] = $nit;
            $_SESSION['cabeceracompra']['idproveedor'] = $idsup;
            $_SESSION['cabeceracompra']['nombreproveedor'] = $nomsup;
            echo json_encode(array("nombre" => $nomsup, "nit" => $nit, "id" => $idsup));
        }
    }

    public function newSupplier() {
        $nombre = strtoupper(trim($_POST["name_supplier"]));
        $nit = trim($_POST["nit"]);
        $ciudad = trim($_POST["ciudades"]);
        $direccion = trim($_POST["address_supplier"]) != "" ? "'" . trim($_POST["address_supplier"]) . "'" : "NULL";
        $telefono = trim($_POST["phone_supplier"]);
        $email = trim($_POST["email_supplier"]) != "" ? "'" . trim($_POST["email_supplier"]) . "'" : "NULL";
        $contacto = trim($_POST["namecontact"]);
        $celular = trim($_POST["cellphone_supplier"]) != "" ? trim($_POST["cellphone_supplier"]) : "NULL";                                             
        $consult = $this->db->executeQue("select nextval('terceros_idtercero_seq'::regclass) limit 1");
        $row = $this->db->arrayResult($consult);
        $iduser = $row['nextval'];
        $query = "insert into terceros values ($iduser,'$nombre', $direccion,$telefono,$nit,$ciudad,$celular,'$contacto',$email)";
        if ($this->db->executeQue($query)) {
            $_SESSION['cabeceracompra']['nitproveedor'] = $nit;
            $_SESSION['cabeceracompra']['idproveedor'] = $iduser;
            $_SESSION['cabeceracompra']['nombreproveedor'] = $nombre; 
            echo json_encode(array("respuesta" => "si",
                "nombre" => $nombre,
                "nit" => 'Nit. ' + $nit,
                "id" => $iduser));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
    }

    public function getProducto() {
        $referencia = $_POST["ref_product"];
        $facturacompra = $_SESSION['facturacompra'];
        $idquery = "select * from productos where referencia='$referencia' and estado='activo'";
        $consult = $this->db->executeQue($idquery);
        $total = $this->db->numRows($consult);
        if ($total == 0) {
            echo json_encode(array("res" => "new", "mess" => "El producto no existe, por favor cree uno nuevo", "refe" => "$referencia"));
        } else {
            while ($row = $this->db->arrayResult($consult)) {
                $idprod = $row['idproducto'];
                $nomprod = $row['nombreproducto'];
                $iva = $row['iva'];
                $unidad = $row['unidadmedida'];
                $idverify = strrev(urlencode(base64_encode($idprod)));
                $idid = sha1($idprod);
                if (isset($_SESSION['facturacompra'])) {
                    if (isset($facturacompra[$idprod])) {
                        echo json_encode(array("res" => "rep", "mess" => "El producto ya se encuentra en los items de compra", "refe" => "$referencia"));
                    } else {
                        $_SESSION['facturacompra'][$idprod] = array('id' => $idprod,
                            'nombre' => $nomprod,
                            'referencia' => $referencia,
                            'dell' => $idid,
                            'verify' => $idverify,
                            'cantidad' => '',
                            'costo' => '',
                            'costoiva' => '',
                            'unidad' => $unidad,
                            'iva' => $iva);
                        echo json_encode(array("res" => "ok",
                            "mess" => "",
                            "refe" => "$referencia",
                            "id" => "$idprod",
                            "nombre" => "$nomprod",
                            "idid" => "$idid",
                            "verify" => "$idverify",
                            "unidad" => "$unidad"));
                    }
                } else {
                    $_SESSION['facturacompra'][$idprod] = array('id' => $idprod,
                        'nombre' => $nomprod,
                        'referencia' => $referencia,
                        'dell' => $idid,
                        'verify' => $idverify,
                        'cantidad' => '',
                        'costo' => '',
                        'costoiva' => '',
                        'unidad' => $unidad,
                        'iva' => $iva);
                    echo json_encode(array("res" => "ok",
                        "mess" => "",
                        "refe" => "$referencia",
                        "id" => "$idprod",
                        "nombre" => "$nomprod",
                        "idid" => "$idid",
                        "verify" => "$idverify",
                        "unidad" => "$unidad"));
                }
            }
        }
    }

    public function categorias() {
        $categorias = array();
        $consulta = $this->db->executeQue("select * from categoriasp order by nombrecategoria asc");
        $resultados = $this->db->numRows($consulta);
        if ($resultados == 0) {
            
        } else {
            while ($row = $this->db->arrayResult($consulta)) {
                $categorias[$row['idcategoria']] = $row['nombrecategoria'];
            }
        }
        return $categorias;
    }

    public function primeraCategoria() {
        $consulta = $this->db->executeQue("select * from categoriasp order by nombrecategoria asc");
        $resultados = $this->db->numRows($consulta);
        if ($resultados == 0) {
            
        } else {
            $primeraCategoria = $this->db->arrayResult($consulta);
        }
        return $primeraCategoria['idcategoria'];
    }

    public function crearCategoria() {
        $nombrecat = strtoupper($_POST['name_categoria']);
        $idquery = "select nextval('categoriasp_idcategoria_seq'::regclass) limit 1";
        $consult = $this->db->executeQue($idquery);
        $idcategoria = 0;
        while ($row = $this->db->arrayResult($consult)) {
            $idcategoria = $row['nextval'];
        }
        if ($this->db->executeQue("insert into categoriasp values($idcategoria,'$nombrecat')")) {
            echo '<script>parent.parent.message("Se ha insertado una nueva categoria","images/iconos_alerta/ok.png");'
            . 'parent.updateSelect("' . $idcategoria . '","' . $nombrecat . '");'
            . 'parent.$.fancybox.close(); </script>';
        } else {
            echo '<script>parent.parent.message("No se pudo insertar una nueva categoria","images/iconos_alerta/error.png")' .
            ';parent.$.fancybox.close(); </script>';
        }
    }

    public function crearProducto() {
        $nombrepro = strtoupper($_POST['name_products']);
        $referencia = $_POST['referencia'];
        $precio = $_POST['price'];
        $iva = $_POST['iva'];
        $unidad = $_POST['unidad'];
        $precioiva = (($precio * $iva) / 100) + $precio;
        $puntos = $precioiva / $this->config->get('pointvalue');
        $idcategoria = $_POST['categorias'];
        $idquery = "select nextval('productos_idproducto_seq'::regclass) limit 1";
        $consult = $this->db->executeQue($idquery);
        $idimagen = 1;
        $row = $this->db->arrayResult($consult);
        $idproducto = $row['nextval'];
        if ($this->db->executeQue("insert into productos " . "
                values($idproducto,$idcategoria,'$nombrepro',$puntos,$idimagen,'$referencia',$iva,'activo',$precio,$precioiva,NULL,NULL,NULL,NULL,NULL,NULL,NULL,100,'$unidad')")) {
            $idverify = strrev(urlencode(base64_encode($idproducto)));
            $idid = sha1($idproducto);
            $_SESSION['facturacompra'][$idproducto] = array('id' => $idproducto,
                'nombre' => $nombrepro,
                'referencia' => $referencia,
                'dell' => $idid,
                'verify' => $idverify,
                'cantidad' => '',
                'costo' => '',
                'costoiva' => '',
                'iva' => $iva,
                'unidad' => $unidad);
            $consultica = $this->db->executeQue("select bodegaid from bodegas");
            if ($this->db->numRows($consultica) > 0) {
                while ($fila = $this->db->arrayResult($consultica)) {
                    $idbodega = $fila['bodegaid'];
                    $this->db->executeQue("insert into bodegasproductos values(nextval('bodegasproductos_idbodegaproductos_seq'::regclass),
                    $idbodega,$idproducto,0,NULL,NULL,0,$precio)");
                }
            }
            echo json_encode(array("respuesta" => "si",
                "id" => $idproducto,
                "nombre" => $nombrepro,
                "referencia" => $referencia,
                "idid" => $idid,
                "verify" => $idverify,
                "unidad" => $unidad));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
    }

    public function deleteItemshop() {
        if (isset($_POST["verify"])) {
            $idpro = base64_decode(urldecode(strrev($_POST["verify"])));
            unset($_SESSION['facturacompra'][$idpro]);
            if (!isset($_SESSION['facturacompra'][$idpro])) {
                $respuesta['res'] = 'si';
                $respuesta['idrow'] = $idpro;

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
                $respuesta['respuesta3'] = number_format($subtotalfactcom + $ivafactcom, 0, ',', '.');
                $respuesta['respuesta4'] = number_format($subtotalfactcom, 0, ',', '.');
                $respuesta['respuesta5'] = number_format($ivafactcom, 0, ',', '.');

                echo json_encode($respuesta);
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    public function finishBuy() {
        $document = $this->generateDocument();
        if ($document) {
            $this->insertDetails($document);
            unset($_SESSION['facturacompra']);
            unset($_SESSION['cabeceracompra']);
            unset($_SESSION['subtotalcompra']);
            unset($_SESSION['precioivacompra']);
            unset($_SESSION['totalproveedor']);
            //header('location: index.php?controlador=SupplierBuy&messageok=ok');
            echo json_encode(array("res" => "si"));
        } else {
            
        }
    }

    private function generateDocument() {
        $idocumento = $this->getIdSecuencia("nextval('documentos_iddocumento_seq'::regclass)");
        $prefijo = "FC";
        $fecha = $_SESSION['cabeceracompra']['FechaFact'];
        $observaciones = "";
        $tipodocuento = "COMPRAS";
        $numdoc = $_SESSION['cabeceracompra']['NumeroFact'];
        $idproveedor = $_SESSION['cabeceracompra']['idproveedor'];
        $idbodega = $this->getUserBodega();
        $nombredoc = "Factura de compra";
        $coddoc = null;
        $idfactura = null;
        $idperiodo = $this->getCurrentPeriodo();
        $query = "insert into documentos values($idocumento,'$prefijo','$fecha',NULL" .
                ",'$tipodocuento',$numdoc,$idproveedor,$idbodega,'$nombredoc',NULL,NULL,$idperiodo)";
        if ($this->db->executeQue($query)) {
            return $idocumento;
        } else {
            return false;
        }
    }

    public function insertDetails($iddocumento) {
        $compras = $_SESSION['facturacompra'];
        foreach ($compras as $value) {
            if ($this->createDetail($iddocumento, $value["id"], $value["costo"], $value["cantidad"])) {
                $idbodega = $this->getUserBodega();
                $bodegaproducto = $this->getUltimoCostoStock($value["id"], $idbodega);
                $newstock = $value["cantidad"] + $bodegaproducto['stock'];
                $vrtotaldetalle = number_format($value["cantidad"] * $value["costo"], 2, '.', '');
                $newvalortotal = $vrtotaldetalle + $bodegaproducto['vrtotal'];
                $nuevocosto = number_format($newvalortotal / $newstock, 2, '.', '');
                if ($this->createMovimiento($bodegaproducto['id'], $iddocumento, $idbodega, $newstock, $nuevocosto)) {
                    $queryupdate = "update bodegasproductos set costo=$nuevocosto, stock=$newstock where idbodega=$idbodega and idproducto=" . $value["id"];
                    if ($this->db->executeQue($queryupdate)) {
                        $idbodega = $this->getUserBodega();
                        $idproveedor = $_SESSION['cabeceracompra']['idproveedor'];
                        $this->associatedProducts($value["id"], $idproveedor, number_format($value["costo"], 2, '.', ''));
                        if ($value['fechavence'] != null) {
                            $this->associatedDateExpire($value["id"], $value['fechavence'], $value["cantidad"], $idbodega);
                        }
                        $this->updateUtilityProducto($value["id"], $nuevocosto);
                    } else {
                        
                    }
                } else {
                    
                }
            } else {
                return false;
            }
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

    private function createDetail($iddocumento, $idproducto, $costo, $cantidad) {
        $idetalle = $this->getIdSecuencia("nextval('detalledocumentos_iddetallecodumentos_seq'::regclass)");
        $query = "insert into detalledocumentos values($idetalle,$cantidad,$costo,$idproducto,$iddocumento)";
        if ($this->db->executeQue($query)) {
            return true;
        } else {
            return false;
        }
    }

    private function createMovimiento($idbodegaproducto, $idocumento, $idbodega, $saldostock, $costo) {
        $idmovimiento = $this->getIdSecuencia("nextval('movimientos_idmovimiento_seq'::regclass)");
        $fecha = date("Y-m-d");
        $tipodocuento = "COMPRAS";
        $idfactura = null;
        $query = "insert into movimientos values($idmovimiento,$idbodegaproducto,'$fecha','$tipodocuento',NULL,$idocumento,$idbodega,$saldostock,$costo)";
        if ($this->db->executeQue($query)) {
            return true;
        } else {
            return false;
        }
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

    private function associatedProducts($idproducto, $idproveedor, $costo) {
        $idquery = "select * from productosproveedores where idproveedor=$idproveedor and idproducto=$idproducto";
        $consult = $this->db->executeQue($idquery);
        $total = $this->db->numRows($consult);
        if ($total == 0) {
            $idproductosprovedores = $this->getIdSecuencia("nextval('productosproveedores_idproductosproveedores_seq'::regclass)");
            $idquery2 = "insert into productosproveedores values($idproductosprovedores,$idproducto,$idproveedor,$costo)";
            $this->db->executeQue($idquery2);
        } else {
            $row = $this->db->arrayResult($consult);
            $idpp = $row['idproductosproveedores'];
            $idquery3 = "update productosproveedores set ultimocosto=$costo where idproductosproveedores=$idpp";
            $this->db->executeQue($idquery3);
        }
    }

    private function associatedDateExpire($idproducto, $fecha, $cantidad, $idbodega) {
        $idvencimientoproductos = $this->getIdSecuencia("nextval('vencimientoproductos_idvencimientoproducto_seq'::regclass)");
        $idquery = "insert into vencimientoproductos values($idvencimientoproductos,'$fecha',$idproducto,$cantidad,8, $idbodega)";
        $this->db->executeQue($idquery);
    }

    public function getAllBoughtsSupplier() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos d, terceros t 
        where d.prefijo='FC' and d.idbodega=$idbodega and t.idtercero=d.idtercero order by 1 desc";
        $resultados = $this->db->executeQue($query);
        while ($fila = $this->db->arrayResult($resultados)) {
            $otroquery = "select sum(d.costo*d.cantidad) as total,  sum(((d.costo*p.iva)/100)*d.cantidad) as ivatotal
                from detalledocumentos d, productos p where d.iddocumento=" . $fila['iddocumento'] . "
                    and d.idproducto=p.idproducto";
            $otroresultado = $this->db->executeQue($otroquery);
            $fila2 = $this->db->arrayResult($otroresultado);
            $buyssup[] = array('id' => $fila['iddocumento'],
                'fecha' => $fila['fecha'],
                'codigo' => $fila['codigo'],
                'empresa' => $fila['nombretercero'],
                'nit' => $fila['nit'],
                'total' => $fila2['total'],
                'ivatotal' => $fila2['ivatotal']);
        }
        return $buyssup;
    }

    public function getdocumentByid($iddocument) {
        $query = "select * from documentos d, terceros t 
        where d.iddocumento=$iddocument and t.idtercero=d.idtercero order by 1 desc";
        $resultados = $this->db->executeQue($query);
        $fila = $this->db->arrayResult($resultados);
        $otroquery = "select sum(costo*cantidad) as total 
                from detalledocumentos where iddocumento=$iddocument";
        $otroresultado = $this->db->executeQue($otroquery);
        $fila2 = $this->db->arrayResult($otroresultado);
        $buyssup = array('id' => $fila['iddocumento'],
            'fecha' => $fila['fecha'],
            'codigo' => $fila['codigo'],
            'empresa' => $fila['nombretercero'],
            'nit' => $fila['nit'],
            'idtercero' => $fila['idtercero'],
            'total' => $fila2['total']);
        return $buyssup;
    }

    public function getdetailsBoughtsup($iddocument) {
        $idbodega = $this->getUserBodega();
        $query = "select d.cantidad, d.costo, p.nombreproducto, p.referencia,p.unidadmedida, (d.costo*d.cantidad) as valortotal,p.idproducto,
                  coalesce((
                            select sum(cantidad) 
                            from   detalledocumentos dc, 
                                   documentos d          
                            where  dc.iddocumento = d.iddocumento and 
                                    dc.idproducto = p.idproducto  and
                                    d.nombredocumento = 'DEVOLUCION EN COMPRA' and   
                                    d.codigodocumento = $iddocument),0)as cantdev, (select stock from bodegasproductos bp where bp.idproducto = p.idproducto and idbodega=$idbodega ) as stock
        from  detalledocumentos d, 
              productos p
        where d.iddocumento = $iddocument    and
               p.idproducto = d.idproducto    
        order by d.iddetallecodumentos asc";
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $detalles[] = array('referencia' => $row['referencia'],
                'nombreproducto' => $row['nombreproducto'],
                'cantidad' => $row['cantidad'],
                'costo' => $row['costo'],
                'valortotal' => $row['valortotal'],
                'idproducto' => $row['idproducto'],
                'cantdev' => $row['cantdev'],
                'stock' => $row['stock'],
                'unidad' => $row['unidadmedida']);
        }
        return $detalles;
    }

    private function updateUtilityProducto($idproducto, $costoUpdated) {
        $consulta = $this->db->executeQue("select * from productos where idproducto=$idproducto");
        $file = $this->db->arrayResult($consulta);
        if ($file['porcentajeutilidad'] != 0 || $file['porcentajeutilidad'] != "NULL") {
            $porcentaje = $file['porcentajeutilidad'];
        } else {
            $porcentaje = 100;
        }
        $utilidadtotaltmp = $file['precio'] - $costoUpdated;
        $utilidadtotal = ($utilidadtotaltmp * $porcentaje) / 100;
        $nivel0 = ($utilidadtotal * 12) / 100;
        $nivel1 = ($utilidadtotal * 7) / 100;
        $nivel2 = ($utilidadtotal * 15) / 100;
        $nivel3 = ($utilidadtotal * 8) / 100;
        $niveln = ($utilidadtotal * 3) / 100;
        $utilidadplentiful = $utilidadtotal - $nivel0 - $nivel1 - $nivel2 - $nivel3 - $niveln;
        $query2 = "update productos set utilidadtotal=$utilidadtotal, utilidadplentiful=$utilidadplentiful, 
        nivel0=$nivel0, nivel1=$nivel1, nivel2=$nivel2, nivel3=$nivel3, niveli=$niveln, porcentajeutilidad=$porcentaje
        where idproducto=$idproducto";
        $this->db->executeQue($query2);
    }

    public function registrarDevolucion($codigodoc, $tercero) {
        $bodega = $this->getUserBodega();
        $fecha = date("Y-m-d");
        $periodo = $this->getCurrentPeriodo();
        $codigo = $this->getCodigodoc();
        $iddocumento = $this->getIdSecuencia("nextval('documentos_iddocumento_seq'::regclass)");
        $query = "insert into documentos values ($iddocumento,'DC','$fecha',NULL,'DEVOLUCION',$codigo,$tercero,$bodega,'DEVOLUCION EN COMPRA',$codigodoc,NULL,$periodo)";
        if ($this->db->executeQue($query)) {
            foreach ($_SESSION['devolucionc'] as $key => $value) {
                $costocalc = $_SESSION['devolucioncosto'][$key];
                $stockactual = $this->getstockVal($bodega, $key);
                if ($stockactual - $value == 0) {
                    $query2 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$value,$costocalc,$key,$iddocumento); ";
                    $query2.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),(select idbodegaproductos from  bodegasproductos where idproducto = $key and idbodega = $bodega),'$fecha','DEVOLUCION EN COMPRAS',NULL, 
                        $iddocumento,$bodega, (select (stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodega), 0);";
                    $query2.="update bodegasproductos set stock = (stock-$value),                  
                                               costo = 0
                                               where idproducto=$key and idbodega = $bodega;
                            update productos set utilidadtotal=0, utilidadplentiful=0, 
        nivel0=0, nivel1=0, nivel2=0, nivel3=0, niveli=0 where idproducto=$key;";
                    $this->db->executeQue($query2);
                } else {
                    $query2 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$value,$costocalc,$key,$iddocumento); ";
                    $query2.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),(select idbodegaproductos from  bodegasproductos where idproducto = $key and idbodega = $bodega),'$fecha','DEVOLUCION EN COMPRAS',NULL, 
                        $iddocumento,$bodega, (select (stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodega),      
                        (select ((stock*costo)-($value*$costocalc))/(stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodega));";
                    $query2.="update bodegasproductos set stock = (stock-$value),                  
                                               costo = (select ((stock*costo)-($value*$costocalc))/(stock-$value) 
                                               from  bodegasproductos 
                                               where idproducto = $key and idbodega = $bodega) 
                        where idproducto=$key and idbodega = $bodega;
                            select costo from bodegasproductos where idproducto = $key and idbodega = $bodega;";
                    $resultset = $this->db->executeQue($query2);
                    $row5 = $this->db->arrayResult($resultset);
                    $this->updateUtilityProducto($key, $row5["costo"]);
                }
            }
            unset($_SESSION['devolucion']);
            unset($_SESSION['devolucionc']);
            unset($_SESSION['devolucioncosto']);
            echo json_encode(array("res" => "si"));
        } else {
            unset($_SESSION['devolucion']);
            unset($_SESSION['devolucionc']);
            unset($_SESSION['devolucioncosto']);
            echo json_encode(array("res" => "no"));
        }
    }

    private function getCodigodoc($prefijo = 'DC') {
        $bodega = $this->getUserBodega();
        $query = "select * from documentos where prefijo='$prefijo' and idbodega=$bodega";
        $consulta = $this->db->executeQue($query);
        $codigointerno = $this->db->numRows($consulta) + 1;
        return $codigointerno;
    }

    private function getstockVal($idbodega, $idpro) {
        $consulta = "select stock from bodegasproductos where idbodega=$idbodega and idproducto=$idpro";
        $respuesta = $this->db->executeQue($consulta);
        $row = $this->db->arrayResult($respuesta);
        return $row["stock"];
    }
    
    public function getNombrebodega() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $file = $this->db->arrayResult($consulta);
        return $file["nombrebodega"];
    }


}

?>