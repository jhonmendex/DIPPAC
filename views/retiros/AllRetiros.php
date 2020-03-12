<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Retiros</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">  
    <div style="float: left;width: 50%;">
        <fieldset class="colorleyend" style="width: 100%;">
            <legend class="colorleyendinto">Opciones</legend>
            <div id="cajaselect3" style="margin-bottom: 15px">
                        Bodega: <strong><?php echo $nombrebodega?></strong>                        
        </div>
            <div id="cajaselect" style="margin-bottom: 15px">
                <a style="cursor: pointer; color: #005500; font-weight: bold;" 
                   href="index.php?controlador=Retiros&accion=newRetiro">
                    + Crear nuevo retiro
                </a>
            </div>
        </fieldset>
    </div> 
    <div style="clear: left"></div>
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Retiros</legend>
        
        <div style="float: left;height: 16px;margin-bottom: 10px">
           <img src="images/list.png" width="15px" height="15px" /> : Detalles del retiro
        </div>                           
        <div style="clear: both; margin-bottom: 15px"></div>
        <div style="margin-top: 15px;margin-bottom: 20px"> 

            <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
                <thead>
                    <tr class="headall">                                                    
                        <th class="head" style="cursor: pointer">No. Documento</th>
                        <th class="head">Tipo</th>
                        <th class="head">Fecha</th>
                        <th class="head">Total</th> 
                        <th class="head">Detalles</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($retiros)) {
                        foreach ($retiros as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>"> 
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["codigo"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["tipo"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["fecha"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    $<?php echo number_format($value["total"], 0, ',', '.') ?>
                                </td> 
                                <td class="item2" style="width: 20px;">
                                    <a class="various3" title="Detalles del retiro" href="index.php?controlador=Retiros&accion=getdetailsRetiro&iddoc=<?php echo $value["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                        <img src="images/list.png" width="15px" height="15px" title="<?php echo "detalle de compras y devolucion a proveedor"; ?>"/>                       
                                    </a>                        
                                </td>                          
                            </tr>
                            <?php
                            if ($estilo == 1) {
                                $estilo = 2;
                            } else {
                                $estilo = 1;
                            }
                        }
                    }
                    ?> 
                </tbody>
                <tfoot>
                    <th>No. Documento</th>
                    <th id="tipofilter">Tipo</th>
                    <th></th>
                    <th></th> 
                    <th></th> 
                </tfoot>
            </table>  

        </div>
    </fieldset>
</div> 
</div>
</div>
<script>             
<?php if ($mensajito) { ?>
        message('Se ha ingresado un nuevo retiro al sistema', 'images/iconos_alerta/ok.png');
<?php } ?>
    $(document).ready(function(){
        $(".various3").fancybox({
            'width'                : 900,
            'height'               : 420,
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
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }
            ]            
        }).columnFilter({
            aoColumns: [{type: "number"},
                {type: "select"},
                null,               
                null,                                
                null]
        });
        $('#tipofilter .filter_column .select_filter').change(function(){            
            oTable.fnFilter( "^" + $('#tipofilter .filter_column .select_filter').val().replace("%20", " ") + "$", 1, true); 
            $("#tipofilter .filter_column .select_filter option[value='']").remove();
        });                          

    });      
</script>
