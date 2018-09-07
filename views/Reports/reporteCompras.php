<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>   
<style>
    #cajaselect{ margin-left: -1%;}  
</style>
<div id="main">     
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Reporte de compras</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">           
            <div style="width: 100%;">     
                <fieldset class="colorleyend" style="width: 97%; padding: 10px">
                    <legend class="colorleyendinto">Opciones de busqueda</legend>     
                    <form method="POST" action="index.php?controlador=Reports&accion=reporteCompras"> 
                        <table border="0">   
                          <tr>   
                            <td><?php $doc->texto('DATEINI') ?>: </td>
                            <td><?php $view->input("dateini", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $finicial)); ?>
                            </td>  
                            <td><?php $doc->texto('DATEFIN') ?>: </td>
                            <td><?php $view->input("datefin", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $ffinal)); ?>
                            </td>  
                        </tr>
                            <tr>  
                            <td>Bodegas:</td><td> 
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
                            <td>Proveedor:</td>
                                    <td>    
                                        <input id="clientena" type="text" name="clientena" style="background: none !important; width: 300px;float: left"/>
                                        <div style="margin-left: 1px;float: left; margin-top: 2px">   
                                            <a class="search" href="index.php?controlador=Reports&accion=getProveedores" title="Buscar cliente">
                                                <img src="images/zoom.png" width="17" height="17"/>
                                            </a>
                                        </div>
                                        <div style="clear: both"></div>
                                        <input type="hidden" name="idcliente" value="0" id="clienteid"/>                                        
                                    </td> 
                            <td><button class="buscarButton" style="height: 40px;width: 200px">Ver reporte</button></td>
                        </tr>
                        <tr>  
                        <td>Categorias:</td>
                        <td> 
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
                        </tr>
                        </tbody>
                    </table>
                    </form>    
                </fieldset>   
                <div>             
                    <div style="margin-top: 0px;margin-bottom: 20px; width: 99%">   
                        <?php foreach ($reportev[0] as $key => $value) { ?>  
                            <fieldset class="colorleyend" style="width: 99%; padding: 5px">   
                                <legend class="colorleyendinto">Compras de la bodega: <?php echo $reportev[0][$key]['nombrebodega']?></legend>       
                                                                                        
                                      <div style="margin-top: 0px;margin-bottom: 20px">   
                                        <table class="mytable" border="0" cellspacing="0" cellpadding="0">      
                                            <thead>  
                                                <tr class="headall">     
                                                    <th class="headinit" style="cursor: pointer;">Fecha</th>
                                                    <th class="headinit" style="cursor: pointer;">Factura #</th>
                                                    <th class="headinit" style="cursor: pointer;">Proveedor</th>
                                                    <th class="head">No. identificación</th>
                                                    <th class="head">Dirección</th>
                                                    <th class="head">Valor venta</th>
                                                    <th class="head">Tarifa IVA</th>
                                                    <th class="head">Valor IVA</th> 
                                                    <th class="head" style="cursor: pointer;">Total</th>                  
                                                </tr>       
                                            </thead>     
                                            <tbody style="line-height: 25px">      
                                                <?php  
                                                foreach ($reportev[0][$key]['productos'] as $value3) {
                                                    
                                                    ?>     
                                                    <tr id="<?php echo $value3["id"] ?>">   
                                                        <td align="center" class="init2">    
                                                              <?php echo $value3["fecha"] ?> 
                                                        </td>
                                                        <td align="center" class="init2">    
                                                              <?php echo $value3["Nfactura"] ?> 
                                                        </td>
                                                        <td style="text-align: center" class="item2">  
                                                            <?php echo $value3["proveedor"] ?> 
                                                        </td>      
                                                        <td style="text-align: center" class="item2">     
                                                           <?php echo $value3["nit"] ?>  
                                                        </td>    
                                                        <td style="text-align: center" class="item2">    
                                                          <?php echo $value3["direccion"] ?> 
                                                        </td>                                                          
                                                        <td style="text-align: center" class="item2">    
                                                             <?php 
                                                             foreach ($reportev[3][$value3["id"]] as $value4) { 
                                                                 $comparador = $value4['ivas']; 
                                                             } 
                                                             echo '&#36;' . number_format($value3["subtotal"]-$comparador, 0, ',', '.'); ?> 
                                                        </td>
                                                        <td style="text-align: center" class="item2">  
                                                             <?php foreach ($reportev[3][$value3["id"]] as $value4) { 
                                                              echo $value4['iddetalle']." : ".'&#36;'.number_format($value4['piva'], 0, ',', '.'); ?><br>
                                                           <?php } ?>    
                                                        </td> 
                                                        <td style="text-align: center" class="item2">  
                                                          <?php  echo '&#36;' . number_format($value4['ivas'], 0, ',', '.');   ?>
                                                        </td> 
                                                        <td style="text-align: center" class="item2">  
                                                        <?php 
                                                            $totalventa = $value3["subtotal"];
                                                            echo '&#36;' . number_format($totalventa, 0, ',', '.');
                                                             ?>
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
                                            <th class="init" style="background-color: #D3D6FF">Total ventas antes de IVA </th>
                                            <th class="item" align="center" style="background-color: #f3f3f3"><?php echo '&#36;' . number_format($reportev[1][$key]-$reportev[2][$key], 0, ',', '.'); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="init" style="background-color: #D3D6FF">Total IVA</th> 
                                            <th class="item" align="center" style="background-color: #f3f3f3"><?php echo '&#36;' . number_format($reportev[2][$key], 0, ',', '.'); ?></th>
                                        </tr>
                                        <tr class="class1">
                                            <th class="init" style="background-color: #D3D6FF">Total ventas con IVA</th> 
                                            <th class="item" align="center" style="background-color: #f3f3f3"><?php echo  '&#36;' .number_format($reportev[1][$key], 0, ',', '.'); ?></th>
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
    
        function actualizarcliente(id, nombre){           
       $("#clientena").val(nombre);
       $("#clienteid").val(id); 
    }
    $(document).ready(function(){ 
        
        $(".search").fancybox({
               'width': 800,
               'height': 400,
               'autoScale': false,
               'transitionIn': 'elastic',
               'transitionOut': 'elastic',
               'speedIn': 500,
               'type': 'iframe',
               'hideOnOverlayClick': false
            });        
        
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
                null,
                null,
                null,
                null,
                null

            ]   
        } ); 
    }); 
</script>        