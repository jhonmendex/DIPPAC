<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class TestDiscalculiaModel extends ModelBase
{

  public function getUsersByTutor($idUsuario)
  {
    $query = 'select usuarios.idusuario, usuarios.nombreusuario, cuestionarios."Id"
    as cuestionarioId, cuestionarios.fechapresentacion, cuestionarios.edad from public.usuarios inner join public.cuestionarios on usuarios.idusuario = cuestionarios."usuarioId"
    where public.usuarios."tutorId" = ' . $idUsuario . '';
    $consulta = $this->db->executeQue($query);
    $total = $this->db->numRows($consulta);
    $send = null;
    if ($total > 0) {
      while ($row = $this->db->arrayResult($consulta)) {
        $send[] = array(
          'id' => $row['idusuario'],
          'nombre' => $row['nombreusuario'],
          'idCuestionario' => $row['cuestionarioid'],
          'fecha' => $row['fechapresentacion'],
          'edad' => $row['edad']
        );
      }
    }
    $res = array_reduce($send, function (array $accumulator, array $element) {
      $accumulator[$element['id']][] = $element;
      return $accumulator;
    }, []);
    return $res;
  }

  public function getDetailTest($id)
  {
    $query = 'select cuestionarios."Id" as idCuestionario, cuestionarios.conclusion, cuestionarios.calificacion, cuestionarios.fechapresentacion, respuestas."Id" as
    idRespuesta, respuestas.imagen, respuestas."esCorrecta", respuestas.respuesta, respuestas.tipo, respuestas.nombreprueba
    from public.cuestionarios inner join public.respuestas on respuestas."cuestionarioId" = cuestionarios."Id"
    where cuestionarios."Id" =' . $id;
    $consulta = $this->db->executeQue($query);
    $total = $this->db->numRows($consulta);
    $send = null;
    if ($total > 0) {
      while ($row = $this->db->arrayResult($consulta)) {
        $send[] = array(
          'id' => $row['idcuestionario'],
          'idrespuesta' => $row['idrespuesta'],
          'idCuestionario' => $row['idcuestionario'],
          'fecha' => $row['fechapresentacion'],
          'respuesta' => $row['respuesta'],
          'conclusion' => $row['conclusion'],
          'correcta' => $row['esCorrecta'],
          'tipo' => $row['tipo'],
          'nombreprueba' => $row['nombreprueba'],
          'imagen' => $row['imagen'],
        );
      }
    }
    return $send;
  }

  public function updateCuestionario($conclussion, $score, $idCuestionario)
  {
    $query = "update cuestionarios set conclusion = '" . $conclussion . "' , calificacion = " . $score . " where \"Id\" = " . $idCuestionario;
    $consulta = $this->db->executeQue($query);
    return $consulta;
  }
  public function updateAnswerGraphic($id, $ans)
  {
    $query = 'update respuestas set "esCorrecta" = ' . $ans . ' where "Id" =' . $id;
    $consulta = $this->db->executeQue($query);
    if (!$consulta) //If query couldnt be executed
    {
      return $this->db->error; //Display information about why wasnt executed (eg. Error: couldnt find table)
    } else {
      return true;
    }
  }
}
