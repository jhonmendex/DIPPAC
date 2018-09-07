<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
require ('classes/Producto.php');
require ('classes/detalleVenta.php');

class ManPurchaseOrderModel extends ModelBase {

    public function getManPurchaseOrders($idestado, $fechaini, $fechafin) {
        $query = " select * from ventas where estado_venta = '$idestado' and fecha between '$fechaini' and '$fechafin' order by fecha desc ";
        $consulta = $this->db->executeQue($query);
        $ventas;
        while ($row = $this->db->arrayResult($consulta)) {
            $ventas[] = array('id' => $row['idventa'],
                'estado' => $row['estado_venta'],
                'fecha' => $row['fecha'],
                'valor' => $row['precio_venta'],
                'usuario' => $row['idusuario']);
        }
        return $ventas;
    }

    public function primerEstado() {
        return 'espera';
    }

    public function fechaInicial() {
        $fechaactual = date("Y-m-d");
        $hora_actual = strtotime("now");
        $fecha_final = strtotime("-8 days", $hora_actual);
        $fecha_final2 = date("Y-m-d", $fecha_final);
        return $fecha_final2;
    }

    public function fechaFinal() {
        $fechaactual = date("Y-m-d");
        return $fechaactual;
    }

    public function getFacturas($fechaini, $fechafin) {
        $bodega = $this->getUserBodega();
        $query = " select fv.idfactura,fv.consecutivo,v.idventa,fv.seguimiento,fv.fecha,v.idusuario 
                   from   facturaventas fv , 
                          ventas v 
                   where  fv.idventa = v.idventa  and 
                          fv.fecha between '$fechaini' and '$fechafin' and idbodega= $bodega
                          order by fv.fecha desc ";
        $consulta = $this->db->executeQue($query);
        $facturas;
        while ($row = $this->db->arrayResult($consulta)) {
            $info = $this->getdetailfactura($row['idventa']);
            $facturas[] = array('id' => $row['idfactura'],
                'consecutivo' => $row['consecutivo'],
                'idorden' => $row['idventa'],
                'estado' => $row['seguimiento'],
                'fecha' => $row['fecha'],
                'usuario' => $row['idusuario'],
                'subtotal' => $info['subtotal'],
                'iva' => $info['iva']);
        }

        return $facturas;
    }

    private function getdetailfactura($idventa) {
        $query = "select sum(d.precioventa*d.cantidad) subtotal, sum(((p.iva*d.precioventa)/100)*d.cantidad) as iva
        from detalleventas d, productos p 
        where d.idventa=$idventa and d.idproducto=p.idproducto";
        $consulta = $this->db->executeQue($query);
        $row = $this->db->arrayResult($consulta);
        return array('subtotal' => $row['subtotal'], 'iva' => $row['iva']);
    }

    public function getDetails() {
        $idbodega = $this->getUserBodega();
        $venta = $_GET["idventa"];
        $query = "select v.idventa,v.idusuario,v.fecha,v.puntos_venta,v.precio_venta,v.tipoenvio,dv.cantidad, p.iva,
                         p.nombreproducto,p.puntos,p.referencia,p.precioiva,u.nombreusuario,u.idusuario,
                         dv.precioventa, dv.valorpuntodetalle, bp.stock, v.estado_venta
                  from   ventas v,
                         detalleventas dv,
                         productos p,
                         usuarios  u, 
                         bodegasproductos bp                         
                  where       v.idventa  = dv.idventa   and
                          dv.idproducto  = p.idproducto and 
                            u.idusuario  = v.idusuario  and
                              v.idventa  = $venta and
                           dv.idproducto = bp.idproducto and
                             bp.idbodega = $idbodega";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $detalles;
        while ($row = $this->db->arrayResult($consulta)) {
            $detalles[] = array(
                'id' => $row['idventa'],
                'referencia' => $row['referencia'],
                'cantidad' => $row['cantidad'],
                'articulo' => $row['nombreproducto'],
                'stock' => $row['stock'],
                'puntos' => ($row['precioventa'] + (($row['precioventa'] * $row['iva']) / 100)) / $row['valorpuntodetalle'],
                'precioiva' => $row['precioventa'] + (($row['precioventa'] * $row['iva']) / 100));
            $detalles2 = array(
                'usuario' => $row["nombreusuario"],
                'idusuario' => $row["idusuario"],
                'estado' => $row["estado_venta"],
                'norden' => $row["idventa"],
                'fecha' => $row["fecha"],
                'puntos' => $row["puntos_venta"],
                'subtotal' => $subtotal,
                'totalorden' => $row["precio_venta"]
            );
        }
        $detalles3 = array(0 => $detalles, 1 => $detalles2);
        return $detalles3;
    }

