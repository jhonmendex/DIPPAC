<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<style>
    body{
        overflow: hidden;
    }
</style>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-main">Mis comisiones</td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 15px"> 
            <fieldset class="colorleyend" style="width: 98%">
                <legend class="colorleyendinto">Mis comisiones</legend>
            <table class="table" border="0" cellspacing="0" cellpadding="3">        
                <tr class="headall">                        
                    <th class="head"><?php $doc->texto('PERIOD') ?></th>                        
                    <th class="head">Fecha</th>
                    <th class="head">Valor</th>                          
                </tr>      
                <?php
                $estilo = 1;
                foreach ($info as $value) {
                    ?>
                    <tr class="class<?php echo $estilo; ?>">                          
                        <th class="init"><?php echo $value["nombre"] ?></th>
                        <th class="item"><?php echo $value["fecha"] ?></th>               
                        <th class="item"><?php echo '&#36;' . number_format($value["total"], 0, '', '.'); ?></th>                             
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
                </fieldset>
        </div> 
    </div> 
</div>     
<script>
    $(document).ready(function(){
        $(".various3").fancybox({
            'width'                : 700,
            'height'               : 400,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false    
        });    
        $('img').css("border","0");
    });
</script>