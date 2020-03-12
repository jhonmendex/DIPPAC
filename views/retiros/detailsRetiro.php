<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">   
   <div style="float: left;width: 100%; margin-left: 0px"> 
       <fieldset class="colorleyend" style="width: 100%;">  
           <legend class="colorleyendinto">Informaci&oacute;n del retiro</legend> 
            <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                <tr>
                    <td width="120px"><strong>Codigo:</strong></td>
                    <td><?php echo $docinfo["prefijo"].".".$docinfo["codigo"]; ?></td>
                </tr> 
                <tr>
                    <td><strong>Tipo documento:</strong></td>
                    <td><?php echo $docinfo["tipo"]; ?></td>
                </tr> 
                <tr>
                    <td><strong>Fecha:</strong></td>
                    <td><?php echo $docinfo["fecha"]; ?></td>
                </tr>                
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><?php echo '&#36;' . number_format($docinfo["total"], 0, ',', '.'); ?></td>
                </tr>                 
            </table>         
        </fieldset>   
    </div>          
    <div style="clear: left"></div>
    <fieldset class="colorleyend" style="width: 100%;">  
           <legend class="colorleyendinto">Detalles del retiro</legend> 
    <div>
        <table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" id="example">
            <thead>
                <tr class="headall">
                    <th class="headinit" style="cursor: pointer;">Referencia</th>
                    <th class="head" style="cursor: pointer;">Articulo</th>
                    <th class="head" style="cursor: pointer;">Cantidad</th>                  
                    <th class="head" style="cursor: pointer;">Costo base</th> 
                    <th class="head" style="cursor: pointer;">Total</th>                      
                </tr> 
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                if (sizeof($detallesdoc) != 0) {
                    foreach ($detallesdoc as $value) {
                        ?>
                        <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["referencia"] ?>">
                            <td align="center" class="init2" style="width: 200px;" id="nameb<?php echo $value["id"] ?>">
                                <?php echo $value["referencia"] ?>
                            </td>
                            <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                <?php echo $value["nombreproducto"] ?>
                            </td>
                        <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>">
                            <?php echo $value["cantidad"];?>   
                        </td>                                               
                            <td align="center" class="item2" style="width: 20px;" id="dirb<?php echo $value["id"] ?>">
                                <?php echo number_format($value["costo"], 2, ',', '.'); ?>
                            </td>
                            <td align="center" class="item2" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">
                                <?php echo '&#36;' . number_format($value["valortotal"], 0, ',', '.'); ?>
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
        </table> 
    </div> 
    </fieldset>
   </div> 

<script>
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
        $('img').css("border","0");        
        $('#example').dataTable( { 
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
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,                                              
            ]
        } );
    });
</script>