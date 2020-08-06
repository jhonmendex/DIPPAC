<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class CuestionarioModel extends ModelBase {

    public function getCuestionarios() {
        $query = "SELECT * FROM cuestionarios";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $send = null;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $send[] = array('id' => $row['Id'],
                    'conclusion' => $row['conclusion'],
                    'calificacion' => $row['calificacion'],
                    'usuarioId' => $row['usuarioId']);
            }
        }
        return $send;
    }

    public function addAnswers($answer) {

        foreach ($answer as $clave => $valor) {
            $query = 'INSERT INTO public.respuestas(respuesta, "cuestionarioId")
            VALUES ('.$valor.', 1);';
        $consulta = $this->db->executeQue($query);
        }
        return "success";
    }

}

?>
