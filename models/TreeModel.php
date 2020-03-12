<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

require ('classes/Tree.php');

class TreeModel extends ModelBase {

    public function getTree($idUser, $nameUser) {
        $mi_arbol = new Arbol($idUser, $nameUser);
        $mi_arbol->arbol($mi_arbol->getRaiz(), $this->getLevel());
        return json_encode($mi_arbol->getArbol());
    }

    public function getLevel() {
        if ($_POST['levels']) {
            return $_POST['levels'];
        } else {
            return 3;
        }
    }

    public function getNodeIdAjax() {
        session_start();
        return $_POST['idUser'];
    }

    public function getNodeAjax($usuario) {
        $usuario['puntosPeriodo'] = number_format($this->getPuntos($usuario['id']), 2, ',', '.');;
        echo json_encode($usuario);
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

    public function getPuntos($user) {
        $points = 0;
        $query = 'select sum(puntos_venta) as puntosperiodo from ventas where idusuario=' .
                $user . ' and idperiodo=' . $this->getCurrentPeriodo();

        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $points = $row['puntosperiodo'];
        }
        return $points;
    }

}

?>
