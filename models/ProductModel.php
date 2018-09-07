<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ProductModel extends ModelBase {
    
    public function getProductsTodos() {
        $query = "SELECT p.idproducto, p.nombreproducto, p.referencia, p.puntos, p.iva, 
                    p.estado, p.precio, p.unidadmedida, (select count(*) as proveedores from productosproveedores ppp where ppp.idproducto=p.idproducto) as proveedores
                    from productos p
            where estado='activo'
                and p.referencia<>'LICINS'
            order by nombreproducto asc";            
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $productos[] = array('id' => $row['idproducto'],
                'nombre' => $row['nombreproducto'],
                'referencia' => $row['referencia'],
                'puntos' => $row['puntos'],
                'iva' => $row['iva'],
                'estado' => $row['estado'],
                'precio' => $idbodega ? $row['preciobase'] : $row['precio'],
                'unidad' => $row['unidadmedida'],
                'proveedores' => $row['proveedores']);
        }
        return $productos;
    }

    public function getProducts($idcat, $active = false) {
        $idbodega = $this->getUserBodega();
        if ($idbodega) {
            if ($active) {
                $query = "SELECT p.idproducto, p.nombreproducto, p.referencia, p.puntos, p.iva, 
                    p.estado, b.preciobase, p.precio, p.unidadmedida, (select count(*) as proveedores from productosproveedores ppp where ppp.idproducto=p.idproducto) as proveedores
                    from productos p, bodegasproductos b
            where p.idcategoria=$idcat
                and p.estado='activo'
                and b.idproducto=p.idproducto
                and b.idbodega=$idbodega
                and p.referencia<>'LICINS'
            order by p.nombreproducto asc";
            } else {
                $query = "SELECT p.idproducto, p.nombreproducto, p.referencia, p.puntos, p.iva, 
                    p.estado, b.preciobase, p.precio, p.unidadmedida, (select count(*) as proveedores from productosproveedores ppp where ppp.idproducto=p.idproducto) as proveedores
                    from productos p, bodegasproductos b
            where p.idcategoria=$idcat
                and b.idproducto=p.idproducto 
                and b.idbodega=$idbodega 
                and p.referencia<>'LICINS'
            order by p.nombreproducto asc";
            }
        } else {
            if ($active) {
                $query = "SELECT p.idproducto, p.nombreproducto, p.referencia, p.puntos, p.iva, 
                    p.estado, p.precio, p.unidadmedida, (select count(*) as proveedores from productosproveedores ppp where ppp.idproducto=p.idproducto) as proveedores
                    from productos p
            where idcategoria=$idcat
                and estado='activo'
                and p.referencia<>'LICINS'
            order by nombreproducto asc";
            } else {
                $query = "SELECT p.idproducto, p.nombreproducto, p.referencia, p.puntos, p.iva, 
                    p.estado, p.precio, p.unidadmedida, (select count(*) as proveedores from productosproveedores ppp where ppp.idproducto=p.idproducto) as proveedores
                    from productos p
            where idcategoria=$idcat
                and p.referencia<>'LICINS'
            order by nombreproducto asc";
            }
        }
        $consulta = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($consulta)) {
            $productos[] = array('id' => $row['idproducto'],
                'nombre' => $row['nombreproducto'],
                'referencia' => $row['referencia'],
                'puntos' => $row['puntos'],
                'iva' => $row['iva'],
                'estado' => $row['estado'],
                'precio' => $idbodega ? $row['preciobase'] : $row['precio'],
                'unidad' => $row['unidadmedida'],
                'proveedores' => $row['proveedores']);
        }
        return $productos;
    }

    public function getProduct($idpro) {
        $idbodega = $this->getUserBodega();
        if (!$idbodega) {
            $query = "SELECT * from productos p, categoriasp c, imagenes i
        where p.idproducto=$idpro and p.idimagen=i.idimagen and p.idcategoria=c.idcategoria
        limit 1";
        } else {
            $query = "SELECT * from productos p, categoriasp c, imagenes i, bodegasproductos b
        where p.idproducto=$idpro and p.idimagen=i.idimagen and p.idcategoria=c.idcategoria and b.idproducto=p.idproducto and b.idbodega=$idbodega
        limit 1";
        }
        $consulta = $this->db->executeQue($query);
        $row = $this->db->arrayResult($consulta);
        $imagennnn = $this->corregirImagen($row['url']);
        if ($imagennnn != $row['url']) {
            unlink($row['url']);
            $this->db->executeQue("update imagenes set url='$imagennnn' where idimagen=" . $row['idimagen']);
        }
        $producto = array('id' => $row['idproducto'],
            'nombre' => $row['nombreproducto'],
            'referencia' => $row['referencia'],
            'iva' => $row['iva'],
            'precio' => $idbodega ? $row['preciobase'] : $row['precio'],
            'idcategoria' => $row['idcategoria'],
            'idimagen' => $row['idimagen'],
            'unidad' => $row['unidadmedida'],
            'imagen' => $imagennnn,
            'porcentajeutilidad' => $row['porcentajeutilidad']);
        return $producto;
    }

    private function corregirImagen($urlimagen) {
        $nombreimagen = explode(".", $urlimagen);
        $imagen = new Imagen($urlimagen);
        $imagen->redimencionMaximum(200);
        $url_new = $imagen->guardar($nombreimagen[0], 80, true);
        return $url_new;
    }

    public function uploadPicture() {
        if ($_FILES["pic"]["size"] != 0) {
            $destino = $_FILES["pic"]["name"];
            copy($_FILES["pic"]["tmp_name"], $destino);
            $imagen = new Imagen($destino);
            $imagen->redimencionMaximum(200, 200);
            $namefile = time();
            $url_new = $imagen->guardar(IMAGES . SL . "images_shop" . SL . time(), 80, true);
            unlink($destino);
            $idquery = "select nextval('imagenes_idimagen_seq'::regclass) from imagenes limit 1";
            $consult = $this->db->executeQue($idquery);
            $idproducto = 0;
            while ($row = $this->db->arrayResult($consult)) {
                $idproducto = $row['nextval'];
            }
            $query = "insert into imagenes values ($idproducto,'product$namefile','$url_new')";
            $consult = $this->db->executeQue($query);
            if (isset($_POST['versioning'])) {
                echo "<script> function terminarfin2(){ $('#nonemig',window.parent.document).html('<img title=\"\"  alt=\"plentiful\" src=\"" .
                $url_new . "\" /><input type=\"hidden\" name=\"imagen\" value=\"" . $idproducto . "\"/>');" .
                "parent.parent.message('Imagen subida con exito', 'images/iconos_alerta/ok.png');" .
                "parent.$.fancybox.close();}setTimeout('terminarfin2()','300');</script>";
            } else {
                echo json_encode(array('status' => 'ok',
                    'newurl' => $url_new,
                    'idprod' => $idproducto));
            }
        }
    }

    /*
     * 
     * 
     */

    public function categorias() {
        $categorias = array();
        $consulta = $this->db->executeQue("select * from categoriasp order by nombrecategoria asc");
        $resultados = $this->db->numRows($consulta);
        if ($resultados == 0) {
            
        } else {
            while ($row = $this->db->arrayResult($consulta)) {
                $categorias[$row['idcategoria']] = $row['nombrecategoria'];
            }
        }
        return $categorias;
    }

    public function primeraCategoria() {
        $consulta = $this->db->executeQue("select * from categoriasp order by nombrecategoria asc");
        $resultados = $this->db->numRows($consulta);
        if ($resultados == 0) {
            return false;
        } else {
            $primeraCategoria = $this->db->arrayResult($consulta);
            return $primeraCategoria['idcategoria'];
        }
    }

    public function crearProducto() {
        $nombrepro = strtoupper($_POST['name_products']);
        $idimagen = $_POST['imagen'];
        $unidad = $_POST['unidad'];
        $referencia = $_POST['referencia'];
        $precio = str_replace(",", ".", $_POST['price']);
        $iva = str_replace(",", ".", $_POST['iva']);
        $precioiva = (($precio * $iva) / 100) + $precio;
        $puntos = $precioiva / $this->config->get('pointvalue');
        $idcategoria = $_POST['categorias'];
        $comisionable = str_replace(",", ".", $_POST['comission']);
        $consult = $this->db->executeQue("select nextval('productos_idproducto_seq'::regclass) limit 1");
        $row = $this->db->arrayResult($consult);
        $idproducto = $row['nextval'];
        if ($this->db->executeQue("insert into productos " . "
                values($idproducto,$idcategoria,'$nombrepro',$puntos,$idimagen,$referencia,$iva,'activo',$precio,$precioiva,NULL,NULL,NULL,NULL,NULL,NULL,NULL,$comisionable,'$unidad')")) {
            $consultica = $this->db->executeQue("select bodegaid from bodegas");
            if ($this->db->numRows($consultica) > 0) {
                while ($fila = $this->db->arrayResult($consultica)) {
                    $idbodega = $fila['bodegaid'];
                    $this->db->executeQue("insert into bodegasproductos values(nextval('bodegasproductos_idbodegaproductos_seq'::regclass),
                    $idbodega,$idproducto,0,NULL,NULL,0,$precio)");
                }
            }
            echo json_encode(array("respuesta" => "si"));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
    }

    public function getProveedoresProducto() {
        $producto = $_GET['idpro'];
        $query = "select  pp.ultimocosto, p.nombreproducto, t.nombretercero, t.nit, t.telefono
        from productosproveedores pp, terceros t, productos p
        where pp.idproducto=p.idproducto and t.idtercero=pp.idproveedor and pp.idproducto=$producto";
        $resultado = $this->db->executeQue($query);
        while ($row = $this->db->arrayResult($resultado)) {
            $proovedores[] = array('nit' => $row['nit'],
                'producto' => $row['nombreproducto'],
                'costo' => $row['ultimocosto'],
                'nombre' => $row['nombretercero'],
                'telefono' => $row['telefono']);
        }
        return $proovedores;
    }

    public function updateProduct() {
        $idbodega = $this->getUserBodega();
        $nombrepro = strtoupper(trim($_POST['name_products']));
        $refe = trim($_POST['referencia']);
        $idimagen = $_POST['imagen'];
        $idproducto = $_POST['idproducto'];
        $unidad = trim($_POST['unidad']);
        $precio = str_replace(",", ".", trim($_POST['price']));
        $iva = str_replace(",", ".", trim($_POST['iva']));
        $precioiva = (($precio * $iva) / 100) + $precio;
        $puntos = $precioiva / $this->config->get('pointvalue');
        $idcategoria = $_POST['categorias'];
        $comisionable = str_replace(",", ".", $_POST['comission']);
        if ($idbodega) {
            $query = "update productos set 
                idcategoria=$idcategoria, nombreproducto='$nombrepro', puntos=$puntos, idimagen=$idimagen, 
                iva=$iva, porcentajeutilidad=$comisionable, referencia='$refe'
                where idproducto=$idproducto;
                update bodegasproductos set preciobase=$precio where idproducto=$idproducto and idbodega=$idbodega";
            $query2 = "select costo from bodegasproductos where idproducto=$idproducto and idbodega=$idbodega";
            $resres = $this->db->executeQue($query2);
            $row = $this->db->arrayResult($resres);
            if ($row["costo"] != 0) {
                $this->updateUtilityProducto($idproducto, $row["costo"]);
            }
        } else {
            $query = "update productos set 
                idcategoria=$idcategoria, nombreproducto='$nombrepro', puntos=$puntos, idimagen=$idimagen, 
                iva=$iva, precio=$precio, precioiva=$precioiva, porcentajeutilidad=$comisionable, referencia='$refe'
                where idproducto=$idproducto";
        }
        if ($this->db->executeQue($query)) {
            $puntos = number_format($puntos, 2, ",", ".");
            $precio = number_format($precio, 0, ",", ".");
            $precioiva = number_format($precioiva, 0, ",", ".");
            echo json_encode(array("respuesta" => "si",
                "id" => $idproducto,
                "nombre" => $nombrepro,
                "puntos" => $puntos,
                "iva" => $iva,
                "precio" => $precio,
                "precioiva" => $precioiva,
                "referencia" => $refe,
                "unidad" => $unidad,
                "idcategoria" => $idcategoria));
        } else {
            echo json_encode(array("respuesta" => "no"));
        }
    }

    private function getUserBodega() {
        $usuario = unserialize($_SESSION['user']);
        return $usuario->getBodega();
    }

    private function updateUtilityProducto($idproducto, $costoUpdated) {
        $consulta = $this->db->executeQue("select * from productos where idproducto=$idproducto");
        $file = $this->db->arrayResult($consulta);
        if ($file['porcentajeutilidad'] != 0 || $file['porcentajeutilidad'] != "NULL") {
            $porcentaje = $file['porcentajeutilidad'];
        } else {
            $porcentaje = 100;
        }
        $utilidadtotaltmp = $file['precio'] - $costoUpdated;
        $utilidadtotal = ($utilidadtotaltmp * $porcentaje) / 100;
        $nivel0 = ($utilidadtotal * 12) / 100;
        $nivel1 = ($utilidadtotal * 7) / 100;
        $nivel2 = ($utilidadtotal * 15) / 100;
        $nivel3 = ($utilidadtotal * 8) / 100;
        $niveln = ($utilidadtotal * 3) / 100;
        $utilidadplentiful = $utilidadtotal - $nivel0 - $nivel1 - $nivel2 - $nivel3 - $niveln;
        $query2 = "update productos set utilidadtotal=$utilidadtotal, utilidadplentiful=$utilidadplentiful, 
        nivel0=$nivel0, nivel1=$nivel1, nivel2=$nivel2, nivel3=$nivel3, niveli=$niveln, porcentajeutilidad=$porcentaje
        where idproducto=$idproducto";
        $this->db->executeQue($query2);
    }

    public function getPerfilGrupe() {
        $usuario = unserialize($_SESSION['user']);
        $idperfil = $usuario->getPerfilUser();
        $resultset = $this->db->executeQue("select grupo from perfiles where idperfil=$idperfil");
        $row = $this->db->arrayResult($resultset);
        return $row["grupo"];
    }

    public function getCategoriasComplete() {
        $consulta = $this->db->executeQue("select cp.idcategoria, cp.nombrecategoria, 
                (select count(*) from productos p where p.idcategoria=cp.idcategoria) as productos
                from categoriasp cp
                order by cp.nombrecategoria asc");
        while ($row = $this->db->arrayResult($consulta)) {
            $categorias[] = array("id" => $row["idcategoria"],
                "nombre" => $row["nombrecategoria"],
                "productos" => $row["productos"]);
        }
        return $categorias;
    }

    public function deleteCategoria() {
        if (isset($_POST["verify"])) {
            $categoriaid = base64_decode(urldecode(strrev($_POST["verify"])));
            if ($this->verificarProductosCat($categoriaid) == 0) {
                $query3 = "delete from categoriasp where idcategoria=$categoriaid";
                if ($this->db->executeQue($query3)) {
                    $respuesta['res'] = 'si';
                    $respuesta['idrow'] = $categoriaid;
                    echo json_encode($respuesta);
                } else {
                    $respuesta['res'] = 'no';
                    echo json_encode($respuesta);
                }
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    private function verificarProductosCat($categoriaid) {
        $rs = $this->db->executeQue("select * from productos where idcategoria=$categoriaid");
        return $this->db->numRows($rs);
    }

    public function insertCategoryAjax() {
        $nombrecat = strtoupper(trim($_POST['nombrecategoria']));
        $idquery = "select nextval('categoriasp_idcategoria_seq'::regclass) limit 1";
        $consult = $this->db->executeQue($idquery);
        $row = $this->db->arrayResult($consult);
        $idcategoria = $row['nextval'];
        if ($this->db->executeQue("insert into categoriasp values($idcategoria,'$nombrecat')")) {
            $respuesta['respuesta'] = 'si';
            $respuesta['id'] = $idcategoria;
            $respuesta['idcode'] = sha1($idcategoria);
            $respuesta['idverify'] = strrev(urlencode(base64_encode($idcategoria)));
            $respuesta['nombre'] = $nombrecat;
            echo json_encode($respuesta);
        } else {
            $respuesta['respuesta'] = 'no';
            echo json_encode($respuesta);
        }
    }

    public function updateCategoryAjax() {
        $nombrecat = strtoupper(trim($_POST['nombrecategoria']));
        $idcat = $_POST['idcategoria'];
        if ($this->db->executeQue("update categoriasp set nombrecategoria='$nombrecat' where idcategoria=$idcat")) {
            $respuesta['respuesta'] = 'si';
            $respuesta['id'] = $idcat;
            $respuesta['nombre'] = $nombrecat;
            echo json_encode($respuesta);
        } else {
            $respuesta['respuesta'] = 'no';
            echo json_encode($respuesta);
        }
    }

    public function getNameCatByName($idcategoria) {
        $rs = $this->db->executeQue("select nombrecategoria from categoriasp where idcategoria=$idcategoria");
        $row = $this->db->arrayResult($rs);
        return $row["nombrecategoria"];
    }

    public function disablePro() {
        if (isset($_POST["verify"])) {
            $idproducto = base64_decode(urldecode(strrev($_POST["verify"])));
            if ($this->db->executeQue("update productos set estado='inactivo' where idproducto=$idproducto")) {
                $respuesta['res'] = 'si';
                $respuesta['idrow'] = $idproducto;
                $respuesta['verify'] = $_POST["verify"];
                $respuesta['ididid'] = sha1(time() . "" . $idproducto + time());
                $respuesta['nombre'] = $this->getNamePro($idproducto);
                echo json_encode($respuesta);
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    public function enablePro() {
        if (isset($_POST["verify"])) {
            $idproducto = base64_decode(urldecode(strrev($_POST["verify"])));
            if ($this->db->executeQue("update productos set estado='activo' where idproducto=$idproducto")) {
                $respuesta['res'] = 'si';
                $respuesta['idrow'] = $idproducto;
                $respuesta['verify'] = $_POST["verify"];
                $respuesta['ididid'] = sha1(time() . "" . $idproducto + time());
                $respuesta['nombre'] = $this->getNamePro($idproducto);
                echo json_encode($respuesta);
            } else {
                $respuesta['res'] = 'no';
                echo json_encode($respuesta);
            }
        }
    }

    private function getNamePro($idproducto) {
        $rs = $this->db->executeQue("select nombreproducto from productos where idproducto=$idproducto");
        $row = $this->db->arrayResult($rs);
        return $row["nombreproducto"];
    }

    public function getNombrebodega() {
        $idbodega = $this->getUserBodega();
        $consulta = $this->db->executeQue("select nombrebodega from bodegas where bodegaid=$idbodega");
        $file = $this->db->arrayResult($consulta);
        return $file["nombrebodega"];
    }

}
?>

