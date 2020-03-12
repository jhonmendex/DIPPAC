<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>

<div id="main"> 
    <div class="maxcontent" id="content">
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50">
         <table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap">
            <tbody>
             <tr>
               <td id="fancybox-title-float-main">Mi orden de pedido</td>
             </tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">                                                   
        <fieldset class="colorleyend" style="width: 450px;float: left; min-height: 96px" >
            <legend class="colorleyendinto">Informaci&oacute;n de usuario</legend>  
            <div>
                <table style="width: 100%">                       
                    <tr style="height: 18px">
                        <td>Nombre:</td>
                        <td style="text-align: right;font-size: 20px">                              
                                <?php echo $usuario["nombre"] ?>                           
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Cedula:</td>
                        <td style="text-align: right;font-size: 16px">                              
                                <?php echo number_format($usuario["cedula"],"0",",",".") ?>                           
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>E-mail:</td>
                        <td style="text-align: right;font-size: 16px">                              
                                <?php echo $usuario["email"] ?>                           
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Puntos acumulados en <strong><?php echo $usuario["periodo"] ?></strong>:</td>
                        <td style="text-align: right;font-size: 16px">                              
                                <?php echo $usuario["puntos"]?number_format($usuario["puntos"], "2",",","."):"0,0" ?>                           
                        </td> 
                    </tr>
                </table>   
            </div>
        </fieldset>
            
        <fieldset class="colorleyend" style="width: 239px;float: left">
            <legend class="colorleyendinto">Resumen orden</legend> 
            <div>
                <table>                       
                    <tr style="height: 18px">
                        <td>Subtotal:</td>
                        <td style="text-align: right;">  
                            <strong style="font-size: 16px" id="subtotalcliente">
                                $ <?php echo number_format($totales["subtotal"],0,",",".") ?>
                            </strong>
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Iva:</td>
                        <td style="text-align: right;">  
                            <strong style="font-size: 16px" id="ivacliente">
                                $ <?php echo number_format($totales["iva"],0,",",".") ?>
                            </strong>
                        </td>
                    </tr>
                    <tr style="height: 18px">
                        <td>Total:</td>
                        <td style="text-align: right;">
                            <strong style="font-size: 20px" id="totalcliente">
                                $ <?php echo number_format($totales["total"],0,",",".") ?>
                            </strong>
                        </td>
                    </tr>
                    <tr style="height: 18px">
                        <td>Total Puntos:</td>
                        <td style="text-align: right;">
                            <strong style="color: #083698;font-size: 20px" id="totalpuntoscliente">
                                <?php echo number_format($totales["puntos"],2,",",".") ?>
                            </strong>
                        </td>
                    </tr>
                </table>   
            </div>
        </fieldset> 
        <fieldset class="colorleyend" style="width: 162px;float: left">
            <legend class="colorleyendinto">Opciones</legend> 
            <div style="text-align: center">
                <?php
                        if (sizeof($detalles) != 0) {?>
                <div style="margin-left: auto; margin-right: auto">  
                    <a tar='index.php?controlador=Shopping&accion=confirmorden'
                       id="allconfirm"
                       onclick='confirmfunction3($(this).attr("id"))'
                       href='#'>    
                        <button style="height: 30px" class="buscarButton" id="FinishAll">Finalizar Compra</button>      
                    </a>
                </div>       
                <div style="margin-left: auto; margin-right: auto">
                    <a tar='index.php?controlador=Shopping&accion=cancelShop'
                       id="allcancel"
                       onclick='confirmfunction2($(this).attr("id"))'
                       href='#'>        
                        <button style="height: 30px" class="buscarButton" id="CancelAll">Cancelar Compra</button>
                    </a>
                </div>  
                <?php }else{ ?>
                <div style="margin-left: auto; margin-right: auto">  
                    <a tar='index.php?controlador=Shopping&accion=confirmorden'
                       id="allconfirm"
                       onclick='confirmfunction3($(this).attr("id"))'
                       href='#'>    
                        <button style="height: 30px" class="buscarButtonDis" disabled="disabled" id="FinishAll">Finalizar Compra</button>      
                    </a>
                </div>       
                <div style="margin-left: auto; margin-right: auto">
                    <a tar='index.php?controlador=Shopping&accion=cancelShop'
                       id="allcancel"
                       onclick='confirmfunction2($(this).attr("id"))'
                       href='#'>        
                        <button style="height: 30px" class="buscarButtonDis" disabled="disabled"  id="CancelAll">Cancelar Compra</button>
                    </a>
                </div>
                <?php } ?>
                <div style="margin-left: auto; margin-right: auto">
                    <a href='index.php?controlador=Shopping'>        
                        <button style="height: 30px" class="buscarButton" id="BackToCart">Volver al catalogo</button>
                    </a>
                </div> 
                <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                    <img src="images/ajax-loader.gif"/> Procesando...
                </div>
            </div>
        </fieldset>      
        <div style="clear: both"></div>
    
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Detalles de mi orden de compra</legend>
         <div style="margin-top: 15px;margin-bottom: 20px">  
        <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">
            <thead>
                        <tr class="headall">     
                            <th class="headinit" style="cursor: pointer; width: 140px">Referencia</th>                        
                            <th class="head" style="cursor: pointer">Nombre producto</th>
                            <th class="head" style="width: 105px">Cantidad</th>                             
                            <th class="head">Puntos</th>
                            <th class="head" style="width: 105px;">Total puntos</th> 
                            <th class="head" style="width: 130px">Precio unitario <br>(Iva incluido)</th>
                            <th class="head" style="min-width: 80px">Precio Total</th>                             
                            <th class="head" style="width: 20px">Eliminar</th>  
                        </tr>       
                    </thead> 
                    <tbody>
                       <?php
                        if (sizeof($detalles) != 0) {
                            $estilo = 1;
                            foreach ($detalles as $key => $value) {
                                ?>
                                <tr class="class<?php echo $estilo; ?>" id="pro<?php echo $key ?>"> 
                                    <td class="init2" style="width: 140px;">
                                        <?php echo $value["referencia"] ?> 
                                    </td>  
                                    <td class="item2" style="width: 350px;">
                                        <?php echo $value["nombre"] ?> 
                                    </td>  
                                    <td class="item2" style="width: 105px">                                       
                                        <input class="cantidad"
                                           name="cantidad" 
                                           value="<?php echo $value["cantidad"]?>" 
                                           size="8" 
                                           style="width: 45px;" 
                                           maxlength="6" 
                                           id="<?php echo $key?>pro"
                                           onkeydown="return validar(event, '<?php echo $value["unidad"]?>')" 
                                           onkeyup="actualizar('<?php echo $key?>',$(this).attr('id'), '<?php echo $value["unidad"]?>')"/>
                                    </td>                
                                    <td class="item2" style="width: 150px !important">
                                       <?php echo number_format($value["puntos"],2,",",".")  ?> 
                                    </td> 
                                    <td class="item2" style="width: 20px;" id="puntos<?php echo $key ?>">
                                        <?php echo number_format($value["puntos"]*$value["cantidad"],2,",",".")  ?> 
                                    </td> 
                                    <td class="item2" style="width: 20px;">
                                        <?php echo number_format($value["precioiva"],0,",",".") ?> 
                                    </td> 
                                    <td class="item2" style="width: 105px;" id="item<?php echo $key ?>">
                                       <?php echo number_format($value["precioiva"]*$value["cantidad"],0,",",".") ?> 
                                    </td>                
                                    <td class="item2" style="width: 20px;">
                                       <a id='dell<?php echo $value['dell'] ?>' 
                                           callback='<?php echo $value['nombre'] ?>' 
                                           tar='index.php?controlador=Shopping&accion=deleteItemShop' 
                                           href='#' 
                                           verify='<?php echo $value['verify'] ?>'
                                           onclick='confirmfunction($(this).attr("id"))'>
                                            <img src='images/delete.gif' class='delete' title="Eliminar item"/>
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
            <?php foreach ($detail as $detalle) { ?>

                <?php
                if ($estilo == 1) {
                    $estilo = 2;
                } else {
                    $estilo = 1;
                }
            }
            ?>

        </table> 
             </div>
      </fieldset>     
</div>
</div>
</div>
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el item <strong id="nombrecalldel"></strong> de la orden de pedido?
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
            Esta seguro de cancelar la orden de pedido actual?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <div id="contentcall3">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de finalizar la venta de la orden de pedido actual?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept3">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel3">CANCELAR</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
    <a href="#contentcall2" class="callback2">Open Example</a>
    <a href="#contentcall3" class="callback3">Open Example</a>
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
                           $("#ivacliente").html(data.iva);
                           $("#totalcliente").html(data.total);
                           $("#totalpuntoscliente").html(data.totalpuntos);
                           $("#subtotalcliente").html(data.subtotal);
                           oTable.fnDeleteRow(oTable.fnGetPosition($('#pro' + data.idrow).get(0)));
                           $.fancybox.close();
                           message("Se ha eliminado el item de la orden de compra", "images/iconos_alerta/ok.png");
                           if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                               $("#FinishAll").attr("disabled", "disabled");
                               $("#FinishAll").removeClass("buscarButton");
                               $("#FinishAll").addClass("buscarButtonDis");  
                               $("#CancelAll").attr("disabled", "disabled");
                               $("#CancelAll").removeClass("buscarButton");
                               $("#CancelAll").addClass("buscarButtonDis"); 
                           }
                       } else {
                           $.fancybox.close();
                           message("No se pudo eliminar el item de la orden de pedido", "images/iconos_alerta/error.png");
                       }
                   }
               });
           });
           $('#cancel').click(function() {
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
                           window.location = 'index.php?controlador=Shopping';
                       }
                   }
               });
           });
           $('#cancel2').click(function() {
               $.fancybox.close();
           });
       }
       
    function confirmfunction3(id){
        $('.callback3').trigger('click');
        $('#accept3').click(function() {
            $.ajax({
                type: "POST",
                url: $('#' + id).attr('tar'),
                dataType: "json",
                data: {},
                success: function(data) {
                    if (data.respuesta == 'si') {
                        window.location = 'index.php?controlador=Shopping&accion=shopSell';
                    }else{
                        $.fancybox.close();
                        message("No puede continuar, por favor verifique las cantidades ingresadas.", "images/iconos_alerta/error.png"); 
                    }
                }
            });
        });
        $('#cancel3').click(function() {
            $.fancybox.close();
        });
    }
       
    function actualizar(idproducto, id,unidad){        
        $.ajax({
           type: "POST",
           beforeSend : function(xhr, opts){
               $('#' + id).after('<img src="images/ajax-loader.gif"/>');                    
               $(".cantidad").not('#' + id).attr("disabled", "disabled");
               $(".cantidad").not('#' + id).css("background-color", "#999");               
           },
           url: "index.php?controlador=Shopping&accion=updateOrden",
           dataType: "json",
           data: {cantidad: $('#' + id).val(),idpro: idproducto, unid:unidad},
           success: function(data) {
               $('#' + id).nextAll().remove();
               $(".cantidad").not('#' + id).removeAttr("disabled");
               $(".cantidad").not('#' + id).css("background-color", "#FFF"); 
               if(data.respuesta=="si"){
                 $('#' + id).css("background-color","#FFF");
                 $('#' + id).nextAll().remove();
                 $("#ivacliente").html(data.iva);
                 $("#totalcliente").html(data.total);
                 $("#totalpuntoscliente").html(data.totalpuntos);
                 $("#subtotalcliente").html(data.subtotal);
                 $("#puntos"+idproducto).html(data.puntos);
                 $("#item"+idproducto).html(data.item);
               }else{
                 $('#' + id).after('<div class="error_input" style="margin-top:8px !important;font-size: 12px; color: Red; font-weight: bold;">cantidad debe ser mayor a 0</div>');
                 $('#' + id).css("background-color","#F0CBBA"); 
                 $("#ivacliente").html(data.iva);
                 $("#totalcliente").html(data.total);
                 $("#totalpuntoscliente").html(data.totalpuntos);
                 $("#subtotalcliente").html(data.subtotal);
                 $("#puntos"+idproducto).html(data.puntos);
                 $("#item"+idproducto).html(data.item);
               }                
           }
       });
    }
    
    function validar(e,unidad) {
        if (e.keyCode == 86 && e.ctrlKey)
            return true;
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8)
            return true;
        if (tecla == 48)
            return true;
        if (tecla == 49)
            return true;
        if (tecla == 50)
            return true;
        if (tecla == 51)
            return true;
        if (tecla == 52)
            return true;
        if (tecla == 53)
            return true;
        if (tecla == 54)
            return true;
        if (tecla == 55)
            return true;
        if (tecla == 56)
            return true;
        if (tecla == 57)
            return true;
        if (tecla == 188 && unidad!='und')
            return true;   
        if (tecla == 190 && unidad!='und')
            return true; 
        patron = /1/; //ver nota
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }
    
    $(document).ready(function() {        
        $('img').css("border","0");
        $(".callback").fancybox({
           'autoDimensions': false,
           'width': 400,
           'height': 160,
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
        $(".callback2").fancybox({
           'autoDimensions': false,
           'width': 400,
           'height': 160,
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
       $(".callback3").fancybox({
           'autoDimensions': false,
           'width': 400,
           'height': 160,
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
        
        oTable = $('#mytable').dataTable({
               "fnCreatedRow": function(nRow, aData, iDataIndex) {
                   $(nRow).addClass("class1");
                   $('td:eq(0)', nRow).addClass('init2');
                   $('td:eq(1)', nRow).addClass('item2');
                   $('td:eq(2)', nRow).addClass('item2');
                   $('td:eq(3)', nRow).addClass('item2');
                   $('td:eq(4)', nRow).addClass('item2');
                   $('td:eq(5)', nRow).addClass('item2');
                   $('td:eq(6)', nRow).addClass('item2');
                   $('td:eq(7)', nRow).addClass('item2');                   
                   $('td:eq(7)', nRow).css('text-align','center');  
               },
               "aLengthMenu": [
                   [15, 25, 50, -1],
                   [15, 25, 50, "Todos"]
               ],
               "iDisplayLength": 15,
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
                   {"bSortable": false, "bSearchable": false},
                   {"bSortable": false, "bSearchable": false},
                   {"bSortable": false, "bSearchable": false},
                   {"bSortable": false, "bSearchable": false},
                   {"bSortable": false, "bSearchable": false}
               ]
       });
    });
</script>