    public function getDetailsInvoices() {
        $idfactura = $_GET["idfactura"];
        $query = "select fv.idfactura,v.idventa,fv.consecutivo,v.idusuario,v.fecha,v.puntos_venta,v.precio_venta,v.tipoenvio,dv.cantidad,dv.precioventa,p.iva,
                         p.nombreproducto,p.puntos,p.referencia,p.precioiva,(p.precio*dv.cantidad) as total, u.nombreusuario, fv.seguimiento,dv.valorpuntodetalle
                  from   ventas v,
                         facturaventas fv,
                         detalleventas dv,
                         productos p,
                         usuarios  u
                  where       v.idventa  = dv.idventa   and
                              fv.idventa = v.idventa    and
                          dv.idproducto  = p.idproducto and 
                            u.idusuario  = v.idusuario  and
                           fv.idfactura  = $idfactura";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $detalles;
        while ($row = $this->db->arrayResult($consulta)) {
            $subtotal = $subtotal + ($row['precioventa'] * $row['cantidad']);
            $totaliva = $totaliva + ((($row['precioventa'] * $row['iva']) / 100) * $row['cantidad']);
            $detalles[] = array(                
                'referencia' => $row['referencia'],
                'cantidad' => $row['cantidad'],
                'articulo' => $row['nombreproducto'],
                'puntos' =>  ((($row['precioventa'] * $row['iva']) / 100) + $row['precioventa'])/$row['valorpuntodetalle'],
                'precioiva' => ((($row['precioventa'] * $row['iva']) / 100) + $row['precioventa']),
                'iva' => $row['iva']
            );
            $detalles2 = array(
                'idfactura' => $row["idfactura"],
                'usuario' => $row["nombreusuario"],
                'consecutivo' => $row['consecutivo'],
                'idusuario' => $row["idusuario"],
                'norden' => $row["idventa"],
                'fecha' => $row["fecha"],
                'puntos' => $row["puntos_venta"],
                'subtotal' => $subtotal,
                'totaliva' => $totaliva,
                'totalorden' => $row["precio_venta"],
                'estado' => $row["seguimiento"]
            );
        }
        $detalles3 = array(0 => $detalles, 1 => $detalles2);
        return $detalles3;
    }

    public function verificarDetallesStock($idventa) {
        $idbodega = $this->getUserBodega();
        $query = "select v.idventa,v.idusuario,v.fecha,v.puntos_venta,v.precio_venta,v.tipoenvio,dv.cantidad, p.iva,
                         p.nombreproducto,p.puntos,p.referencia,p.precioiva,u.nombreusuario,u.idusuario,
                         dv.precioventa, dv.valorpuntodetalle, bp.stock, v.estado_venta
                  from   ventas v,
                         detalleventas dv,
                         productos p,
                         usuarios  u, 
                         bodegasproductos bp                         
                  where       v.idventa  = dv.idventa   and
                          dv.idproducto  = p.idproducto and 
                            u.idusuario  = v.idusuario  and
                              v.idventa  = $idventa and
                           dv.idproducto = bp.idproducto and
                             bp.idbodega = $idbodega";
        $consulta = $this->db->executeQue($query);
        $hayexistencias = true;
        while ($row = $this->db->arrayResult($consulta)) {
            if ($row['stock'] - $row['cantidad'] < 0) {
                if ($row['referencia']!="LICINS") {
                    $hayexistencias = false;
                }
            }
        }

        if (!$hayexistencias) {
            echo json_encode(array("respuesta" => "no"));
        } else {
            echo json_encode(array("respuesta" => "si"));
        }
    }

    public function cambiarEstado($estadoorden, $norden) {
        $periodo = $this->getCurrentPeriodo();
        $bodega = $this->getUserBodega();
        $fechahoy = date("Y-m-d");
        $consecutivo = $this->getConsecutivo();
        if ($estadoorden == 'pagado') {
            $query = "insert into facturaventas values (nextval('facturaventas_idfactura_seq'::regclass),$norden,$consecutivo,'por entregar','$fechahoy',$periodo,$bodega);";
            $query.="update ventas set estado_venta = 'pagado' where idventa = $norden; ";
            $query.="update detalleventas set cantidaddevuelta = 0 where idventa = $norden; ";
            if ($this->db->executeQue($query)) {
                $this->updatestock($norden);
                echo json_encode(array("respuesta" => "si", "orden" => $norden));
            } else {
                echo json_encode(array("respuesta" => "no"));
            }
        } else {
            $query = "update ventas set estado_venta = 'anulado', puntos_venta=0, precio_venta=0  where idventa = $norden;
                    update detalleventas set cantidad=0, precioventa=0 where idventa=$norden;";
            if ($this->db->executeQue($query)) {
                echo json_encode(array("respuesta" => "sisi", "orden" => $norden));
            } else {
                echo json_encode(array("respuesta" => "nono"));
            }
        }
    }

