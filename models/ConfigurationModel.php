<?php

defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');

class ConfigurationModel extends ModelBase {

    public function getInfromation() {
        $source = INCLUDES . DS . "configuration.php";
        //$target = 'out.txt';
        $sh = fopen($source, 'r');
        //$th = fopen($target, 'w');
        while (!feof($sh)) {
            $line = fgets($sh);
            $tmp1 = explode("(", $line);
            if ($tmp1[0] == "\$config->set") {
                $tmp2 = explode(")", $tmp1[1]);
                $tmp3 = explode(",", $tmp2[0]);
                $variable = str_replace("'", "", $tmp3[0]);
                $valor = str_replace("'", "", $tmp3[1]);
                $informacion[$variable] = $valor;
            }
            //if (strpos($line, '@parsethis') !== false) {
            //$line = 'new line to be inserted' . PHP_EOL;
            //}
            //fwrite($th, $line);
        }
        fclose($sh);
        //flcose($th);
        //unlink($source);
        //rename($target, $source);
        return $informacion;
    }
    
    public function updateData(){
        $source = INCLUDES . DS . "configuration.php";
        $target = INCLUDES . DS . "configuration2.php";
        $sh = fopen($source, 'r');
        $th = fopen($target, 'w');
        while (!feof($sh)) {
            $line = fgets($sh);
            $tmp1 = explode("(", $line);
            if ($tmp1[0] == "\$config->set") {
                $tmp2 = explode(")", $tmp1[1]);
                $tmp3 = explode(",", $tmp2[0]);
                $variable = str_replace("'", "", $tmp3[0]);                  
                if(isset ($_POST[$variable])){                       
                    if(is_numeric(trim($_POST[$variable]))){
                      $line=$tmp1[0]."('".$variable."', ".trim($_POST[$variable]).");".PHP_EOL;
                      fwrite($th, $line);    
                      eval("\$this->config->set('".$variable."', ".trim($_POST[$variable]).");");
                    }else{
                      $line=$tmp1[0]."('".$variable."', '".trim($_POST[$variable])."');".PHP_EOL;
                      fwrite($th, $line);  
                      eval("\$this->config->set('".$variable."', '".trim($_POST[$variable])."');");
                    }                    
                }else{
                   fwrite($th, $line); 
                }
            }else{
                fwrite($th, $line);
            }
        }                
        fclose($sh);
        fclose($th);                
        $sh2 = fopen($target, 'r');
        $th2 = fopen($source, 'w');
        while (!feof($sh2)) {
            $line = fgets($sh2);           
            fwrite($th2, $line);            
        }                
        fclose($sh2);
        fclose($th2);
        //unlink($source);
        //rename($target, $source); 
        $this->editPointsValue(trim($_POST["pointvalue"]));
        echo json_encode(array("respuesta"=>"si"));
    }
    
    private function editPointsValue($valpunto){
        $this->db->executeQue("update productos set puntos=(precioiva/$valpunto)");
    }
    

}
?>
