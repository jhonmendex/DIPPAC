<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class Beneficiario {

    private $id;    
    private $nombre;
    private $ciudad;
    private $cedula;
    private $direccion;
    private $telefono;
    private $email;
    private $fecha_nacimiento;    
    private $parentesco;    

    public function __construct($id=null, $nombre=null, $ciudad=null, $cedula=null, $direccion=null, 
            $telefono=null, $email=null, $fecha_nacimiento=null, $parentesco=null) {
        $this->id = $id;        
        $this->nombre = $nombre;
        $this->ciudad = $ciudad;
        $this->cedula = $cedula;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->fecha_nacimiento = $fecha_nacimiento;  
        $this->parentesco = $parentesco;  
    }

    public function getId() {
        return $this->id;
    }    

    public function getNombre() {
        return $this->nombre;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }
    
    public function getParentesco() {
        return $this->parentesco;
    }
    
    public function setParentesco($value) {
        $this->parentesco = $value;
    }
    
    public function setId($value) {
        $this->id = $value;
    }
    
    public function setNombre($value) {
        $this->nombre = $value;
    }

    public function setCiudad($value) {
        $this->ciudad = $value;
    }

    public function setCedula($value) {
        $this->cedula = $value;
    }

    public function setDireccion($value) {
        $this->direccion = $value;
    }

    public function setTelefono($value) {
        $this->telefono  = $value ? $value:0;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function setFechaNacimiento($value) {
        $this->fecha_nacimiento = $value;
    }
      

}

?>
