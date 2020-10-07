<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class DaltonismModel extends ModelBase
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

    public function addAnswer($answer, $idUser, $edad)

    {
        $cuestionario = "INSERT INTO public.cuestionarios(\"usuarioId\",edad,conclusion)VALUES (" . $idUser . ", " . $edad . ", '" . $answer['resultado'] . "');";

        $resultRespuesta = $this->db->executeQue($cuestionario);

        $select = "SELECT * FROM public.cuestionarios ORDER BY \"Id\" DESC LIMIT 1";

        $resultConsulta = $this->db->selectLastRegister($select);

        if (!$resultConsulta) {
            return "error";
        }
        $respuesta = "INSERT INTO public.respuestas(\"cuestionarioId\", tipo, nombreprueba,normales,deutaronapia,deutoronomalia,protanomalia,protanopia,tritanomalia,tritanopia)
        VALUES ('" . $resultConsulta[0] . "', " . $answer['type'] . ", '" . $answer['testName'] . "','" . $answer['normales'] . "','" . $answer['deutaronapia'] . "','" . $answer['deutoronomalia'] . "','" . $answer['protanomalia'] . "','" . $answer['protanopia'] . "','" . $answer['tritanomalia'] . "','" . $answer['tritanopia'] . "');";

        $resultRespuesta = $this->db->executeQue($respuesta);

        if (!$resultRespuesta) {
            return "error";
        }


        return "success";
    }
    public function getReport()
    {
        $consult = $this->db->executeQue('select u.idusuario,u.nombreusuario,c.edad,c.fechapresentacion,p.normales,p.deutaronapia,p.deutoronomalia,
        p.protanomalia,p.protanopia,p.tritanomalia,p.tritanopia,c.conclusion
        from usuarios u, cuestionarios c,respuestas p
        where u.idusuario=c."usuarioId" and c."Id"=p."cuestionarioId" and p.tipo=6');
        while ($fila = $this->db->arrayResult($consult)) {
            $usuarios[] = array(
                'id' => $fila['idusuario'],
                'nombre' => $fila['nombreusuario'],
                'edad' => $fila['edad'],
                'fechapresentacion' => $fila['fechapresentacion'],
                'normales' => $fila['normales'],
                'deutaronapia' => $fila['deutaronapia'],
                'deutoronomalia' => $fila['deutoronomalia'],
                'protanomalia' => $fila['protanomalia'],
                'protanopia' => $fila['protanopia'],
                'tritanomalia' => $fila['tritanomalia'],
                'tritanopia' => $fila['tritanopia'],
                'conclusion' => $fila['conclusion']
            );
        }
        return $usuarios;
    }
}
