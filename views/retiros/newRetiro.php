<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Retiros: Nuevo retiro</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">    

    <fieldset class="colorleyend" style="width: available;float: left; min-height: 96px">
        <legend class="colorleyendinto">Detalles del retiro</legend>        
        <div style="margin-bottom: 15px;float: left;line-height: 15px; width: 180px">
            Seleccione tipo de retiro:
        </div>
        <div style="margin-bottom: 15px; margin-left: 15px; float: left">
            <select name="tiporetiro" id="tiporetiro">
                <option value="consumo">Consumo</option>
                <option value="perdida">Perdida</option>
                <option value="donaciones">Donaciones</option>
            </select>            
        </div>
        <div style="clear: both;"></div>
        <div style="display: none" id="nuevaopcion">
            <div style="margin-bottom: 15px;float: left;line-height: 15px; width: 180px">
                Seleccione tipo de perdida:
            </div>
            <div style="margin-bottom: 15px; margin-left: 15px; float: left">
                <select name="tipoperdida"  id="tipoperdida">
                    <option value="robo">Robo</option>
                    <option value="vencimiento">Vencimiento</option>
                    <option value="descomposicion">Descomposicion</option>
                    <option value="dano">Da&ntilde;o del empaque</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
            <div style="clear: both;"></div>
        </div>
    </fieldset>    
            <fieldset class="colorleyend" style="width: 162px;float: left">
        <legend class="colorleyendinto">Opciones</legend> 
        <div style="text-align: center">
            <div style="margin-left: auto; margin-right: auto">           
                <button style="height: 40px" class="buscarButton" id="accpet">Finalizar Retiro</button>         
            </div>       
            <div style="margin-left: auto; margin-right: auto">
                <a tar='index.php?controlador=Retiros&accion=Cancelretiro'
                   id="allcancel"
                   onclick='confirmfunction2($(this).attr("id"))'
                   href='#'>        
                    <button style="height: 40px" class="buscarButton" id="CancelAll">Cancelar Retiro</button>
                </a>
            </div>    
            <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                <img src="images/ajax-loader.gif"/> Procesando...
            </div>
        </div>
    </fieldset>      
    <div style="clear: both"></div>

    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Detalles del Retiro</legend>
        <div style="float: left;">
                    <img class="delete" src="images/delete.gif" />: Eliminar un detalle del retiro
                </div>                
                <div style="clear: both; margin-bottom: 15px"></div>
        <div id="cajaselect" style="margin-bottom: 15px">
            <a id="addProduct" style="color: #005500; font-weight: bold;" href="#">
                + Agregar detalle de retiro
            </a>
        </div>
        <div style="display: none" id="inputreferencia">
            <div style="float: left;line-height: 20px">
                Referencia del producto:
            </div>
            <div style="margin-left: 15px; float: left;">
                <input type="text" name="codigopro" id="codeprod" maxlength="15" size="30"/>                
            </div>
            <div style="margin-left: 2px;float: left; margin-top: 2px">
                <a id="search" href="index.php?controlador=Retiros&accion=getProducts" title="Buscar producto">
                    <img src="images/zoom.png" width="17" height="17"/>
                </a>
            </div>
            <div style="margin-left: 10px;float: left;">
                <button class="buscarButton" id="addToOut">Agregar</button>  
            </div>
            <div style="clear: both;"></div>
            
        </div>
        <form id="myform" action="index.php?controlador=Retiros&accion=createRetiro" method="post">
            <div style="margin-top: 15px;margin-bottom: 20px">  
                <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
                    <thead>
                        <tr class="headall">     
                            <th class="headinit" style="width: 130px">Referencia</th>                        
                            <th class="head">Nombre</th>
                            <th class="head" style="width: 77px">Cantidad en stock</th> 
                            <th class="head" style="width: 50px">Costo</th> 
                            <th class="head" style="width: 77px">Cantidad a Retirar</th>
                            <th class="head" style="width: 60px">Total a Retirar</th>
                            <th class="head" style="width: 60px">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estilo = 1;
                        if (sizeof($items)!=0) {
                            foreach ($items as $value) {
                                ?>
                                <tr class="class<?php echo $estilo; ?>" id="<?php echo $value['id']; ?>"> 
                                    <td class="init2">
                                        <?php echo $value["referencia"] ?>
                                    </td>  
                                    <td class="item2">
                                        <?php echo $value["nombre"] ?>
                                    </td>
                                    <td class="item2" id="cantstock<?php echo $value['id']; ?>">
                                        <?php echo $value["stock"] ?>                       
                                    </td>
                                    <td class="item2">
                                        <?php echo number_format($value["costo"], 2, ",", ".") ?>                       
                                    </td>
                                    <td class="item2" style="text-align: center" >
                                        <?php if ($value["unidad"] == 'und') { ?> 
                                            <input name="cantidad"
                                                   label="cantidad" 
                                                   patt="val2"
                                                   type="text"
                                                   minsize="1" 
                                                   id="cantretirar<?php echo $value['id']; ?>" 
                                                   size="7"
                                                   maxlength="5" 
                                                   class="evento"
                                                   value="<?php echo $value["cantidadRetirar"] ? $value["cantidadRetirar"] : null ?>"
                                                   presence="val1"
                                                   onkeypress="return validar(event)"/>
                                               <?php } else { ?> 
                                            <input name="cantidad"
                                                   label="cantidad" 
                                                   patt="val6"
                                                   type="text"
                                                   minsize="1" 
                                                   id="cantretirar<?php echo $value['id']; ?>" 
                                                   size="7"
                                                   maxlength="6" 
                                                   class="evento"
                                                   value="<?php echo $value["cantidadRetirar"] ? $value["cantidadRetirar"] : null ?>"
                                                   presence="val1"/>
                                               <?php } ?> 
                                    </td>
                                    <td class="item2" id="total<?php echo $value['id']; ?>" style="font-weight: bold;">
                                        <?php echo $value["cantidadRetirar"] ? number_format(($value["cantidadRetirar"] * $value["costo"]), 2, ",", ".") : 0.0 ?>                       
                                    </td>                                
                                    <td class="item2" style="text-align: center">                                    
                                        <a id="dell<?php echo sha1($value['id']); ?>" 
                                           callback="<?php echo $value['nombre']; ?>" 
                                           tar="index.php?controlador=Retiros&accion=deleteItem" 
                                           verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                           href="#"
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
        </form>                        
    </fieldset>
</div> 
</div>
</div>
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el item <strong id="nombrecalldel"></strong> del retiro actual?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
        </div>
    </div>
</div>        
<div style="display: none">
    <div id="contentcall2">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de cancelar el retiro actual?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
    <a href="#contentcall2" class="callback2">Open Example</a>
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>     
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
                        oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));
                        if($('#mytable >tbody >tr').length==1&&$('#mytable >tbody >tr >td').attr("class")=="dataTables_empty"){ 
                            $("#accpet").attr("disabled", "disabled");
                            $("#accpet").removeClass("buscarButton");
                            $("#accpet").addClass("buscarButtonDis");    
                            $("#CancelAll").attr("disabled", "disabled");
                            $("#CancelAll").removeClass("buscarButton");
                            $("#CancelAll").addClass("buscarButtonDis");
                        }
                        $.fancybox.close();
                        message("Se ha eliminado el item","images/iconos_alerta/ok.png");
                    }else{
                        $.fancybox.close();
                        message("No se pudo eliminar el item","images/iconos_alerta/error.png");
                    }
                }               
            });
        });
        $('#cancel').click(function(){
            $.fancybox.close();            
        });
    }
    
    function confirmfunction2(id) {        
       $('.callback2').trigger('click');
       $('#accept2').click(function() {
           $.ajax({
               type: "POST",
               url: $('#' + id).attr('tar'),
               dataType: "json",
               data: {},
               success: function(data) {
                   if (data.respuesta == 'ok') {
                       window.location = 'index.php?controlador=Retiros';
                   }
               }
           });
       });
       $('#cancel2').click(function() {
           $.fancybox.close();
       });
    }
    
    function createdata(id,nombre,referencia,stock,costo,total,idcode,idverify, unidad){  
        var inputcantid;
        if(unidad=="und"){
            inputcantid="<input name='cantidad' label='cantidad' patt='val2' minsize='1' objectid='"+id+"' id='cantretirar"+id+"' size='7' maxlength='5' class='evento"+id+"' presence='val1' onkeypress='return validar(event)'/>";
        }else{
            inputcantid="<input name='cantidad' label='cantidad' patt='val6' minsize='1' objectid='"+id+"' id='cantretirar"+id+"' size='7' maxlength='6' class='evento"+id+"' presence='val1'/>";
        } 
        var addId = $('#mytable').dataTable().fnAddData([
            referencia,
            nombre,
            stock,            
            costo,
            inputcantid,
            "0",
            "<a id='dell"+idcode+"' callback='"+nombre+"' tar='index.php?controlador=Retiros&accion=deleteItem' verify='"+idverify+"' href='#' onclick='confirmfunction($(this).attr(\"id\"))'> <img class='delete' src='images/delete.gif' title='Eliminar item'/> </a>"
        ]);     
        var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
        theNode.setAttribute('id',id);
        $("#accpet").removeAttr("disabled", "disabled");
        $('#accpet').attr('class') != 'buscarButton' ? $("#accpet").addClass("buscarButton") : null;
        $("#accpet").removeClass("buscarButtonDis");
        $("#CancelAll").removeAttr("disabled", "disabled");
        $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
        $("#CancelAll").removeClass("buscarButtonDis");
        $("input").unbind("focus");
        $("input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
        $(".evento"+id).keyup(function(){             
            var columnname=$(this).attr("id");
            var n=columnname.split("cantretirar");                 
            var cantidadmax = $.trim($("#cantstock"+n[1]).html());
            if(cantidadmax-$(this).val()<0){
                $(this).val(cantidadmax); 
            }
            $.ajax({
                type: "POST",                
                url: "index.php?controlador=Retiros&accion=updateItem",
                dataType: "json",
                data: {cant:$(this).val(),idpro:n[1]},
                success: function(data) {
                    $("#total"+n[1]).html(data.costo);
                }               
            });
        });        
    }
    
    $(document).ready(function(){
    
    <?php if (sizeof($items) == 0) { ?>
               $("#accpet").attr("disabled", "disabled");
               $("#accpet").removeClass("buscarButton");
               $("#accpet").addClass("buscarButtonDis");    
               $("#CancelAll").attr("disabled", "disabled");
               $("#CancelAll").removeClass("buscarButton");
               $("#CancelAll").addClass("buscarButtonDis");
        <?php }?>
        $(".evento").keyup(function(){             
            var columnname=$(this).attr("id");
            var n=columnname.split("cantretirar");                 
            var cantidadmax = $.trim($("#cantstock"+n[1]).html());
            if(cantidadmax-$(this).val()<0){
                $(this).val(cantidadmax); 
                message("Verifique el valor ingresado","images/iconos_alerta/error.png");
            }
            $.ajax({
                type: "POST",                
                url: "index.php?controlador=Retiros&accion=updateItem",
                dataType: "json",
                data: {cant:$(this).val(),idpro:n[1]},
                success: function(data) {
                    $("#total"+n[1]).html(data.costo);
                }               
            });
        });        
        $("#addToOut").click(function(){
            $("#addToOut").attr("disabled", "disabled");
            $('.error_input').remove();
            if($("#codeprod").val()){
                $.ajax({
                    type: "POST",                
                    url: "index.php?controlador=Retiros&accion=addNewItem",
                    dataType: "json",
                    data: {idpro:$("#codeprod").val()},
                    success: function(data) {
                        if(data.res=='si'){
                            $("#addToOut").removeAttr("disabled", "disabled");                        
                            $("#codeprod").val("");                            
                            createdata(data.pro.id, data.pro.nombre, data.pro.referencia, data.pro.stock, data.pro.costoformato, 0, data.pro.code, data.pro.verify,data.pro.unidad)
                            message("Se ha insertando un nuevo item a la orden de retiro","images/iconos_alerta/ok.png");
                        }else{
                            $("#addToOut").removeAttr("disabled", "disabled");
                            $("#codeprod").val("");  
                            $('#codeprod').css("Background-color","#F0CBBA");
                            $('#codeprod').after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;margin-top: 5px">'+data.mess+'</div>');                
                        }
                    }               
                });
            }else{
                $("#addToOut").removeAttr("disabled", "disabled");
                $('#codeprod').css("Background-color","#F0CBBA");
                $('#codeprod').after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;margin-top: 5px">Referencia requerida</div>');                
            }
        });
        $("#tiporetiro").change(function(){            
            if($("#tiporetiro").val()=="perdida"){
                $("#nuevaopcion").show();
            }else{
                $("#nuevaopcion").hide();
            }            
        });
        $("#addProduct").click(function(){
            if($("#inputreferencia").is (':visible')){
                $("#inputreferencia").slideUp(500);
            }else{
                $("#inputreferencia").slideDown(500);
            }
            
        });
        $("#search").fancybox({
            'width'                : '90%',
            'height'               : '100%',
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false    
        });    
        $(".callback").fancybox({      
            'autoDimensions'       : false,
            'width'                : 400,
            'height'               : 160, 
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
            'height'               : 160, 
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
                if($('td:eq(4) input', nRow).attr('objectid')){                    
                    $('td:eq(2)', nRow).attr('id','cantstock'+$('td:eq(4) input', nRow).attr('objectid'));
                    $('td:eq(5)', nRow).attr('id','total'+$('td:eq(4) input', nRow).attr('objectid'));
                    $('td:eq(5)', nRow).css('font-weight','bold');                    
                    $('td:eq(6)', nRow).css('text-align','center');
                    $('td:eq(4)', nRow).css('text-align','center');
                    $('td:eq(4) input', nRow).removeAttr('objectid')                    
                }
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
            "aoColumns": [
                null,
                null,
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }
            ]            
        } );    
        
        $("#accpet").click(function() {
        $('#myform').ajaxForm({
            dataType: 'json',            
            beforeSubmit: function(arr, $form, options) {
               $("#accpet").attr("disabled", "disabled");
               $("#accpet").removeClass("buscarButton");
               $("#accpet").addClass("buscarButtonDis");    
               $("#CancelAll").attr("disabled", "disabled");
               $("#CancelAll").removeClass("buscarButton");
               $("#CancelAll").addClass("buscarButtonDis");
                $('#loader').css('display', 'block'); 
                if($('#mytable >tbody >tr').length==1&&$('#mytable >tbody >tr >td').attr("class")=="dataTables_empty"){ 
                    message("no existen items en el retiro",'images/iconos_alerta/error.png');  
                    $('#loader').css('display', 'none');
                    $("#accpet").removeAttr("disabled", "disabled");
                    $("#accpet").removeClass("buscarButtonDis");
                    $("#accpet").addClass("buscarButton");    
                    $("#CancelAll").removeAttr("disabled", "disabled");
                    $("#CancelAll").removeClass("buscarButtonDis");
                    $("#CancelAll").addClass("buscarButton");
                    return false;                     
                }else{ 
                    if(validates('myform')){                
                        arr.push({name:'tiporetiro', value: $("#tiporetiro").val()});
                        arr.push({name:'tipoperdida', value: $("#nuevaopcion").is (':visible')?$("#tipoperdida").val():''});
                        return true;             
                    }else{                                        
                        $('#loader').css('display', 'none');
                        $("#accpet").removeAttr("disabled", "disabled");
                        $("#accpet").removeClass("buscarButtonDis");
                        $("#accpet").addClass("buscarButton");    
                        $("#CancelAll").removeAttr("disabled", "disabled");
                        $("#CancelAll").removeClass("buscarButtonDis");
                        $("#CancelAll").addClass("buscarButton");
                        return false;                    
                    }
                }
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {                
                if(responseText.res=='si'){
                    window.location="index.php?controlador=Retiros&messageok=ok";
                }                
            }
        }).submit();
        
         });
        $("input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });     
</script>
