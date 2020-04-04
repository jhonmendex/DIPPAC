<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Administraci&oacute;n de usuarios</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
<div class="container" style="margin-bottom: 20px; margin-top: 15px"> 
    <div style="float: left;width: 40%;"> 
        <fieldset class="colorleyend" style="width: 100%">
            <legend class="colorleyendinto">Opciones</legend>           
            <div id="cajaselect" style="margin-bottom: 15px">
                <a class="various3" title="Crear usuario" href="index.php?controlador=ManageUsers&accion=createUser" style="cursor: pointer; color: #005500; font-weight: bold;">
                    + Crear nuevo usuario
                </a>
            </div>
        </fieldset>
    </div>   
    <div style="clear: left"></div>
<fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Lista de usuarios</legend>
                <div style="float: left;">
                    <img class="delete" src="images/edit.png" width="15px" height="15px"/>: Editar un usuario
                </div>
                <div style="float: left; margin-left: 30px">
                    <img src="images/user_group.png" width="15px" height="15px"/>: Cambiar perfil de un usuario
                </div>
                <div style="float: left; height: 16px; margin-left: 30px">
                    <img src="images/enable.png"/>: usuario activo
                </div>                        
                <div style="float: left; margin-left: 30px; height: 16px">
                    <img class="delete" src="images/disable.png"/>: usuario inactivo
                </div>                        
                <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
                    (<a style="cursor: default; color: #005500; font-weight: bold;">inactivar</a>) : Inactivar un usuario
                </div>  

                <div style="float: left;height: 16px; margin-top: 10px; padding-top: 7px;">
                    (<a style="cursor: default; color: #005500; font-weight: bold;">activar</a>) : Activar un usuario
                </div>                  
                <div style="clear: both; margin-bottom: 15px"></div>                
                    <div>
        <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">        
            <thead>
                <tr class="headall">                 
                    <th class="headinit" style="cursor: pointer">Nombre de usuario</th>                        
                    <th class="head">Nombre de usuario</th>
                    <th class="head" style="cursor: pointer">Codigo</th>
                    <th class="head">Cedula</th> 
                    <th class="head">Perfil</th>                     
                    <th class="head">Estado</th> 
                    <th class="head" style="cursor: pointer">Fecha de Ingreso</th> 
                    <th class="head">Editar</th> 
                    <th class="head">Cambiar Perfil</th>                    
                </tr>   
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                if (sizeof($usuarios) != 0) {
                    foreach ($usuarios as $value) {
                        ?>
                        <tr class="class<?php echo $estilo; ?>">                  
                            <td class="init2" id="nombre<?php echo $value['id']; ?>">
                            <?php echo $value['nombre']; ?>
                            </td>               
                            <td class="item2">
                            <?php echo $value['alias']; ?>
                            </td>
                            <td class="item2">
                            <?php echo $value['id']; ?>
                            </td>
                            <td class="item2" id="cedula<?php echo $value['id']; ?>">
                            <?php echo $value['cedula']; ?>
                            </td>               
                            <td class="item2" id="perfil<?php echo $value['id']; ?>">
                            <?php echo $value['perfil']; ?>
                            </td>
                            <td class="item2">
                            <?php if($value['estado']=="inactivo"){ ?>
                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                <img class="delete" src="images/disable.png"/>
                                </div>
                                <br>
                                <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px">
                                   (<a id="dell2<?php echo sha1($value['id']); ?>" 
                                       callback="<?php echo $value['nombre']; ?>" 
                                       tar="index.php?controlador=ManageUsers&accion=enableUser" 
                                       verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                       href="#"
                                       onclick="confirmfunction2($(this).attr('id'))"
                                       style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)
                                </div>
                            <?php }else{?>
                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                <img class="delete" src="images/enable.png"/>
                                </div>
                                <br>
                                <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px"> 
                                    (<a id="dell<?php echo sha1($value['id']); ?>" 
                                       callback="<?php echo $value['nombre']; ?>" 
                                       tar="index.php?controlador=ManageUsers&accion=disableUser" 
                                       verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                       href="#"
                                       onclick="confirmfunction($(this).attr('id'))"
                                       style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)
                                </div>
                             <?php }?>
                            </td>
                            <td class="item2"><?php echo $value['fecha']; ?></td>
                            <td class="item2" style="width: 20px; text-align: center">                                
                                <a class="various4" title="Editar usuario" href="index.php?controlador=ManageUsers&accion=editUser&iduser=<?php echo $value['id']; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                    <img src="images/edit.png" width="22px" height="22px" title="Editar inmformacion"/>                       
                                </a>  
                            </td>
                            <td class="item2" style="width: 20px; text-align: center">  
                                <?php if ($value['grupo'] != 'No usuario') { ?>
                                <a class="various2" title="Cambiar perfil" href="index.php?controlador=ManageUsers&accion=editProfile&iduser=<?php echo $value['id']; ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                    <img src="images/user_group.png" width="22px" height="22px" title="Cambiar perfil"/>                       
                                </a>  
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
                ?>  
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre de Usuario</th>                        
                    <th>Alias</th>
                    <th>Codigo</th>
                    <th>Cedula</th> 
                    <th id="perfilfilter">Perfil</th>                     
                    <th></th> 
                    <th></th> 
                    <th></th> 
                    <th></th> 
                    <th></th>
                </tr>
            </tfoot>
        </table>  
    </div>
</fieldset>
</div> 
</div> 
</div> 
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de desactivar el usuario <strong id="nombrecalldel"></strong>?
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
<div style="display: none">
    <div id="contentcall2">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de activar el usuario <strong id="nombrecalldel2"></strong>?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall2" class="callback2">Open Example</a>
</div>
<script>
    jQuery.fn.dataTableExt.oSort['format-date-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "-", "" ).replace( "-", "" );
        var y = (b == "-") ? 0 : b.replace( "-", "" ).replace( "-", "" );
        return (x-y);
    };

    jQuery.fn.dataTableExt.oSort['format-date-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "-", "" ).replace( "-", "" );
        var y = (b == "-") ? 0 : b.replace( "-", "" ).replace( "-", "" );
        return (y-x);
    };
    var oTable;
    function confirmfunction(id){
        $('#nombrecalldel').html($('#'+id).attr('callback'));                
        $('.callback').trigger('click');        
        $('#accept').click(function(){                                       
            $.ajax({
                type: "POST",
                url: $('#'+id).attr('tar'),
                dataType: "json",
                data: {verify:$('#'+id).attr('verify')},
                success: function(data) {
                    if(data.res=='si'){                                                                         
                        $('#state' + data.idrow).html('').append('<img class="delete" src="images/disable.png" title="inactivo"/>');
                        $('#' + id).removeAttr('tar');
                        $.fancybox.close();
                        $('#' + id).removeAttr('onclick');
                        $('#' + id).unbind('click');
                        $('#' + id).remove();
                        $("#otrootro" + data.idrow).html("").append('(<a id="' + data.ididid + '"\n\
                            callback="' + data.nombre + '"\n\
                            tar="index.php?controlador=ManageUsers&accion=enableUser" \n\
                            onclick="confirmfunction2($(this).attr(\'id\'))" \n\
                            verify="' + data.verify + '" \n\
                            href="#"\n\
                            style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)');                     
                        message("Se ha inactivado el usuario","images/iconos_alerta/ok.png");
                    }else{
                        $.fancybox.close();
                        message("No se pudo inactivar el usuario","images/iconos_alerta/error.png");
                    }
                }               
            });
        });
        $('#cancel').click(function(){
            $.fancybox.close();            
        });
    }
    
    function confirmfunction2(id){
        $('#nombrecalldel2').html($('#'+id).attr('callback'));                
        $('.callback2').trigger('click');        
        $('#accept2').click(function(){                                       
            $.ajax({
                type: "POST",
                url: $('#'+id).attr('tar'),
                dataType: "json",
                data: {verify:$('#'+id).attr('verify')},
                success: function(data) {
                    if(data.res=='si'){  
                        $('#state' + data.idrow).html('').append('<img class="delete" src="images/enable.png" title="activo"/>');
                        $('#' + id).removeAttr('tar');                                                                                                                     
                        $.fancybox.close();
                        $('#' + id).removeAttr('onclick');
                        $('#' + id).unbind('click');
                        $('#' + id).remove();
                        $("#otrootro" + data.idrow).html("").append('(<a id="' + data.ididid + '"\n\
                            callback="' + data.nombre + '"\n\
                            tar="index.php?controlador=ManageUsers&accion=disableUser" \n\
                            onclick="confirmfunction($(this).attr(\'id\'))" \n\
                            verify="' + data.verify + '" \n\
                            href="#"\n\
                            style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)');                       
                        message("Se ha activado el usuario","images/iconos_alerta/ok.png");
                    }else{
                        $.fancybox.close();
                        message("No se pudo activar el usuario","images/iconos_alerta/error.png");
                    }
                }               
            });
        });
        $('#cancel2').click(function(){
            $.fancybox.close();            
        });
    }
    function createData(id,nombre,alias, cedula, perfil, estado, grupo, fehaingreso,idcode,idverify){                                 
        var addId = $('#mytable').dataTable().fnAddData([
            nombre,
            alias,
            id,
            cedula,            
            perfil,
            "<div id='state"+id+"' style='height: 0px'> \n\
            <img class='delete' src='images/enable.png'/>\n\
            </div>\n\
            <div id='otrootro"+id+"' style='height: 4px'>\n\
            (<a id='dell"+idcode+"' \n\
            callback='"+nombre+"'\n\
            tar='index.php?controlador=ManageUsers&accion=disableUser'\n\
            verify='"+idverify+"'\n\
            href='#'\n\
            onclick='confirmfunction($(this).attr(\'id\'))'\n\
            style='cursor: pointer; color: #005500; font-weight: bold;'>inactivar</a></div>)",
            fehaingreso,
            "<a class='various4"+id+"' title='Editar usuario' href='index.php?controlador=ManageUsers&accion=editUser&iduser="+id+"' style='width: 15px; margin-left: auto; margin-right: auto;'>"
                +"<img src='images/edit.png' width='22px' height='22px' title='ver detalles'/></a>",   
            "<a class='various2"+id+"' title='Cambiar perfil' href='index.php?controlador=ManageUsers&accion=editProfile&iduser="+id+"' style='width: 15px; margin-left: auto; margin-right: auto;'>\n\
                <img src='images/user_group.png' width='22px' height='22px' title='Cambiar perfil'/></a>"]);     
        var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
        theNode.setAttribute('id',id);            
        $(".various4"+id).fancybox({
            'width'                : 1100,
            'height'               : 450,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false
        }); 
        $(".various2"+id).fancybox({
            'width'                : 600,
            'height'               : 190,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false  
        }); 
    }
    
    function updatedata(id,nombre,cedula){
        $('#nombre'+id).html(nombre);
        $('#cedula'+id).html(cedula)    
    }

    function updatedata2(id,perfil){
        $('#perfil'+id).html(perfil);            
    }
    
    $(document).ready(function(){
        $(".various3").fancybox({
            'width'                : 1100,
            'height'               : 380,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false              
        });  
        $(".various2").fancybox({
           'width'                : 600,
            'height'               : 190,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false            
        }); 
         $(".various4").fancybox({
            'width'                : 1100,
            'height'               : 450,
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
                $('td:eq(7)', nRow).addClass('item2');
                $('td:eq(8)', nRow).addClass('item2');                
                $('td:eq(5)', nRow).css({'text-align':'center','width':'20px'});
                $('td:eq(7)', nRow).css({'text-align':'center','width':'20px'});
                $('td:eq(8)', nRow).css({'text-align':'center','width':'20px'});                
            },
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "Todos"]
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
            "oSearch": {"bSmart": false},
            "aaSorting": [[ 6, "desc" ]],             
            "aoColumns": [
                null,
                {"bSortable": false},
                null,
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false},
                {"sType": "format-date", "bSearchable": false },
                {"bSortable": false, "bSearchable": false },
                {"bSortable": false, "bSearchable": false }                               
            ]            
        }).columnFilter({
            aoColumns: [{type: "text"},
                {type: "text"},
                {type: "number"},               
                {type: "number"},
                {type: "select"},
                null,
                null,
                null]
        });
        $('#perfilfilter .filter_column .select_filter').change(function(){
            // oTable.fnFilter( "^\\s*" + $('#perfilfilter .filter_column .select_filter').val() + "\\s*$", 4, true);                          
            oTable.fnFilter( "^" + $('#perfilfilter .filter_column .select_filter').val().replace("%20", " ") + "$", 4, true); 
            $("#perfilfilter .filter_column .select_filter option[value='']").remove();
        }); 
       // $('#estadofilter .filter_column .select_filter').change(function(){                                     
         //   oTable.fnFilter( "^" + $('#estadofilter .filter_column .select_filter').val() + "$", 5, true);  
          //  $("#estadofilter .filter_column .select_filter option[value='']").remove();
        //});
        $(".callback").fancybox({      
            'autoDimensions'       : false,
            'width'                : 400,
            'height'               : 130, 
            'autoScale'            : false,
            'overlayOpacity'       : 0.1,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'fade',
            'speedIn'              :  500,                        
            'hideOnOverlayClick'   : false,
            'overlayColor'         : '#000',
            'showCloseButton'      : false,
            'padding'              : 0, 
            'margin'               : 0
        });
        $(".callback2").fancybox({      
            'autoDimensions'       : false,
            'width'                : 400,
            'height'               : 130, 
            'autoScale'            : false,
            'overlayOpacity'       : 0.1,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'fade',
            'speedIn'              :  500,                        
            'hideOnOverlayClick'   : false,
            'overlayColor'         : '#000',
            'showCloseButton'      : false,
            'padding'              : 0, 
            'margin'               : 0
        });
    });
</script>
