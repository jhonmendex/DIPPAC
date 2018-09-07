<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Administraci&oacute;n de perfiles</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 15px"> 
            <div style="float: left;width: 50%;">
                <fieldset class="colorleyend" style="width: 100%;">
                    <legend class="colorleyendinto">Opciones</legend>                    
                    <div id="cajaselect" style="margin-bottom: 15px">
                        <a style="cursor: pointer; color: #005500; font-weight: bold;" title="Crear perfil" class="various3" href="index.php?controlador=Profiles&accion=createProfile">
                            + Crear nuevo perfil
                        </a>
                    </div>
                </fieldset>
            </div>
            <div style="clear: left"></div>
            <fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Lista de perfiles</legend>
                <div style="float: left;">
                    <img class="delete" src="images/delete.gif" />: Eliminar un perfil
                </div>
                <div style="float: left; margin-left: 30px">
                    <img src="images/candado.png" width="18px" height="18px" />: Editar permisos de un perfil
                </div>                
                 <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
                            <strong style="color: #252f38">N/A</strong> : No aplica
                        </div> 
                <div style="clear: both; margin-bottom: 15px"></div>
                <div>
                     <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">   
                        <thead>
                            <tr class="headall">                
                                <th class="headinit" style="width: 80px; cursor: pointer">Codigo</th> 
                                <th class="head" style="cursor: pointer">Nombre de Perfil</th> 
                                <th class="head">Grupo</th> 
                                <th class="head" style="width: 90px;cursor: pointer">No. de usuarios</th> 
                                <th class="head">Editar Permisos</th> 
                                <th class="head">Eliminar</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($perfiles) != 0) {
                                foreach ($perfiles as $value) {
                                    if ($value['grupo'] != "Superadministrador") {
                                        ?>
                                        <tr class="class<?php echo $estilo; ?>" id="<?php echo $value['id']; ?>"> 
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['nombre']; ?></td> 
                                            <td><?php echo $value['grupo']; ?></td>                 
                                            <td><?php echo $value['cantidad']; ?></td>
                                            <td style="width: 20px;">
                                                <a class="various3" title="Editar permisos del perfil" href="index.php?controlador=Profiles&accion=assingPermissions&profile=<?php echo $value['id']; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                                    <img src="images/candado.png" width="18px" height="18px" title="Editar permisos del perfil"/>                       
                                                </a>                        
                                            </td>
                                            <td style="width: 20px;">
                                                <?php if ($value['cantidad'] == 0) { ?>
                                                    <a  id="dell<?php echo sha1($value['id']); ?>" 
                                                        callback="<?php echo $value['nombre']; ?>"
                                                        tar="index.php?controlador=Profiles&accion=deleteProfile"
                                                        verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>"
                                                        href="#" 
                                                        onclick="confirmfunction($(this).attr('id'))">
                                                        <img class="delete" src="images/delete.gif" title="Eliminar perfil"/>                       
                                                    </a>
                                                <?php }else{ ?>
                                                <strong style="color: #252f38">N/A</strong>
                                                <?php } ?>
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
                            }
                            ?>  
                        </tbody>
                    </table> 
                </div> 
            </fieldset>
        </div> 
    </div> 
</div> 
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el perfil <strong id="nombrecalldel"></strong>?
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
                    $.fancybox.close();
                    message("Se ha eliminado el perfil", "images/iconos_alerta/ok.png");
                } else {
                    $.fancybox.close();
                    message("No se pudo eliminar el perfil", "images/iconos_alerta/error.png");
                }
            }
        });
    });
    $('#cancel').click(function() {
        $.fancybox.close();
    });
}

function createdata(id, nombre, grupo, idcode, idverify) {
       var addId = $('#mytable').dataTable().fnAddData([
           id,
           nombre,
           grupo,
           0,                      
           "<a class='various3" + id + "' title='Editar permisos del perfil' href='index.php?controlador=Profiles&accion=assingPermissions&profile=" + id + "'><img src='images/candado.png' width='18px' height='18px'/></a>",
           "<a id='dell" + idcode + "' callback='" + nombre + "' tar='index.php?controlador=Profiles&accion=deleteProfile' href='#' verify='" + idverify + "' onclick='confirmfunction($(this).attr(\"id\"))'><img src='images/delete.gif' class='delete'/></a>"]
        );
       var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
       theNode.setAttribute('id', id);
       $(".various3" + id).fancybox({
            'width': 810,
            'height': 450,
            'autoScale': false,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'type': 'iframe',
            'hideOnOverlayClick': false
       });                                                             
}

$(document).ready(function() {
   $('img').css("border", "0");
   oTable = $('#mytable').dataTable({
       "fnCreatedRow": function(nRow, aData, iDataIndex) {  
           $(nRow).addClass("class1");
           $('td:eq(0)', nRow).addClass('init2');
           $('td:eq(1)', nRow).addClass('item2');
           $('td:eq(2)', nRow).addClass('item2');
           $('td:eq(3)', nRow).addClass('item2');
           $('td:eq(4)', nRow).addClass('item2');
           $('td:eq(5)', nRow).addClass('item2');            
           $('td:eq(0)', nRow).css('text-align','center');
           $('td:eq(2)', nRow).css('text-align','center');
           $('td:eq(3)', nRow).css('text-align','center');
           $('td:eq(4)', nRow).css('text-align','center');
           $('td:eq(5)', nRow).css('text-align','center');                                      
       },
       "aLengthMenu": [
           [5,10, 15, 20, -1],
           [5,10, 15, 20, "Todos"]
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

    $(".various3").fancybox({
        'width': 810,
        'height': 450,
        'autoScale': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'type': 'iframe',
        'hideOnOverlayClick': false
    });
    $('img').css("border", "0");
});
</script>
