<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Detalle{
    private $producto;
    private $cantidad;    

    public function __construct($producto,$cantidad) {
        $this->producto = $producto;
        $this->cantidad = $cantidad;        
    } 
    
    public function getProducto(){
        return $this->producto;
    }

    public function getCantidad(){
        return $this->cantidad;
    }   
}
?>
