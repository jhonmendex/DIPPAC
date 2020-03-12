<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>       
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Remisiones: Detalles de remisi&oacute;n</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">      
            <div style="float: left;width: 60%; margin-left: 0px"> 
                <fieldset class="colorleyend" style="width: 100%">  
                    <legend class="colorleyendinto">Informaci&oacute;n de la remisión No. <?php echo $idremision ?></legend>   
                    <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">    
                        <tr><th width="40%">Bodega remitente</th><td><input type="text" readonly="readonly" size="40%" value="<?php echo $detailsremissions[1]["bodega"]; ?>"></td></tr>                
                        <tr><th>Remisión realizada por</th><td><input type="text" readonly="readonly" size="40%" value="<?php echo $detailsremissions[1]["emisor"]; ?>"></td></tr>
                        <tr><th>Fecha</th><td><input type="text" readonly="readonly" value="<?php echo $detailsremissions[1]["fecha"]; ?>"></td></tr>             
                        <tr><th>Total remisión</th><td><input type="text" readonly="readonly" value="<?php echo '&#36;' . number_format($detailsremissions[1]["totalremision"], 0, ',', '.'); ?>"></td></tr>                 
                    </table>                 
                </fieldset>     
            </div>    
            <div style="float: right;width: 37%; margin-left: 5px"> 
                <?php if ($detailsremissions[1]["estado"] == 'POR ENTREGAR') { ?>
                    <fieldset class="colorleyend" style="width: 100%"> 
                        <legend class="colorleyendinto">Opciones</legend> 
                        <form method="POST" action="index.php?controlador=Remissions&accion=aceptarRemision&idremision=<?php echo $idremision ?>" id="formremmision">
                            <table class="table" border="0" cellspacing="0" cellpadding="3">   
                                <tr>          

                                    <td>
                                        <button id="boton" class="buscarButton" style="height: 40px">
                                            Aceptar remisión
                                        </button>                                              
                                    </td> 

                                    <!--
                                    <td><a href="index.php?controlador=Remissions&accion=rechazarRemision&idremision=<?php echo $idremision ?>">
                                            <button id="boton" disabled="disabled" style="height: 40px">
                                            Rechazar remisión
                                        </button>  
                                        </a>
                                    </td>   -->                  
                                </tr>     
                                <tr><td  style="color: #900000">Antes de aceptar la remision verifique que los productos esten completos y en buen estado</td></tr> 
                            </table>  
                        </form>
                        <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                            <img src="images/ajax-loader.gif"/> Procesando...
                        </div>
                    </fieldset> 
                <?php } else { ?>     
                    <h2 style="color: #009900">Esta remisión ha sido <?php echo $detailsremissions[1]["estado"] ?> </h2> 
                <?php } ?>
            </div>   
            <div style="clear: left"></div>                 
            <fieldset class="colorleyend" style="width: 100%">  
                <legend class="colorleyendinto">Detalles de la remisión No. <?php echo $idremision ?></legend>                    
                <div style="margin-top: 0px;margin-bottom: 20px"> 
                    <table id="mytable2" class="table" border="0" cellspacing="0" cellpadding="0">      
                        <thead>   
                            <tr class="headall">     
                                <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                                <th class="head">Referencia</th>
                                <th class="head">Stock actual</th>
                                <th class="head" style="cursor: pointer;">Cantidad <br> Remisi&oacute;n</th>
                                <th class="head" style="cursor: pointer;">Vr Unit</th>  
                                <th class="head" style="cursor: pointer;">Vr Total</th>                      
                            </tr>       
                        </thead> 
                        <tbody style="text-align: center; line-height: 25px">      
                            <?php
                            foreach ($detailsremissions[0] as $value) {
                                ?>    
                                <tr id="<?php echo $value["id"] ?>">   
                                    <td class="init2">  
                                        <?php echo $value["nombrep"] ?>  
                                    </td>   
                                    <td class="item2"> 
                                        <?php echo $value["referencia"] ?>  
                                    </td>      
                                    <td class="item2">   
                                        <?php echo $value["stock"] ?>  
                                    </td>   
                                    <td class="item2">    
                                        <?php echo $value["cantidad"] ?>  
                                    </td>      
                                    <td class="item2">  
                                        <?php echo '&#36;' . number_format($value["costo"], 0, ',', '.'); ?> 
                                    </td>    
                                    <td class="item2">      
                                        <?php echo '&#36;' . number_format($value["total"], 0, ',', '.'); ?> 
                                    </td>       
                                </tr>     
                            <?php } ?>                                        
                        </tbody>  
                    </table>   
                </div>                                              
            </fieldset>             
        </div>    
    </div>    
</div>    
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>  
    eval("<?php echo $mensaje ?>"); 
    jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['numeric-point-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "$", "" ).replace( ".", "" );
        var y = (b == "-") ? 0 : b.replace( "$", "" ).replace( ".", "" );
        return (x-y);
    };

    jQuery.fn.dataTableExt.oSort['numeric-point-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "$", "" ).replace( ".", "" );
        var y = (b == "-") ? 0 : b.replace( "$", "" ).replace( ".", "" );
        return (y-x);
    };
    $(document).ready(function(){      
        $('#mytable2').dataTable( { 
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
                null,  
                null,  
                null,  
                null,    

            ] 
        } );
                
        $('#formremmision').ajaxForm({
            dataType: 'json',
            beforeSubmit: function(arr, $form, options) {
                $('#loader').css('display', 'block');
                $("#boton").attr("disabled", "disabled");
                $("#boton").addClass("buscarButtonDis");
                $("#boton").removeClass("buscarButton");                                                                                      
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {
                if (responseText.res == 'si') {                        
                    window.location="index.php?controlador=Remissions&accion=getDetailsRemissions&idremission=<?php echo $idremision?>&mensaje=message('Se registro la remision de entrada con exito', 'images/iconos_alerta/ok.png');";                                                                       
                }else{
                    message('No se registro la remision de entrada', 'images/iconos_alerta/error.png');
                    $('#loader').css('display', 'none');
                    $("#boton").removeAttr("disabled", "disabled");
                    $("#boton").addClass("buscarButton");
                    $("#boton").removeClass("buscarButtonDis"); 
                }
            }
        });        
    }); 
</script>