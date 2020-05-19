<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

require ('classes/Usuario.php');

class UserModel extends ModelBase {

    public function LoginUser() {        
        $pass = $_POST['pwd'];
        $user = $_POST['user'];
        $validacion = Validacion::singleton();
        if ($validacion->Login($user, $pass)) {   
            header('Location: index.php');
        } else {
            header('location: index.php?controlador=User&accion=Login&message=error');
        }
    }

    public function LogoutUser() {
        $validacion = Validacion::singleton();
        $validacion->Logout();
    }

    public function getUserId() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getIdUser();
    }

    public function getUserName() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getNameUser();
    }

    public function getUserProfile() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getPerfilUser();
    }
    
    public function getUserProfileName() {
        $usuario = unserialize($_SESSION['user']);
        $idperfil= $usuario->getPerfilUser();
        $result=$this->db->executeQue("select nombreperfil from perfiles where idperfil=$idperfil");
        $row=$this->db->arrayResult($result);        
        return $row["nombreperfil"];
    }

    public function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

    public function getMenus() {
        $perfil = $this->getUserProfile();
        $menus_user = null;        
            $consulta = $this->db->executeQue("select distinct(submenus.idmenu), menus.nombremenu, menus.url_main 
                    from perfiles_permisos, submenus, menus 
                    where idperfil=$perfil and perfiles_permisos.idsubmenu=submenus.idsubmenu and menus.idmenu=submenus.idmenu
                    order by menus.nombremenu asc");
            $total = $this->db->numRows($consulta);
            if ($total > 0) {
                while ($row = $this->db->arrayResult($consulta)) {
                    $menus_user[] = array('idmen' => $row['idmenu'], 'namemen' => $row['nombremenu'], 'urlprin' => $row['url_main']);
                }
            }       
        return $menus_user;
    }

    public function getSubmenus($mainmenu) {
        $perfil = $this->getUserProfile();
        $menus_user = null;
        if (isset($_GET['idmenu'])) {
            $menu = $_GET['idmenu'];
        } else {
            $menu = $mainmenu;
        }
        $consulta = null;
        if ($perfil == 5 || $perfil == 3) {
            $consulta = $this->db->executeQue("select submenus.url_submenu,submenus.nombresubmenu, submenus.icon_submenu from perfiles_permisos, submenus where idperfil=$perfil and submenus.idsubmenu=perfiles_permisos.idsubmenu and idmenu=1");
        } else {
            $consulta = $this->db->executeQue("select submenus.url_submenu,submenus.nombresubmenu, submenus.icon_submenu from perfiles_permisos, submenus where idperfil=$perfil and submenus.idsubmenu=perfiles_permisos.idsubmenu and idmenu=$menu");
        }

        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $menus_user[] = array('urlmenu' => $row['url_submenu'], 'icono' => $row['icon_submenu'],'nombresubmenu' => $row['nombresubmenu']);
            }
        }

        return $menus_user;
    }

    public function getMenuName($mainmenu) {
        $perfil = $this->getUserProfile();
        if (isset($_GET['idmenu'])) {
            $menu = $_GET['idmenu'];
        } else {
            $menu = $mainmenu;
        }
        $consulta = null;
        $nombremenu = null;
        if ($perfil == 5 || $perfil == 3) {
            $consulta = $this->db->executeQue("select * from menus where idmenu=1");
        } else {
            $consulta = $this->db->executeQue("select * from menus where idmenu=$menu");
        }
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $nombremenu = $row['nombremenu'];
            }
        }
        return $nombremenu;
    }

    public function getUserById($id_user) {
        $consulta = $this->db->executeQue("select * from usuarios where idusuario=$id_user");
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            $name_user = null;
            while ($row = $this->db->arrayResult($consulta)) {
                $name_user['nombre'] = $row['nombreusuario'];
                $name_user['ciudad'] = $row['ciudad'];
                $name_user['cedula'] = $row['cedula'];
                $name_user['email'] = $row['email'];
                $name_user['direcion'] = $row['direccion'];
                $name_user['fechacumple'] = $row['nombreusuario'];
                $name_user['fax'] = $row['fax'];
                $name_user['telefono'] = $row['telefonocasa'];
                $name_user['celular'] = $row['telefonooficina'];
                $name_user['alias'] = $row['alias'];
                $name_user['id'] = $row['idusuario'];
            }
            return $name_user;
        } else {
            return false;
        }
    }

    /*
     * 
     * 
     * AJX METHODS
     * 
     * 
     */

    public function getUserNameAjax() {
        session_start();
        $id_user = $_GET['sponsor'];
        $usuario = unserialize($_SESSION['user']);
        if ($id_user == $usuario->getIdUser()) {
            return $usuario->getNameUser();
        } else {
            $consulta = $this->db->executeQue("select * from usuarios where idusuario=$id_user");
            $total = $this->db->numRows($consulta);
            if ($total > 0) {
                $name_sponsor = null;
                while ($row = $this->db->arrayResult($consulta)) {
                    $name_sponsor = $row['nombreusuario'];
                }
                return $name_sponsor;
            } else {
                return null;
            }
        }
    }

     public function verifyNet($user){
        $consulta = $this->db->executeQue("select * from usuarios");
        $total = $this->db->numRows($consulta);
        if ($total >= 2)  
            {  
            return true;
            }
            else { 
            return false;
            }
            
     }
}

?>