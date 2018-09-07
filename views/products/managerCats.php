<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 10px">  
    <div style="float: left;width: 50%;">
        <fieldset class="colorleyend" style="width: 100%;">
            <legend class="colorleyendinto">Opciones</legend>            
            <div id="cajaselect2" style="margin-bottom: 15px">
                <a style="cursor: pointer; color: #005500; font-weight: bold;" class="various3" 
                   href="index.php?controlador=Products&accion=newCategory"
                   title="Crear Categoria">
                    + Crear nueva categoria
                </a>
            </div>
        </fieldset>
    </div>
    <div style="clear: left"></div>
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Categorias</legend> 
        <div style="float: left;">
            <img class="delete" src="images/delete.gif" />: Eliminar una categoria
        </div>
        <div style="float: left; margin-left: 30px">
            <img src="images/edit.png" width="15px" height="15px" />: Editar una categoria
        </div>
        <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
            <strong style="color: #252f38">N/A</strong> : No aplica
        </div>                        
        <div style="clear: both; margin-bottom: 15px"></div>
        <div style="margin-top: 15px;margin-bottom: 20px">
            <table class="table" border="0" cellspacing="0" cellpadding="0" id="mytable">    
                <thead>
                    <tr class="headall">     
                        <th class="headinit" style="cursor: pointer;">Nombre de categoria</th>                        
                        <th class="head" style="cursor: pointer;">No. de productos asociados</th>                   
                        <th class="head">Editar</th>  
                        <th class="head">Eliminar</th>  
                    </tr> 
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($categorias) != 0) {
                        foreach ($categorias as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>"> 
                                <td class="init2" id="namec<?php echo $value["id"] ?>">
                                    <?php echo $value["nombre"] ?>
                                </td>  
                                <td class="item2" style="text-align: center">
                                    <?php echo $value["productos"] ?>
                                </td>                            

                                <td class="item2" style="width: 20px;text-align: center">
                                    <a class="various3" title="Editar Categoria" href="index.php?controlador=Products&accion=editarCat&idcat=<?php echo $value["id"]; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                        <img src="images/edit.png" width="21px" height="21px" title="<?php $doc->texto('EDIT'); ?>"/>                                              
                                    </a>                        
                                </td> 
                                <td class="item2" style="width: 20px;text-align: center">
                                    <?php if ($value['productos'] == 0) { ?>
                                        <a id="dell<?php echo sha1($value['id']); ?>" 
                                           callback="<?php echo $value['nombre']; ?>" 
                                           tar="index.php?controlador=Products&accion=deleteCat" 
                                           verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                           href="#" 
                                           onclick="confirmfunction($(this).attr('id'))">
                                            <img class="delete" src="images/delete.gif" title="Eliminar item"/> 
                                        </a>
                                    <?php }else{ ?>
                                    <strong style="color: #252f38">N/A</strong>
                                     <?php }?>
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

<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar la categoria <strong id="nombrecalldel"></strong>?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
                                               var oTable;
                                               function confirmfunction(id) {
                                                   $('#nombrecalldel').html($('#' + id).attr('callback'));
                                                   $('.callback').trigger('click');
                                                   $('#accept').click(function() {
                                                       $.ajax({
                                                           type: "POST",
                                                           url: $('#' + id).attr('tar'),
                                                           dataType: "json",
                                                           data: {verify: $('#' + id).attr('verify')},
                                                           success: function(data) {
                                                               if (data.res == 'si') {
                                                                   oTable.fnDeleteRow(oTable.fnGetPosition($('#' + data.idrow).get(0)));
                                                                   $("#categorias option[value='" + data.idrow + "']", window.parent.document).remove();
                                                                   if ($("#categorias", window.parent.document).val() == data.idrow) {
                                                                       if ($('#categorias > option', window.parent.document).length == 0) {
                                                                           $("#categorias", window.parent.document).append("<option value='9999999'>NO EXISTEN CATEGORIAS DISPONIBLES</option>");
                                                                           $("#ordernow", window.parent.document).attr("disabled", "disabled");
                                                                           $("#ordernow", window.parent.document).addClass("buscarButtonDis");
                                                                           $("#ordernow", window.parent.document).removeClass("buscarButton");
                                                                       } else {
                                                                           var rescreate="parent.message('Se ha eliminado la categoria', 'images/iconos_alerta/ok.png')";                                                                       
                                                                           parent.window.location="index.php?Products&create="+rescreate;
                                                                       }
                                                                   } else {
                                                                       $.fancybox.close();
                                                                       parent.message("Se ha eliminado la categoria", "images/iconos_alerta/ok.png");
                                                                   }
                                                               } else {
                                                                   $.fancybox.close();
                                                                   parent.message("No se pudo eliminar la categoria", "images/iconos_alerta/error.png");
                                                               }
                                                           }
                                                       });
                                                   });
                                                   $('#cancel').click(function() {
                                                       $.fancybox.close();
                                                   });
                                               }

                                               function updatedata(id, nombre) {
                                                   $("#namec" + id).html(nombre);
                                               }

                                               function createData(id, nombre, idcode, idverify) {
                                                   var addId = $('#mytable').dataTable().fnAddData([
                                                       nombre,
                                                       0,
                                                       "<a class='various3" + id + "' title='Editar Categoria' href='index.php?controlador=Products&accion=editarCat&idcat=" + id + "' objectedit='" + id + "' ><img src='images/edit.png' width='21px' height='21px'/></a>",
                                                       "<a id='dell" + idcode + "' callback='" + nombre + "' tar='index.php?controlador=Products&accion=deleteCat' href='#' verify='" + idverify + "' onclick='confirmfunction($(this).attr(\"id\"))'><img src='images/delete.gif' class='delete'/></a>"]);
                                                   var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
                                                   theNode.setAttribute('id', id);
                                                   $(".various3" + id).fancybox({
                                                       'autoDimensions': false,
                                                        'width': 600,
                                                        'height': 190,
                                                        'autoScale': false,
                                                        'transitionIn': 'elastic',
                                                        'transitionOut': 'fade',
                                                        'speedIn': 500,
                                                        'type': 'iframe',
                                                        'hideOnOverlayClick': false,            
                                                        'overlayColor': '#000',
                                                        'margin': 15,
                                                        'padding': 5
                                                   });
                                               }

                                               $(document).ready(function() {
                                                   $(".various3").fancybox({
                                                       'autoDimensions': false,
                                                        'width': 600,
                                                        'height': 190,
                                                        'autoScale': false,
                                                        'transitionIn': 'elastic',
                                                        'transitionOut': 'fade',
                                                        'speedIn': 500,
                                                        'type': 'iframe',
                                                        'hideOnOverlayClick': false,            
                                                        'overlayColor': '#000',
                                                        'margin': 15,
                                                        'padding': 5
                                                   });
                                                   $('img').css("border", "0");
                                                   oTable = $('#mytable').dataTable({
                                                       "fnCreatedRow": function(nRow, aData, iDataIndex) {
                                                           $(nRow).addClass("class1");
                                                           $('td:eq(0)', nRow).addClass('init2');
                                                           $('td:eq(1)', nRow).addClass('item2');
                                                           $('td:eq(2)', nRow).addClass('item2');
                                                           $('td:eq(3)', nRow).addClass('item2');
                                                           $('td:eq(1)', nRow).css('text-align', 'center');
                                                           $('td:eq(2)', nRow).css('text-align', 'center');
                                                           $('td:eq(3)', nRow).css('text-align', 'center');
                                                           if ($('td:eq(2) a', nRow).attr('objectedit')) {
                                                               $('td:eq(0)', nRow).attr('id', 'namec' + $('td:eq(2) a', nRow).attr('objectedit'));
                                                               $('td:eq(2) a', nRow).removeAttr('objectedit');
                                                           } else {
                                                               $('td:eq(0)', nRow).attr('id', 'namec' + $(nRow).attr('id'));
                                                           }
                                                       },
                                                       "aLengthMenu": [
                                                           [5, 10, 20, -1],
                                                           [5, 10, 20, "Todos"]
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
                                                       "aaSorting": [[0, "asc"]],
                                                       "aoColumns": [
                                                           null,
                                                           null,
                                                           {"bSortable": false, "bSearchable": false},
                                                           {"bSortable": false, "bSearchable": false}
                                                       ]
                                                   });

                                                   $(".callback").fancybox({
                                                       'autoDimensions': false,
                                                       'width': 400,
                                                       'height': 130,
                                                       'autoScale': false,
                                                       'overlayOpacity': 0.1,
                                                       'transitionIn': 'elastic',
                                                       'transitionOut': 'fade',
                                                       'speedIn': 500,
                                                       'hideOnOverlayClick': false,
                                                       'overlayColor': '#000',
                                                       'showCloseButton': false,
                                                       'padding': 0,
                                                       'margin': 0
                                                   });
                                               });
</script>