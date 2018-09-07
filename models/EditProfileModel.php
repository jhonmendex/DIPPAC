<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class EditProfileModel extends ModelBase {

    public function getSelectDepartamentos() {
        $consulta = $this->db->executeQue('select * from departamentos order by nombredepartamento');
        $total = $this->db->numRows($consulta);
        $tagselect = "<select name='departamentos' id='departamentos'>";
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $nombre_departamento = $row['nombredepartamento'];
                $id_departamento = $row['iddepartamento'];
                $tagselect.="<option value='" . $id_departamento . "'>" . $nombre_departamento . "</option>";
            }
        }
        $tagselect.="</select>";
        return $tagselect;
    }

    private function getFirstDepartamentoId() {
        $consulta = $this->db->executeQue('select * from departamentos order by nombredepartamento limit 1');
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $id_departamento = $row['iddepartamento'];
                return $id_departamento;
            }
        }
    }

    public function getSelectCiudades($iddepartamento = 0) {
        if ($iddepartamento == 0) {
            $iddepartamento = $this->getFirstDepartamentoId();
        }
        $consulta = $this->db->executeQue('select * from ciudades where iddepartamento=' . $iddepartamento . ' order by nombreciudad');
        $total = $this->db->numRows($consulta);

        $tagselect = "<select id='ciudades' name='ciudades'>";
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $nombre_ciudad = $row['nombreciudad'];
                $id_ciudad = $row['idciudad'];
                $tagselect.="<option value='" . $id_ciudad . "'>" . $nombre_ciudad . "</option>";
            }
        }
        $tagselect.="</select>";
        return $tagselect;
    }

    public function getChangeCiudades() {
        $iddepart = $_GET['departamento'];
        $ciudadesNew = $this->getSelectCiudades($iddepart);
        return $ciudadesNew;
    }

    public function getUserProfile($idusuario) {
        $consulta = $this->db->executeQue("select * from usuarios where idusuario=$idusuario");
        while ($row = $this->db->arrayResult($consulta)) {
            $ciudad = $row['ciudad'];
            $nombre = $row['nombreusuario'];
            $cedula = $row['cedula'];
            $direccion = $row['direccion'];
            $telefono = $row['telefonocasa'];
            $celular = $row['telefonooficina'];
            $email = $row['email'];
            $fechac = $row['fechacumple'];
            $fax = $row['fax'];
            $usuario = new Usuario();
            $usuario->setCiudad($ciudad);
            $usuario->setNombre($nombre);
            $usuario->setCedula($cedula);
            $usuario->setDireccion($direccion);
            $usuario->setTelefono($telefono);
            $usuario->setMovil($celular);
            $usuario->setEmail($email);
            $usuario->setFechaNacimiento($fechac);
            $usuario->setFax($fax);
            return $usuario;
        }
    }

    public function traerDepto($idciudad) {
        $consulta = $this->db->executeQue("select * from ciudades  where idciudad=$idciudad");
        while ($row = $this->db->arrayResult($consulta)) {
            $iddepartamento = $row['iddepartamento'];
            return $iddepartamento;
        }
    }

    public function updateProfile($idusuario) {
        $nombre = strtoupper(trim($_POST["full_name"]));
        $cedula = trim($_POST["cedula"]);
        $fborn = $_POST["born_date"];
        $correo = trim($_POST["email"]);
        $telefono = $_POST["phone"] ? $_POST["phone"]:"NULL";
        $celuar = $_POST["movil"] ? $_POST["movil"]:"NULL";
        $ciudad = $_POST["ciudades"];
        $direccion = trim($_POST["address"]);
        $fax = $_POST["fax"] ? $_POST["fax"]:"NULL";
        if ($this->db->executeQue("update usuarios 
                set nombreusuario = '$nombre',
                cedula = '$cedula',
                fechacumple='$fborn',
                email='$correo',
                telefonocasa=$telefono,
                telefonooficina=$celuar,
                direccion='$direccion',
                fax=$fax,
                ciudad='$ciudad' 
                where idusuario = '$idusuario'")) {
            echo json_encode(array("respuesta"=>"si"));
        } else {
            echo json_encode(array("respuesta"=>"no"));
        }
    }

}

?>
