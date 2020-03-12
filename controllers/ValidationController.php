<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ValidationController extends ControllerPublic {

    public function main() {
        
    }

    public function validar_diferencia() {
        $this->getModel("Validacion");
        $valor = $_POST['valor1'];
        $label = $_POST['labelone'];
        $valor2 = $_POST['valor2'];
        $operacion = $_POST['operacion'];
        if ($this->model->validar_diferencia($valor, $valor2, $operacion)) {
            $respuesta['result'] = "true";
            echo json_encode($respuesta);
        } else {
            $respuesta['result'] = "false";
            $respuesta['mensaje'] = $this->document->t("IS_DIFFERENT_TO",$label);
            echo json_encode($respuesta);
        }
    }

    public function validar_presencia() {
        $this->getModel("Validacion");
        $valor = $_POST['valor'];
        $label = $_POST['label'];
        if ($this->model->validar_presencia($valor)) {
            $respuesta['result'] = "true";
            echo json_encode($respuesta);
        } else {
            $respuesta['result'] = "false";
            $respuesta['mensaje'] = $this->document->t("IS_REQUIRED", $label);
            echo json_encode($respuesta);
        }
    }

    public function validar_pattern() {
        $types = array('val1' => 'validar_nombre',
            'val3' => 'validar_email',
            'val2' => 'validar_numero',
            'val4' => 'validar_nombre_no_digit',
            'val5' => 'validar_nombre_short',
            'val6' => 'validar_decimal',
            'val7' => 'validar_direccion',
            'val8' => 'validar_digito',
            'val9' => 'validar_alias');
        $this->getModel("Validacion");
        $valor = $_POST['valor'];
        $tipo = $_POST['type'];
        $label = $_POST['label'];
        $min = $_POST['minis'];
        if ($min <= 0) {
            $min = 1;
        }
        // if ($this->model->$types[$tipo]($valor, $min)) {
        //     $respuesta['result'] = "true";
        //     echo json_encode($respuesta);
        // } else {
        //     $respuesta['result'] = "false";
        //     $respuesta['mensaje'] = $this->document->t("IS_INVALID", $label);
        //     echo json_encode($respuesta);
        // }
        $respuesta['result'] = "true";
        echo json_encode($respuesta);
    }

    public function validar_unica() {
        $this->getModel("Validacion");
        $value = $_POST['valor'];
        $table = $_POST['key'];
        $label = $_POST['label'];
        $field = $_POST['name'];
        $exception = $_POST['exception'];
        $fields = explode('_', $field);
        if ($this->model->validar_unica($value, $fields[0], $table, $exception)) {
            $respuesta['result'] = "true";
            echo json_encode($respuesta);
        } else {
            $respuesta['result'] = "false";
            $respuesta['mensaje'] = $this->document->t("IS_REPEAT", $label);
            echo json_encode($respuesta);
        }
    }

}

?>
