<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class NoVinculadoModel extends ModelBase {
    
    private function getPerfilNoVinculado(){
        $consult = $this->db->executeQue("select * from perfiles where grupo='No usuario'");
        $row = $this->db->arrayResult($consult);
        $idperfil = $row['idperfil'];  
        return $idperfil;
    }
    
    private function getBarrioName($idbarrio){
        $consult = $this->db->executeQue("select * from barrios where idbarrio=$idbarrio");
        $row = $this->db->arrayResult($consult);
        $nombrebarrio = $row['nombre'];  
        return $nombrebarrio;
    }
    
    private function getCiudadName($idciudad){
        $consult = $this->db->executeQue("select * from ciudades where idciudad=$idciudad");
        $row = $this->db->arrayResult($consult);
        $nombreciudad = $row['nombreciudad'];  
        return $nombreciudad;
    }

    public function noVinculado() {
        $idperfil=  $this->getPerfilNoVinculado();
        $usuario = strtoupper(trim($_POST["nombreusuario"]));
        $alias = strtoupper(trim($_POST["alias"]));
        $direccion = trim($_POST["direccion"]);
        $correo = trim($_POST["email"]);
        $cedula = trim($_POST["cedula"]);
        $ciudad = trim($_POST["ciudades"]);
        $barrio = $_POST["barrvin"]?trim($_POST["barrvin"]):"NULL";
        $phone = trim($_POST["telefono"]);
        $fechacumple = trim($_POST["born_date"]);
        $pass = trim($_POST["pass"]);
        $consult = $this->db->executeQue("select nextval('usuarios_idusuario_seq'::regclass) limit 1");        
        $row = $this->db->arrayResult($consult);
        $iduser = $row['nextval'];        
        $query = "insert into usuarios values ($iduser,1,$ciudad,$idperfil,'$usuario','$alias','".sha1($pass)."',$cedula,'$direccion',$phone,0,0,'" .
                date("Y-m-d") . "','$correo',3,'N/A','$fechacumple',$barrio,NULL)";
        if ($this->db->executeQue($query)) {
            if ($this->correoNoVinculado($correo, $usuario, $alias, $cedula, $pass,
                    $phone, $direccion, $_POST["barrvin"]?$this->getBarrioName($barrio):"N/A", $this->getCiudadName($ciudad),$fechacumple)) {
                return true;
            } else {
                $this->db->executeQue("delete from usuarios where idusuario=$iduser");
                return false;
            }
        } else {
            $this->db->executeQue("delete from usuarios where idusuario=$iduser");
            return false;
        }
    }

    private function correoNoVinculado($correo, $usuario, $alias, $cedula, $pass, $phone, $direccion, $barrio, $ciudad, $fechacumple) {
        $email = new Correo();
        $email2 = new Correo();
        $correoempresa = $this->config->get('mail');
        $nombreempresa = $this->config->get('company');
        $email->emailFrom($correoempresa);
        $email->nameFrom($nombreempresa);
        $email->subject("Registro completado $nombreempresa");        
        $email->emailTo($correo);
        $email->respondTo();
        $email2->emailFrom($correo);
        $email2->nameFrom($usuario);
        $email2->subject("Nuevo usuario No usuario");        
        $email2->emailTo($correoempresa);
        $email2->respondTo($correo);
        $bodymail = "<p>Bienvenidos a ".$this->config->get('company')." sus sue&ntilde;os hechos realidad, en un plazo de 48 un encargado de ".$this->config->get('company')." se comunicara 
            con usted para verificar los datos de su nueva cuenta, una vez se lleve a cabo la verificacion su cuenta sera activada para que pueda 
            ingresar a nuestro sistema.</p>";        
        $bodymail.='<p>A continuacion estan los datos ingresados en el registro:</p>';
        $bodymail2.='<p>Se ha registrado un nuevo usuario como No usuario, a continuacion se encuentra la informacion basica y de contacto del nuevo usuario:</p>';
        $bodymail.='<p><strong>1. Informacion basica:</strong></p>';
        $bodymail2.='<p><strong>1. Informacion basica:</strong></p>';
        $bodymail.='<table><tr><td>Nombre:</td><td>' . $usuario . '</td></tr>';
        $bodymail2.='<table><tr><td>Nombre:</td><td>' . $usuario . '</td></tr>';
        $bodymail.='<tr><td>Fecha de nacimiento:</td><td>' . $fechacumple . '</td></tr>';
        $bodymail2.='<tr><td>Fecha de nacimiento:</td><td>' . $fechacumple . '</td></tr>';
        $bodymail.='<tr><td>Cedula:</td><td>' . $cedula . '</td></tr></table>';
        $bodymail2.='<tr><td>Cedula:</td><td>' . $cedula . '</td></tr></table>';
        $bodymail.='<p><strong>2. Informacion de contacto:</strong></p>';
        $bodymail2.='<p><strong>2. Informacion de contacto:</strong></p>';
        $bodymail.='<table><tr><td>Ciudad:</td><td>' . $ciudad . '</td></tr>';
        $bodymail2.='<table><tr><td>Ciudad:</td><td>' . $ciudad . '</td></tr>';
        $bodymail.='<tr><td>Barrio:</td><td>' . $barrio . '</td></tr>';        
        $bodymail2.='<tr><td>Barrio:</td><td>' . $barrio . '</td></tr>';
        $bodymail.='<tr><td>Direccion:</td><td>' . $direccion . '</td></tr>';
        $bodymail2.='<tr><td>Direccion:</td><td>' . $direccion . '</td></tr>';
        $bodymail.='<tr><td>Telefono:</td><td>' . $phone . '</td></tr>';
        $bodymail2.='<tr><td>Telefono:</td><td>' . $phone . '</td></tr>';
        $bodymail.='<tr><td>Correo:</td><td>' . $correo . '</td></tr></table>';
        $bodymail2.='<tr><td>Correo:</td><td>' . $correo . '</td></tr></table>';
        $email2->mailBody($bodymail2);        
        $bodymail.='<p><strong>3. Informacion de usuario:</strong></p>';
        $bodymail.='<table><tr><td>Alias:</td><td>' . $alias . '</td></tr>';
        $bodymail.='<tr><td>Password:</td><td>' . $pass . '</td></tr></table>';
        $email->mailBody($bodymail);
        if ($email->send()&&$email2->send()) {
            return true;
        } else {
            return false;
        }
    }

    private function generatepass($length) {
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{rand(0, 61)};
        }
        return $key;
    }

    private function updatePass($newpass, $iduser) {
        $this->db->executeQue("update usuarios set password='$newpass' where idusuario=$iduser");
    }

    public function valAlias() {        
        $search = strtoupper(trim($_POST['aliasUser']));
        $consulta = $this->db->executeQue("select * from usuarios where alias='$search'");
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            $name_user = null;
            $row = $this->db->arrayResult($consulta);
            $name_user['id'] = $row['idusuario'];
            $name_user['nombre'] = $row['nombreusuario'];
            $name_user['alias'] = $row['alias'];           
            $name_user['password'] = $this->generatepass(8);
            $name_user['email'] = $row['email'];            
            if ($this->recoveryPass($name_user)) {
                $this->updatePass(sha1($name_user['password']),$name_user['id']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function recoveryPass($user) {
        $email = new Correo();
        $correoempresa = $this->config->get('mail');
        $nombreempresa = $this->config->get('company');
        $email->emailFrom($correoempresa);
        $email->nameFrom($nombreempresa);
        $email->subject("Restablecer Password ".$this->config->get('company'));
        $email->emailTo(trim($user['email']));        
        $email->respondTo();
        $bodymail = '<table><tr><td><Strong>Se ha generado una nueva contrase&ntilde;a para el ingrso a la plataforma, a continuacion presentamos su informacion de usuario:</strong></td></tr>';
        $bodymail.='<tr><td>Nombre: </td><td>' . $user['nombre'] . '</td></tr>';
        $bodymail.='<tr><td>Correo: </td><td>' . $user['email'] . '</td></tr>';
        $bodymail.='<tr><td>Alias: </td><td>' . $user['alias'] . '</td></tr>';
        $bodymail.='<tr><td>Password: </td><td>' . $user['password'] . '</td></tr></table>';
        $email->mailBody($bodymail);
        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }

}

?>