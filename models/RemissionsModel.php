<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class RemissionsModel extends ModelBase {

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
            $productos[] = array('id' => $row['idproducto'],
                'nombre' => $row['nombreproducto'],
                'referencia' => $row['referencia'],
                'stock' => $row['stock'],
                'costo' => $row['costo'],
                'unidad' => $row['unidadmedida']);
            $bodega = array('nombrebodega' => $row['nombrebodega'],
                'idbodega' => $row['bodegaid']);
        }
        $detalles = array(0 => $productos, 1 => $bodega);
        return $detalles;
    }

    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

    public function getWareHouseLocal() {
        $idbodega = $this->getUserBodega();
        $query = "SELECT * from bodegas where bodegaid  != $idbodega order by nombrebodega asc";
        $consulta = $this->db->executeQue($query);
        $bodegas;
        while ($row = $this->db->arrayResult($consulta)) {
            $bodegas[] = array('id' => $row['bodegaid'],
                'nombre' => $row['nombrebodega'],
                'direccion' => $row['direccionbodega']);
        }
        return $bodegas;
    }

    public function getWareHouse() {
        $query = "SELECT * from bodegas order by nombrebodega asc";
        $consulta = $this->db->executeQue($query);
        $bodegas;
        while ($row = $this->db->arrayResult($consulta)) {
            $bodegas[] = array('id' => $row['bodegaid'],
                'nombre' => $row['nombrebodega'],
                'direccion' => $row['direccionbodega']);
        }
        return $bodegas;
    }

    public function getUserProfile() {
        $usuario = unserialize($_SESSION['user']);
        $idperfil = $usuario->getPerfilUser();
        $query = "select grupo from perfiles where idperfil=$idperfil";
        $consulta = $this->db->executeQue($query);
        $row = $this->db->arrayResult($consulta);
        return $row["grupo"];
    }

    public function getUsuarios() {
        $usuario = $this->getUserId();
        $query = "select idusuario,nombreusuario from usuarios where idusuario=$usuario";
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $usuario = array('id' => $row["idusuario"],
                'nombreu' => $row["nombreusuario"]);
        }
        return $usuario;
    }

    private function getUserId() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getIdUser();
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

    public function getRemissions($idproducto, $cantidad, $idbodega) {
        $query = "select p.idproducto,p.nombreproducto,p.referencia,bp.stock,bp.costo,(bp.costo*$cantidad) as total 
                  from   productos p,
                         bodegasproductos bp 
                  where  p.idproducto = $idproducto   and
                         p.idproducto = bp.idproducto and
                         p.estado     = 'activo'      and  
                         bp.idbodega = $idbodega";
        $result = $this->db->executeQue($query);
        $row = $this->db->arrayResult($result);
        echo json_encode(array('respuesta'=>'si', 'id' => $row['idproducto'], 'nombreproducto' => $row['nombreproducto'], 'referencia' => $row['referencia'],
            'stock' => $row['stock'], 'cantidad' => $cantidad, 'costo' => $row['costo'], 'total' => $row['total']));
    }

    public function getRemissionsSesion($idbodega) {
        foreach ($_SESSION['remision'] as $key => $value) {
            if ($value <= 0) {
                unset($_SESSION['remision'][$key]);
            } else {
                $query = "select p.idproducto,p.nombreproducto,p.referencia,bp.stock,bp.costo,(bp.costo*$value) as total 
                  from   productos p,
                         bodegasproductos bp  
                  where  p.idproducto = $key and
                         p.idproducto = bp.idproducto and
                         p.estado     = 'activo'      and  
                         bp.idbodega = $idbodega ";
                $productossesion;
                $result = $this->db->executeQue($query);
                $row = $this->db->arrayResult($result);
                $productossesion[] = array('id' => $row['idproducto'],
                    'nombre' => $row['nombreproducto'],
                    'referencia' => $row['referencia'],
                    'stock' => $row['stock'],
                    'costo' => $row['costo'],
                    'cantidad' => $value,
                    'total' => $row['total']);
            }
        }
        return $productossesion;
    }

    //public function remissionRegister($bodegaorigen, $bodegadestino, $cajas, $usuariodestino) {
    public function remissionRegister($bodegadestino) {
        $bodegaorigen= $this->getUserBodega();
        $usuariodestino=$this->getUserId();
        $fecha = date("Y-m-d H:i:s");
        $periodo = $this->getCurrentPeriodo();
        $codigo = $this->getCodigodoc();
        $iddocumento = "nextval('documentos_iddocumento_seq'::regclass)";
        $query = "insert into documentos values ($iddocumento,'DRS','$fecha',NULL,'REMISION SALIDA',$codigo,NULL,$bodegaorigen,'REMISION DE SALIDA',NULL,NULL,$periodo);";
        $query.="insert into remisiones values(nextval('remisiones_idremision_seq'::regclass),$bodegadestino,     
                     (select iddocumento from documentos where idbodega=$bodegaorigen order by 1 desc limit 1),'POR ENTREGAR',$usuariodestino,NULL);";
        if ($this->db->executeQue($query)) {
            foreach ($_SESSION['remision'] as $key => $value) {
                $prostock=$this->getUltimoCostoStock($key, $bodegaorigen);
                $query2 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$value,(select costo from bodegasproductos where idproducto = $key and idbodega = $bodegaorigen),$key,(select iddocumento from documentos where idbodega=$bodegaorigen order by 1 desc limit 1)); ";
                if($prostock["stock"]-$value==0){
                    $query2.="insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                      (select idbodegaproductos from  bodegasproductos where idproducto = $key and idbodega = $bodegaorigen),'$fecha','REMISION SALIDA',NULL, 
                      (select iddocumento from documentos where idbodega=$bodegaorigen order by 1 desc limit 1),$bodegaorigen,
                      (select (stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodegaorigen),   
                      0);";
                        $query2.=" update bodegasproductos set  
                              stock = (stock-$value), 
                              costo = 0  where idproducto=$key and idbodega = $bodegaorigen;";
                }else{
                    $query2.="insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                      (select idbodegaproductos from  bodegasproductos where idproducto = $key and idbodega = $bodegaorigen),'$fecha','REMISION SALIDA',NULL, 
                      (select iddocumento from documentos where idbodega=$bodegaorigen order by 1 desc limit 1),$bodegaorigen,
                      (select (stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodegaorigen),   
                      (select ((stock*costo)-(costo*$value))/(stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodegaorigen)) ;";
                $query2.=" update bodegasproductos set  
                              stock = (stock-$value), 
                              costo = (select ((stock*costo)-(costo*$value))/(stock-$value) from bodegasproductos where idproducto = $key and idbodega = $bodegaorigen) where idproducto=$key and idbodega = $bodegaorigen ;";
                }
                
                $this->db->executeQue($query2);
            }
            $respuesta['res'] = 'si';
            echo json_encode($respuesta);
            unset($_SESSION['remision']);
            unset($_SESSION['cajasesion']);
        } else {
            $respuesta['res'] = 'no';
            echo json_encode($respuesta);
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

    public function getCodigodoc() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRS'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRS' order by 1 desc limit 1";
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
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DRE'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DRE' order by 1 desc limit 1";
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

    public function getRemissionsWarehouse() {
        $idbodega = $this->getUserBodega();
        $query = " select r.estado,
        (select nombreusuario from usuarios where idusuario=r.emisor) as emisor,
        r.idremision,
        d.codigo,
        (select nombrebodega from bodegas where bodegaid= d.idbodega ) as bodegades,
        b.nombrebodega,
        d.fecha
                from   remisiones r,
                       documentos d,
                        bodegas b   
                where  r.iddocumento = d.iddocumento and  
                        r.idbodega   = b.bodegaid  and   
                       r.idbodega    =  $idbodega";
        $consulta = $this->db->executeQue($query);
        $remissionswarehouse;
        while ($row = $this->db->arrayResult($consulta)) {
            $remissionswarehouse[] = array('id' => $row['idremision'],
                'codigo' => $row['codigo'],
                'bodegades' => $row['bodegades'],
                'bodegaori' => $row['nombrebodega'],
                'fecha' => $row['fecha'],
                'emisor' => $row['emisor'],
                'estado' => $row['estado']);
        }
        return $remissionswarehouse;
    }

    public function getDetailsRemissions($idremision) {
        $idbodega = $this->getUserBodega();
        $query = " select  r.estado,
        p.nombreproducto,
        p.referencia,
        bp.stock,
        dd.cantidad,
        dd.costo,
        (dd.costo*dd.cantidad) as total ,
        (select nombrebodega from bodegas where bodegaid= d.idbodega ) as nombrebodega,
        d.fecha,
        (select nombreusuario from usuarios where idusuario=r.emisor) as emisor
                from    remisiones r,
                        detalledocumentos dd ,
                        productos p,
                        bodegasproductos bp,
                        bodegas b ,
                        documentos d  
             where  dd.iddocumento = r.iddocumento and
                    dd.iddocumento = d.iddocumento and
                    dd.idproducto  = p.idproducto  and
                    bp.idproducto  = p.idproducto  and
                     b.bodegaid    = bp.idbodega   and
                      p.estado     = 'activo'      and  
                    bp.idbodega    = $idbodega    and
                     r.idremision  = $idremision";
        $consulta = $this->db->executeQue($query);
        $detailsremissions;
        $detallesremissions2;
        while ($row = $this->db->arrayResult($consulta)) {
            $totalremision = $totalremision + $row['total'];
            $detailsremissions[] = array('id' => $row['idremision'],
                'nombrep' => $row['nombreproducto'],
                'referencia' => $row['referencia'],
                'stock' => $row['stock'],
                'cantidad' => $row['cantidad'],
                'costo' => $row['costo'],
                'total' => $row['total']);
            $detallesremissions2 = array('idremision' => $row['idremision'], 'bodega' => $row['nombrebodega'], 'fecha' => $row['fecha'], 'totalremision' => $totalremision, 'emisor' => $row['emisor'], 'estado' => $row['estado']);
        }
        return $detalles3 = array(0 => $detailsremissions, 1 => $detallesremissions2);
    }

    public function aceptRemission($idremision) {
        $codigo = $this->getCodigodoc2();
        $idbodega = $this->getUserBodega();
        $fecha = date("Y-m-d H:i:s");
        $periodo = $this->getCurrentPeriodo();
        $iddocumento = "nextval('documentos_iddocumento_seq'::regclass)";
        $query = "insert into documentos values($iddocumento,'DRE','$fecha',NULL,'REMISION ENTRADA','$codigo',NULL,$idbodega,'REMISION DE ENTRADA',NULL,NULL,$periodo); ";
        
        $query.="insert into detalledocumentos 
                    select  nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),d.cantidad,d.costo,d.idproducto,
                            (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1 )  
                    from    detalledocumentos d,
                            remisiones r   
                    where   r.iddocumento = d.iddocumento and
                            r.idremision = $idremision;";
        $query.="insert into movimientos 
                    select nextval('movimientos_idmovimiento_seq'::regclass),
                           (select (select idbodegaproductos from  bodegasproductos where idproducto = d.idproducto and idbodega = $idbodega)
                                            from    detalledocumentos d,
                                                    remisiones r        
                                            where   r.iddocumento = d.iddocumento and  
                                                    r.idremision = $idremision limit 1),
                           '$fecha','REMISION ENTRADA',NULL,
                           (select iddocumento from documentos where idbodega=$idbodega order by 1 desc limit 1 ),
                           $idbodega,     
                           (select (select stock+d.cantidad from bodegasproductos where idproducto = d.idproducto and idbodega = $idbodega)
                                            from    detalledocumentos d,
                                                    remisiones r        
                                            where   r.iddocumento = d.iddocumento and  
                                                    r.idremision = $idremision limit 1),
                           (select (select ((costo*stock)+(d.cantidad*d.costo))/(stock+d.cantidad) from bodegasproductos where idproducto = d.idproducto and idbodega = $idbodega)
                                            from    detalledocumentos d,
                                                    remisiones r        
                                            where   r.iddocumento = d.iddocumento and  
                                                    r.idremision = $idremision limit 1);   
                    update  remisiones set estado = 'ACEPTADA' where idremision=$idremision";
        if ($this->db->executeQue($query)) {
            $query2 = " select costo,cantidad,idproducto  
                     from   detalledocumentos d,
                            remisiones r        
                     where  r.iddocumento = d.iddocumento and
                            r.idremision = $idremision ";
            $consulta2 = $this->db->executeQue($query2);
            $variable = 0;
            while ($row = $this->db->arrayResult($consulta2)) {
                $idproducto = $row['idproducto'];
                $cantidad = $row['cantidad'];
                $query3 = "update bodegasproductos set    
                                  stock =($cantidad+stock),
                                  costo = (select (select ((costo*stock)+(d.cantidad*d.costo))/(stock+d.cantidad) from bodegasproductos where idproducto = d.idproducto and idbodega = $idbodega)
                                            from    detalledocumentos d,
                                                    remisiones r        
                                            where   r.iddocumento = d.iddocumento and  
                                                    r.idremision = $idremision limit 1)        
                           where  idbodega   = $idbodega  and
                                  idproducto = $idproducto ";
                $this->db->executeQue($query3);
                $variable++;
            }
            if ($variable > 0) {
                echo json_encode(array("res"=>"si"));
            } else {
               echo json_encode(array("res"=>"no"));
            }
        } else {
            echo json_encode(array("res"=>"no"));
        }
    }

    public function rejectRemission($idremision) {
        $query = "update remisiones set estado='RECHAZADA' where idremision=$idremision";
        if ($this->db->executeQue($query)) {
            echo "<script>parent.message('Se ha rechazado la remisión', 'images/iconos_alerta/ok.png');" .
            "parent.$.fancybox.close();" .
            "parent.setTimeout('location.reload()', 1000);  </script>";
        } else {
            echo "<script>parent.message('No se pudo rechazar la remisión ', 'images/iconos_alerta/error.png');" .
            "parent.setTimeout('location.reload()', 1000);  </script>";
        }
    }
    
     public function validateRemission() {
        $error = "";
        $res = "si";        
        if (sizeof($_SESSION['remision']) != 0) {
            foreach ($_SESSION['remision'] as $value) {
                if ($value == 0) {
                    $error = "Algun producto de la remision tiene cantidad 0";
                    $res = "no";                    
                }
            }
        } else {
            $error = "No existen productos en la remision";
            $res = "no";            
        }
        echo json_encode(array("res"=>$res,"mensaje"=>$error));        
    }
    
    public function getNombreBodega() {
        $idbodega=$this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $row = $this->db->arrayResult($consulta);
        return $row["nombrebodega"];
    }
    
    public function getCantidadBodegas() {        
        $consulta = $this->db->executeQue("select count(*) as cuenta from bodegas");
        $row = $this->db->arrayResult($consulta);
        return $row["cuenta"];
    }

}
?> 
