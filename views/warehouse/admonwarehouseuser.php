<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 10px">        
    <fieldset class="colorleyend" style="width: 100%">        
        <legend class="colorleyendinto">Asignar usuario a bodega</legend>
        <form method="POST" action="index.php?controlador=Warehouse&accion=createPermission" id="miform2">
            <input type="hidden" name="idware" value="<?php echo $idbodega ?>"/>
            <table cellspacing="5" border="0" style="width: 100%;" align="center" >
                <tr>
                    <td width="25%">Seleccione el perfil</td>   
                    <td width="25%">Seleccione el usuario</td> 
                </tr>
                <tr>
                    <td width="25%">
                        <select name="perfiles" id="perfiles">
                           
                            <?php
                            if (sizeof($perfiles) != 0) {
                                foreach ($perfiles as $value) {
                                    ?>
                                    <option value="<?php echo $value['id'] ?>">
                                        <?php echo $value['nombre'] ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </td>   
                    <td width="25%">
                        <select name="usersbyperfil" id="usersbyperfil">
                            <?php
                            if (sizeof($perfilesUsers) != 0) {
                                foreach ($perfilesUsers as $value) {
                                    ?>
                                    <option value="<?php echo $value['id'] ?>" id="optionus<?php echo $value['id'] ?>">
                                        <?php echo $value['nombre'] ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </td>   
                    <td rowspan="2"><button class="buscarButton">Asignar bodega</button></td>
                </tr>         
            </table>
        </form>
    </fieldset>           
    <fieldset class="colorleyend" style="width: 100%">        
        <legend class="colorleyendinto">Usuarios de la bodega <?php echo $bodega["nombre"];?></legend>
        <div>
                    <img class="delete" src="images/delete.gif" />: Eliminar permisos de un usuario asociado a la bodega
        </div>
    <div style="margin-top: 15px;margin-bottom: 20px">          
        <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">  
            <thead>
                <tr class="headall">     
                    <th class="head" style="width: 450px;">Nombre</th>                        
                    <th class="head" style="width: 450px;">Perfil</th>
                    <th class="head" style="width: 20px;">Eliminar</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                if (sizeof($usuariobodega)) {
                foreach ($usuariobodega as $value) {
                    ?>
                    <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>"> 
                        <td class="init2"><?php echo $value["nombre"] ?></td>  
                            <td class="item2"><?php echo $value["perfil"] ?></td>
                            <td class="item2">
                            <a id="dell<?php echo sha1($value['id']); ?>" 
                               callback="<?php echo $value['nombre']; ?>"                                
                               verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                               href="#" 
                               tar="index.php?controlador=Warehouse&accion=deleteUserWarehouse&idware=<?php echo $idbodega ?>"
                               onclick="confirmfunction($(this).attr('id'))">
                                <img class="delete" src="images/delete.gif" title="Eliminar item"/>                       
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
        </table>                   
    </div>
   </fieldset>
</div>
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el permiso de bodega al usuario <strong id="nombrecalldel"></strong>?
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
    function confirmfunction(id){       
        $('#nombrecalldel').html($("#"+id).attr("callback"));                
        $('.callback').trigger('click');        
        $('#accept').click(function(){             
            $.ajax({
                type: "POST",
                url: $('#'+id).attr('tar'),
                dataType: "json",
                data: {verify: $("#"+id).attr("verify")},
                async:false, 
                success: function(data) {
                    if(data.res=='si'){                        
                        oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));
                        $.ajax({
                            type: "POST",                
                            dataType: "json",               
                            url: "index.php?controlador=Warehouse&accion=ajaxUsuarios",
                            data: {idperfil: $('#perfiles').val()},  
                            async: false,
                            success: function( response ){        
                                $('#usersbyperfil').html('');
                                if(response!=null){
                                    if(response.length!=0){
                                        for(var i = 0; i < response.length; i++){
                                            var option = $("<option>").attr({'value': response[i]['id'],
                                                'id': 'optionus'+response[i]['id']}).appendTo("#usersbyperfil");
                                            option.html(response[i]['nombre']);
                                        }    
                                    }
                                }
                            },
                            error: function( error ){
                                alert( error );
                            }
                        });
                        $.fancybox.close();                        
                        parent.message("Se ha eliminado el permiso del usuario","images/iconos_alerta/ok.png");                        
                    }else{
                        $.fancybox.close();
                        parent.message("No se pudo eliminar el permiso de este usuario","images/iconos_alerta/error.png");
                    }
                }               
            });                        
        });
        $('#cancel').click(function(){
            $.fancybox.close();            
        });
    }
    $(document).ready(function(){        
        $('#perfiles').val('<?php echo $perfiles[0]['id'] ?>')
        $('#perfiles').change(function(){            
            $.ajax({
                type: "POST",                
                dataType: "json",               
                url: "index.php?controlador=Warehouse&accion=ajaxUsuarios",
                data: {idperfil: $('#perfiles').val()},                
                success: function( response ) 
                {        
                    $('#usersbyperfil').html('');
                    if(response!=null){
                        if(response.length!=0){
                            for(var i = 0; i < response.length; i++){
                                var option = $("<option>").attr({'value': response[i]['id'],
                                    'id': 'optionus'+response[i]['id']}).appendTo("#usersbyperfil");
                                option.html(response[i]['nombre']);
                            }
                        } 
                    }
                },
                error: function( error ){
                    alert( error );
                }
            });
        });
        
        $('#miform2').ajaxForm({            
            dataType: 'json',            
            success: function(responseText) {                               
                if(responseText.respuesta=='si'){  
                    var addId = $('#mytable').dataTable().fnAddData([
                        responseText.newuser['nombre'],
                        responseText.newuser['perfil'],                        
                        '<a id="dell'+responseText.newuser['idid']+'" \n\
                        href="#"\n\
                        tar="index.php?controlador=Warehouse&accion=deleteUserWarehouse&idware='+responseText.idbodega+'"\n\
                        callback="'+responseText.newuser['nombre']+'"\n\
                        verify="'+responseText.newuser['idverify']+'" \n\
                        href="#" onclick="confirmfunction($(this).attr(\'id\'))">\n\
                        <img src="images/delete.gif" class="delete" title="Eliminar item"/></a>']);                     
                    var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
                    theNode.setAttribute('id',responseText.newuser['id']);                         
                    $('#optionus'+responseText.newuser['id']).remove();                                                
                    parent.message("Se ha agregado un usuario a la bodega","images/iconos_alerta/ok.png");                                                           
                }else{
                    parent.message("No se ha podido agregar un usuario a la bodega","images/iconos_alerta/ok.png");                                                           
                }
            } 
         });                   
                oTable=$('#mytable').dataTable( {
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {               
                        $(nRow).addClass("class1");
                        $('td:eq(0)', nRow).addClass('init2');
                        $('td:eq(1)', nRow).addClass('item2');
                        $('td:eq(2)', nRow).addClass('item2');                                                     
                    },
                    "aLengthMenu": [
                        [5, 10, 20, -1],
                        [5, 10, 20, "Todos"]
                    ],
                    "iDisplayLength": 5,            
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
                    "aaSorting": [[ 0, "asc" ]],
                    "aoColumns": [null,
                        null,
                        { "bSortable": false, "bSearchable": false }
                    ]            
                }); 
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
            });
</script>
