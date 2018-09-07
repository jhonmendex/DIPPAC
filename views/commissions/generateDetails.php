<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>

<div class="container" style="margin-bottom: 20px; margin-top: 10px">
    <fieldset class="colorleyend" style="width: 99%; padding: 5px">
                    <legend class="colorleyendinto">Comisiones por usuario del periodo:<?php echo $periodoname?> </legend>   
                    <div> 
    <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
        <thead>
        <tr class="headall">    
            <th class="headinit">Codigo </th> 
            <th class="head">Nombre</th>                        
            <th class="head">Cedula</th>
            <th class="head">Total</th>                          
        </tr>
        </thead>
        <tbody>
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
            </tbody>
    </table>   
</div> 
</fieldset>      
</div>
<script>
$(document).ready(function(){        
        $('img').css("border","0");
        
        $('#mytable').dataTable({
               "fnCreatedRow": function(nRow, aData, iDataIndex) {
                   $(nRow).addClass("class1");
                   $('td:eq(0)', nRow).addClass('init2');
                   $('td:eq(1)', nRow).addClass('item2');
                   $('td:eq(2)', nRow).addClass('item2');
                   $('td:eq(3)', nRow).addClass('item2');                   
               },
               "aLengthMenu": [
                   [10, 15, 20, -1],
                   [10, 15, 20, "Todos"]
               ],
               "iDisplayLength": 5,
               "oLanguage": {
                   "sEmptyTable": "No existen datos disponibles",
                   "sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                   "sInfoEmpty": "Mostrando desde 0 hasta 0 de 0 registros",
                   "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                   "sInfoPostFix": "",
                   "sInfoThousands": ",",
                   "sLengthMenu": "Mostrar _MENU_ registros",
                   "sLoadingRecords": "Cargando...",
                   "sProcessing": "Procesando...",
                   "sSearch": "Buscar:",
                   "sZeroRecords": "No se encontraron resultados",
                   "oPaginate": {
                       "sFirst": "Primero",
                       "sLast": "Último",
                       "sNext": "Siguiente",
                       "sPrevious": "Anterior"
                   },
                   "oAria": {
                       "sSortAscending": ": activar para Ordenar Ascendentemente",
                       "sSortDescending": ": activar para Ordendar Descendentemente"
                   }
               },
               "sPaginationType": "full_numbers",
              // "aaSorting": [[0, "asc"]],
               "aoColumns": [
                   null,
                   null,                   
                   null,
                   null,
               ]
           });
              
    });
</script>