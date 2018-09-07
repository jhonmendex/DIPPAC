<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
require ('classes/Producto.php');
require ('classes/detalleVenta.php');

class PurshasesModel extends ModelBase {

    public function getPurshases($idusuario) {
        $query = null;
        if (!isset($_POST["dateini"]) && !isset($_POST["datefin"])) {
            $query = "SELECT * from ventas  where idusuario='$idusuario' order by fecha desc";
        } else {
            $fecha1 = $_POST['dateini'];
            $fecha2 = $_POST['datefin'];
            $query = "SELECT * from ventas where fecha between '$fecha1' and '$fecha2'  and idusuario='$idusuario' order by fecha desc";
        }
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $detalles;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $detalles[] = array('id' => $row['idventa'],
                    'fecha' => $row['fecha'],
                    'fecha2' => $row['fecha'],
                    'puntos' => $row['puntos_venta'],
                    'precio' => $row['precio_venta'],
                    'periodo' => $this->getPeriodo($row['fecha']));
            }
        }
        return $detalles;
    }

    public function getDetails($idusuario) {
        $venta = $_GET['idVenta'];
        $query = "SELECT * from ventas where idusuario='$idusuario' and idventa=$venta";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $detalles = Array();
        if ($total > 0) {
            $query2 = "SELECT * from detalleventas where idventa=$venta";
            $consulta2 = $this->db->executeQue($query2);
            $total2 = $this->db->numRows($consulta2);
            if ($total2 > 0) {
                while ($row = $this->db->arrayResult($consulta2)) {
                    $query3 = "SELECT * from productos where idproducto=" . $row['idproducto'];
                    $consulta3 = $this->db->executeQue($query3);
                    $total3 = $this->db->numRows($consulta3);
                    if ($total3 > 0) {
                        while ($row2 = $this->db->arrayResult($consulta3)) {
                            $producto = new Producto($row2['idproducto'], $row2['idcategoria'], $row2['nombreproducto'],
                                            $row2['precio'], number_format($row2['puntos'], 2, '.', ''), $row2['referencia'],
                                            $row2['iva'], $row2['stock'], null);
                            $detalle = new Detalle($producto, $row['cantidad']);
                            $detalles[] = $detalle;
                        }
                    }
                }
            }
        }
        return $detalles;
    }

    private function getPeriodo($fecha) {
        $array = explode('-', $fecha);
        if ($array[1] == 01) {
            return "Enero " . $array[0];
        } else if ($array[1] == 02) {
            return "Febrero " . $array[0];
        } else if ($array[1] == 03) {
            return "Marzo " . $array[0];
        } else if ($array[1] == 04) {
            return "Abril " . $array[0];
        } else if ($array[1] == 05) {
            return "Mayo " . $array[0];
        } else if ($array[1] == 06) {
            return "Junio " . $array[0];
        } else if ($array[1] == 07) {
            return "Julio " . $array[0];
        } else if ($array[1] == 08) {
            return "Agosto " . $array[0];
        } else if ($array[1] == 09) {
            return "Septiembre " . $array[0];
        } else if ($array[1] == 10) {
            return "Octubre " . $array[0];
        } else if ($array[1] == 11) {
            return "Noviembre " . $array[0];
        } else if ($array[1] == 12) {
            return "Diciembre " . $array[0];
        }
    }
}

?>
