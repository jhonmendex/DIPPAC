<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Remisiones</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px"> 
            <div style="float: left;width: 50%;">
                <fieldset class="colorleyend" style="width: 100%;">
                    <legend class="colorleyendinto">Opciones</legend>
                    <div id="cajaselect3" style="margin-bottom: 15px">
                        Bodega: <strong><?php echo $nombrebodega?></strong>                        
           </div>
                    <div id="cajaselect" style="margin-bottom: 15px">
                       <?php if($cantidadbodegas>1){?>
                        <a style="cursor: pointer; color: #005500; font-weight: bold;" 
                           href="index.php?controlador=Remissions&accion=inizialiteRemision">
                            + Crear nueva remision
                        </a>
                        <?php }else{?>
                        No existen mas bodegas disponibles para realizar una remisi&oacute;n
                        <?php }?>
                    </div>
                </fieldset>
            </div> 
            <div style="clear: left"></div>
            <fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Lista de remisiones recibidas de <?php echo $nombrebodega?></legend>
                <div style="margin-top: 15px;margin-bottom: 20px"> 
                    <table id="mytable" class="table" border="0" cellspacing="0" cellpadding="0">      
                        <thead>   
                            <tr class="headall"> 
                                <th class="headinit" style="cursor: pointer;"># Remision</th>  
                                <th class="headinit" style="cursor: pointer;">Bodega origen</th>                        
                                <th class="head">Bodega destino</th>
                                <th class="head">Fecha</th>
                                <th class="head" style="cursor: pointer;">Responsable</th>
                                <th class="head" style="cursor: pointer;">Estado</th>
                                <th class="head" style="cursor: pointer;">Ver remision</th>                      
                            </tr>       
                        </thead> 
                        <tbody style="text-align: center; line-height: 25px">      
                            <?php
                            if(sizeof($remisionbodega)!=0){
                            foreach ($remisionbodega as $value) {
                                ?>    
                                <tr id="<?php echo $value["id"] ?>">   
                                    <td>   
                                        <?php echo $value["codigo"] ?>  
                                    </td>                                              
                                    <td>  
                                        <?php echo $value["bodegades"] ?>  
                                    </td>    
                                    <td>    
                                        <?php echo $value["bodegaori"] ?>  
                                    </td>      
                                    <td>   
                                        <?php echo $value["fecha"] ?>  
                                    </td>     
                                    <td>      
                                        <?php echo $value["emisor"] ?> 
                                    </td>        
                                    <td>     
                                        <?php echo $value["estado"] ?> 
                                    </td>
                                    <td>     
                                        <a class="various4" href="index.php?controlador=Remissions&accion=getDetailsRemissions&idremission=<?php echo $value["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                            <img src="images/list.png" width="15px" height="15px" title="<?php $doc->texto('VIEW_DETAILS2'); ?>"/>
                                        </a>                                                
                                    </td>         
                                </tr>     
                            <?php }
                            }?>                                         
                        </tbody>  
                    </table>   
                </div>
            </fieldset>
        </div> 
    </div>
</div>
<script>                 
    eval("<?php echo $mensaje ?>"); 
    var oTable;      
    $(document).ready(function(){
        $(".various3").fancybox({
            'width'                : '90%',
            'height'               : '90%',
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false    
        });   
        $('img').css("border","0");        
        oTable=$('#mytable').dataTable( {
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).addClass("class1");
                $('td:eq(0)', nRow).addClass('init2');
                $('td:eq(1)', nRow).addClass('item2');
                $('td:eq(2)', nRow).addClass('item2');
                $('td:eq(3)', nRow).addClass('item2');
                $('td:eq(4)', nRow).addClass('item2');
                $('td:eq(5)', nRow).addClass('item2');
                $('td:eq(6)', nRow).addClass('item2');
            },
            "aLengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ],
            "iDisplayLength": 10,
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
            "aaSorting": [[ 0, "desc" ]],
            "aoColumns": [
                null,
                null,
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": true },
                { "bSortable": false, "bSearchable": true },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }
            ]            
        } );                          

    });      
</script>