<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class RetirosModel extends ModelBase {

    public function addItemToSession() {
        $referencia = trim($_POST['idpro']);
        $consulta = "select * from productos where referencia='$referencia' and estado='activo'";
        $resultado = $this->db->executeQue($consulta);
        if ($this->db->numRows($resultado) != 0) {
            $producto = $this->db->arrayResult($resultado);
            $idbodega = $this->getUserBodega();
            $idproducto = $producto['idproducto'];
            $consulta2 = "select * from bodegasproductos where idproducto=$idproducto and idbodega=$idbodega";
            $resultado2 = $this->db->executeQue($consulta2);
            $prostock = $this->db->arrayResult($resultado2);
            if ($prostock['stock'] != 0) {
                if (isset($_SESSION['retirosesion'][$idproducto])) {
                    $respuesta['res'] = "no";
                    $respuesta['mess'] = "Producto ya esta en la orden";
                    echo json_encode($respuesta);
                } else {
                    $item = $_SESSION['retirosesion'][$idproducto] = array('id' => $producto['idproducto'],
                        'referencia' => $producto['referencia'],
                        'nombre' => $producto['nombreproducto'],
                        'unidad' => $producto['unidadmedida'],
                        'stock' => $prostock['stock'],
                        'costo' => $prostock['costo'],
                        'verify' => strrev(urlencode(base64_encode($producto['idproducto']))),
                        'code' => sha1($producto['idproducto']),
                        'costoformato'=> number_format($prostock['costo'],2,",","."));
                    $respuesta['res'] = "si";
                    $respuesta['pro'] = $item;
                    echo json_encode($respuesta);
                }
            } else {
                $respuesta['res'] = "no";
                $respuesta['mess'] = "No hay existencias del producto";
                echo json_encode($respuesta);
            }
        } else {
            $respuesta['res'] = "no";
            $respuesta['mess'] = "No existe el producto";
            echo json_encode($respuesta);
        }
    }

    public function updateItem(){
        $cantidad=trim($_POST['cant']);
        $_SESSION['retirosesion'][$_POST['idpro']]['cantidadRetirar']=$cantidad;
        $costototal=number_format($cantidad*$_SESSION['retirosesion'][$_POST['idpro']]['costo'],2,",",".");
        $respuesta['costo']=$costototal;
        echo json_encode($respuesta);
    }
    
    public function deleteItemToSession() {
        if (isset($_POST["verify"])) {
            $itemid = base64_decode(urldecode(strrev($_POST["verify"])));
            unset($_SESSION['retirosesion'][$itemid]);
            $respuesta['res'] = 'si';
            $respuesta['idrow'] = $itemid;
            echo json_encode($respuesta);
        }
    }
    
    public function createRetiro(){
        $document = $this->generateDocument();
        if ($document) {
            $this->insertDetails($document);            
            unset($_SESSION['retirosesion']);   
            $respuesta['res']='si';
            echo json_encode($respuesta);
        } else {
            $respuesta['res']='no';
            echo json_encode($respuesta);
        }
    } 
    
    private function generateDocument() {
        $idocumento = $this->getIdSecuencia("nextval('documentos_iddocumento_seq'::regclass)");
        if($_POST['tipoperdida']!=""){
           $observaciones = $_POST['tipoperdida'];  
           $prefijo = "REP"; 
           $tipodocuento = "RET.PERDIDA";
           $nombredoc = "RETIRO POR PERDIDA";
        }else{
            if($_POST['tiporetiro']=="consumo"){
               $observaciones = "consumo";  
               $prefijo = "REC";
               $tipodocuento = "RET.CONSUMO";
               $nombredoc = "RETIRO POR CONSUMO";
            }else{
               $observaciones = "Donacion";  
               $prefijo = "RED";
               $tipodocuento = "RET.DONACION";
               $nombredoc = "RETIRO POR DONACION";
            }
        }       
        $fecha = date("Y-m-d H:i:s");                      
        $idproveedor = null;
        $idbodega = $this->getUserBodega();        
        $coddoc = null;
        $idfactura = null;
        $idperiodo = $this->getCurrentPeriodo();
        $numdoc = $this->internalCode($idbodega, $prefijo);
        $query = "insert into documentos values($idocumento,'$prefijo','$fecha','$observaciones'" .
                ",'$tipodocuento',$numdoc,NULL,$idbodega,'$nombredoc',NULL,NULL,$idperiodo)";
        if ($this->db->executeQue($query)) {
            return $idocumento;
        } else {
            return false;
        }
    }
    
    private function insertDetails($iddocumento) {
        $retiros = $_SESSION['retirosesion'];
        foreach ($retiros as $value) {
            if ($this->createDetail($iddocumento, $value["id"], $value["costo"], $value["cantidadRetirar"])) {
                $idbodega = $this->getUserBodega();
                $bodegaproducto = $this->getUltimoCostoStock($value["id"], $idbodega);
                $newstock = $bodegaproducto['stock'] - $value["cantidadRetirar"];
                $vrtotaldetalle = number_format($value["cantidadRetirar"] * $value["costo"], 2, '.', '');
                $newvalortotal = $bodegaproducto['vrtotal'] - $vrtotaldetalle;
                $nuevocosto = $newstock==0?0:number_format($newvalortotal / $newstock, 2, '.', '');
                if ($this->createMovimiento($bodegaproducto['id'], $iddocumento, $idbodega, $newstock, $nuevocosto)) {
                    $queryupdate = "update bodegasproductos set costo=$nuevocosto, stock=$newstock where idbodega=$idbodega and idproducto=" . $value["id"];
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
        if($_POST['tipoperdida']){           
           $tipodocuento = "RET.PERDIDA";           
        }else{    
            if($_POST['tiporetiro']=="consumo"){
               $tipodocuento = "RET.CONSUMO";                
            }else{               
               $tipodocuento = "RET.DONACION";               
            }                     
        }  
        $idfactura = null;
        $query = "insert into movimientos values($idmovimiento,$idbodegaproducto,'$fecha','$tipodocuento',NULL,$idocumento,$idbodega,$saldostock,$costo)";
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
    private function internalCode($bodega,$prefijo) {
        $query = "select * from documentos where prefijo='$prefijo' and idbodega=$bodega";
        $consulta = $this->db->executeQue($query);
        $codigointerno = $this->db->numRows($consulta)+1;        
        return $codigointerno;
    }
    
    public function getAllRetiros(){ 
        $idbodega = $this->getUserBodega();
        $query = "select * from documentos d
        where (d.prefijo='REC' or d.prefijo='REP' or d.prefijo='RED') and d.idbodega=$idbodega order by 1 desc";
        $resultados = $this->db->executeQue($query);
        while ($fila = $this->db->arrayResult($resultados)) {
            $otroquery = "select sum(costo*cantidad) as total 
                from detalledocumentos where iddocumento=" . $fila['iddocumento'];
            $otroresultado = $this->db->executeQue($otroquery);
            $fila2 = $this->db->arrayResult($otroresultado);
            $buyssup[] = array('id' => $fila['iddocumento'],
                'fecha' => $fila['fecha'],
                'codigo' => $fila['codigo'],
                'tipo' => $fila['tipodocumento'],                
                'total' => $fila2['total']);
        }
        return $buyssup;
    }
    
    public function getdocumentByid($iddocument) {
        $query = "select * from documentos d 
        where d.iddocumento=$iddocument order by 1 desc";
        $resultados = $this->db->executeQue($query);
        $fila = $this->db->arrayResult($resultados);
        $otroquery = "select sum(costo*cantidad) as total 
                from detalledocumentos where iddocumento=$iddocument";
        $otroresultado = $this->db->executeQue($otroquery);
        $fila2 = $this->db->arrayResult($otroresultado);
        $retiro = array('id' => $fila['iddocumento'],
            'fecha' => $fila['fecha'],
            'prefijo' => $fila['prefijo'],
            'tipo' => $fila['tipodocumento'],
            'codigo' => $fila['codigo'], 
            'total' => $fila2['total']);
        return $retiro;
    }
 
    public function getdetailsRetiro($iddocument) {
        $query = "select d.cantidad, d.costo, p.nombreproducto, p.referencia, (d.costo*d.cantidad) as valortotal,p.idproducto                
        from detalledocumentos d, productos p where d.iddocumento=$iddocument 
        and p.idproducto=d.idproducto order by d.iddetallecodumentos asc";
        $consulta = $this->db->executeQue($query); 
        while ($row = $this->db->arrayResult($consulta)) { 
            $detalles[] = array('referencia' => $row['referencia'],
                'nombreproducto' => $row['nombreproducto'],
                'cantidad' => $row['cantidad'],
                'costo' => $row['costo'],
                'valortotal' => $row['valortotal'], 
                'idproducto' => $row['idproducto']); 
        }
        return $detalles;
    }
    
    public function getNombrebodega() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $file = $this->db->arrayResult($consulta);
        return $file["nombrebodega"];
    }
}

?>
