<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
require ('classes/Producto.php');
require ('classes/detalleVenta.php');

class ShoppingModel extends ModelBase {

    public function productosByCategoria() {
        $limit = 15;
        $categoria = (int) $_GET['cat'];
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        if ($categoria < 1) {
            $categoria = $this->primeraCategoria();
        }
        $offset = ($pag - 1) * $limit;
        $consulta = $this->db->executeQue("select * from productos where idcategoria=$categoria and estado='activo'");
        $total = $this->db->numRows($consulta);
        $consulta2 = $this->db->executeQue("select * from productos where idcategoria=$categoria and estado='activo' order by nombreproducto asc LIMIT $limit OFFSET $offset");
        $divs = array();
        if ($total > 0) {
            $cont = 0;
            while ($row = $this->db->arrayResult($consulta2)) {
                $url = '';
                $imagen = (int) $row['idimagen'];
                if ($imagen == 0) {
                    $imagen = 1;
                }
                $consulta3 = $this->db->executeQue("select * from imagenes where idimagen=" . $imagen);
                while ($row2 = $this->db->arrayResult($consulta3)) {
                    $url = $row2['url'];
                }
                $producto = new Producto($row['idproducto'], $row['idcategoria'],
                                $row['nombreproducto'], $row['precio'], $row['puntos'],
                                $row['referencia'], $row['iva'], $row['stock'], $url);
                $divproducto = '<div class="productoitem">';
                $divproducto.="<form id='form" . $producto->getId() .
                        "' onsubmit='return validates($(this).attr(\"id\"))' method='get' action='index.php'>";
                $divproducto.='<img src="' . $producto->getImagen() . '"></img></br>';
                $divproducto.=$producto->getNombre() . '</br>';
                $divproducto.=$producto->getReferencia() . '</br>';
                $divproducto .= 'Precio: '; 
                if ($producto->getIva() != 0) {
                    if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                        $divproducto.= '&#36;' . number_format((($producto->getPrecio() *
                                        $producto->getIva()) / 100) + $producto->getPrecio(), 0, ',', '.') . ' X Libra</br>';
                    } else {
                        $divproducto.= '&#36;' . number_format((($producto->getPrecio() *
                                        $producto->getIva()) / 100) + $producto->getPrecio(), 0, ',', '.') . '</br>';
                    }
                } else {
                    if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                        $divproducto.= '&#36;' . number_format($producto->getPrecio(), 0, ',', '.') . ' X Libra</br>';
                    } else {
                        $divproducto.= '&#36;' . number_format($producto->getPrecio(), 0, ',', '.') . '</br>';
                    } 
                }
                $divproducto.='Puntos: ' . number_format($producto->getPuntos(), 2, ',', '.') . '</br>';
                $divproducto.='<input type="hidden" name="idcategoria" value="' . $categoria . '"/>';
                $divproducto.='<input type="hidden" name="idProducto" value="' . $producto->getId() . '"/>';
                $divproducto.='<input type="hidden" name="paginaact" value="' . $pag . '"/>';
                $divproducto.='<input type="hidden" name="controlador" value="Shopping"/>';
                $divproducto.='<input type="hidden" name="accion" value="orden"/>';
                $divproducto.='<input type="checkbox" name="' . $producto->getId() .
                        '" onClick="addCheck($(this).attr(\'name\'))">';
                if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                    $divproducto.='Cantidad: <input type="text" name="cantidad" label="Cantidad" presence="val1" maxlength="5" size="5" autocomplete="off"/> </br>';
                } else {  
                    $divproducto.='Cantidad: <input type="text" name="cantidad" label="Cantidad" onkeypress="return validar(event)" presence="val1" maxlength="3" patt="val2" size="5" autocomplete="off"/> </br>';
                } 
                $divproducto.='<button class="buscarButton">comprar</button> </br>';
                $divproducto.='</form>';
                $divproducto.=' </div>';
                $divs[$cont] = $divproducto;
                $cont++;
            }
            return $divs;
        }
    }

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
            
        } else {
            $primeraCategoria = $this->db->arrayResult($consulta);
        }
        return $primeraCategoria['idcategoria'];
    }

    public function paginacionProductos() {
        $limit = 15;
        $categoria = (int) $_GET['cat'];
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        if ($categoria < 1) {
            $categoria = $this->primeraCategoria();
        }
        $consulta = $this->db->executeQue("select * from productos where idcategoria=$categoria and estado='activo'");
        $total = $this->db->numRows($consulta);
        $totalPag = ceil($total / $limit);
        $links = array();
        for ($i = 1; $i <= $totalPag; $i++) {

            if ($i == $pag) {
                $links[] = "<div class='pagenavselected'><strong>$i</strong></div>";
            } else {
                $links[] = "<div class='pagenav'><a href='index.php?controlador=Shopping&pag=$i&cat=$categoria'>$i</a></div>";
            }
        }
        $linksHtml = implode(" ", $links);

        if ($totalPag == 1) {
            $linksHtml = "";
        } else {

            if ($pag == 1) {
                $sig = $pag + 1;
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$sig&cat=$categoria'>Siguiente</a></div>";
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$totalPag&cat=$categoria'>Fin</a></div>";
            } else if ($pag == $totalPag) {
                $ant = $pag - 1;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$ant&cat=$categoria'>Anterior</a></div>" . $linksHtml;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=1&cat=$categoria'>Inicio</a></div>" . $linksHtml;
            } else {
                $ant = $pag - 1;
                $sig = $pag + 1;
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$sig&cat=$categoria'>Siguiente</a></div>";
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$totalPag&cat=$categoria'>Fin</a></div>";
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$ant&cat=$categoria'>Anterior</a></div>" . $linksHtml;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=1&cat=$categoria'>Inicio</a></div>" . $linksHtml;
            }
        }
        return $linksHtml;
    }

    public function categoriaSelected() {
        $categoria = (int) $_GET['cat'];
        if ($categoria < 1) {
            $categoria = $this->primeraCategoria();
        } else {
            
        }
        return $categoria;
    }

    public function agregarItem() {
        $producto = null;
        if (isset($_GET['idProducto'])) {
            $item = $_GET['idProducto'];
            $cantidad = $_GET['cantidad'];
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            $consulta = $this->db->executeQue("select * from productos where idproducto=$item");
            $total = $this->db->numRows($consulta);
            if ($total > 0) {
                while ($row = $this->db->arrayResult($consulta)) {
                    $producto = new Producto($row['idproducto'], $row['idcategoria'], $row['nombreproducto'],
                                    $row['precio'], $row['puntos'], $row['referencia'], $row['iva'],
                                    $row['stock'], null);
                }
            }
            if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                $detalle = new Detalle($producto, $cantidad);
            } else {
                $detalle = new Detalle($producto, (int) $cantidad);
            }
            if (!isset($itemsEnCesta)) {
                $itemsEnCesta[$producto->getId()] = serialize($detalle);
            } else {
                foreach ($itemsEnCesta as $k => $v) {
                    $encontrado = 0;
                    if ($producto->getId() == $k) {
                        $detalle1 = unserialize($v);
                        if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                            $detalle2 = new Detalle($producto, $cantidad + $detalle1->getCantidad());
                        } else {
                            $detalle2 = new Detalle($producto, ((int) $cantidad) + $detalle1->getCantidad());
                        }
                        $itemsEnCesta[$producto->getId()] = serialize($detalle2);
                        $encontrado = 1;
                    }

                    if ($encontrado == 0) {
                        $itemsEnCesta[$producto->getId()] = serialize($detalle);
                    }
                }
            }
            $_SESSION['itemsEnCesta'] = $itemsEnCesta;
        }
    }

    public function eliminarItem() {
        $productos = $_SESSION['itemsEnCesta'];
        if (count($productos) <= 1) {
            $this->eliminarOrden();
            ob_end_clean();
            header("location: index.php?controlador=Shopping");
        } else {
            $producto = $_GET['idproducto'];
            unset($_SESSION['itemsEnCesta'][$producto]);            
        }
    }

    public function traerDetalles() {
        $detalles = Array();
        if (!isset($_SESSION['itemsEnCesta'])) {
            return null;
        } else {
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            $cont = 0;
            foreach ($itemsEnCesta as $k => $v) {
                $detalle = unserialize($v);
                $detalles[$cont] = $detalle;
                $cont++;
            }
            return $detalles;
        }
    }

    public function traerSubtotal() {
        $detalles = Array();
        if (!isset($_SESSION['itemsEnCesta'])) {
            return null;
        } else {
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            $suma = 0;
            foreach ($itemsEnCesta as $k => $v) {
                $detalle = unserialize($v);
                $unit = $detalle->getCantidad() * $detalle->getProducto()->getPrecio();
                $suma+=$unit;
            }
            return $suma;
        }
    }

    public function traerCategoriaActual() {
        return $_GET['idcategoria'];
    }

    public function traerPuntos() {
        $detalles = Array();
        if (!isset($_SESSION['itemsEnCesta'])) {
            return null;
        } else {
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            $suma = 0;
            foreach ($itemsEnCesta as $k => $v) {
                $detalle = unserialize($v);
                $unit = $detalle->getCantidad() * $detalle->getProducto()->getPuntos();
                $suma+=$unit;
            }
            return $suma;
        }
    }

    public function traerIva() {
        $detalles = Array();
        if (!isset($_SESSION['itemsEnCesta'])) {
            return null;
        } else {
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            $iva = 0;
            foreach ($itemsEnCesta as $k => $v) {
                $detalle = unserialize($v);
                if ($detalle->getProducto()->getIva() > 0) {
                    $unit = $detalle->getCantidad() * (( $detalle->getProducto()->getIva() *
                            $detalle->getProducto()->getPrecio()) / 100);
                    $iva+=$unit;
                } else {
                    
                }
            }
            return $iva;
        }
    }

    public function productosByNombre() {
        $limit = 15;
        $categoria = $_GET['idcategoria'];
        $producto = strtoupper($_GET['nomProducto']);
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }

        $offset = ($pag - 1) * $limit;
        $consulta = $this->db->executeQue("select * from productos where nombreproducto like '%$producto%' and estado='activo'");
        $total = $this->db->numRows($consulta);
        $consulta = $this->db->executeQue("select * from productos where nombreproducto like '%$producto%' and estado='activo' order by nombreproducto asc LIMIT $limit OFFSET $offset");
        $divs = array();
        if ($total > 0) {
            $cont = 0;
            while ($row = $this->db->arrayResult($consulta)) {
                $url = '';
                $imagen = (int) $row['idimagen'];
                if ($imagen == 0) {
                    $imagen = 1;
                }
                $consulta3 = $this->db->executeQue("select * from imagenes where idimagen=" . $imagen);
                while ($row2 = $this->db->arrayResult($consulta3)) {
                    $url = $row2['url'];
                }
                $producto = new Producto($row['idproducto'], $row['idcategoria'],
                                $row['nombreproducto'], $row['precio'], $row['puntos'],
                                $row['referencia'], $row['iva'], $row['stock'], $url);
                $divproducto = '<div class="productoitem">';
                $divproducto.="<form id='form" . $producto->getId() . "' onsubmit='return validates($(this).attr(\"id\"))' method='get' action='index.php'>";
                $divproducto.='<img src="' . $producto->getImagen() . '"></img></br>';
                $divproducto.=$producto->getNombre() . '</br>';
                $divproducto.=$producto->getReferencia() . '</br>';
                $divproducto .= 'Precio: ';
                if ($producto->getIva() != 0) {
                    if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                        $divproducto.= '&#36;' . number_format((($producto->getPrecio() *
                                        $producto->getIva()) / 100) + $producto->getPrecio(), 0, ',', '.') . ' X Libra</br>';
                    } else {
                        $divproducto.= '&#36;' . number_format((($producto->getPrecio() *
                                        $producto->getIva()) / 100) + $producto->getPrecio(), 0, ',', '.') . '</br>';
                    }
                } else {
                    if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                        $divproducto.= '&#36;' . number_format($producto->getPrecio(), 0, ',', '.') . ' X Libra</br>';
                    } else {
                        $divproducto.= '&#36;' . number_format($producto->getPrecio(), 0, ',', '.') . '</br>';
                    }
                }
                $divproducto.='Puntos: ' . number_format($producto->getPuntos(), 2, ',', '.') . '</br>';
                $divproducto.='<input type="hidden" name="idcategoria" value="' . $categoria . '"/>';
                $divproducto.='<input type="hidden" name="idProducto" value="' . $producto->getId() . '"/>';
                $divproducto.='<input type="hidden" name="controlador" value="Shopping"/>';
                $divproducto.='<input type="hidden" name="accion" value="orden"/>';
                if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                    $divproducto.='Cantidad: <input type="text" name="cantidad" label="Cantidad" presence="val1" maxlength="5" size="5" autocomplete="off"/> </br>';
                } else {

                    $divproducto.='Cantidad: <input type="text" name="cantidad" label="Cantidad" onkeypress="return validar(event)" presence="val1" maxlength="3" patt="val2" size="5" autocomplete="off"/> </br>';
                }
                $divproducto.='<button class="buscarButton">comprar</button> </br>';
                $divproducto.='</form>';
                $divproducto.=' </div>';
                $divs[$cont] = $divproducto;
                $cont++;
            }
            return $divs;
        }
    }

    public function paginacionProductosResultado() {
        $limit = 15;
        $producto = strtoupper($_GET['nomProducto']);
        $categoria = $_GET['idcategoria'];
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        $consulta = $this->db->executeQue("select * from productos where nombreproducto like '%$producto%' and estado='activo'");
        $total = $this->db->numRows($consulta);
        $totalPag = ceil($total / $limit);
        $links = array();
        for ($i = 1; $i <= $totalPag; $i++) {
            if ($i == $pag) {
                $links[] = "<div class='pagenavselected'><strong>$i</strong></div>";
            } else {
                $links[] = "<div class='pagenav'><a href='index.php?controlador=Shopping&accion=resultado&nomProducto=$producto&pag=$i&cat=$categoria'>$i</a></div>";
            }
        }
        $linksHtml = implode(" ", $links);
        if ($totalPag == 1) {
            $linksHtml = "";
        } else {
            if ($pag == 1) {
                $sig = $pag + 1;
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$sig&cat=$categoria'>Siguiente</a></div>";
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$totalPag&cat=$categoria'>Fin</a></div>";
            } else if ($pag == $totalPag) {
                $ant = $pag - 1;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$ant&cat=$categoria'>Anterior</a></div>" . $linksHtml;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=1&cat=$categoria'>Inicio</a></div>" . $linksHtml;
            } else {
                $ant = $pag - 1;
                $sig = $pag + 1;
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$sig&cat=$categoria'>Siguiente</a></div>";
                $linksHtml = $linksHtml . "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$totalPag&cat=$categoria'>Fin</a></div>";
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=$ant&cat=$categoria'>Anterior</a></div>" . $linksHtml;
                $linksHtml = "<div class='pagenav2'><a href='index.php?controlador=Shopping&pag=1&cat=$categoria'>Inicio</a></div>" . $linksHtml;
            }
        }
        return $linksHtml;
    }

    public function eliminarOrden() {
        unset($_SESSION['itemsEnCesta']);
    }

    public function getTipoEnvio() {
        $tipoenvio = $_GET['envio'];
        return $tipoenvio;
    }

    public function crearFactura($idUser, $details, $subtotal, $puntos, $iva) {
        $tipoenvio = $_GET['envio'];
        $fecha = date("Y-m-d");
        $puntoscompra = $puntos;
        $valorcompra = $subtotal + $iva;
        $comprador = $idUser;        
        $detail = $details;
        $periodo=$this->getCurrentPeriodo();
        $idquery = "select nextval('ventas_idventa_seq'::regclass) limit 1";
        $consult = $this->db->executeQue($idquery);               
        $row = $this->db->arrayResult($consult);
        $idfact = $row['nextval'];                    
        $query = "insert into ventas values($idfact,$comprador,'$fecha','espera',$puntoscompra,$valorcompra,'$tipoenvio',$periodo)";
        $this->db->executeQue($query); 
        foreach ($detail as $detalle) {
            $cantidad = $detalle->getCantidad();
            $idprod = $detalle->getProducto()->getId();
            $precio = $detalle->getProducto()->getPrecio();
            $puntos = $this->config->get('pointvalue');
            $query3 = "insert into detalleventas values(nextval('detalleventas_iddetalleventa_seq'::regclass),$idprod,$idfact,$cantidad,$precio,NULL,NULL,NULL,NULL,NULL,$puntos, NULL)";
            $this->db->executeQue($query3); 
        }                
        unset($_SESSION['itemsEnCesta']);
        if ($idfact < 10) {
            $idfact = '000' . $idfact;
        } else if ($idfact < 100 && $idfact >= 10) {
            $idfact = '00' . $idfact;
        } else if ($idfact < 1000 && $idfact >= 100) {
            $idfact = '0' . $idfact;
        } else {
            $idfact = $idfact;
        }
        return $idfact;
    }

    public function getCurrentPeriodo() {
        $query = "select * from periodos where '" . date("Y-m-d") . "' BETWEEN fechainicio AND fechafin";
        $consulta = $this->db->executeQue($query);
        $idperiodo = 0;
        while ($row = $this->db->arrayResult($consulta)) {
            $idperiodo = $row['idperiodo'];
        }
        return $idperiodo;
    }

    public function getNameCurrentPeriodo() {
        $query = "select * from periodos where '" . date("Y-m-d") . "' BETWEEN fechainicio AND fechafin";
        $consulta = $this->db->executeQue($query);
        $nombreperiodo = '';
        while ($row = $this->db->arrayResult($consulta)) {
            $nombreperiodo = $row['nombreperiodo'];
        }
        return $nombreperiodo;
    }
    
    public function getMes() {
        $mes = date("m");
        if ($mes == 01) {
            return "Enero";
        } else if ($mes == 02) {
            return "Febrero";
        } else if ($mes == 03) {
            return "Marzo";
        } else if ($mes == 04) {
            return "Abril";
        } else if ($mes == 05) {
            return "Mayo";
        } else if ($mes == 06) {
            return "Junio";
        } else if ($mes == 07) {
            return "Julio";
        } else if ($mes == 08) {
            return "Agosto";
        } else if ($mes == 09) {
            return "Septiembre";
        } else if ($mes == 10) {
            return "Octubre";
        } else if ($mes == 11) {
            return "Noviembre";
        } else if ($mes == 12) {
            return "Diciembre";
        }
    }

    public function getEnvios() {
        $envios = array("Domicilio", "Punto de Venta");
        return $envios;
    }

    public function agregarItems($idProducto, $cantidadd) {
        session_start();
        $producto = null;
        $item = $idProducto;
        $cantidad = $cantidadd;
        $itemsEnCesta = $_SESSION['itemsEnCesta'];
        $consulta = $this->db->executeQue("select * from productos where idproducto=$item");
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $producto = new Producto($row['idproducto'], $row['idcategoria'], $row['nombreproducto'],
                                $row['precio'], $row['puntos'], $row['referencia'], $row['iva'],
                                $row['stock'], null);
            }
        }
        if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
            $detalle = new Detalle($producto, $cantidad);
        } else {
            $detalle = new Detalle($producto, (int) $cantidad);
        }
        if (!isset($itemsEnCesta)) {
            $itemsEnCesta[$producto->getId()] = serialize($detalle);
        } else {
            foreach ($itemsEnCesta as $k => $v) {
                $encontrado = 0;
                if ($producto->getId() == $k) {
                    $detalle1 = unserialize($v);
                    if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
                        $detalle2 = new Detalle($producto, $cantidad + $detalle1->getCantidad());
                    } else {
                        $detalle2 = new Detalle($producto, ((int) $cantidad) + $detalle1->getCantidad());
                    }
                    $itemsEnCesta[$producto->getId()] = serialize($detalle2);
                    $encontrado = 1;
                }
                if ($encontrado == 0) {
                    $itemsEnCesta[$producto->getId()] = serialize($detalle);
                }
            }
        }
        $_SESSION['itemsEnCesta'] = $itemsEnCesta;
    }

    /* Reporte de ventas diario con formato csv para don libardo
     * 
     * 
     * 
     */

    public function ShopReport() {
        $query = "SELECT * from ventas where estado_venta='pagado' order by idventa asc";
        $consulta = $this->db->executeQue($query);
        while ($row3 = $this->db->arrayResult($consulta)) {
            $nogravado = 0;
            $gravado10 = 0;
            $iva10 = 0;
            $gravado12 = 0;
            $iva12 = 0;
            $gravado16 = 0;
            $iva16 = 0;
            $query2 = "SELECT * from detalleventas where idventa=" . $row3['idventa'];
            $consulta2 = $this->db->executeQue($query2);
            while ($row = $this->db->arrayResult($consulta2)) {
                $query3 = "SELECT * from productos where idproducto=" . $row['idproducto'];
                $consulta3 = $this->db->executeQue($query3);
                while ($row2 = $this->db->arrayResult($consulta3)) {
                    //calculos de los valores a exportar
                    if ($row2['iva'] == 0) {
                        $nogravado += ($row2['precio'] * $row['cantidad']);
                    } else if ($row2['iva'] == 10) {
                        $gravado10 += ($row2['precio'] * $row['cantidad']);
                        $iva10 += ((($row2['precio'] * $row2['iva']) / 100) * $row['cantidad']);
                    } else if ($row2['iva'] == 12) {
                        $gravado12 += ($row2['precio'] * $row['cantidad']);
                        $iva12 += ((($row2['precio'] * $row2['iva']) / 100) * $row['cantidad']);
                    } else if ($row2['iva'] == 16) {
                        $gravado16 += ($row2['precio'] * $row['cantidad']);
                        $iva16 += ((($row2['precio'] * $row2['iva']) / 100) * $row['cantidad']);
                    }
                }
            }
            /*
             * imprimir aca informacion de 8 items por producto
             */
            $query4 = "SELECT * from usuarios where idusuario=" . $row3['idusuario'];
            $consulta4 = $this->db->executeQue($query4);
            $nombreusuario = "";
            $cedulausuario = 0;
            while ($row4 = $this->db->arrayResult($consulta4)) {
                $nombreusuario = $row4['nombreusuario'];
                $cedulausuario = $row4['cedula'];
            }
            $fecha = $this->cambiafecha($row3['fecha']);
            $facturanumber = $this->formatoNfactura($row3['idventa']);
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,41359501,C,' . number_format($nogravado, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,41359502,C,' . number_format($gravado10, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,41359503,C,' . number_format($gravado12, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,41359504,C,' . number_format($gravado16, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,24080502,C,' . number_format($iva10, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,24080503,C,' . number_format($iva12, 0, '', '') . '<br>';
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,24080504,C,' . number_format($iva16, 0, '', '') . '<br>';
            $totalll = $nogravado + $gravado10 + $gravado12 + $gravado16 + $iva10 + $iva12 + $iva16;
            echo $fecha . ',FV,' . $facturanumber . ',VENTA  EN LA FECHA,' . $cedulausuario . ',' . $nombreusuario . ',,1110501,C,' . number_format($totalll, 0, '', '') . '<br>';
        }
    }

    public function cambiafecha($fecha) {
        ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
        return $lafecha;
    }

    public function formatoNfactura($numerofactura) {
        if ($numerofactura < 10) {
            return "00000" . $numerofactura;
        } else if ($numerofactura < 100) {
            return "0000" . $numerofactura;
        } else if ($numerofactura < 1000) {
            return "000" . $numerofactura;
        } else if ($numerofactura < 10000) {
            return "00" . $numerofactura;
        } else if ($numerofactura < 100000) {
            return "0" . $numerofactura;
        } else if ($numerofactura < 1000000) {
            return $numerofactura;
        }
    }

    public function refrescarItem($valor, $productoitem) {
        session_start();
        $producto = null;
        $item = $productoitem;
        $cantidad = $valor;
        $itemsEnCesta = $_SESSION['itemsEnCesta'];
        $consulta = $this->db->executeQue("select * from productos where idproducto=$item");
        $total = $this->db->numRows($consulta);
        if ($total > 0) {
            while ($row = $this->db->arrayResult($consulta)) {
                $producto = new Producto($row['idproducto'], $row['idcategoria'], $row['nombreproducto'],
                                $row['precio'], $row['puntos'], $row['referencia'], $row['iva'],
                                $row['stock'], null);
            }
        }

        if ($producto->getIdCategoria() == 14 || $producto->getIdCategoria() == 8) {
            $detalle2 = new Detalle($producto, $cantidad);
        } else {
            $detalle2 = new Detalle($producto, ((int) $cantidad));
        }
        $itemsEnCesta[$producto->getId()] = serialize($detalle2);
        $encontrado = 1;


        $_SESSION['itemsEnCesta'] = $itemsEnCesta;
    }

    public function traerDetalle($idpro) {
        $detalle = null;
        if (!isset($_SESSION['itemsEnCesta'])) {
            return null;
        } else {
            $itemsEnCesta = $_SESSION['itemsEnCesta'];
            foreach ($itemsEnCesta as $k => $v) {
                if ($k == $idpro) {
                    $detalle = unserialize($v);
                }
            }
            return $detalle;
        }
    }

}

?>
