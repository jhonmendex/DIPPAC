<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ValidacionModel extends ModelBase {

    private $models = array('val1' => 'usuarios',
        'val2' => 'productos',
        'val3' => 'beneficiarios',
        'val4' => 'perfiles',
        'val5' => 'terceros',
        'val6' => 'categoriasp',
        'val7' => 'bodegas');
    

    function validar_direccion($direccion, $minimum=1) {
        if (preg_match('/^[a-zA-ZñÑáéíóú.\*\/,#-\d_\s]{' . $minimum . ',50}$/i', $direccion)) {
            return true;
        } else {
            return true;
        }
    }
    
    function validar_alias($direccion, $minimum=1) {
        if (preg_match('/^[a-zA-Z\d_]{' . $minimum . ',50}$/i', $direccion)) {
            return true;
        } else {
            return false;
        }
    }


    function validar_nombre($nombre, $minimum=0) {
        if (preg_match('/^[a-zA-ZñÑáéíóú,-.\d_\s]{' . $minimum . ',50}$/i', $nombre)) {
            return true;
        } else {
            return false;
        }
    }

    function validar_nombre_no_digit($nombre, $minimum=0) {
        if (preg_match('/^[a-zA-ZñÑáéíóú\s]{' . $minimum . ',50}$/i', $nombre)) {
            return true;
        } else {
            return false;
        }
    }

    function validar_nombre_short($nombre, $minimum=0) {
        if (preg_match('/^[a-zA-ZñÑáéíóú\s]{' . $minimum . ',30}$/i', $nombre)) {
            return true;
        } else {
            return false;
        }
    }

    function validar_email($email, $minimum=0) {
        if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
            return true;
        } else {
            return false;
        }
    }

    function validar_numero($number, $minimum=0) {
        if ($number != '') {
            $number= (Integer) $number;
            if (preg_match('/^[0-9]{' . $minimum . ',15}$/', $number)) {
                if ($number > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function validar_digito($number, $minimum=0) {
        $number= (int) $number;
        if (preg_match('/^[0-9]{' . $minimum . ',15}$/', $number)) {
            return true;
        } else {
            return false;
        }
    }

    function validar_decimal($number, $minimum=0) {
        if ($number != '') {
            //  if (eregi('^[0-9]{' . $minimum . ',15}$|^[0-9]{' . $minimum . ',15}[,|\.]{0,1}[0-9]{1,15}$', $number)) {
            if (preg_match('/^[0-9]{' . $minimum . ',15}$|^[0-9]{' . $minimum . ',15}[,|\.]{0,1}[0-9]{1,15}$/', $number)) {
                if ($number > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function validar_unica($value, $field, $table, $exception) {
        $consulta = null;
        $value=trim($value);
        if (is_numeric($value)) {
            if ($field == 'referencia') {
                if (!$exception||$exception=="null") {
                    $query = "select * from " . $this->models[$table] . "  where " . $field . "='".trim($value)."';";                    
                } else {                    
                    $query = "select * from " . $this->models[$table] . "  where $field='".trim($value)."' and $field<>'".trim($exception)."'";
                }
            } else {
                if (!$exception||$exception=="null") {
                    $query = "select * from " . $this->models[$table] . "  where " . $field . "=" . $value;
                } else {
                    $query = "select * from " . $this->models[$table] . "  where $field='$value' and $field<>$exception";
                }
            }
            $consulta = $this->db->executeQue($query);
        } else {
            if (!$exception||$exception=="null") {
                $query = "select * from " . $this->models[$table] . "  where " . $field . "='".strtoupper(trim($value))."' or ". $field . "='".trim($value)."'";
            } else {
                $query = "select * from " . $this->models[$table] . "  where ($field='".strtoupper(trim($value))."' and $field<>'".strtoupper(trim($exception))."') or ($field='".trim($value)."' and $field<>'".trim($exception)."')";
            }
            $consulta = $this->db->executeQue($query);
        }
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            return false;
        } else {
            return true;
        }
    }

    function validar_presencia($value) {
        $values = (string) $values;
        if ($value != '') {
            return true;
        } else {
            return false;
        }
    }

}

?>
