<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 20px">      
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Proveedores de: <?php echo $proveedores[0]["producto"]; ?></legend>
        <div>
            <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">      
                <thead>
                    <tr class="headall">     
                        <th class="headinit">Referencia</th>                        
                        <th class="head">Nombre</th>
                        <th class="head">Telefono</th>
                        <th class="head" style="cursor: pointer">Ultimo Costo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($proveedores) != 0) {
                        foreach ($proveedores as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>"> 
                                <td class="init2">
                                    <?php echo $value["nit"] ?>
                                </td>                                  
                                <td class="item2">
                                    <?php echo $value["nombre"] ?>
                                </td> 
                                <td class="item2">
                                    <?php echo $value["telefono"] ?>
                                </td> 
                                <td class="item2">
                                    <?php
                                    echo '&#36;' . number_format($value["costo"], 0, ',', '.');
                                    ?>
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
        $('#mytable').dataTable( {           
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
            "aaSorting": [[ 3, "asc" ]],
            "aoColumns": [
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false, "bSearchable": false },
                { "sType": "numeric-point", "bSearchable": false },
            ]            
        } );                          
    });
</script>
