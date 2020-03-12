<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class View {

    private $path;
    private $vars;

    function __construct() {
        $this->path = VIEWS . DS;
    }

    public function show() {

        if (is_array($this->vars)) {
            foreach ($this->vars as $key => $value) {
                $$key = $value;
            }
        }
        include($this->path);
        $aplication = Document::singleton();
        $aplication->setFinish();
    }

    public function setVars($nameVar, $valueVar) {

        $this->vars[$nameVar] = $valueVar;
    }

    public function setTemplate($name) {
        $this->path = $this->path . $name . '.php';
    }

    public function input($name, $type, $lab, $validations= null, $options=null) {
        $tag = '<input ';
        if ($type == 'numeric') {
            $tag.= "type='text' name='$name' label='$lab' ";
        } else if ($type == 'calendar') {
            $tag.= "type='text' name='$name' label='$lab' ";
        } else {
            $tag.= "type='$type' name='$name' label='$lab' ";
        }
        if ($type == 'numeric') {
            if ($validations != null) {
                foreach ($validations as $key => $value) {
                    if ($key == 'required' && $value) {
                        $tag.='presence="val1" ';
                    }
                    if ($key == 'text' && $value == 'numeric') {
                        $tag.='patt="val2" ';
                    }
                    if ($key == 'text' && $value == 'digit') {
                        $tag.='patt="val8" ';
                    }
                    if ($key == 'norepeat') {
                        $tag.="norepeat='$value' ";                       
                    }
                    if ($key == 'minsize') {
                        $tag.="minsize='$value' ";
                    }                    
                    if ($key == 'except') {
                        $tag.="except='$value' ";                       
                    }
                }
                if ($options != null) {
                    foreach ($options as $key => $value) {
                        $tag.=$key . "='$value' ";
                    }
                }
            } else {
                if ($options != null) {
                    foreach ($options as $key => $value) {
                        $tag.=$key . '=' . $value . ' ';
                    }
                }
            }
            $tag.='onKeyPress="return validar(event)" />';
        } else if ($type == 'calendar') {
            if ($validations != null) {
                foreach ($validations as $key => $value) {
                    if ($key == 'required' && $value) {
                        $tag.='presence="val1" ';
                    }
                }
            }
            if ($options != null) {
                foreach ($options as $key => $value) {
                    if ($key != 'class') {
                        $tag.=$key . "='$value' ";
                    }
                }
            }
            $tag.='class="onepic" />';
        } else {
            if ($validations != null) {
                foreach ($validations as $key => $value) {
                    if ($key == 'required' && $value) {
                        $tag.='presence="val1" ';
                    }
                    if ($key == 'text' && $value == 'regular') {
                        $tag.='patt="val1" ';
                    }
                    if ($key == 'text' && $value == 'email') {
                        $tag.='patt="val3" ';
                    }
                    if ($key == 'text' && $value == 'onlytext') {
                        $tag.='patt="val4" ';
                    }
                    if ($key == 'text' && $value == 'shorttext') {
                        $tag.='patt="val5" ';
                    }
                    if ($key == 'text' && $value == 'decimal') {
                        $tag.='patt="val6" ';
                    }
                    if ($key == 'text' && $value == 'address') {
                        $tag.='patt="val7" ';
                    }
                    if ($key == 'text' && $value == 'alias') {
                        $tag.='patt="val9" ';
                    }
                    if ($key == 'norepeat') {
                        $tag.="norepeat='$value' ";
                    }
                    if ($key == 'except') {
                        $tag.="except='$value' ";                       
                    }
                    if ($key == 'minsize') {
                        $tag.="minsize='$value' ";
                    }
                }
                if ($options != null) {
                    foreach ($options as $key => $value) {
                        $tag.=$key . "='$value' ";
                    }
                }
            } else {
                if ($options != null) {
                    foreach ($options as $key => $value) {
                        $tag.=$key . "='$value' ";
                    }
                }
            }
            $tag.=' />';
        }
        echo $tag;
    }

    public function startForm($action, $id, $method='post') {
        echo "<form action='$action' method='$method' id='$id' onsubmit='return validates($(this).attr(\"id\"))'>";
    }

    public function endForm() {
        echo '</form>';
    }

    public function setFrame() {
        if (is_array($this->vars)) {
            foreach ($this->vars as $key => $value) {
                $$key = $value;
            }
        }
        $validacion = Validacion::singleton();
        if ($validacion->isLogged()) {
            include($this->path);
        }
    }

}

?>