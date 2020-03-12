<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Producto {

    private $id;
    private $idcategoria;
    private $nombre;
    private $precio;
    private $puntos;
    private $referencia;
    private $iva;
    private $stock;
    private $imagen;

    public function __construct($id=null, $idcategoria=null, $nombre=null, $precio=null, $puntos=null, $referencia=null, $iva=null, $stock=null, $imagen=null) {
        $this->id = $id;
        $this->idcategoria = $idcategoria;
        $this->iva = $iva;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->puntos = $puntos;
        $this->referencia = $referencia;
        $this->stock = $stock;
        $this->imagen = $imagen;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdCategoria() {
        return $this->idcategoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getPuntos() {
        return $this->puntos;
    }

    public function getReferencia() {
        return $this->referencia;
    }

    public function getIva() {
        return $this->iva;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getImagen() {
        return $this->imagen;
    }

}

?>
