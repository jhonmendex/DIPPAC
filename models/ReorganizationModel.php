<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ReorganizationModel extends ModelBase {

    public function getProducts($idcat, $idbodega) {
        $query = "SELECT p.unidadmedida, p.idproducto,p.nombreproducto,p.referencia,bp.stock,bp.costo,b.nombrebodega,b.bodegaid  
                  from  productos p , 
                        bodegasproductos bp,
                        bodegas b   
                  where p.idproducto = bp.idproducto and
                        bp.idbodega  = $idbodega     and 
                        b.bodegaid   = bp.idbodega   and 
                        p.estado     = 'activo'      and    
                        idcategoria  = $idcat order by nombreproducto asc";
        $consulta = $this->db->executeQue($query);
        $productos;
        while ($row = $this->db->arrayResult($consulta)) {
            if ($row['referencia'] != "LICINS") {
                $productos[] = array('id' => $row['idproducto'],
                    'nombre' => $row['nombreproducto'],
                    'referencia' => $row['referencia'],
                    'stock' => $row['stock'],
                    'costo' => $row['costo'],
                    'unidad' => $row['unidadmedida']);
                $bodega = array('nombrebodega' => $row['nombrebodega'],
                    'idbodega' => $row['bodegaid']);
            }
        }
        $detalles = array(0 => $productos, 1 => $bodega);
        return $detalles;
    }

    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
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

    public function getCodigodoc() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRPS'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRPS' order by 1 desc limit 1";
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $consecutivo = $row['consecutivo'];
            }
        } else {
            $consecutivo = 1;
        }
        return $consecutivo;
    }

    public function getCodigodoc2() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRPE'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRPE' order by 1 desc limit 1";
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $consecutivo = $row['consecutivo'];
            }
        } else {
            $consecutivo = 1;
        }
        return $consecutivo;
    }

    public function getCodigodoc3() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRPSE'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRPSE' order by 1 desc limit 1";
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $consecutivo = $row['consecutivo'];
            }
        } else {
            $consecutivo = 1;
        }
        return $consecutivo;
    }

    public function getCodigodoc4() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRPSS'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRPSS' order by 1 desc limit 1";
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $consecutivo = $row['consecutivo'];
            }
        } else {
            $consecutivo = 1;
        }
        return $consecutivo;
    }

    public function getCurrentPeriodo() {
        $query = 'select * from periodos where \'' . date("Y-m-d") . '\' BETWEEN fechainicio AND fechafin';
        $consulta = $this->db->executeQue($query);
        $idperiodo = 0;
        while ($row = $this->db->arrayResult($consulta)) {
            $idperiodo = $row['idperiodo'];
        }
        return $idperiodo;
    }

    public function addItemToSession() {
        $referencia = trim($_POST['idpro']);
        $consulta = "select * from productos where referencia='$referencia' and estado='activo'";
        $resultado = $this->db->executeQue($consulta);
        if ($this->db->numRows($resultado) != 0) {
            $producto = $this->db->arrayResult($resultado);
            if (isset($_SESSION['Reorgsesion'][$producto['idproducto']])) {
                $respuesta['res'] = "no";
                $respuesta['mess'] = "El producto ya fue seleccionado en el paso 2";
                echo json_encode($respuesta);
            } else {                
                $idbodega = $this->getUserBodega();
                $idproducto = $producto['idproducto'];
                $consulta2 = "select * from bodegasproductos where idproducto=$idproducto and idbodega=$idbodega";
                $resultado2 = $this->db->executeQue($consulta2);
                $prostock = $this->db->arrayResult($resultado2);
                if ($prostock['stock'] > 0) {
                    if (isset($_SESSION['reorganizacionsesion'][$idproducto])) {
                        $respuesta['res'] = "no";
                        $respuesta['mess'] = "Producto ya esta en la orden";
                        echo json_encode($respuesta);
                    } else {
                        $item = $_SESSION['reorganizacionsesion'][$idproducto] = array(
                            'id' => $producto['idproducto'],
                            'referencia' => $producto['referencia'],
                            'nombre' => $producto['nombreproducto'],
                            'stock' => $prostock['stock'],
                            'costo' => $prostock['costo'],
                            'unidad' => $producto['unidadmedida'],
                            'verify' => strrev(urlencode(base64_encode($producto['idproducto']))),
                            'code' => sha1($producto['idproducto']));
                        $respuesta['res'] = "si";
                        $respuesta['pro'] = $item;
                        echo json_encode($respuesta);
                    }
                } else {
                    $respuesta['res'] = "no";
                    $respuesta['mess'] = "No hay existencias del producto";
                    echo json_encode($respuesta);
                }
            }
        } else {
            $respuesta['res'] = "no";
            $respuesta['mess'] = "No existe el producto";
            echo json_encode($respuesta);
        }
    }

    public function addItemToSessionps() {
        $referencia = trim($_POST['idpro']);
        $consulta = "select * from productos where referencia='$referencia' and estado='activo'";
        $resultado = $this->db->executeQue($consulta);
        if ($this->db->numRows($resultado) != 0) {
            $producto = $this->db->arrayResult($resultado);
            if (isset($_SESSION['Reorgsesionps'][$producto['idproducto']])) {
                $respuesta['res'] = "no";
                $respuesta['mess'] = "El producto ya fue seleccionado en el paso 1";
                echo json_encode($respuesta);
            } else {                
                $idbodega = $this->getUserBodega();
                $idproducto = $producto['idproducto'];
                $consulta2 = "select * from bodegasproductos where idproducto=$idproducto and idbodega=$idbodega";
                $resultado2 = $this->db->executeQue($consulta2);
                $prostock = $this->db->arrayResult($resultado2);
                if (isset($_SESSION['reorganizacionsesionps'][$idproducto])) {
                    $respuesta['res'] = "no";
                    $respuesta['mess'] = "Producto ya esta en la orden";
                    echo json_encode($respuesta);
                } else {
                    $item = $_SESSION['reorganizacionsesionps'][$idproducto] = array(
                        'id' => $producto['idproducto'],
                        'referencia' => $producto['referencia'],
                        'unidad' => $producto['unidadmedida'],
                        'nombre' => $producto['nombreproducto'],
                        'stock' => $prostock['stock'],
                        'costo' => $prostock['costo'],
                        'verify' => strrev(urlencode(base64_encode($producto['idproducto']))),
                        'code' => sha1($producto['idproducto']));
                    $respuesta['res'] = "si";
                    $respuesta['pro'] = $item;
                    echo json_encode($respuesta);
                }
            }
        } else {
            $respuesta['res'] = "no";
            $respuesta['mess'] = "No existe el producto";
            echo json_encode($respuesta);
        }
    }

    public function addReorgSession() {
        $idproducto = trim($_POST['idpro']);
        $estado = trim($_POST['estado']);
        $cantid = trim($_POST['cant']);
        $consulta = "select * from productos where idproducto=$idproducto and estado='activo'";
        $resultado = $this->db->executeQue($consulta);
        if ($this->db->numRows($resultado) != 0) {
            $producto = $this->db->arrayResult($resultado);
            $idproducto = $producto['idproducto'];
            $item = $_SESSION['Reorgsesion'][$idproducto] = array(
                'id' => $producto['idproducto'],
                'referencia' => $producto['referencia'],
                'nombre' => $producto['nombreproducto'],
                'cantid' => $cantid,
                'estado' => $estado,
                'unidad' => $producto['unidadmedida']);
            $respuesta['res'] = "si";
            $respuesta['pro'] = $item;
            echo json_encode($respuesta);
        }
    }

    public function addReorgSessionps() {
        $idproducto = trim($_POST['idpro']);
        $idbodega = $this->getUserBodega();
        $estado = trim($_POST['estado']);
        $cantid = trim($_POST['cant']);
        $consulta = "select * from productos, bodegasproductos where bodegasproductos.idproducto=productos.idproducto and productos.idproducto=$idproducto and estado='activo' and bodegasproductos.idbodega=$idbodega";
        $resultado = $this->db->executeQue($consulta);
        if ($this->db->numRows($resultado) != 0) {
            $producto = $this->db->arrayResult($resultado);
            $idproducto = $producto['idproducto'];
            $item = $_SESSION['Reorgsesionps'][$idproducto] = array(
                'id' => $producto['idproducto'],
                'referencia' => $producto['referencia'],
                'nombre' => $producto['nombreproducto'],
                'costo' => $producto['costo'],
                'stock' => $producto['stock'],
                'cantid' => $cantid,
                'estado' => $estado,
                'unidad' => $producto['unidadmedida']);
            $respuesta['res'] = "si";
            $respuesta['pro'] = $item;
            echo json_encode($respuesta);
        }
    }

    public function deleteSession() {
        unset($_SESSION['Reorgsesion']);
        unset($_SESSION['reorganizacionsesion']);
        unset($_SESSION['cantsesion']);
        $respuesta['res'] = 'si';
        echo json_encode($respuesta);
    }

    public function deleteSessionps() {
        unset($_SESSION['Reorgsesionps']);
        unset($_SESSION['reorganizacionsesionps']);
        unset($_SESSION['cantsesionps']);
        $respuesta['res'] = 'si';
        echo json_encode($respuesta);
    }

    public function deleteItemToSession() {
        $idpro = $_POST['idpro'];
        unset($_SESSION['Reorgsesion'][$idpro]);
        $respuesta['res'] = 'si';        
        echo json_encode($respuesta);
    }

    public function deleteItemToSessionps() {
        $idpro = $_POST['idpro'];
        unset($_SESSION['Reorgsesionps'][$idpro]);
        $respuesta['res'] = 'si';        
        echo json_encode($respuesta);
    }

    public function deleteItemToSessionp() {
        if (isset($_POST["verify"])) {
            $itemid = base64_decode(urldecode(strrev($_POST["verify"])));
            unset($_SESSION['reorganizacionsesion'][$itemid]);
            unset($_SESSION['cantsesion']);
            //unset($_SESSION['Reorgsesion']);
            $respuesta['res'] = 'si';
            $respuesta['idrow'] = $itemid;
            echo json_encode($respuesta);
        }
    }

    public function deleteItemToSessionpps() {
        if (isset($_POST["verify"])) {
            $itemid = base64_decode(urldecode(strrev($_POST["verify"])));
            unset($_SESSION['reorganizacionsesionps'][$itemid]);
            unset($_SESSION['cantsesionps']);
            //unset($_SESSION['Reorgsesionps']);
            $respuesta['res'] = 'si';
            $respuesta['idrow'] = $itemid;
            echo json_encode($respuesta);
        }
    }

    public function finalizarReorganizacionp() {
        $idbodega = $this->getUserBodega();
        $cantidad = $_SESSION['cantsesion'];
        $itemssesion = $_SESSION['Reorgsesion'];
        $itemsesion = $_SESSION['reorganizacionsesion'];
        foreach ($itemsesion as $value) {
            $idproducto = $value["id"];
            $costoactual = $value["costo"];
            $stoatual = $value["stock"];
            $fecha = date("Y-m-d H:i:s");
            $periodo = $this->getCurrentPeriodo();
            $codigo = $this->getCodigodoc();
            $codigo2 = $this->getCodigodoc2();
            $iddocumento = "nextval('documentos_iddocumento_seq'::regclass)";
            $query = "insert into documentos values($iddocumento,'DRPS','$fecha',NULL,'REORGANIZACION PRODUCTO SALIDA',$codigo,NULL,$idbodega,'REORGANIZACION DE PRODUCTO SALIDA',NULL,NULL,$periodo);";
            $query.= "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$cantidad,(select costo from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),$idproducto,(select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1));";
            if ($stoatual - $cantidad == 0) {
                $query.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                              (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),
                                              '$fecha', 
                                              'REORGANIZACION PRODUCTO SALIDA',NULL, 
                                              (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                              $idbodega,
                                              (select (stock-$cantidad) from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),  
                                              0);";
                $query.= "update bodegasproductos set stock = stock-$cantidad, costo=0 where idproducto = $idproducto and idbodega=$idbodega";
            } else {
                $query.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                              (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),
                                              '$fecha', 
                                              'REORGANIZACION PRODUCTO SALIDA',NULL, 
                                              (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                              $idbodega,
                                              (select (stock-$cantidad) from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),  
                                              (select ((stock*costo)-(costo*$cantidad))/(stock-$cantidad) from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega));";
                $query.= "update bodegasproductos set stock = stock-$cantidad where idproducto = $idproducto and idbodega=$idbodega";
            }

            if ($this->db->executeQue($query)) {
                $iddocumento2 = "nextval('documentos_iddocumento_seq'::regclass)";
                $query2 = "insert into documentos values($iddocumento2,'DRPE','$fecha',NULL,'REORGANIZACION PRODUCTOS ENTRADA',$codigo2,NULL,$idbodega,'REORGANIZACION DE PRODUCTOS ENTRADA',NULL,NULL,$periodo);";
                $this->db->executeQue($query2);
                foreach ($itemssesion as $value3) {
                    $cantentrada+= $value3["cantid"];
                }
                $costoentrante = ($costoactual*$cantidad) / $cantentrada;
                foreach ($itemssesion as $value2) {
                    $idproducto2 = $value2["id"];
                    $cantid = $value2["cantid"];
                    $unidad = $value2["unidad"];
                    $porcentaje = ($cantid * 100) / $costoactual;
                    $costoentrantepeso = ($porcentaje * $costoactual) / 100;
                    $query3 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),
                              $cantid,(        
                                SELECT CASE WHEN '$unidad' = 'und' 
                                THEN       
                                   $costoentrante  
                                ELSE  
                                   (((select stock*costo from bodegasproductos where idproducto = $idproducto2 and idbodega=$idbodega)+ 
                                   ($cantid*$costoentrantepeso))
                                   /(select stock+$cantid  from bodegasproductos where idproducto=$idproducto2 and idbodega = $idbodega))        
                                END),          
                               $idproducto2,   
                               (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1));";

                    $query3.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                                        (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),
                                                        '$fecha', 
                                                        'REORGANIZACION PRODUCTO ENTRADA',NULL, 
                                                        (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                                        $idbodega,  
                                                        (select (stock+$cantid) from bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),  
                                                        (SELECT CASE WHEN '$unidad' = 'und' 
                                                        THEN     
                                                            (((select stock*costo from bodegasproductos where idproducto = $idproducto2 and idbodega=$idbodega)+ 
                                                            ($cantid*$costoentrante))
                                                            /(select stock+$cantid  from bodegasproductos where idproducto=$idproducto2 and idbodega = $idbodega))  
                                                        ELSE           
                                                         (((select stock*costo from bodegasproductos where idproducto = $idproducto2 and idbodega=$idbodega)+ 
                                                         ($cantid*$costoentrantepeso))
                                                         /(select stock+$cantid  from bodegasproductos where idproducto=$idproducto2 and idbodega = $idbodega))
                                                        END));";
                    $query3.= "update bodegasproductos set stock = stock+$cantid, costo=(((select stock*costo from bodegasproductos where idproducto = $idproducto2 and idbodega=$idbodega)+ 
                                                            ($cantid*$costoentrante))
                                                            /(select stock+$cantid  from bodegasproductos where idproducto=$idproducto2 and idbodega = $idbodega)) 
                    where idproducto = $idproducto2 and idbodega=$idbodega;
                    select costo from bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega;";
                    $resultset = $this->db->executeQue($query3);
                    if ($resultset) {
                        $row5 = $this->db->arrayResult($resultset);
                        $this->updateUtilityProducto($idproducto2, $row5["costo"]);
                        unset($_SESSION['cantsesion']);
                        unset($_SESSION['Reorgsesion']);
                        unset($_SESSION['reorganizacionsesion']);
                        echo "<script>parent.message('Se realizó la reorganizacion con exito', 'images/iconos_alerta/ok.png');" .
                        "parent.$.fancybox.close();</script>";
                    } else {
                        echo "<script>parent.message('No se realizó la reorganizacion', 'images/iconos_alerta/error.png');" .
                        "parent.$.fancybox.close();</script>";
                    }
                }
            } else {
                echo "<script>parent.message('No se realizó la reorganizacion', 'images/iconos_alerta/error.png');" .
                "parent.$.fancybox.close();</script>";
            }
        }
    }

    public function finalizarReorganizacionps() {
        $idbodega = $this->getUserBodega();
        $cantidad = $_SESSION['cantsesionps'];
        $itemssesion = $_SESSION['Reorgsesionps'];
        $itemsesion = $_SESSION['reorganizacionsesionps'];
        $periodo = $this->getCurrentPeriodo();
        $codigo3 = $this->getCodigodoc3();
        $codigo4 = $this->getCodigodoc4();
        $fecha = date("Y-m-d H:i:s");
        foreach ($itemsesion as $value) {
            $idproducto = $value["id"];
            $costoactual = $value["costo"];
            $iddocumento = "nextval('documentos_iddocumento_seq'::regclass)";
            $query = "insert into documentos values($iddocumento,'DRPSE','$fecha',NULL,'REORGANIZACION PRODUCTO ENTRADA',$codigo3,NULL,$idbodega,'REORGANIZACION DE PRODUCTOS ENTRADA',NULL,NULL,$periodo);";
            foreach ($itemssesion as $value3) {
                $cantid = $value3["cantid"];
                $costoactual2 = $value3["costo"];
                $costoentrada += ($cantid * $costoactual2);
            }            
            $costoentrada=$costoentrada/$cantidad;
            $query.= "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$cantidad,
                $costoentrada,$idproducto,(select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1));";
                $query.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                              (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),
                                              '$fecha', 
                                              'REORGANIZACION PRODUCTO ENTRADA',NULL, 
                                              (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                              $idbodega,   
                                              (select (stock+$cantidad) from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega),  
                                              (select (($costoentrada*$cantidad)+(stock*costo))/($cantidad+stock) from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega));";
                $query.= "update bodegasproductos set stock = stock+$cantidad where idproducto = $idproducto and idbodega=$idbodega;
                    select costo from bodegasproductos where idproducto = $idproducto and idbodega = $idbodega;";            
            $resultado=$this->db->executeQue($query);
            if ($resultado) {               
                $row5 = $this->db->arrayResult($resultset);
                $this->updateUtilityProducto($idproducto, $row5["costo"]);
                $iddocumento2 = "nextval('documentos_iddocumento_seq'::regclass)";
                $query2 = "insert into documentos values($iddocumento2,'DRPSS','$fecha',NULL,'REORGANIZACION PRODUCTO SALIDA',$codigo4,NULL,$idbodega,'REORGANIZACION DE PRODUCTOS SALIDA',NULL,NULL,$periodo);";
                $this->db->executeQue($query2);
                foreach ($itemssesion as $value4) {
                    $idproducto2 = $value4["id"];
                    $cantid = $value4["cantid"];
                    $stock = $value4["stock"];
                    $query3 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),
                              $cantid,(select costo from bodegasproductos where idproducto=$idproducto2 and idbodega=$idbodega),          
                               $idproducto2,   
                               (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1));";
                    if($stock-$cantid==0){
                        $query3.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                                        (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),
                                                        '$fecha', 
                                                        'REORGANIZACION PRODUCTO SALIDA',NULL, 
                                                        (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                                        $idbodega,  
                                                        (select (stock-$cantid) from bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),  
                                                        0);";
                        $query3.= "update bodegasproductos set stock = stock-$cantid, costo=0 where idproducto = $idproducto2 and idbodega=$idbodega";
                    }else{
                        $query3.= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                                        (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),
                                                        '$fecha', 
                                                        'REORGANIZACION PRODUCTO SALIDA',NULL, 
                                                        (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1),
                                                        $idbodega,  
                                                        (select (stock-$cantid) from bodegasproductos where idproducto = $idproducto2 and idbodega = $idbodega),  
                                                        (select costo from bodegasproductos where idproducto=$idproducto2 and idbodega=$idbodega));";
                        $query3.= "update bodegasproductos set stock = stock-$cantid where idproducto = $idproducto2 and idbodega=$idbodega";
                    }
                    if ($this->db->executeQue($query3)) {
                        $suma = true;
                    } else {
                        $suma = false;
                    }
                }
                if ($suma == true) {                  
                    unset($_SESSION['Reorgsesionps']);
                    unset($_SESSION['reorganizacionsesionps']);
                    unset($_SESSION['cantsesionps']);
                    echo "<script>parent.message('Se realizó la reorganizacion con exito', 'images/iconos_alerta/ok.png');" .
                    "parent.$.fancybox.close();" .
                    "parent.setTimeout('location.reload()', 1000);  </script>";
                } else {
                    echo "<script>parent.message('No se realizó la reorganizacion', 'images/iconos_alerta/error.png');" .
                    "parent.$.fancybox.close();</script>";
                }
            } else {
                echo "<script>parent.message('No se realizó la reorganizacion', 'images/iconos_alerta/error.png');" .
                "parent.$.fancybox.close();</script>";
            }
        }
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
    
     public function getNombrebodega() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $file = $this->db->arrayResult($consulta);
        return $file["nombrebodega"];
    }

}
?> 

