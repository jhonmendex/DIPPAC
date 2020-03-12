<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');



class CommissionsModel extends ModelBase {

private $_elements = array(); 
        
public function generateTree($idperiodo) {
$fecha = date("Y-m-d H:i:s"); 
$consulta = $this->db->executeQue("  
select u.nombreusuario,u.idusuario,u.id_padre,ventas.puntos_venta,ventas.idperiodo
from   usuarios u    
left join (SELECT *
           FROM ventas v
           WHERE v.estado_venta = 'pagado' and
                 v.idperiodo = $idperiodo) AS ventas ON u.idusuario = ventas.idusuario     
           order by 3 asc ");      
$total = $this->db->numRows($consulta);
   if($total > 0){    
     while($row = $this->db->arrayResult($consulta))
        {
           if ($row["puntos_venta"] =="") {
              $valocomision = 0;               
            }else{  
              $this->calcularcomision($row["idusuario"],0,$idperiodo);  
              array_push($this->_elements,$row["puntos_venta"]);
              $valocomision = array_sum($this->_elements);     
            }                         
            $consecutivo = $this->getIdSecuencia("nextval('comisiones_idcomision_seq'::regclass)");
            $this->db->executeQue("insert into comisiones values($consecutivo,$idperiodo,".$row["idusuario"] .",$valocomision,NULL,'$fecha')");    
            // print_r($row["nombreusuario"]." --> ".$valocomision."\n");
            while(count($this->_elements))array_pop($this->_elements);               
        }  
        echo json_encode(array("respuesta"=>"si"));      
   }       
                         
}                
           
function calcularcomision($idpadre,$nivel,$idperiodo) 
{  
    $consulta = $this->db->executeQue("      
    select u.idusuario,nombreusuario,u.id_padre,ventas.puntos_venta,ventas.idperiodo
    from   usuarios u  
    left join (SELECT *
           FROM ventas v
           WHERE v.estado_venta = 'pagado' and
                 v.idperiodo = $idperiodo) AS ventas ON u.idusuario = ventas.idusuario
    where u.id_padre = $idpadre");    
    $total = $this->db->numRows($consulta);
    if($total > 0){                
        $nivel=$nivel+1;                   
        while($row = $this->db->arrayResult($consulta))
        {                     
             //echo $nivel.'-->'.$row["nombreusuario"]."\n" ; 
            array_push($this->_elements,$row["puntos_venta"]);       
            self::calcularcomision($row["idusuario"], $nivel,$idperiodo);  
        }          
    }           
}     

    public function getReporte($nombre, $idUser) {
        $mi_arbol = new Red();
        $mi_arbol2 = new Red();
        $mi_arbol3 = new Red();
        echo '<strong>Liquidacion de comisiones del usuario ' . $nombre . ' (' . $idUser . ')</strong></br></br>';
        echo 'Febrero</br>Mis puntos: ' . number_format($mi_arbol->getPuntos($idUser, 1), 2, ',', '.') . '</br>';
        if ($mi_arbol->getPuntos($idUser, 1) > 120) {
            $mi_arbol->meRecovery($idUser, 1);
            $mi_arbol->arbol($idUser, 1);
        } else {
            
        }

        echo '</br></br>Marzo</br>Mis puntos: ' . number_format($mi_arbol->getPuntos($idUser, 2), 2, ',', '.') . '</br>';
        if ($mi_arbol2->getPuntos($idUser, 2) > 120) {
            $mi_arbol2->meRecovery($idUser, 2);
            $mi_arbol2->arbol($idUser, 2);
        } else {
            
        }
        echo '</br></br>Abril</br>Mis puntos: ' . number_format($mi_arbol->getPuntos($idUser, 4), 2, ',', '.') . '</br>';
        if ($mi_arbol3->getPuntos($idUser, 4) > 120) {
            $mi_arbol3->meRecovery($idUser, 4);
            $mi_arbol3->arbol($idUser, 4);
        } else {
            
        }

        echo '</br></br>Mayo</br>Mis puntos: ' . number_format($mi_arbol->getPuntos($idUser, 5), 2, ',', '.') . '</br>';
        if ($mi_arbol3->getPuntos($idUser, 5) > 120) {
            $mi_arbol3->meRecovery($idUser, 5);
            $mi_arbol3->arbol($idUser, 5);
        } else {
            
        }
    }

    public function getAvailablePeriods() {
        $fecha = explode("-", date('Y-m-d', strtotime("-1 month")));
        $ultimoDia = $this->getUltimoDiaMes($fecha[0], $fecha[1]);
        $fechacomparar = $fecha[0] . "-" . $fecha[1] . "-" . $ultimoDia;
        $result = $this->db->executeQue("select p.idperiodo, p.nombreperiodo
                                            from periodos p
                                            where p.fechafin<='$fechacomparar'
                                            and p.idperiodo not in((select DISTINCT idperiodo from comisiones))");
        while ($row = $this->db->arrayResult($result)) {
            $periodos[] = array("id" => $row["idperiodo"], "nombre" => $row["nombreperiodo"]);
        }
        return $periodos;
    }

    public function getComissionsGenerated() {
        $result = $this->db->executeQue("select DISTINCT cc.idperiodo, p.nombreperiodo,cc.idcomision,(select sum(valortotal) from comisiones where cc.idperiodo=idperiodo) as total, cc.fechacomision, cc.nousers
            from comisiones cc left join periodos p on p.idperiodo=cc.idperiodo order by cc.idperiodo desc");
        while ($row = $this->db->arrayResult($result)) {
            $comisiones[$row["idperiodo"]] = array("id" => $row["idcomision"],
                "total" => $row["total"],
                "nouser" => $row["noUsers"],
                "fecha" => $row["fechacomision"],
                "nombre" => $row["nombreperiodo"]);
        } 
        return $comisiones;
    }

    private function getUltimoDiaMes($elAnio, $elMes) {
        return date("d", (mktime(0, 0, 0, $elMes + 1, 1, $elAnio) - 1));
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

    public function getComissionsAll($periodo) {
        $result = $this->db->executeQue("select * from comisiones c, usuarios u where c.idperiodo=$periodo and c.idusuario=u.idusuario");
        while ($row = $this->db->arrayResult($result)) {
            $comisiones[] = array("codigo" => $row['idusuario'],
                "nombre" => $row['nombreusuario'],
                "total" => $row['valortotal'],
                "cedula" => $row['cedula']);
        }
        return $comisiones;
    }

    public function getPeriodoName($periodo) {
        $result = $this->db->executeQue("select nombreperiodo from periodos where idperiodo=$periodo");
        $row = $this->db->arrayResult($result);
        $periodoname = $row['nombreperiodo'];
        return $periodoname;
    }
    
    public function getMyComissions($user) {
        $result = $this->db->executeQue("select * from comisiones c, periodos p where c.idusuario=$user and c.idperiodo=p.idperiodo");
        while ($row = $this->db->arrayResult($result)) {
            $comisiones[] = array("id" => $row['idcomision'],
                "fecha" => $row['fechacomision'],
                "nombre" => $row['nombreperiodo'],
                "total" => $row['valortotal']);
        }
        return $comisiones; 
    }

}

?>
