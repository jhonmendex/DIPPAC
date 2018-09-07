<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">

    <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">        
        <tr class="headall">                
            <th class="headinit"><?php $doc->texto('LEVEL') ?></th>
            <th class="head"><?php $doc->texto('TOTAL') ?></th>                

        </tr>      
            <tr class="class1"> 
                <th class="init">Yo</th>
                <th class="item"><?php echo '&#36;' . number_format($level0 , 0, ',', '.'); ?></th>               
            </tr>
            <tr class="class2"> 
                <th class="init">Nivel 1</th>
                <th class="item"><?php echo '&#36;' . number_format($level1 , 0, ',', '.'); ?></th>               
            </tr>
            <tr class="class1"> 
                <th class="init">Nivel 2</th>
                <th class="item"><?php echo '&#36;' . number_format($level2 , 0, ',', '.'); ?></th>               
            </tr>
            <tr class="class2"> 
                <th class="init">Nivel 3</th>
                <th class="item"><?php echo '&#36;' . number_format($level3 , 0, ',', '.'); ?></th>               
            </tr>
            <tr class="class1"> 
                <th class="init">Nivel n</th>
                <th class="item"><?php echo '&#36;' . number_format($level4 , 0, ',', '.'); ?></th>               
            </tr>
             <?php
        $estilo = 1;
        foreach ($allComission as $value) {
            ?>
            <tr class="class<?php echo $estilo; ?>">               
                <td class="item2"><?php echo $value["codigo"] ?></td>
                <td class="item2"><?php echo $value["nombre"] ?></td>
                <td class="item2"><?php echo $value["cedula"] ?></td> 
                <td class="item2"><?php echo number_format($value["total"], 2, ',', '.'); ?></td>                                                           
            </tr>
            <?php
            if ($estilo == 1) {
                $estilo = 2;
            } else {
                $estilo = 1;
            }
        }
        ?>  
    </table>    
</div> 
