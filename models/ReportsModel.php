<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
 
class ReportsModel extends ModelBase { 
 
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

    public function getWareHouse() {   
        $idbodega = $this->getUserBodega();
        $usuario = $this->validarUsuario();
        if($usuario == true) {     
         $query = "SELECT * from bodegas order by nombrebodega asc";   
        }     
        else{     
         $query = "SELECT * from bodegas where bodegaid=$idbodega order by nombrebodega asc";   
        }
        $consulta = $this->db->executeQue($query);
        $bodegas;
        while ($row = $this->db->arrayResult($consulta)) {
            $bodegas[] = array('id' => $row['bodegaid'],
                'nombre' => $row['nombrebodega']);  
        }    
        return $bodegas;  
    } 
    
    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }
    
      public function getUserId() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getIdUser();
    }
     
     public function validarUsuario(){
        $idusuario=$this->getUserId();
        $query="select perfil from usuarios where idusuario=$idusuario"; 
        $consulta  = $this->db->executeQue($query);
        $perfil    = $this->db->arrayResult($consulta);
        $perfil2= $perfil["perfil"]; 
        $query2="select grupo from perfiles where idperfil = $perfil2";
        $consulta3  = $this->db->executeQue($query2);
        $grupo    = $this->db->arrayResult($consulta3);
        if($grupo['grupo']=='Superadministrador'){      
         $sadministrador = true;  
        }else{         
         $sadministrador = false;   
        }          
        return $sadministrador; 
     }
      
     public function resumenSaldos($idbodega,$idcategoria){
      $resumens; 
      $bodegas;
      $productos;
      if($idcategoria=='todasc' && $idbodega=='todasb'){
           $query="select * from bodegas";   
           $consulta  = $this->db->executeQue($query); 
            while ($row = $this->db->arrayResult($consulta)) 
            {      
               $query2="select p.idproducto,p.nombreproducto,p.referencia,bp.costo,bp.stock,(bp.stock*bp.costo) as stockxcosto
                        from  productos p, bodegasproductos bp, categoriasp c 
                        where p.idproducto  = bp.idproducto and 
                              p.idcategoria = c.idcategoria and 
                              bp.idbodega = ".$row['bodegaid']; 
               $consulta2  = $this->db->executeQue($query2); 
               while ($row2 = $this->db->arrayResult($consulta2)) 
                 { 
                  $bodegas[$row['bodegaid']]['productos'][] = array('id' => $row2['idproducto'], 
                      'nombre'     => $row2['nombreproducto'],
                      'referencia' => $row2['referencia'],
                      'stock' => $row2['stock'], 
                      'stockxcosto' => $row2['stockxcosto'],
                      'costo' => $row2['costo']);    
                  $totales[$row['bodegaid']] +=  $row2['stockxcosto'];   
                  $totales2[$row['bodegaid']] +=  $row2['stock'];   
                 }
                  $bodegas[$row['bodegaid']]['nombrebodega']=$row['nombrebodega'];    
            } 
      }
      else if($idcategoria=="todasc" && $idbodega!='todasb'){  
           $query="select * from bodegas where bodegaid=$idbodega"; 
           $consulta  = $this->db->executeQue($query); 
            while ($row = $this->db->arrayResult($consulta)) 
            {      
               $query2="select p.idproducto,p.nombreproducto,p.referencia,bp.costo,bp.stock,(bp.stock*bp.costo) as stockxcosto
                        from  productos p, bodegasproductos bp, categoriasp c 
                        where p.idproducto  = bp.idproducto and 
                              p.idcategoria = c.idcategoria and 
                              bp.idbodega = ".$row['bodegaid']; 
               $consulta2  = $this->db->executeQue($query2); 
               while ($row2 = $this->db->arrayResult($consulta2)) 
                 { 
                  $bodegas[$row['bodegaid']]['productos'][] = array('id' => $row2['idproducto'], 
                      'nombre'     => $row2['nombreproducto'],
                      'referencia' => $row2['referencia'],
                      'stock' => $row2['stock'], 
                      'stockxcosto' => $row2['stockxcosto'],
                      'costo' => $row2['costo']);    
                  $totales[$row['bodegaid']] +=  $row2['stockxcosto'];   
                  $totales2[$row['bodegaid']] +=  $row2['stock'];   
                 }
                  $bodegas[$row['bodegaid']]['nombrebodega']=$row['nombrebodega'];    
            }   
      }   
      else if($idcategoria!="todasc" && $idbodega!='todasb'){ 
           $query="select * from bodegas where bodegaid = $idbodega";
           $consulta  = $this->db->executeQue($query); 
            while ($row = $this->db->arrayResult($consulta)) 
            {       
               $query2="select p.idproducto,p.nombreproducto,p.referencia,bp.costo,bp.stock,(bp.stock*bp.costo) as stockxcosto
                        from  productos p, bodegasproductos bp, categoriasp c 
                        where p.idproducto  = bp.idproducto and 
                              p.idcategoria = c.idcategoria and
                              p.idcategoria = $idcategoria  and
                              bp.idbodega = ".$row['bodegaid']; 
               $consulta2  = $this->db->executeQue($query2); 
               while ($row2 = $this->db->arrayResult($consulta2)) 
                 { 
                  $bodegas[$row['bodegaid']]['productos'][] = array('id' => $row2['idproducto'], 
                      'nombre'     => $row2['nombreproducto'],
                      'referencia' => $row2['referencia'],
                      'stock' => $row2['stock'], 
                      'stockxcosto' => $row2['stockxcosto'],
                      'costo' => $row2['costo']);    
                  $totales[$row['bodegaid']] +=  $row2['stockxcosto'];   
                  $totales2[$row['bodegaid']] +=  $row2['stock'];   
                 }  
                  $bodegas[$row['bodegaid']]['nombrebodega']=$row['nombrebodega'];
            }      
      }   
      else if($idbodega=='todasb' && $idcategoria !='todasc'){ 
           $query="select * from bodegas";
           $consulta  = $this->db->executeQue($query); 
            while ($row = $this->db->arrayResult($consulta)) 
            {      
               $query2="select p.idproducto,p.nombreproducto,p.referencia,bp.costo,bp.stock,(bp.stock*bp.costo) as stockxcosto
                        from  productos p, bodegasproductos bp, categoriasp c 
                        where p.idproducto  = bp.idproducto and 
                              p.idcategoria = c.idcategoria and
                              p.idcategoria = $idcategoria  and
                              bp.idbodega = ".$row['bodegaid']; 
               $consulta2  = $this->db->executeQue($query2); 
               while ($row2 = $this->db->arrayResult($consulta2)) 
                 { 
                  $bodegas[$row['bodegaid']]['productos'][] = array('id' => $row2['idproducto'], 
                      'nombre'     => $row2['nombreproducto'],
                      'referencia' => $row2['referencia'],
                      'stock' => $row2['stock'], 
                      'stockxcosto' => $row2['stockxcosto'],
                      'costo' => $row2['costo']);    
                  $totales[$row['bodegaid']] +=  $row2['stockxcosto'];   
                  $totales2[$row['bodegaid']] +=  $row2['stock'];   
                 }
                  $bodegas[$row['bodegaid']]['nombrebodega']=$row['nombrebodega'];
                  
            }      
       }  
      $resumens = array(0 => $bodegas,1=>$totales,2=>$totales2);
     return $resumens;          
     }
     
     public function reporteVentas($idbodega, $finicial, $ffinal) {
        if ($idbodega == 'todasb') {  
            $query = "select * from bodegas";
            $consulta = $this->db->executeQue($query);
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = " SELECT fv.consecutivo,fv.idventa, SUM(dv.precioventa*dv.cantidad) AS subtotal,fv.idbodega,fv.fecha
                        FROM   facturaventas fv, detalleventas dv
                        WHERE  fv.idventa  = dv.idventa  AND   
                               fv.fecha between '$finicial' AND '$ffinal'  AND
                               fv.idbodega = " . $row['bodegaid'] . "
                        GROUP  BY fv.idventa,fv.consecutivo,fv.idbodega,fv.fecha order by 1 asc";
                $consulta2 = $this->db->executeQue($query2);
                while ($row2 = $this->db->arrayResult($consulta2)) {  
                    $ventas[$row['bodegaid']]['productos'][] = array(
                        'id' => $row2['idventa'],  
                        'consecutivo' => $row2['consecutivo'], 
                        'subtotal' => $row2['subtotal'],
                        'fecha' => $row2['fecha']); 
                    $totales[$row['bodegaid']] += $row2['subtotal'];   
                    $query3="select p.iva,sum(((dv.precioventa*p.iva)/100)*dv.cantidad) as piva
                            from    detalleventas dv,   
                                    productos p     
                            where   dv.idproducto = p.idproducto and
                                       p.iva  not in(0) and
                                       dv.idventa = ".$row2['idventa']."
                           GROUP BY  p.iva"; 
                    $consulta3 = $this->db->executeQue($query3);   
                    while($row3 = $this->db->arrayResult($consulta3)){     
                     $detalles[$row2['idventa']][]= array('iddetalle' => $row3['iva'],'piva' => $row3['piva']); 
                     
                    }
                }
                $ventas[$row['bodegaid']]['nombrebodega'] = $row['nombrebodega'];
            }
        } else {
            $query = "select * from bodegas where bodegaid =$idbodega";
            $consulta = $this->db->executeQue($query);
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = " SELECT fv.consecutivo,fv.idventa, sum(dv.precioventa*dv.cantidad) as subtotal,fv.idbodega,fv.fecha
                        FROM   facturaventas fv, detalleventas dv
                        WHERE  fv.idventa  = dv.idventa  AND 
                               fv.fecha between '$finicial' AND '$ffinal'  AND
                               fv.idbodega = " . $row['bodegaid'] . "
                        GROUP  BY fv.idventa,fv.consecutivo,fv.idbodega,fv.fecha order by 1 asc";
                $consulta2 = $this->db->executeQue($query2);
                while ($row2 = $this->db->arrayResult($consulta2)) {
                    $ventas[$row['bodegaid']]['productos'][] = array(
                        'id' => $row2['idventa'],  
                        'consecutivo' => $row2['consecutivo'],
                        'subtotal' => $row2['subtotal'],
                        'fecha' => $row2['fecha']); 
                    $totales[$row['bodegaid']] += $row2['subtotal'];    
                    $query3="select p.iva,sum(((dv.precioventa*p.iva)/100)*dv.cantidad) as piva
                            from    detalleventas dv,   
                                    productos p     
                            where   dv.idproducto = p.idproducto and
                                       p.iva  not in(0) and
                                       dv.idventa = ".$row2['idventa']."
                           GROUP BY  p.iva";  
                    $consulta3 = $this->db->executeQue($query3);  
                    while($row3 = $this->db->arrayResult($consulta3)){     
                     $detalles[$row2['idventa']][]= array('iddetalle' => $row3['iva'],'piva' => $row3['piva']); 
                     $totales2[$row['bodegaid']] += $row3['piva'];  
                    }
                }
                $ventas[$row['bodegaid']]['nombrebodega'] = $row['nombrebodega'];
            }
        }
        $reportev = array(0 => $ventas, 1 => $totales, 2 => $totales2,3=>$detalles);
        return $reportev;  
    }
      
    public function bodegaDefecto(){
       $idbodega = $this->getUserBodega();
       return $idbodega; 
    } 
    
    public function categoriaDefecto(){  
       $query="select * from categoriasp order by nombrecategoria asc limit 1";
       $consulta = $this->db->executeQue($query);
       $row = $this->db->arrayResult($consulta);
       $idcategoria = $row['idcategoria'];  
       return $idcategoria;   
    }    
      
     public function reporteCompras($idbodega, $finicial, $ffinal) {
        if ($idbodega == 'todasb') {   
            $query = "select * from bodegas";
            $consulta = $this->db->executeQue($query);
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = " SELECT D.CODIGO,D.IDDOCUMENTO,SUM(DD.COSTO*DD.CANTIDAD) AS SUBTOTAL, D.IDBODEGA,D.FECHA
                            FROM   DOCUMENTOS D,
                                   DETALLEDOCUMENTOS DD
                            WHERE  D.IDDOCUMENTO = DD.IDDOCUMENTO AND
                                   D.FECHA BETWEEN '$finicial' AND '$ffinal'  AND
                                   D.IDBODEGA = " . $row['bodegaid'] . "
                                   AND D.TIPODOCUMENTO='COMPRAS'
                            GROUP  BY D.CODIGO,D.IDDOCUMENTO,D.IDBODEGA,D.FECHA 
                            ORDER  BY D.FECHA ASC";
                $consulta2 = $this->db->executeQue($query2);
                while ($row2 = $this->db->arrayResult($consulta2)) {  
                    $ventas[$row['bodegaid']]['productos'][] = array(
                        'id' => $row2['iddocumento'],  
                        'Nfactura' => $row2['codigo'], 
                        'subtotal' => $row2['subtotal'],
                        'fecha' => $row2['fecha']); 
                    $totales[$row['bodegaid']] += $row2['subtotal'];   
                    $query3="   SELECT   P.IVA,SUM(((DD.COSTO*P.IVA)/100)*DD.CANTIDAD) AS PIVA
                                FROM     DETALLEDOCUMENTOS DD,
                                         PRODUCTOS P
                                WHERE    DD.IDPRODUCTO = P.IDPRODUCTO AND
                                         P.IVA NOT IN(0) AND   
                                         DD.IDDOCUMENTO =  ".$row2['iddocumento']."    
                                GROUP BY P.IVA"; 
                    $consulta3 = $this->db->executeQue($query3);   
                    while($row3 = $this->db->arrayResult($consulta3)){      
                     $detalles[$row2['iddocumento']][]= array('iddetalle' => $row3['iva'],'piva' => $row3['piva']); 
                     
                    }
                }
                $ventas[$row['bodegaid']]['nombrebodega'] = $row['nombrebodega'];
            }
        } else {
            $query = "select * from bodegas where bodegaid =$idbodega";
            $consulta = $this->db->executeQue($query);
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = "SELECT D.CODIGO,D.IDDOCUMENTO,SUM(DD.COSTO*DD.CANTIDAD) AS SUBTOTAL, D.IDBODEGA,D.FECHA
                            FROM   DOCUMENTOS D,
                                   DETALLEDOCUMENTOS DD                                   
                            WHERE  D.IDDOCUMENTO = DD.IDDOCUMENTO AND                                   
                                   D.FECHA BETWEEN '$finicial' AND '$ffinal'  AND
                                   D.IDBODEGA = " . $row['bodegaid'] . " AND 
                                   D.TIPODOCUMENTO='COMPRAS'
                            GROUP  BY D.CODIGO,D.IDDOCUMENTO,D.IDBODEGA,D.FECHA 
                            ORDER  BY D.FECHA ASC";
                $consulta2 = $this->db->executeQue($query2);
                while ($row2 = $this->db->arrayResult($consulta2)) {
                    $ventas[$row['bodegaid']]['productos'][] = array(
                        'id' => $row2['iddocumento'],  
                        'Nfactura' => $row2['codigo'],
                        'subtotal' => $row2['subtotal'],
                        'fecha' => $row2['fecha']); 
                    $totales[$row['bodegaid']] += $row2['subtotal'];    
                    $query3="   SELECT   P.IVA,SUM(((DD.COSTO*P.IVA)/100)*CANTIDAD) AS PIVA
                                FROM     DETALLEDOCUMENTOS DD,
                                         PRODUCTOS P
                                WHERE    DD.IDPRODUCTO = P.IDPRODUCTO AND
                                         P.IVA NOT IN(0) AND   
                                         DD.IDDOCUMENTO =  ".$row2['iddocumento']."    
                                GROUP BY P.IVA";    
                    $consulta3 = $this->db->executeQue($query3);  
                    while($row3 = $this->db->arrayResult($consulta3)){     
                     $detalles[$row2['iddocumento']][]= array('iddetalle' => $row3['iva'],'piva' => $row3['piva']); 
                     $totales2[$row['bodegaid']] += $row3['piva'];  
                    }
                }
                $ventas[$row['bodegaid']]['nombrebodega'] = $row['nombrebodega'];
            } 
        }
        $reportev = array(0 => $ventas, 1 => $totales, 2 => $totales2,3=>$detalles);
        return $reportev;  
    }    
}
?>
