<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Arbol {

    protected $db;
    private $array_arbol;
    private $raiz;

    function __construct($user, $nameUser) {       
        $this->db = DataBase::singleton();
        $this->raiz = $user;
        $this->array_arbol[] = array('' . $this->raiz . '', '', '' . $nameUser .
            '', '<div id="raiz" style="cursor: pointer" class="raiz' . $user . '" onclick="viewMe(' .
            $user . ')">' .
            $user . '</div>');
    }

    function arbol($user, $niveles, $nivel=1) {

        if ($niveles == 0) {
            
        } else {            
            $query = 'select * from usuarios where id_padre=' . $user;
            $consulta = $this->db->executeQue($query);            
            while ($row = $this->db->arrayResult($consulta)) {
                $son = $row['idusuario'];
                $nombre = $row['nombreusuario'];
                $treeItem = null;                
                if ($nivel == 1) {
                    $treeItem = '<div id="nivel1" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                } else if ($nivel == 2) {
                    $treeItem = '<div id="nivel2" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                } else if ($nivel == 3) {
                    $treeItem = '<div id="nivel3" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                } else if ($nivel == 4) {
                    $treeItem = '<div id="nivel4" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }else if ($nivel == 5) {
                    $treeItem = '<div id="nivel5" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }else if ($nivel == 6) {
                    $treeItem = '<div id="nivel6" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }else if ($nivel == 7) {
                    $treeItem = '<div id="nivel7" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>'; 
                }else if ($nivel == 8) {
                    $treeItem = '<div id="nivel8" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }else if ($nivel == 9) {
                    $treeItem = '<div id="nivel9" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }else if ($nivel == 10) {
                    $treeItem = '<div id="nivel10" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                } else {                      
                    $treeItem = '<div id="niveln" style="cursor: pointer" class="nivel' .
                            $son . '" onclick="viewAll(' .
                            $son . ')">' . $son . '</div>';
                }

                $this->array_arbol[] = array($son, '' . $user . '', $nombre, $treeItem);
                $this->arbol($son, $niveles - 1, $nivel + 1);
            }
        }
    }

    function getArbol() {
        return $this->array_arbol;
    }

    function getRaiz() {
        return $this->raiz;
    }

}

?>
