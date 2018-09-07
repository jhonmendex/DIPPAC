<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>   
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Resumen de saldos</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">             
            <div style="width: 100%;">     
                <fieldset class="colorleyend" style="width: 99%; padding: 5px">
                    <legend class="colorleyendinto">Opciones de busqueda</legend>    
                    <form method="POST" action="index.php?controlador=Reports&accion=resumenSaldos">
                    <table border="0" style="padding: 10px; line-height: 15px">   
                        <tbody>    
                        <tr>       
                            <td>Seleccione una bodega:</td><td> 
                                <div id="cajaselect" style="margin-bottom: 0px">
                                    <table border="0" width="100%">                   
                                        <tr>      
                                            <td>   
                                            <select id="bodegas" name="idbodega"> 
                                                <?php foreach ($bodegas as $key => $value) { ?>
                                                    <option value="<?php echo $value["id"] ?>"> 
                                                        <?php echo $value["nombre"] ?>
                                                    </option>   
                                                <?php } if($sadministrador == true) { ?>  
                                                    <option value="todasb"> 
                                                        <?php echo "TODAS LAS BODEGAS" ?>
                                                    </option> 
                                                    <?php } ?> 
                                            </select>                             
                                            </td>                   
                                        </tr>
                                    </table> 
                                </div>     
                            </td>
                            <td>Seleccione la categoria del producto: </td><td> 
                                <div id="cajaselect" style="margin-bottom: 0px">
                                    <table border="0" width="100%">                   
                                        <tr>     
                                            <td>
                                            <select id="categorias" name="idcat">
                                                <?php foreach ($categorias as $key => $value) { ?>
                                                    <option value="<?php echo $key ?>">
                                                        <?php echo $value ?>
                                                    </option>           
                                                <?php } ?>  
                                                    <option value="todasc"> 
                                                        <?php echo "TODAS LAS CATEGORIAS" ?>
                                                    </option>   
                                            </select>                             
                                            </td>                   
                                        </tr>
                                    </table> 
                                </div>       
                            </td>
                            <td><button class="buscarButton" style="height: 40px;width: 200px">Ver reporte</button></td>
                        </tr> 
                        </tbody>
                    </table>
                    </form>    
                </fieldset>   
                <div>            
                    <div style="margin-top: 0px;margin-bottom: 20px">   
                        <?php foreach ($resumens[0] as $key => $value) { ?>  
                            <fieldset class="colorleyend" style="width: 99%; padding: 5px"> 
                                <legend class="colorleyendinto">BODEGA :<?php echo $resumens[0][$key]['nombrebodega']?></legend>       
                                                                                        
                                      <div style="margin-top: 0px;margin-bottom: 20px">   
                                        <table class="mytable" border="0" cellspacing="0" cellpadding="0">      
                                            <thead>    
                                                <tr class="headall">     
                                                    <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                                                    <th class="head">Referencia</th>
                                                    <th class="head">Costo</th>
                                                    <th class="head" style="cursor: pointer;">Saldo en cantidad</th>
                                                    <th class="head" style="cursor: pointer;">Saldo en costo total</th>                    
                                                </tr>       
                                            </thead>    
                                            <tbody style="line-height: 25px">      
                                                <?php
                                                foreach ($resumens[0][$key]['productos'] as $value3) {
                                                    ?>     
                                                    <tr id="<?php echo $value3["id"] ?>">   
                                                        <td class="init2">   
                                                            <?php echo $value3["nombre"] ?>  
                                                        </td>   
                                                        <td style="text-align: center" class="item2"> 
                                                            <?php echo $value3["referencia"] ?>  
                                                        </td>      
                                                        <td style="text-align: center" class="item2">    
                                                            <?php echo $value3["costo"] ?>  
                                                        </td>      
                                                        <td style="text-align: center" class="item2">      
                                                            <?php echo $value3["stock"] ?>  
                                                        </td>       
                                                        <td style="text-align: center" class="item2">  
                                                            <?php echo '&#36;' . number_format($value3["stockxcosto"], 0, ',', '.'); ?> 
                                                        </td>           
                                                    </tr>   
                                                <?php } ?>
                                            </tbody>  
                                        </table>
                                    </div>   
                                <table class="table" cellspacing="0" cellpadding="3" border="0" style="margin-top: 40px; padding: 5px; font-size: 20px; line-height: 20px; width: 60% !important"> 
                                    <thead> 
                                        <tr class="headall">
                                            <th align="center" colspan="2" class="headinit">TOTALES</th>
                                        </tr>
                                    </thead>
                                        <tbody> 
                                        <tr class="class1">
                                            <th class="init" style="background-color: #D3D6FF">Total saldo en cantidad</th>
                                            <th class="item" align="center" style="background-color: #f3f3f3"><?php echo  number_format($resumens[2][$key], 0, ',', '.'); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="init" style="background-color: #D3D6FF">Total saldo en costo</th> 
                                            <th class="item" align="center" style="background-color: #f3f3f3"><?php echo '&#36;' . number_format($resumens[1][$key], 0, ',', '.'); ?></th>
                                        </tr>
                                        </tbody>
                                 </table> 
                            </fieldset>   
                        <?php } ?>          
                    </div>                                
                </div>    
            </div> 
        </div>       
    </div> 
</div>
<script>
    $(document).ready(function(){   
        $('#categorias').val("<?php echo $categoriaselected; ?>"); 
        $('#bodegas').val("<?php echo $bodegaselected; ?>");   
        $('.mytable').css('line-height' ,'15px');
        $('.mytable').css('width' ,'100%');
        $('.mytable').dataTable( { 
            "oLanguage":  {
                "sEmptyTable":     "No existen datos disponibles",
                "sInfo":           "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando desde 0 hasta 0 de 0 registros",
                "sInfoFiltered":   "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing":     "Procesando...",
                "sSearch":         "Buscar:",
                "sZeroRecords":    "No se encontraron resultados",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }, 
                "oAria": { 
                    "sSortAscending":  ": activar para Ordenar Ascendentemente",
                    "sSortDescending": ": activar para Ordendar Descendentemente"
                }
            }, 
            "sPaginationType": "full_numbers",
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                null,
                null,  
                null,  
                null,  
                null   

            ]   
        } );
    }); 
</script>     