    public function updatestock($norden) {
        $query = "select  fv.fecha,p.idproducto,p.precio,dv.cantidad, dv.precioventa,
            dv.iddetalleventa, p.porcentajeutilidad,p.referencia, v.idusuario
                  from   ventas v,
                         detalleventas dv,
                         facturaventas fv, 
                         productos p
                  where       v.idventa   = dv.idventa   and
                             fv.idventa   =  v.idventa   and
                          dv.idproducto   = p.idproducto and 
                              v.idventa   = $norden ";
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $refe = $row['referencia'];
            $usu = $row['idusuario'];
            $iddetalleventa = $row['iddetalleventa'];
            $precioventa = $row['precioventa'];
            $cantidad = $row['cantidad'];
            $idproducto = $row['idproducto'];
            $porutility = $row['porcentajeutilidad'];
            $bodega = $this->getUserBodega();
            $constultafinal = "select * from bodegasproductos where idproducto=$idproducto and idbodega=$bodega";
            $unicoresultado = $this->db->executeQue($constultafinal);
            $fila = $this->db->arrayResult($unicoresultado);
            $stockk = $fila['stock'];
            $costotemporal = $fila['costo'];
            $costo = $stockk - $cantidad == 0 ? 0 : $fila['costo'];
            $fecha = $row['fecha'];
            if ($porutility != 0 || $porutility != "NULL") {
                $porcentaje = $porutility;
            } else {
                $porcentaje = 100;
            }
            $utilidadtotaltmp = $precioventa - $costotemporal;
            $utilidadtotal = ($utilidadtotaltmp * $porcentaje) / 100;
            // $nivel0 = ($utilidadtotal * 12) / 100;
            // $nivel1 = ($utilidadtotal * 7) / 100;
            // $nivel2 = ($utilidadtotal * 15) / 100;
            // $nivel3 = ($utilidadtotal * 8) / 100;
            // $niveln = ($utilidadtotal * 3) / 100;
            $nivel0 = 0;   
            $nivel1 = 0;
            $nivel2 = 0;  
            $nivel3 = 0;
            $niveln = 0;
            if ($refe == "LICINS") {  
                $activarcon = "update detalleventas set nivel0=0, nivel1=0, nivel2=0, nivel3=0, niveli =0
                                    where idproducto = $idproducto and idventa = $norden and iddetalleventa=$iddetalleventa;";
                $activarcon .= "update usuarios set idestado = 2 where idusuario = $usu";
                $this->db->executeQue($activarcon);
            } else {
                $query2 = "update detalleventas set nivel0=$nivel0, nivel1=$nivel1, nivel2=$nivel2, nivel3=$nivel3, niveli =$niveln
                                    where idproducto = $idproducto and idventa = $norden and iddetalleventa=$iddetalleventa;
                        
                        update detalleventas set costoalfacturar=(select costo from bodegasproductos where idproducto = $idproducto and idbodega = $bodega)
                            where idproducto = $idproducto and idventa = $norden and iddetalleventa=$iddetalleventa;";
                $query2 .= "update bodegasproductos set    
                                    stock = stock - $cantidad, costo= $costo 
                                    where idproducto = $idproducto and idbodega = $bodega;";
                $query2 .= "insert into movimientos values(nextval('movimientos_idmovimiento_seq'::regclass),
                                     (select idbodegaproductos from  bodegasproductos where idproducto = $idproducto and idbodega = $bodega),
                                      '$fecha','VENTAS',(select idfactura from facturaventas where idventa = $norden and idbodega = $bodega),
                                   NULL,$bodega,(select stock from bodegasproductos where idproducto = $idproducto and idbodega = $bodega),
                                       $costo);";
                $this->db->executeQue($query2);
            }
        }
    }

    public function cambiarEstadoFactura($estadofactura, $nfactura, $idfactura) {
        $bodega = $this->getUserBodega();
        $query.="update facturaventas set seguimiento = '$estadofactura' where consecutivo = $nfactura and idbodega = $bodega ";
        if ($this->db->executeQue($query)) {
            echo json_encode(array("respuesta" => "si", "Nofact" => $idfactura, "estadofact" => $estadofactura));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
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
