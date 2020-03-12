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
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Compras recientes</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 15px"> 
            <?php $view->startForm("index.php?controlador=Purchases", "formpurchases"); ?>
            <fieldset class="colorleyend" style="width: 100%">
                <legend class="colorleyendinto">Opciones de busqueda</legend>
                <table cellspacing="2">  
                    <tr>
                        <td style="font-size: small" colspan="5">
                            A continuaci&oacute;n seleccione un rango de fechas para visualizar sus compras.
                        </td>              
                    </tr>
                    <tr>
                        <td><?php $doc->texto('DATEINI') ?>: </td> 
                        <td> 
                            <?php $view->input("dateini", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly')); ?>                    
                        </td>
                        <td><?php $doc->texto('DATEFIN') ?>: </td> 
                        <td> 
                            <?php $view->input("datefin", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly')); ?>                    
                        </td>
                        <td><button class="buscarButton" style="height: 40px"><?php $doc->texto('SEE') ?></button></td>
                    </tr>   
                </table>
            </fieldset>
            <fieldset class="colorleyend" style="width: 100%">
                <legend class="colorleyendinto">Mis compras</legend>
                <?php $view->endForm(); ?>    
                <table class="table" border="0" cellspacing="0" cellpadding="3">        
                    <tr class="headall">
                        <th class="headinit"></th> 
                        <th class="head"><?php $doc->texto('NUMBERORDER') ?></th>
                        <th class="head"><?php $doc->texto('DATEORDER') ?></th>            
                        <th class="head"><?php $doc->texto('POINTS') ?></th>
                        <th class="head"><?php $doc->texto('TOTAL') ?></th>
                        <th class="head"><?php $doc->texto('PERIOD') ?></th>                 
                    </tr>      
                    <?php
                    $sumacompras = 0;
                    $sumapuntos = 0;
                    $estilo = 1;
                    for ($i = 0; $i < sizeof($comprasr); $i++) {
                        ?>
                        <tr class="class<?php echo $estilo; ?>">
                            <th class="init" style="width: 20px;">
                                <a class="various3" title="Detalles de la compra" href="index.php?controlador=Purchases&accion=details&idVenta=<?php echo $comprasr[$i]["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                    <img src="images/list.png" width="15px" height="15px" title="<?php $doc->texto('VIEW_DETAILS'); ?>"/>                       
                                </a>                        
                            </th>
                            <th class="item"><?php echo $comprasr[$i]["id"] ?></th>
                            <th class="item"><?php echo $comprasr[$i]["fecha"] ?></th>               
                            <th class="item"><?php
                    echo number_format($comprasr[$i]["puntos"], 2, ',', '');
                    $sumapuntos+=$comprasr[$i]["puntos"];
                    ?></th>
                            <th class="item"><?php
                    echo '&#36;' . number_format($comprasr[$i]["precio"], 0, ',', '.');
                    $sumacompras+=$comprasr[$i]["precio"];
                    ?></th>
                            <th class="item"><?php echo $comprasr[$i]["periodo"] ?></th>                   
                        </tr>
                        <?php
                        if ($estilo == 1) {
                            $estilo = 2;
                        } else {
                            $estilo = 1;
                        }
                    }
                    ?>  
                    <tr>
                        <th colspan="3" style="text-align: right; padding: 10px; font-size: 14px;" >
                            <strong>TOTAL</strong> 
                        </th>
                        <th colspan="1" class="init">
                            <?php echo number_format($sumapuntos, 2, ',', '.'); ?>
                        </th>
                        <th colspan="1" class="item">
<?php echo '&#36;' . number_format($sumacompras, 0, ',', '.'); ?>
                        </th>

                    </tr>
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
