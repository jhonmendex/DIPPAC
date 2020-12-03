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

    public function addAnswers($answers, $idUser, $edad)
    {
        $cuestionario = "INSERT INTO public.cuestionarios(\"usuarioId\", \"edad\") VALUES (" . $idUser . "," . $edad . ");";

        $resultRespuesta = $this->db->executeQue($cuestionario);

        $select = "SELECT * FROM public.cuestionarios ORDER BY \"Id\" DESC LIMIT 1";

        $resultConsulta = $this->db->selectLastRegister($select);

        if (!$resultConsulta) {
            return "error";
        }

        sort($answers);

        foreach ($answers as $index => $answer) {
            $respuesta = "INSERT INTO public.respuestas(tipo, respuesta, imagen, \"cuestionarioId\", \"esCorrecta\", nombreprueba)
            VALUES (" . $answer['type'] . ", '" . $answer['answer'] . "', '" . $answer['image'] . "', '" . $resultConsulta[0] . "', " . $answer['isCorrect'] . ", '" . $answer['testName'] . "');";

            $resultRespuesta = $this->db->executeQue($respuesta);

            if (!$resultRespuesta) {
                return "error";
            }
        }

        return "success";
    }
}
