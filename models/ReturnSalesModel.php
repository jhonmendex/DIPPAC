<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
require ('classes/Producto.php');
require ('classes/detalleVenta.php');

class ReturnSalesModel extends ModelBase {

    public function getFacturas() {
        $bodega = $this->getUserBodega();
        $query = " select fv.idfactura,fv.consecutivo,fv.fecha,v.precio_venta,v.idusuario,u.nombreusuario,v.idventa 
                   from   facturaventas fv , 
                          ventas v,
                          usuarios u   
                   where  fv.idventa = v.idventa   and 
                         v.idusuario = u.idusuario and 
                         fv.idbodega = $bodega";
        $consulta = $this->db->executeQue($query);
        $facturas;
        while ($row = $this->db->arrayResult($consulta)) {
             $info = $this->getdetailfactura($row['idventa']);
            $facturas[] = array('codigo' => $row['idfactura'],
                'id' => $row['consecutivo'],
                'fecha' => $row['fecha'],
                'valor' => $row['precio_venta'],
                'usuario' => $row['idusuario'],
                'nomusuario' => $row['nombreusuario'],
                 'subtotal' => $info['subtotal'],
                'iva' => $info['iva'],
                'referencia' => $info['referencia']
            );
        }
        return $facturas;
    }
    
    private function getdetailfactura($idventa) {
        $query = "select sum(d.precioventa*d.cantidad) subtotal, sum(((p.iva*d.precioventa)/100)*d.cantidad) as iva
        from detalleventas d, productos p 
        where d.idventa=$idventa and d.idproducto=p.idproducto";
        $consulta = $this->db->executeQue($query);
        $row = $this->db->arrayResult($consulta);
        
        $query2 = "select p.referencia
        from detalleventas d, productos p 
        where d.idventa=$idventa and d.idproducto=p.idproducto limit 1";
        $consulta2 = $this->db->executeQue($query2);
        $row2 = $this->db->arrayResult($consulta2);
        return array('subtotal' => $row['subtotal'], 'iva' => $row['iva'], 'referencia' => $row2['referencia']);
    }

    public function getDetailsInvoices() {
        $idfactura = $_GET["idfactura"];
        $codigo = $_GET["codigo"];
        $bodega = $this->getUserBodega();
        $query = "select dv.iddetalleventa,fv.idfactura,v.idventa,fv.consecutivo,v.idusuario,v.fecha,v.puntos_venta,v.precio_venta,v.tipoenvio,dv.cantidad,dv.precioventa,dv.precioventa,p.iva,
                         p.nombreproducto,p.unidadmedida,p.puntos,p.referencia,p.precioiva,(p.precio*dv.cantidad) as total,p.idproducto,u.nombreusuario,u.idusuario,       
                         coalesce((  
                            select sum(cantidad) 
                            from   detalledocumentos dc, 
                                documentos d  
                            where  dc.iddocumento = d.iddocumento and 
                                    dc.idproducto = p.idproducto  and
                                    d.idfactura = $codigo),0)as cantdev  
                  from   ventas v, 
                         facturaventas fv,  
                         detalleventas dv, 
                         productos p,     
                         usuarios  u    
                  where       v.idventa  = dv.idventa   and
                              fv.idventa = v.idventa    and
                          dv.idproducto  = p.idproducto and 
                            u.idusuario  = v.idusuario  and
                            fv.idbodega  =  $bodega     and 
                            fv.consecutivo  = $idfactura ;";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $detalles;
        while ($row = $this->db->arrayResult($consulta)) {
            $subtotal = $subtotal + ($row['precioventa'] * $row['cantidad']);
            $totaliva = $totaliva + ((($row['precioventa'] * $row['iva']) / 100) * $row['cantidad']);            
            $detalles[] = array(
                'id' => $row['idventa'],
                'iddetalle' => $row['iddetalleventa'],
                'referencia' => $row['referencia'],
                'unidad' => $row['unidadmedida'],
                'cantidad' => $row['cantidad'],
                'articulo' => $row['nombreproducto'],
                'puntos' => $row['puntos'],
                'precioiva' => $row['iva'] == 0 ? $row['precioventa'] : ((($row['precioventa'] * $row['iva']) / 100) + $row['precioventa']),
                'idproducto' => $row['idproducto'],
                'cantdev' => $row['cantdev']
            );
            $detalles2 = array(
                'usuario' => $row["nombreusuario"],
                'consecutivo' => $row['consecutivo'],
                'idusuario' => $row["idusuario"],
                'norden' => $row["idventa"],
                'fecha' => $row["fecha"],
                'puntos' => $row["puntos_venta"],
                'subtotal' => $subtotal,
                'totaliva' => $totaliva,
                'totalorden' => $row["precio_venta"]
            );
        }
        $detalles3 = array(0 => $detalles, 1 => $detalles2);
        return $detalles3;
    }

