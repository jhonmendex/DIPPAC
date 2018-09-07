<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class SupplierModel extends ModelBase {

    public function createSupplier() {
        $nombre = strtoupper(trim($_POST["name_supplier"]));
        $nit = trim($_POST["nit"]);
        $ciudad = trim($_POST["ciudades"]);
        $direccion = trim($_POST["address_supplier"]) != "" ? "'" . trim($_POST["address_supplier"]) . "'" : "NULL";
        $telefono = trim($_POST["phone_supplier"]);
        $email = trim($_POST["email_supplier"]) != "" ? "'" . trim($_POST["email_supplier"]) . "'" : "NULL";
        $contacto = trim($_POST["namecontact"]);
        $celular = trim($_POST["cellphone_supplier"]) != "" ? trim($_POST["cellphone_supplier"]) : "NULL";
        $consult = $this->db->executeQue("select nextval('terceros_idtercero_seq'::regclass) limit 1");
        $row = $this->db->arrayResult($consult);
        $idtercero = $row['nextval'];
        $query = "insert into terceros values ($idtercero,'$nombre', $direccion,$telefono,$nit,$ciudad,$celular,'$contacto',$email)";
        if ($this->db->executeQue($query)) {
            $idverify = strrev(urlencode(base64_encode($idtercero)));
            $idid = sha1($idtercero);
            echo json_encode(array("respuesta" => "si",
                "id" => $idtercero,
                "nombre" => $nombre,
                "nit" => $nit,
                "telefono" => $telefono,
                "idid" => $idid,
                "verify" => $idverify,
                "contacto" => $contacto,
                "email" => $email == "NULL" ? "" : str_replace("'", "", $email)));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
    }

    public function getSuppliers() {
        $query = "SELECT t.idtercero, t.nombretercero, t.direccion, t.telefono,
            t.nit, t.ciudad, t.celulartercero, t.emailtercero, t.contactotercero,
            (select count(*) from documentos d where d.idtercero=t.idtercero) as movimientos,
            (select count(*) from productosproveedores pp where pp.idproveedor=t.idtercero) as productos
            from terceros t 
            order by nombretercero asc";
        $consulta = $this->db->executeQue($query);        
        while ($row = $this->db->arrayResult($consulta)) {           
            $proveedores[] = array('id' => $row['idtercero'],
                'nombre' => $row['nombretercero'],
                'direccion' => $row['direccion'],
                'telefono' => $row['telefono'],
                'nit' => $row['nit'],
                'ciudad' => $row['ciudad'],
                'contacto' => $row['contactotercero'],
                'email' => $row['emailtercero'],
                'movimientos' => $row['movimientos'],
                'productos' => $row['productos']);
        }
        return $proveedores;
    }

    public function getSupplier() {
        $idtercero = $_GET['idtercero'];
        $query = "SELECT * from terceros where idtercero=$idtercero";
        $consulta = $this->db->executeQue($query);
        $proveedor = null;
        while ($row = $this->db->arrayResult($consulta)) {
            $proveedor = array('id' => $row['idtercero'],
                'nombre' => $row['nombretercero'],
                'direccion' => $row['direccion'],
                'telefono' => $row['telefono'],
                'nit' => $row['nit'],
                'ciudad' => $row['ciudad'],
                'contacto' => $row['contactotercero'],
                'celular' => $row['celulartercero'],
                'email' => $row['emailtercero']);
        }
        $query = "SELECT * from ciudades where idciudad=" . $proveedor['ciudad'];
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $proveedor['departamento'] = $row['iddepartamento'];
        }
        return $proveedor;
    }

    public function updateSupplier() {
        if (isset($_POST["verification"]) && isset($_POST["formid"])) {
            if ($_POST["formid"] == sha1(59216)) {
                $idtercero = base64_decode(urldecode(strrev($_POST["verification"])));
                $nombre = strtoupper(trim($_POST["name_supplier"]));
                $ciudad = trim($_POST["ciudades"]);                
                $direccion = trim($_POST["address_supplier"]) != "" ? "'" . trim($_POST["address_supplier"]) . "'" : "NULL";
                $telefono = trim($_POST["phone_supplier"]);
                $email = trim($_POST["email_supplier"]) != "" ? "'" . trim($_POST["email_supplier"]) . "'" : "NULL";
                $contacto = trim($_POST["namecontact"]);
                $celular = trim($_POST["cellphone_supplier"]) != "" ? trim($_POST["cellphone_supplier"]) : "NULL";
                $query = "update terceros set nombretercero = '$nombre', 
                            direccion = $direccion, 
                            telefono='$telefono', 
                            ciudad=$ciudad,
                            celulartercero=$celular,
                            contactotercero='$contacto', 
                            emailtercero=$email 
                            where idtercero = $idtercero";
                if ($this->db->executeQue($query)) {                    
                    echo json_encode(array("respuesta" => "si",
                        "id" => $idtercero,
                        "nombre" => $nombre,
                        "telefono" => $telefono,
                        "contacto" => $contacto,
                        "email" => $email == "NULL" ? "" : str_replace("'", "", $email)));
                } else {
                    echo json_encode(array("respuesta" => "no"));
                }
            } else {
                echo json_encode(array("respuesta" => "nono", "url"=>$_GET['controlador']));                
            }
        } else {          
            echo json_encode(array("respuesta" => "nono", "url"=>$_GET['controlador']));
        }
    }

    public function deleteSupplier() {
        if (isset($_POST["verify"])) {
            $terceroid = base64_decode(urldecode(strrev($_POST["verify"])));
            $query4 = "delete from terceros where idtercero=$terceroid";
            if ($this->db->executeQue($query4)) {
                $respuesta['res'] = 'si';
                $respuesta['idrow'] = $terceroid;
                echo json_encode($respuesta);
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    public function getProductosSupplier() {
        $tercero = $_GET['idtercero'];
        $consulta = "select pp.ultimocosto, pr.nombreproducto, t.nombretercero, pr.referencia
                    from productosproveedores pp, productos pr, terceros t 
                    where pr.idproducto=pp.idproducto and t.idtercero=pp.idproveedor and pp.idproveedor=$tercero";
        $resultado = $this->db->executeQue($consulta);
        while ($row = $this->db->arrayResult($resultado)) {
            $productos[] = array('referencia' => $row['referencia'],
                'nombre' => $row['nombreproducto'],
                'costo' => $row['ultimocosto'],
                'nombreproveedor' => $row['nombretercero']);
        }
        return $productos;
    }

}

?>
