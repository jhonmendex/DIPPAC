<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class CuestionarioModel extends ModelBase
{

    public function getCuestionarios()
    {
        $query = "SELECT * FROM cuestionarios";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $send = null;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $send[] = array(
                    'id' => $row['Id'],
                    'conclusion' => $row['conclusion'],
                    'calificacion' => $row['calificacion'],
                    'usuarioId' => $row['usuarioId']
                );
            }
        }
        return $send;
    }

    public function addAnswers($answers, $idUser)
    {
        $cuestionario = "INSERT INTO public.cuestionarios(\"usuarioId\") VALUES (" . $idUser . ");";

        $resultRespuesta = $this->db->executeQue($cuestionario);

        $select = "SELECT * FROM public.cuestionarios ORDER BY \"Id\" DESC LIMIT 1";

        $resultConsulta = $this->db->selectLastRegister($select);

        if (!$resultConsulta) {
            return "error";
        }

        foreach ($answers as $index => $answer) {
            $respuesta = "INSERT INTO public.respuestas(\"esCorrecta\", respuesta, \"cuestionarioId\", tipo, nombreprueba)
            VALUES (" . $answer['isCorrect'] . ", '" . $answer['answer'] . "', '" . $resultConsulta[0] . "', " . $answer['type'] . ", '" . $answer['testName'] . "');";

            $resultRespuesta = $this->db->executeQue($respuesta);

            if (!$resultRespuesta) {
                return "error";
            }
        }
        
        return "success";
    }
}