    public function registrarDevolucion($idfactura) {
        $bodega = $this->getUserBodega();
        $fecha = date("Y-m-d");
        $periodo = $this->getCurrentPeriodo();
        $codigo = $this->getCodigodoc();
        $rap=$this->db->executeQue("select * from detalleventas d, facturaventas f where d.idventa=f.idventa and d.idproducto=972");
        $iddocumento = "nextval('documentos_iddocumento_seq'::regclass)";
        $query = "insert into documentos values ($iddocumento,'DV','$fecha',NULL,'DEVOLUCION',$codigo,NULL,$bodega,'DEVOLUCION EN VENTA',NULL,$idfactura,$periodo)";
        if ($this->db->executeQue($query)) {
            foreach ($_SESSION['devolucion'] as $key => $value) {
                $query2 = "insert into detalledocumentos values(nextval('detalledocumentos_iddetallecodumentos_seq'::regclass),$value,(select costo from bodegasproductos where idproducto = $key and idbodega = $bodega),$key,(select iddocumento from documentos where idbodega=$bodega order by 1 desc limit 1)); ";
                $query2.="insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),(select idbodegaproductos from  bodegasproductos where idproducto = $key and idbodega = $bodega),'$fecha','DEVOLUCION EN VENTAS',NULL, 
         (select iddocumento from documentos where idbodega=$bodega order by 1 desc limit 1),$bodega,
         (select ($value+stock) from bodegasproductos where idproducto = $key and idbodega = $bodega),   
         (select ((costo*$value)+(stock*costo))/($value+stock) from bodegasproductos where idproducto = $key and idbodega = $bodega)) ;";
                $query2.="update bodegasproductos set stock = (stock+$value), costo = (select ((costo*$value)+(stock*costo))/($value+stock) from bodegasproductos where idproducto = $key and idbodega = $bodega) where idproducto=$key and idbodega = $bodega;";
                $query2.="update 
                    detalleventas 
                    set cantidaddevuelta=$value 
                    where iddetalleventa=(select iddetalleventa from detalleventas d, facturaventas f where d.idventa=f.idventa and d.idproducto=$key and f.idfactura=$idfactura);";
                $query2.="update 
                    ventas 
                    set puntos_venta=(select (v.puntos_venta-(((d.precioventa+((d.precioventa*p.iva)/100))/d.valorpuntodetalle)*d.cantidaddevuelta)) from detalleventas d, facturaventas f, ventas v, productos p where d.idventa=f.idventa and d.idproducto=$key and p.idproducto=d.idproducto and v.idventa=d.idventa and f.idfactura=$idfactura)
                    where idventa=(select idventa from facturaventas where idfactura=$idfactura)";
                $consulta2 = $this->db->executeQue($query2);
            }
            echo json_encode(array("res"=>"si"));            
        } else {
            echo json_encode(array("res"=>"no"));          
        }
        unset($_SESSION['devolucion']);
    }

    public function getCodigodoc() {
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos where idbodega = $idbodega and prefijo= 'DV'";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select codigo+1 as consecutivo from documentos where idbodega= $idbodega and prefijo= 'DV' order by 1 desc limit 1";
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

    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

    public function getConsecutivo() {
        $idbodega = $this->getUserBodega();
        $query = "select * from facturaventas where idbodega = $idbodega";
        $consulta = $this->db->executeQue($query);
        if ($row = $this->db->arrayResult($consulta)) {
            $query2 = "select consecutivo+1 as consecutivo from facturaventas where idbodega= $idbodega  order by 1 desc limit 1";
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $consecutivo = $row['consecutivo'];
            }
        } else {
            $consecutivo = 1;
        }
        return $consecutivo;
    }
    
     public function getNombrebodega() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $file = $this->db->arrayResult($consulta);
        return $file["nombrebodega"];
    }

}

?>
 