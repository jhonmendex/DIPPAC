<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-main">Generar Comisiones</td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px"> 
            <fieldset class="colorleyend" style="width: 99%; padding: 5px">
                    <legend class="colorleyendinto">Opciones</legend>    
                    <form method="POST" action="index.php?controlador=Commission&accion=generateComision" id="miform">
                    <table border="0" style="padding: 10px; line-height: 15px">   
                        <tbody>    
                        <tr>                                    
                            <td>Seleccione el periodo sobre el cual desea generar las comisiones: </td><td> 
                                <div id="cajaselect" style="margin-bottom: 0px">
                                    <table border="0" width="100%">                   
                                        <tr>     
                                            <td>
                                            <select id="periodo" name="periodo">
                                                <?php foreach ($periodos as $value) { ?>
                                                    <option value="<?php echo $value["id"] ?>">
                                                        <?php echo $value["nombre"] ?>
                                                    </option>           
                                                <?php } ?>                                                       
                                            </select>                             
                                            </td>                   
                                        </tr>
                                    </table> 
                                </div>       
                            </td>
                            <td><button class="buscarButton" style="height: 40px" id="finish">Generar Comisiones</button>
                                <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
                                    <img src="images/ajax-loader.gif"/> Procesando...        
                                </div>
                            </td>
                        </tr> 
                        </tbody>
                    </table>
                    </form>    
                </fieldset>   
     <fieldset class="colorleyend" style="width: 99%; padding: 5px">
                    <legend class="colorleyendinto">Comisiones generadas de periodos anteriores</legend>   
                    <div>
    <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
        <thead>
        <tr class="headall">    
            <th class="headinit">Ver <br>Detalles </th> 
            <th class="head"><?php $doc->texto('PERIOD') ?></th>                        
            <th class="head"><?php $doc->texto('TOTAL') ?></th>
            <th class="head">Fecha de<br> Generaci&oacute;n</th>                          
        </tr>
        </thead>
        <tbody>
        <?php
        $estilo = 1;
        foreach ($comisiones as $key=>$value) {
            ?>
            <tr class="class<?php echo $estilo; ?>">   
                <td class="init2" style="width: 20px;">
                    <a class="various3" title="Comisiones por usuario" href="index.php?controlador=GenerateCommission&accion=levels&periodo=<?php echo  $key;?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                        <img src="images/list.png" width="15px" height="15px" title="<?php $doc->texto('VIEW_DETAILS2'); ?>"/>                       
                    </a>                        
                </td>
                <td class="item2"><?php echo $value["nombre"] ?></td>
                <td class="item2"><?php echo number_format($value["total"], 2, ',', '.'); ?></td>               
                <td class="item2"><?php echo $value["fecha"] ?></td>                             
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
</div> 
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    $(document).ready(function(){

            $('#miform').ajaxForm({
                dataType: 'json',
                beforeSubmit: function() {                    
                    $('#finish').attr('disabled', 'disabled');
                    $("#finish").addClass("buscarButtonDis");
                    $("#finish").removeClass("buscarButton");
                    $('#loader').css('display', 'block');                    
                },
                success: function(res) {  
                if (res.respuesta == 'si') {    
                alert("comisiones generadas!");     
                   window.location="index.php?controlador=GenerateCommission";

                }      
                }
            }); 

        $(".various3").fancybox({
            'width'                : '95%',
            'height'               : '90%',
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false    
        });    
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
                   {"bSortable": false, "bSearchable": false},
                   null,
                   null,
                   null,
               ]
           }); 
                                               
    });
</script>
