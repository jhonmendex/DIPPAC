<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ProfilesModel extends ModelBase {

    public function getPerfiles($sortby='id', $maytomin=false) {
        $query = "SELECT p.idperfil, p.nombreperfil, p.grupo, 
                (SELECT count(*) from usuarios u where u.perfil=p.idperfil) as cantidad
                from perfiles p";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $perfiles = null;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $perfiles[] = array('id' => $row['idperfil'],
                    'nombre' => $row['nombreperfil'],
                    'grupo' => $row['grupo'],
                    'cantidad' => $row['cantidad']);
            }
        } else {
            return false;
        }
        $data = $this->orderBy($perfiles, $sortby);
        if ($maytomin) {
            $datafinal = array_reverse($data, true);
            $data = $datafinal;
        }
        return $data;
    }

    public function getMenusAndSubmenus($idperfil=null) {
        $query = "SELECT * from menus";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $permisos = null;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $query2 = "SELECT * from submenus where idmenu=" . $row['idmenu'];
                $consulta2 = $this->db->executeQue($query2);
                $total2 = $this->db->numRows($consulta2);
                if ($total2 > 0) {
                    while ($row2 = $this->db->arrayResult($consulta2)) {
                        $habil = 0;
                        if ($idperfil) {
                            $query3 = "SELECT * from perfiles_permisos where idsubmenu=" . $row2['idsubmenu'] . " and idperfil=$idperfil";
                        } else {
                            $query3 = "SELECT * from perfiles_permisos where idsubmenu=" . $row2['idsubmenu'];
                        }
                        $consulta3 = $this->db->executeQue($query3);
                        $total3 = $this->db->numRows($consulta3);
                        if ($total3 == 1) {
                            $habil = 1;
                        } else if ($total3 == 0) {
                            $habil = 0;
                        }
                        $permisos[$row['nombremenu']][] = array("idsub" => $row2['idsubmenu'],
                            "nombresub" => $row2['nombresubmenu'],
                            "iconsub" => $row2['icon_submenu'],
                            "permiso" => $habil);
                    }
                }
            }
        }
        return $permisos;
    }

    public function getPerfil($idperfil) {
        $query = "SELECT * from perfiles where idperfil=$idperfil";
        $consulta = $this->db->executeQue($query);
        $total = $this->db->numRows($consulta);
        $perfiles = null;
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $perfiles = array('id' => $row['idperfil'],
                    'nombre' => $row['nombreperfil'],
                    'grupo' => $row['grupo']);
            }
            return $perfiles;
        } else {
            return false;
        }
    }

    public function orderBy($data, $field) {
        $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
        usort($data, create_function('$a,$b', $code));
        return $data;
    }

    public function addSubmenusProfile() {
        if (isset($_POST["idveri"]) && isset($_POST["fomid"])) {
            if ($_POST["fomid"] == sha1(987934)) {
                $perfilid = base64_decode(urldecode(strrev($_POST["idveri"])));
                $submenu = $_POST['subitem'];
                $newval = $_POST['newval'];
                $query = "SELECT * from perfiles_permisos where idsubmenu=$submenu and idperfil=$perfilid";
                $consulta = $this->db->executeQue($query);
                $total = $this->db->numRows($consulta);
                if ($total == 0 && $newval == 1) {
                    $idquery = "select nextval('perfiles_permisos_id_idperfilespermisos_seq'::regclass) from perfiles_permisos limit 1";
                    $consult = $this->db->executeQue($idquery);
                    $idpp = 0;
                    while ($row = $this->db->arrayResult($consult)) {
                        $idpp = $row['nextval'];
                    }
                    $query = "insert into perfiles_permisos values($idpp,$perfilid,$submenu)";
                    $this->db->executeQue($query);
                }
            }
        }
    }

    public function removeSubmenusProfile() {
        if (isset($_POST["idveri"]) && isset($_POST["fomid"])) {
            if ($_POST["fomid"] == sha1(987934)) {
                $perfilid = base64_decode(urldecode(strrev($_POST["idveri"])));
                $submenu = $_POST['subitem'];
                $newval = $_POST['newval'];
                $query = "SELECT * from perfiles_permisos where idsubmenu=$submenu and idperfil=$perfilid";
                $consulta = $this->db->executeQue($query);
                $total = $this->db->numRows($consulta);
                if ($total > 0 && $newval == 0) {
                    while ($row = $this->db->arrayResult($consulta)) {
                        $idpp = $row['idperfilespermisos'];
                        $query2 = "DELETE from perfiles_permisos where idsubmenu=$submenu and idperfil=$perfilid and idperfilespermisos=$idpp";
                        $this->db->executeQue($query2);
                    }
                }
            }
        }
    }

    public function removeProfile() {
        if (isset($_POST["verify"])) {
            $perfilid = base64_decode(urldecode(strrev($_POST["verify"])));
            $query = "SELECT * from usuarios where perfil=$perfilid";
            $consulta = $this->db->executeQue($query);
            $total = $this->db->numRows($consulta);
            if ($total == 0) {                
                $this->db->executeQue("DELETE from perfiles_permisos where idperfil=$perfilid");
                $this->db->executeQue("DELETE from perfiles where idperfil=$perfilid");                
                $respuesta['res'] = 'si';
                $respuesta['idrow'] = $perfilid;
                echo json_encode($respuesta);
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    public function createProfile() {
        $group = $_POST['grupoperfil'];
        $perfilname = $_POST['nombreperfil'];
        $idquery = "select nextval('perfiles_id_perfil_seq'::regclass) limit 1";
        $consult = $this->db->executeQue($idquery);        
        $row = $this->db->arrayResult($consult);
        $idp = $row['nextval'];        
        $query = "insert into perfiles values($idp,'$perfilname','$group')";
        if ($this->db->executeQue($query)) {
            if (isset($_POST['permission'])) {
                foreach ($_POST['permission'] as $value) {
                    $idquery2 = "select nextval('perfiles_permisos_id_idperfilespermisos_seq'::regclass) limit 1";
                    $consult2 = $this->db->executeQue($idquery2);                    
                    $row2 = $this->db->arrayResult($consult2);
                    $idpp2 = $row2['nextval'];                    
                    $query3 = "insert into perfiles_permisos values($idpp2,$idp,$value)";
                    $this->db->executeQue($query3);
                }                
            }
            echo json_encode(array("respuesta"=>"si", 
                "grupo"=>$group, 
                "nombre"=>$perfilname,
                "id"=>$idp,
                "idid"=> sha1($idp),
                "verify"=>strrev(urlencode(base64_encode($idp)))));
        } else {
            echo json_encode(array("no"));
        }
    }

}

?>
