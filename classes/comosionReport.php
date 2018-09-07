<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Red {

    protected $db;
    private $array_arbol;
    private $array_arbol_2;
    private $array_arbol_3;
    private $array_arbol_n;
    private $raiz;

    function __construct() {
        $this->db = DataBase::singleton();
    }

    function meRecovery($son, $recovery=null) {
        if (!$recovery) {
            $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
        } else {
            $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
        }
        $consulta = $this->db->executeQue($query);
        $resultado = $this->db->numRows($consulta);
        if ($resultado != 0) {
            $suma = 0;
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = 'select * from detalleventas where idventa=' . $row['idventa'];
                $consulta2 = $this->db->executeQue($query2);
                while ($row2 = $this->db->arrayResult($consulta2)) {
                    $query3 = 'select * from productos where idproducto=' . $row2['idproducto'];
                    $consulta3 = $this->db->executeQue($query3);
                    while ($row3 = $this->db->arrayResult($consulta3)) {
                        $suma = $suma + ($row2['cantidad'] * $row3['nivel0']);
                    }
                }
            }
            $this->raiz[] = array("code" => $son, "valor" => $suma);
            echo '<strong>Nivel 0: </strong>' . $son . ' <strong>Comision:</strong> &#36;' . number_format($suma, 0, ',', '.') . '</br>';
        }
    }

    function arbol($user, $recovery=null, $niveles=8, $nivel=1) {
        if ($niveles == 0) {
            
        } else {
            $query5 = 'select * from usuarios where id_padre=' . $user;
            $consulta5 = $this->db->executeQue($query5);
            while ($row5 = $this->db->arrayResult($consulta5)) {
                $son = $row5['idusuario'];
                if ($nivel == 1) {
                    if (!$recovery) {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
                    } else {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
                    }
                    $consulta = $this->db->executeQue($query);
                    $resultado = $this->db->numRows($consulta);
                    if ($resultado != 0) {
                        $suma = 0;
                        while ($row = $this->db->arrayResult($consulta)) {
                            $query2 = 'select * from detalleventas where idventa=' . $row['idventa'];
                            $consulta2 = $this->db->executeQue($query2);
                            while ($row2 = $this->db->arrayResult($consulta2)) {
                                $query3 = 'select * from productos where idproducto=' . $row2['idproducto'];
                                $consulta3 = $this->db->executeQue($query3);
                                while ($row3 = $this->db->arrayResult($consulta3)) {
                                    $suma = $suma + ($row2['cantidad'] * $row3['nivel1']);
                                }
                            }
                        }
                        $this->array_arbol[] = array('code' => $son, 'valor' => $suma);
                        ;
                        echo '<strong>Nivel:</strong> '.$nivel . ' <strong>Codigo: </strong>' . $son . '  <strong>Comision: </strong> &#36;' . number_format($suma, 0, ',', '.') . '</br>';
                    }
                } else if ($nivel == 2) {
                    if (!$recovery) {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
                    } else {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
                    }
                    $consulta = $this->db->executeQue($query);
                    $resultado = $this->db->numRows($consulta);
                    if ($resultado != 0) {
                        $suma = 0;
                        while ($row = $this->db->arrayResult($consulta)) {
                            $query2 = 'select * from detalleventas where idventa=' . $row['idventa'];
                            $consulta2 = $this->db->executeQue($query2);
                            while ($row2 = $this->db->arrayResult($consulta2)) {
                                $query3 = 'select * from productos where idproducto=' . $row2['idproducto'];
                                $consulta3 = $this->db->executeQue($query3);
                                while ($row3 = $this->db->arrayResult($consulta3)) {
                                    $suma = $suma + ($row2['cantidad'] * $row3['nivel2']);
                                }
                            }
                        }
                        $this->array_arbol_2[] = array('code' => $son, 'valor' => $suma);
                        ;
                       echo '<strong>Nivel:</strong> '.$nivel . ' <strong>Codigo: </strong>' . $son . '  <strong>Comision: </strong> &#36;' . number_format($suma, 0, ',', '.') . '</br>';
                    }
                } else if ($nivel == 3) {
                    if (!$recovery) {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
                    } else {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
                    }
                    $consulta = $this->db->executeQue($query);
                    $resultado = $this->db->numRows($consulta);
                    if ($resultado != 0) {
                        $suma = 0;
                        while ($row = $this->db->arrayResult($consulta)) {
                            $query2 = 'select * from detalleventas where idventa=' . $row['idventa'];
                            $consulta2 = $this->db->executeQue($query2);
                            while ($row2 = $this->db->arrayResult($consulta2)) {
                                $query3 = 'select * from productos where idproducto=' . $row2['idproducto'];
                                $consulta3 = $this->db->executeQue($query3);
                                while ($row3 = $this->db->arrayResult($consulta3)) {
                                    $suma = $suma + ($row2['cantidad'] * $row3['nivel3']);
                                }
                            }
                        }
                        $this->array_arbol_3[] = array('code' => $son, 'valor' => $suma);
                        ;
                        echo '<strong>Nivel:</strong> '.$nivel . ' <strong>Codigo: </strong>' . $son . '  <strong>Comision: </strong> &#36;' . number_format($suma, 0, ',', '.') . '</br>';
                    }
                } else {
                    if (!$recovery) {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
                    } else {
                        $query = 'select * from ventas where idusuario=' . $son . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
                    }
                    $consulta = $this->db->executeQue($query);
                    $resultado = $this->db->numRows($consulta);
                    if ($resultado != 0) {
                        $suma = 0;
                        while ($row = $this->db->arrayResult($consulta)) {
                            $query2 = 'select * from detalleventas where idventa=' . $row['idventa'];
                            $consulta2 = $this->db->executeQue($query2);
                            while ($row2 = $this->db->arrayResult($consulta2)) {
                                $query3 = 'select * from productos where idproducto=' . $row2['idproducto'];
                                $consulta3 = $this->db->executeQue($query3);
                                while ($row3 = $this->db->arrayResult($consulta3)) {
                                    $suma = $suma + ($row2['cantidad'] * $row3['niveli']);
                                }
                            }
                        }
                        $this->array_arbol_n[] = array('code' => $son, 'valor' => $suma);
                        ;
                        echo '<strong>Nivel:</strong> '.$nivel . ' <strong>Codigo: </strong>' . $son . '  <strong>Comision: </strong> &#36;' . number_format($suma, 0, ',', '.') . '</br>';
                    }
                }
                $this->arbol($son, $recovery, $niveles - 1, $nivel + 1);
            }
        }
    }

    function getArbol() {
        return $this->array_arbol;
    }

    function getArbol2() {
        return $this->array_arbol_2;
    }

    function getArbol3() {
        return $this->array_arbol_3;
    }

    function getArboln() {
        return $this->array_arbol_n;
    }

    function getRaiz() {
        return $this->raiz;
    }

    public function getPuntos($user, $recovery=null) {
        $points = 0;
        $query = '';
        if (!$recovery) {
            $query = 'select sum(puntos_venta) as puntosperiodo from ventas where idusuario=' .
                    $user . ' and estado_venta=\'pagado\' and idperiodo=' . $this->getCurrentPeriodo();
        } else {
            $query = 'select sum(puntos_venta) as puntosperiodo from ventas where idusuario=' .
                    $user . ' and estado_venta=\'pagado\' and idperiodo=' . $recovery;
        }
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $points = $row['puntosperiodo'];
        }
        return $points;
    }

    public function getCurrentPeriodo() {
        $query = 'select * from periodos where "' . date("d-m-Y") . '" BETWEEN fechainicio AND fechafin';
        $consulta = $this->db->executeQue($query);
        $idperiodo = 0;
        while ($row = $this->db->arrayResult($consulta)) {
            $idperiodo = $row['idperiodo'];
        }
        return $idperiodo;
    }

    public function getNameCurrentPeriodo() {
        $query = 'select * from periodos where "' . date("d-m-Y") . '" BETWEEN fechainicio AND fechafin';
        $consulta = $this->db->executeQue($query);
        $nombreperiodo = '';
        while ($row = $this->db->arrayResult($consulta)) {
            $nombreperiodo = $row['nombreperiodo'];
        }
        return $nombreperiodo;
    }

}

?>
