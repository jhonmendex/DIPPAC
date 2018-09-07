<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class StockMovementsModel extends ModelBase {

    public function getMovements($fechainicial, $fechafinal, $referencia) {
        $idproducto = $this->traeridproducto($referencia);
        $idbodega = $this->getUserBodega();
        $granconsulta = "select * from movimientos m, bodegasproductos 
                        bp where bp.idproducto=$idproducto and 
                        m.idbodegasproductos=bp.idbodegaproductos and
                        m.idbodega=$idbodega
                        order by m.idmovimiento asc";
        $resultado = $this->db->executeQue($granconsulta);
        $movimientos;
        while ($fila = $this->db->arrayResult($resultado)) {
            $idmovimiento = $fila['idmovimiento'];
            if ($fila['idfacturaventa']) {
                $query = "SELECT m.idfacturaventa,m.fecha,m.tipomovimiento,m.saldostock,m.costo,dv.cantidad,p.referencia,fv.consecutivo, dv.costoalfacturar
                FROM movimientos m, 
                     facturaventas fv, 
                     ventas v, 
                     detalleventas dv,  
                     productos p,   
                     bodegasproductos bp
                WHERE 
                m.idmovimiento       = $idmovimiento        AND
                m.idfacturaventa     = fv.idfactura         AND
                fv.idventa           = v.idventa            AND
                dv.idventa           = v.idventa            AND
                m.idbodegasproductos = bp.idbodegaproductos AND                
                p.idproducto         = bp.idproducto        AND
                p.idproducto         = $idproducto          AND
                dv.idproducto        = $idproducto          AND
                p.estado             = 'activo'             AND 
                bp.idbodega          = $idbodega            AND          
                m.fecha between '$fechainicial' AND '$fechafinal'";
                $consulta = $this->db->executeQue($query);
                $row = $this->db->arrayResult($consulta);
                $movimientos[] = array('fecha' => $row['fecha'],
                    'documento' => 'FV.' . $row['consecutivo'],
                    'tmovimiento' => $row['tipomovimiento'],
                    'cantidad' => $row['cantidad'],                    
                    'vrunitario' => $row['costoalfacturar'],
                    'vrtotalsalida' => $row["costoalfacturar"] * $row['cantidad'],
                    'saldo' => $row['saldostock'],
                    'saldocosto' => $row['costo'],
                    'vrtotalsaldo' => $row['saldostock'] * $row['costo']);
            } else if ($fila['idocumento'] && ($fila['tipomovimiento'] == 'COMPRAS' || $fila['tipomovimiento'] == 'DEVOLUCION EN VENTAS' || $fila['tipomovimiento'] == 'REMISION ENTRADA' || $fila['tipomovimiento'] == 'AJU.INV.FIS.EN'|| $fila['tipomovimiento'] == 'REORGANIZACION PRODUCTO ENTRADA')) {
                $query = "SELECT m.idocumento,m.fecha,m.tipomovimiento,m.saldostock,m.costo,
                dd.cantidad,dd.costo as costosalida, d.prefijo, d.codigo
                FROM movimientos m, 
                     documentos d,                      
                     detalledocumentos dd,  
                     productos p,   
                     bodegasproductos bp
                WHERE 
                m.idmovimiento       = $idmovimiento        AND
                m.idocumento         = d.iddocumento        AND                
                dd.iddocumento       = d.iddocumento        AND
                m.idbodegasproductos = bp.idbodegaproductos AND                
                p.idproducto         = bp.idproducto        AND
                p.idproducto         = $idproducto          AND
                dd.idproducto        = $idproducto          AND
                p.estado             = 'activo'             AND 
                bp.idbodega          = $idbodega            AND          
                m.fecha between '$fechainicial' AND '$fechafinal'";
                $consulta = $this->db->executeQue($query);
                $row = $this->db->arrayResult($consulta);
                $movimientos[] = array('fecha' => $row['fecha'],
                    'documento' => $row['prefijo'] . '.' . $row['codigo'],
                    'tmovimiento' => $row['tipomovimiento'],
                    'cantidadentrada' => $row['cantidad'],
                    'vrunitarioentrada' => $row['costosalida'],
                    'vrtotalentrada' => $row["costosalida"] * $row['cantidad'],
                    'saldo' => $row['saldostock'],
                    'saldocosto' => $row['costo'],
                    'vrtotalsaldo' => $row['saldostock'] * $row['costo']);
            } else if ($fila['idocumento'] && ($fila['tipomovimiento'] == 'RET.PERDIDA' || $fila['tipomovimiento'] == 'RET.CONSUMO' || $fila['tipomovimiento'] == 'DEVOLUCION EN COMPRAS' || $fila['tipomovimiento'] == 'REMISION SALIDA' || $fila['tipomovimiento'] == 'AJU.INV.FIS.SA'|| $fila['tipomovimiento'] == 'REORGANIZACION PRODUCTO SALIDA'|| $fila['tipomovimiento'] == 'RET.DONACION')) {
                $query = "SELECT m.idocumento,m.fecha,m.tipomovimiento,m.saldostock,m.costo,
                dd.cantidad,dd.costo as costosalida, d.prefijo, d.codigo
                FROM movimientos m, 
                     documentos d,                      
                     detalledocumentos dd,  
                     productos p,   
                     bodegasproductos bp
                WHERE 
                m.idmovimiento       = $idmovimiento        AND
                m.idocumento         = d.iddocumento        AND                
                dd.iddocumento       = d.iddocumento        AND
                m.idbodegasproductos = bp.idbodegaproductos AND                
                p.idproducto         = bp.idproducto        AND
                p.idproducto         = $idproducto          AND
                dd.idproducto        = $idproducto          AND
                p.estado             = 'activo'             AND 
                bp.idbodega          = $idbodega            AND          
                m.fecha between '$fechainicial' AND '$fechafinal'";
                $consulta = $this->db->executeQue($query);
                $row = $this->db->arrayResult($consulta);
                $movimientos[] = array('fecha' => $row['fecha'],
                    'documento' => $row['prefijo'] . '.' . $row['codigo'],
                    'tmovimiento' => $row['tipomovimiento'],
                    'cantidad' => $row['cantidad'],
                    'vrunitario' => $row['costosalida'],
                    'vrtotalsalida' => $row["costosalida"] * $row['cantidad'],
                    'saldo' => $row['saldostock'],
                    'saldocosto' => $row['costo'],
                    'vrtotalsaldo' => $row['saldostock'] * $row['costo']);
            }
        }
        return $movimientos;
    }

    public function traeridproducto($referencia) {
        $query = "select idproducto from productos where referencia = '$referencia' and estado = 'activo'";
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $idproducto = $row["idproducto"];
        }
        return $idproducto;
    }

    public function traernombreproducto($referencia) {
        $query = "select nombreproducto from productos where referencia = '$referencia' and estado = 'activo'";
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $nomproducto = $row["nombreproducto"];
        }
        return $nomproducto;
    }

    public function fechaInicial() {
        $hora_actual = strtotime("now");
        $fecha_final = strtotime("-30 days", $hora_actual);
        $fechainicial = date("Y-m-d", $fecha_final);
        return $fechainicial;
    }

    public function fechaFinal() {
        $fechafinal = date("Y-m-d");
        return $fechafinal;
    }

    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

}

?>
