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
    public function getTypeReport()
    {
        $consult = $this->db->executeQue("select 
        (select count(conclusion) from cuestionarios where conclusion='deutaronapia') deutaronapia,
        (select count(conclusion) from cuestionarios where conclusion='deutoronomalia') deutoronomalia,
        (select count(conclusion) from cuestionarios where conclusion='protanomalia') protanomalia,
        (select count(conclusion) from cuestionarios where conclusion='Protanopia') protanopia,
        (select count(conclusion) from cuestionarios where conclusion='tritanomalia') tritanomalia,
        (select count(conclusion) from cuestionarios where conclusion='tritanopia') tritanopia,
        (select count(conclusion) from cuestionarios where conclusion='Normal') normal");
        while ($fila = $this->db->arrayResult($consult)) {
            $typeReport[] = array(
                'deutaronapia' => $fila['deutaronapia'],
                'deutoronomalia' => $fila['deutoronomalia'],
                'protanomalia' => $fila['protanomalia'],
                'protanopia' => $fila['protanopia'],
                'tritanomalia' => $fila['tritanomalia'],
                'tritanopia' => $fila['tritanopia'],
                'normal' => $fila['normal'],

            );
        }
        return $typeReport;
    }
    public function getAgeReport()
    {
        $consult = $this->db->executeQue("select 
        (select count(conclusion) from cuestionarios where conclusion='deutaronapia' and edad=6) deutaronapia6,
        (select count(conclusion) from cuestionarios where conclusion='deutoronomalia' and edad=6) deutoronomalia6,
        (select count(conclusion) from cuestionarios where conclusion='protanomalia' and edad=6) protanomalia6,
        (select count(conclusion) from cuestionarios where conclusion='Protanopia' and edad=6) protanopia6,
        (select count(conclusion) from cuestionarios where conclusion='tritanomalia' and edad=6) tritanomalia6,
        (select count(conclusion) from cuestionarios where conclusion='tritanopia' and edad=6) tritanopia6,
        (select count(conclusion) from cuestionarios where conclusion='Normal' and edad=6) normal6,
        (select count(conclusion) from cuestionarios where conclusion='deutaronapia' and edad=7) deutaronapia7,
        (select count(conclusion) from cuestionarios where conclusion='deutoronomalia' and edad=7) deutoronomalia7,
        (select count(conclusion) from cuestionarios where conclusion='protanomalia' and edad=7) protanomalia7,
        (select count(conclusion) from cuestionarios where conclusion='Protanopia' and edad=7) protanopia7,
        (select count(conclusion) from cuestionarios where conclusion='tritanomalia' and edad=7) tritanomalia7,
        (select count(conclusion) from cuestionarios where conclusion='tritanopia' and edad=7) tritanopia7,
        (select count(conclusion) from cuestionarios where conclusion='Normal' and edad=7) normal7,
        (select count(conclusion) from cuestionarios where conclusion='deutaronapia' and edad=8) deutaronapia8,
        (select count(conclusion) from cuestionarios where conclusion='deutoronomalia' and edad=8) deutoronomalia8,
        (select count(conclusion) from cuestionarios where conclusion='protanomalia' and edad=8) protanomalia8,
        (select count(conclusion) from cuestionarios where conclusion='Protanopia' and edad=8) protanopia8,
        (select count(conclusion) from cuestionarios where conclusion='tritanomalia' and edad=8) tritanomalia8,
        (select count(conclusion) from cuestionarios where conclusion='tritanopia' and edad=8) tritanopia8,
        (select count(conclusion) from cuestionarios where conclusion='Normal' and edad=8) normal8,
        (select count(conclusion) from cuestionarios where conclusion='deutaronapia' and edad=9) deutaronapia9,
        (select count(conclusion) from cuestionarios where conclusion='deutoronomalia' and edad=9) deutoronomalia9,
        (select count(conclusion) from cuestionarios where conclusion='protanomalia' and edad=9) protanomalia9,
        (select count(conclusion) from cuestionarios where conclusion='Protanopia' and edad=9) protanopia9,
        (select count(conclusion) from cuestionarios where conclusion='tritanomalia' and edad=9) tritanomalia9,
        (select count(conclusion) from cuestionarios where conclusion='tritanopia' and edad=9) tritanopia9,
        (select count(conclusion) from cuestionarios where conclusion='Normal' and edad=9) normal9");
        while ($fila = $this->db->arrayResult($consult)) {
            $ageReport[] = array(
                'deutaronapia6' => $fila['deutaronapia6'],
                'deutoronomalia6' => $fila['deutoronomalia6'],
                'protanomalia6' => $fila['protanomalia6'],
                'protanopia6' => $fila['protanopia6'],
                'tritanomalia6' => $fila['tritanomalia6'],
                'tritanopia6' => $fila['tritanopia6'],
                'normal6' => $fila['normal6'],
                'deutaronapia7' => $fila['deutaronapia7'],
                'deutoronomalia7' => $fila['deutoronomalia7'],
                'protanomalia7' => $fila['protanomalia7'],
                'protanopia7' => $fila['protanopia7'],
                'tritanomalia7' => $fila['tritanomalia7'],
                'tritanopia7' => $fila['tritanopia7'],
                'normal7' => $fila['normal7'],
                'deutaronapia8' => $fila['deutaronapia8'],
                'deutoronomalia8' => $fila['deutoronomalia8'],
                'protanomalia8' => $fila['protanomalia8'],
                'protanopia8' => $fila['protanopia8'],
                'tritanomalia8' => $fila['tritanomalia8'],
                'tritanopia8' => $fila['tritanopia8'],
                'normal8' => $fila['normal8'],
                'deutaronapia9' => $fila['deutaronapia9'],
                'deutoronomalia9' => $fila['deutoronomalia9'],
                'protanomalia9' => $fila['protanomalia9'],
                'protanopia9' => $fila['protanopia9'],
                'tritanomalia9' => $fila['tritanomalia9'],
                'tritanopia9' => $fila['tritanopia9'],
                'normal9' => $fila['normal9'],

            );
        }
        return $ageReport;
    }
}
