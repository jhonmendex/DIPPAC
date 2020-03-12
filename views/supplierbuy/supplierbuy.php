<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content">
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Compra a proveedores: Crear documento de factura de compra</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">   
            <form method="POST" action="#" id="formWarehouse">
        <fieldset class="colorleyend" style="width: available;float: left; min-height: 96px" >
            <legend class="colorleyendinto">Detalles del documento</legend>  
            <div style="float: left">
                <table with="100%" >   
                    <tr style="height: 18px">
                        <td colspan="2"><b>Informacion del proveedor</b></td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>
                            <a style="cursor: pointer; color: #005500; font-weight: bold;" 
                               id="searchch" href="index.php?controlador=SupplierBuy&accion=getProvedoresList"
                               title="Buscar proveedores">
                                + Agregar Proveedor
                            </a>                            
                        </td>                        
                    </tr>                
                    <tr style="height: 18px">
                        <td><strong id="nombreprov"><?php echo $nomsup ?></strong></td>                        
                    </tr>
                    <tr style="height: 18px">
                        <td><strong id="nitprov"><?php echo $nit != "" ? "Nit. " . $nit : null ?></strong><input type="hidden" name="idprov" id="idprov" value="<?php echo $idsup ?>" label='Proveedor' presence='val1'/> </td>
                    
                    </tr>
                </table>
            </div>
            <div style="float: left; margin-left: 50px">
                <table>               
                    <tr style="height: 18px">
                        <td colspan="2"><b>Informacion de factura de compra</b></td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Factura N°: </td>
                        <td>
                            <?php
                            $view->input("numero_factura", "numeric", "Numero factura", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '15',
                                'maxlength' => '9',
                                "id" => "NoFactura",
                                "onkeyup" => "guardarFact($(this).attr(\"id\"))",
                                "value" => $nofact));
                            ?> 
                        </td>
                    </tr>
                    <tr style="height: 18px">
                        <td>Fecha: </td>
                        <td><?php
                            $factdatefor = $facturafechadate != null ? $facturafechadate : '';
                            $view->input("fact_date", "calendar", "Fecha de factura", array('required' => true), array('size' => '15',
                                'readonly' => 'readonly',
                                "id" => "factdate",
                                "value" => $factdatefor,
                                'onclick' => "beforeselectdateFact($(this).attr(\"id\"))",
                                'midate' => (int) date("Y") - 1,
                                'madate' => ((int) date("Y"))));
                            ?></td>
                    </tr>
                </table>   
            </div>
            <div style="float: left; margin-left: 20px">
                <table>   
                    <tr style="height: 18px">
                        <td></td>
                        <td>                        
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Subtotal:</td>
                        <td style="text-align: right;">  
                            <strong style="color: #369808;font-size: 16px" id="subtotalprovedor">
                                $ <?php echo $subtotalfactcom ?>
                            </strong>
                        </td> 
                    </tr>
                    <tr style="height: 18px">
                        <td>Iva:</td>
                        <td style="text-align: right;">  
                            <strong style="color: #369808;font-size: 16px" id="ivaprovedor">
                                $ <?php echo $ivafactcom ?>
                            </strong>
                        </td>
                    </tr>
                    <tr style="height: 18px">
                        <td>Total:</td>
                        <td style="text-align: right;">
                            <strong style="color: #369808;font-size: 20px" id="totalprovedor">
                                $ <?php echo $totalllcom ?>
                            </strong>
                        </td>
                    </tr>
                </table>   
            </div>
            <div style="clear: both"></div>
        </fieldset>
    </form>
    <fieldset class="colorleyend" style="width: 162px;float: left">
        <legend class="colorleyendinto">Opciones</legend> 
        <div style="text-align: center">
            <div style="margin-left: auto; margin-right: auto">           
                <button style="height: 40px" class="buscarButton" id="FinishAll">Finalizar Compra</button>         
            </div>       
            <div style="margin-left: auto; margin-right: auto">
                <a tar='index.php?controlador=SupplierBuy&accion=Cancelbuy'
                   id="allcancel"
                   onclick='confirmfunction2($(this).attr("id"))'
                   href='#'>        
                    <button style="height: 40px" class="buscarButton" id="CancelAll">Cancelar Compra</button>
                </a>
            </div>    
            <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                <img src="images/ajax-loader.gif"/> Procesando...
            </div>
        </div>
    </fieldset>      
    <div style="clear: both"></div>

    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Detalles del compra</legend>
        <div style="float: left;">
                    <img class="delete" src="images/delete.gif" />: Eliminar un detalle de la compra
                </div>                
                <div style="clear: both; margin-bottom: 15px"></div>
        <div id="cajaselect" style="margin-bottom: 15px">
            <a id="addProduct" style="color: #005500; font-weight: bold;" href="#">
                + Agregar detalle de compra
            </a>
        </div>
        <div style="display: none" id="inputreferencia">
            <form id="formrefe" method="POST" action="#">
                <div style="float: left;line-height: 20px">
                    Referencia del producto:
                </div>            
                <div style="margin-left: 15px; float: left;">
                    <input type="text" name="codigopro" id="codeprod" 
                           maxlength="13" 
                           size="30" 
                           minsize="1"
                           patt="val2"
                           presence="val1"
                           label="referencia del producto"
                           onkeypress="return validar(event)"/>                
                </div>
            </form>
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
        <form method="POST" action="index.php?controlador=SupplierBuy&accion=finishbuy" id="formproductos">
            <div style="margin-top: 15px;margin-bottom: 20px">  
                <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
                    <thead>
                        <tr class="headall">     
                            <th class="headinit" style="cursor: pointer; width: 140px">Referencia</th>                        
                            <th class="head" style="cursor: pointer">Nombre producto</th>
                            <th class="head" style="width: 105px">Cantidad</th> 
                            <th class="head" style="width: 130px">Costo</th>
                            <th class="head">Costo+IVA</th>
                            <th class="head" style="min-width: 80px">Total</th> 
                            <th class="head" style="width: 105px;">Fecha vencimiento</th> 
                            <th class="head" style="width: 20px">Eliminar</th>  
                        </tr>       
                    </thead> 
                    <tbody>
                        <?php
                        if (sizeof($compras) != 0) {
                            $estilo = 1;
                            foreach ($compras as $value) {
                                ?>
                                <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>"> 
                                    <td class="init2" style="width: 140px;">
                                        <?php echo $value["referencia"] ?>
                                    </td>  
                                    <td class="item2" style="width: 350px;">
                                        <?php echo $value["nombre"] ?>
                                    </td>  
                                    <td class="item2" style="width: 105px">
                                        <?php
                                        if ($value['unidad'] == 'und') {
                                            $view->input("cantidad", "numeric", "cantidad",
                                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                                    array('maxlength' => '4',
                                                "size" => "8",
                                                "id" => "cantidad" . $value['id'],
                                                "item" => $value['id'],
                                                "onkeyup" => "actualizarTotal($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))",
                                                "value" => $value['cantidad']));
                                        } else {
                                            $view->input("cantidad", "text", "cantidad", 
                                                    array('required' => true, 'text' => 'decimal', 'minsize' => '1'),
                                                    array('maxlength' => '7',
                                                "size" => "8",
                                                "id" => "cantidad" . $value['id'],
                                                "item" => $value['id'],
                                                "onkeyup" => "actualizarTotal($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))",
                                                "value" => $value['cantidad']));
                                        }
                                        ?> <?php echo ucfirst($value['unidad']) ?>s.  
                                    </td>                
                                    <td class="item2" style="width: 150px !important">
                                        <?php
                                        $view->input("costo", "text", "costo", array('required' => true, 'text' => 'decimal', 'minsize' => '2'), 
                                                array('maxlength' => '9',
                                            "size" => "10",
                                            "id" => "costo" . $value['id'],
                                            'item' => $value['id'],
                                            "onkeyup" => "actualizarTotal2($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))",
                                            "value" => $value['costo']));
                                        ?> / <?php echo ucfirst($value['unidad']) ?>.
                                    </td> 
                                    <td class="item2" style="width: 20px;">
                                        <div id="costoiva<?php echo $value['id'] ?>" style="font-weight: bold"> 
                                            <?php if ($value['costoiva']) { ?>
                                                $ <?php echo number_format($value['costoiva'], 0, ',', '.'); ?>
                                            <?php } ?>
                                        </div>
                                    </td> 
                                    <td class="item2" style="width: 20px;">
                                        <div id="total<?php echo $value['id'] ?>" style="font-weight: bold"> 
                                            <?php if ($value['costoiva']) { ?>
                                                $ <?php echo number_format($value['cantidad'] * $value['costoiva'], 0, ',', '.'); ?>
                                            <?php } ?>
                                        </div>
                                    </td> 
                                    <td class="item2" style="width: 105px;">
                                        <div id="fecha<?php echo $value['id'] ?>" style="font-weight: bold" class="sumasuma"> 
                                            <?php
                                            $expiredatefor = $value['fechavence'] != null ? $value['fechavence'] : '';
                                            $view->input("expire_date", "calendar", 'Fecha de vencimiento',
                                                    //array('required' => true),
                                                    array(), 
                                                    array('readonly' => 'readonly',
                                                'size' => '12',
                                                //'onblur' => "saveexpire($(this).attr(\"id\"),$(this).attr(\"item\"))",                                                                                       
                                                'onclick' => "beforeselectdate($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                                "id" => "expiredate" . $value['id'],
                                                'item' => $value['id'],
                                                'value' => $expiredatefor,
                                                'midate' => (int) date("Y"),
                                                'madate' => ((int) date("Y")) + 8));
                                            ?>                    
                                        </div>
                                    </td>                
                                    <td class="item2" style="width: 20px;">
                                        <a id='dell<?php echo $value['dell'] ?>' 
                                           callback='<?php echo $value['nombre'] ?>' 
                                           tar='index.php?controlador=SupplierBuy&accion=deleteItemShop' 
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
                </table>              
            </div>            
        </form>
    </fieldset>     
</div> 
</div>
</div> 

<div style="display: none">
    <a href="index.php?controlador=SupplierBuy&accion=createSupplier" class="various3" id="createProveedor5" title="Crear proveedor">Create</a>
    <a href="index.php?controlador=SupplierBuy&accion=createProduct" class="various5" id="createDetail5" title="Crear producto">Create2</a>
</div>

<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el item <strong id="nombrecalldel"></strong> de la factura de compra?
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
            Esta seguro de cancelar la factura de compra actual?
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
                       var controldelava = false;
                       var controldelava2 = false;
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
                                           //$('#'+data.idrow).remove();
                                           $('#totalprovedor').html('$ ' + data.respuesta3);
                                           $('#ivaprovedor').html('$ ' + data.respuesta5);
                                           $('#subtotalprovedor').html('$ ' + data.respuesta4);
                                           oTable.fnDeleteRow(oTable.fnGetPosition($('#' + data.idrow).get(0)));
                                           $.fancybox.close();
                                           message("Se ha eliminado el item de la factura", "images/iconos_alerta/ok.png");
                                           if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                                               $("#FinishAll").attr("disabled", "disabled");
                                               $("#FinishAll").removeClass("buscarButton");
                                               $("#FinishAll").addClass("buscarButtonDis");
                                               if ($('#idprov').val() == "" && $("#factdate").val() == "" && $("#NoFactura").val() == "") {
                                                   $("#CancelAll").attr("disabled", "disabled");
                                                   $("#CancelAll").removeClass("buscarButton");
                                                   $('#CancelAll').attr('class') != 'buscarButtonDis' ? $("#CancelAll").addClass("buscarButtonDis") : null;
                                               }
                                           }
                                       } else {
                                           $.fancybox.close();
                                           message("No se pudo eliminar el item de la factura", "images/iconos_alerta/error.png");
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
                                           window.location = 'index.php?controlador=SupplierBuy';
                                       }
                                   }
                               });
                           });
                           $('#cancel2').click(function() {
                               $.fancybox.close();
                           });
                       }
                       function actualizarTotal2(id, item) {
                           if ($('#' + id).val() == '' || $('#cantidad' + item).val() == '' || $('#cantidad' + item).val() == 0 || $('#' + id).val() == 0) {
                               $.ajax({
                                   type: "POST",
                                   url: "index.php?controlador=SupplierBuy&accion=ajaxtotal",
                                   dataType: "json",
                                   data: {cantidad: $('#cantidad' + item).val() == '' || $('#cantidad' + item).val() == 0 ? 0 : $('#cantidad' + item).val(),
                                       costo: $('#' + id).val() == '' || $('#' + id).val() == 0 ? 0 : $('#' + id).val(), idpro: item},
                                   success: function(data) {
                                       $('#total' + item).html('$ ' + data.respuesta);
                                       $('#costoiva' + item).html('$ ' + data.respuesta2);
                                       $('#totalprovedor').html('$ ' + data.respuesta3);
                                       $('#ivaprovedor').html('$ ' + data.respuesta5);
                                       $('#subtotalprovedor').html('$ ' + data.respuesta4);
                                   }
                               });
                           } else {
                               //if((patt($('#'+id).val(),'val6','costo',2)=='ok')&&(patt($('#cantidad'+item).val(),'val6','cantidad',1)=='ok')){
                               $.ajax({
                                   type: "POST",
                                   url: "index.php?controlador=SupplierBuy&accion=ajaxtotal",
                                   dataType: "json",
                                   data: {cantidad: $('#cantidad' + item).val(), costo: $('#' + id).val(), idpro: item},
                                   success: function(data) {
                                       $('#total' + item).html('$ ' + data.respuesta);
                                       $('#costoiva' + item).html('$ ' + data.respuesta2);
                                       $('#totalprovedor').html('$ ' + data.respuesta3);
                                       $('#ivaprovedor').html('$ ' + data.respuesta5);
                                       $('#subtotalprovedor').html('$ ' + data.respuesta4);
                                   }
                               });
                               //}            
                           }
                       }

                       function actualizarTotal(id, item) {
                           if ($('#' + id).val() == '' || $('#costo' + item).val() == '' || $('#costo' + item).val() == 0 || $('#' + id).val() == 0) {
                               $.ajax({
                                   type: "POST",
                                   url: "index.php?controlador=SupplierBuy&accion=ajaxtotal",
                                   dataType: "json",
                                   data: {cantidad: $('#' + id).val() == '' || $('#' + id).val() == 0 ? 0 : $('#' + id).val(),
                                       costo: $('#costo' + item).val() == '' || $('#costo' + item).val() == 0 ? 0 : $('#' + id).val(),
                                       idpro: item},
                                   success: function(data) {
                                       $('#total' + item).html('$ ' + data.respuesta);
                                       $('#costoiva' + item).html('$ ' + data.respuesta2);
                                       $('#totalprovedor').html('$ ' + data.respuesta3);
                                       $('#ivaprovedor').html('$ ' + data.respuesta5);
                                       $('#subtotalprovedor').html('$ ' + data.respuesta4);
                                   }
                               });
                           } else {
                               //if((patt($('#costo'+item).val(),'val6','costo',2)=='ok')&&(patt($('#'+id).val(),'val6','cantidad',1)=='ok')){
                               $.ajax({
                                   type: "POST",
                                   url: "index.php?controlador=SupplierBuy&accion=ajaxtotal",
                                   dataType: "json",
                                   data: {cantidad: $('#' + id).val(), costo: $('#costo' + item).val(), idpro: item},
                                   success: function(data) {
                                       $('#total' + item).html('$ ' + data.respuesta);
                                       $('#costoiva' + item).html('$ ' + data.respuesta2);
                                       $('#totalprovedor').html('$ ' + data.respuesta3);
                                       $('#ivaprovedor').html('$ ' + data.respuesta5);
                                       $('#subtotalprovedor').html('$ ' + data.respuesta4);
                                   }
                               });
                               // } 
                           }
                       }

                       function saveexpire2(id, item) {
                           $.ajax({
                               type: "POST",
                               url: "index.php?controlador=SupplierBuy&accion=ajaxFecha",
                               dataType: "json",
                               data: {fecha: $('#' + id).val(), idpro: item},
                               async: false,
                               success: function(data) {
                                   if (data.respuesta == 'no') {
                                       $('.error_input').remove();
                                       $('#' + id).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">La fecha debe ser mayor al dia de hoy</div>');
                                       $('#' + id).val('');
                                   } else if (data.respuesta == 'si') {
                                       $('.error_input').remove();
                                   }
                                   clearTimeout();
                                   controldelava = false;
                                   $('.date').unbind('click');
                               }
                           });
                       }

                       function saveexpireFact2(id) {
                           $.ajax({
                               type: "POST",
                               url: "index.php?controlador=SupplierBuy&accion=ajaxFechaFact",
                               dataType: "json",
                               data: {fecha: $('#' + id).val()},
                               async: false,
                               success: function(data) {
                                   if (data.respuesta == 'no') {
                                       $('.error_input').remove();
                                       $('#' + id).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold; width: 171px; line-height: normal;">La fecha no debe ser mayor al dia de hoy</div>');
                                       $('#' + id).val('');

                                       if ($('#idprov').val() == "" && $("#NoFactura").val() == "") {
                                           if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                                               $("#CancelAll").attr("disabled", "disabled");
                                               $("#CancelAll").removeClass("buscarButton");
                                               $('#CancelAll').attr('class') != 'buscarButtonDis' ? $("#CancelAll").addClass("buscarButtonDis") : null;
                                           }
                                       }
                                   } else if (data.respuesta == 'nono') {
                                       $('.error_input').remove();
                                       $('#' + id).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold; width: 171px; line-height: normal;">La fecha debe ser maximo un a&ntilde;o menor al dia de hoy</div>');
                                       $('#' + id).val('');

                                       if ($('#idprov').val() == "" && $("#NoFactura").val() == "") {
                                           if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                                               $("#CancelAll").attr("disabled", "disabled");
                                               $("#CancelAll").removeClass("buscarButton");
                                               $('#CancelAll').attr('class') != 'buscarButtonDis' ? $("#CancelAll").addClass("buscarButtonDis") : null;
                                           }
                                       }
                                   } else if (data.respuesta == 'si') {
                                       $('.error_input').remove();
                                       $("#CancelAll").removeAttr("disabled", "disabled");
                                       $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
                                       $("#CancelAll").removeClass("buscarButtonDis");
                                   }
                                   clearTimeout();
                                   controldelava2 = false;
                                   $('.date').unbind('click');
                               }
                           });
                       }

                       function beforeselectdate2(id, item) {
                           $('.date').click(function() {
                               if (!controldelava) {
                                   controldelava = true;
                                   saveexpire2(id, item);
                               }
                           });
                           $("select[name=month]").change(function() {
                               $('.date').click(function() {
                                   if (!controldelava) {
                                       controldelava = true;
                                       saveexpire2(id, item);
                                   }
                               });
                           });
                           $("select[name=year]").change(function() {
                               $('.date').click(function() {
                                   if (!controldelava) {
                                       controldelava = true;
                                       saveexpire2(id, item);
                                   }
                               });
                           });
                       }

                       function beforeselectdateFact2(id) {
                           $('.date').click(function() {
                               if (!controldelava2) {
                                   controldelava2 = true;
                                   saveexpireFact2(id);
                               }
                           });
                           $("select[name=month]").change(function() {
                               $('.date').click(function() {
                                   if (!controldelava2) {
                                       controldelava2 = true;
                                       saveexpireFact2(id);
                                   }
                               });
                           });
                           $("select[name=year]").change(function() {
                               $('.date').click(function() {
                                   if (!controldelava2) {
                                       controldelava2 = true;
                                       saveexpireFact2(id);
                                   }
                               });
                           });
                       }

                       function beforeselectdate(id, item) {                       
                           setTimeout("beforeselectdate2('" + id + "','" + item + "')", 400);
                           $("input").not(".onepic").not(".onepic"+item).click(function(){
                                $(".close").click();
                           });                             
                       }

                       function beforeselectdateFact(id) {
                           setTimeout("beforeselectdateFact2('" + id + "')", 400);
                           $("input").not(".onepic").click(function(){
                                 $(".close").click();
                           });                            
                       }

                       function guardarFact(id) {
                           if ($('#' + id).val() != '') {
                               $.ajax({
                                   type: "POST",
                                   url: "index.php?controlador=SupplierBuy&accion=ajaxsessFactura",
                                   dataType: "json",
                                   async: true,
                                   data: {NumeroFact: $('#' + id).val()},
                                   success: function(data) {
                                       $("#CancelAll").removeAttr("disabled", "disabled");
                                       $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
                                       $("#CancelAll").removeClass("buscarButtonDis");
                                   }
                               });
                           } else {
                               if ($('#idprov').val() == "" && $("#factdate").val() == "") {
                                   if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                                       $("#CancelAll").attr("disabled", "disabled");
                                       $("#CancelAll").removeClass("buscarButton");
                                       $('#CancelAll').attr('class') != 'buscarButtonDis' ? $("#CancelAll").addClass("buscarButtonDis") : null;
                                   }
                               }
                           }
                       }

                       function actualizarproveedor(nombre, nit, id) {
                           $('#nombreprov').html(nombre);
                           $('#idprov').val(id);
                           $('#nitprov').html(nit);
                           $("#CancelAll").removeAttr("disabled", "disabled");
                           $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
                           $("#CancelAll").removeClass("buscarButtonDis");
                       }

                       function crearproveedor(nit) {
                           $('#createProveedor5').attr('href', 'index.php?controlador=SupplierBuy&accion=createSupplier&nit=' + nit);
                           $('#createProveedor5').trigger('click');
                       }
                       function crearproducto(referencia) {
                           $('#createDetail5').attr('href', 'index.php?controlador=SupplierBuy&accion=createProduct&ref=' + referencia);
                           $('#createDetail5').trigger('click');
                       }
                       function createdataDet(id, nombre, referencia, idcode, idverify, unidad) {
                           var tagcantidad;
                           if (unidad == 'und') {
                               tagcantidad = "<input type='text' name='cantidad' label='cantidad' onkeypress='return validar(event)' presence='val1' patt='val2' minsize='1' maxlength='3' size='8' id='cantidad" + id + "' reff='" + referencia + "' item='" + id + "' onkeyup='actualizarTotal($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))' value='' /> " + unidad.charAt(0).toUpperCase() + unidad.slice(1) + "s.";
                           } else {
                               tagcantidad = "<input type='text' name='cantidad' label='cantidad' presence='val1' patt='val6' minsize='1' maxlength='6' size='8' id='cantidad" + id + "' reff='" + referencia + "' item='" + id + "' onkeyup='actualizarTotal($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))' value='' /> " + unidad.charAt(0).toUpperCase() + unidad.slice(1) + "s.";
                           }
                           var addId = $('#mytable').dataTable().fnAddData([
                               referencia,
                               nombre,
                               tagcantidad,
                               "<input type='text' name='costo' label='costo' presence='val1' patt='val6' minsize='2' maxlength='9' size='10'  id='costo" + id + "' reff='" + referencia + "' item='" + id + "' onkeyup='actualizarTotal2($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))' value='' /> / " + unidad.charAt(0).toUpperCase() + unidad.slice(1) + ".",
                               "<div id='costoiva" + id + "' style='font-weight: bold'> </div>",
                               "<div id='total" + id + "' style='font-weight: bold'> </div>",
                               "<input type='text' \n\
                           class='onepic" + id + "' \n\
                           size='12' \n\
                           readonly='readonly'\n\
                           label='Fecha de vencimiento'\n\
                           name='expire_date'  \n\
                           onclick='beforeselectdate($(this).attr(\"id\"),$(this).attr(\"item\"))' \n\
                           id='expiredate" + id + "' \n\
                           item='" + id + "'>",
                               "<a id='dell" + idcode + "' callback='" + nombre + "' tar='index.php?controlador=SupplierBuy&accion=deleteItemShop' href='#' verify='" + idverify + "' onclick='confirmfunction($(this).attr(\"id\"))'><img src='images/delete.gif' class='delete'/></a>"]
                                   );
                           var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
                           theNode.setAttribute('id', id);
                           $('input.onepic' + id).simpleDatepicker({
                               startdate: <?php echo date("Y") ?>,
                               enddate: <?php echo date("Y") + 8 ?>,
                               x: 20,
                               y: 20
                           });
                           $("#formproductos input").unbind("focus");
                           $("#formproductos input").focus(function(){
                               $(this).css("background-color","#FFF");
                               $(this).nextAll().remove();
                           });
                           $("#FinishAll").removeAttr("disabled", "disabled");
                           $('#FinishAll').attr('class') != 'buscarButton' ? $("#FinishAll").addClass("buscarButton") : null;
                           $("#FinishAll").removeClass("buscarButtonDis");
                           $("#CancelAll").removeAttr("disabled", "disabled");
                           $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
                           $("#CancelAll").removeClass("buscarButtonDis");
                       }

                       $(document).ready(function() {

<?php if (sizeof($compras) == 0) { ?>
                               $("#FinishAll").attr("disabled", "disabled");
                               $("#FinishAll").removeClass("buscarButton");
                               $("#FinishAll").addClass("buscarButtonDis");
    <?php
    if ($nofact == "" && $idsup == "" && $facturafechadate == "") {
        ?>

                                   $("#CancelAll").attr("disabled", "disabled");
                                   $("#CancelAll").removeClass("buscarButton");
                                   $("#CancelAll").addClass("buscarButtonDis");
        <?php
    }
}
?>

                           $("#addToOut").click(function() {
                               $("#addToOut").attr("disabled", "disabled");
                               if (validates('formrefe')) {
                                   $.ajax({
                                       type: "POST",
                                       url: "index.php?controlador=SupplierBuy&accion=verifyExistProducto",
                                       dataType: "json",
                                       data: {ref_product: $.trim($('#codeprod').val())},
                                       success: function(data) {
                                           if (data.res == "new") {
                                               message(data.mess, 'images/iconos_alerta/error.png');
                                               crearproducto(data.refe);
                                           } else if (data.res == "rep") {
                                               message(data.mess, 'images/iconos_alerta/advertencia.png');
                                           } else if (data.res == "ok") {
                                               createdataDet(data.id, data.nombre, data.refe, data.idid, data.verify, data.unidad);
                                               $("#FinishAll").removeAttr("disabled", "disabled");
                                               $('#FinishAll').attr('class') != 'buscarButton' ? $("#FinishAll").addClass("buscarButton") : null;
                                               $("#FinishAll").removeClass("buscarButtonDis");
                                               $("#CancelAll").removeAttr("disabled", "disabled");
                                               $('#CancelAll').attr('class') != 'buscarButton' ? $("#CancelAll").addClass("buscarButton") : null;
                                               $("#CancelAll").removeClass("buscarButtonDis");
                                           }
                                       }
                                   });
                               }
                               $("#addToOut").removeAttr("disabled", "disabled");
                               $('#codeprod').val("");
                           });
                           $("#addProduct").click(function() {
                               if ($("#inputreferencia").is(':visible')) {
                                   $("#inputreferencia").slideUp(500);
                               } else {
                                   $("#inputreferencia").slideDown(500);
                               }

                           });
                           $("#searchch").fancybox({
                               'width': 700,
                               'height': 400,
                               'autoScale': false,
                               'transitionIn': 'elastic',
                               'transitionOut': 'elastic',
                               'speedIn': 500,
                               'type': 'iframe',
                               'hideOnOverlayClick': false
                           });
                           $("#search").fancybox({
                               'width': 800,
                               'height': 400,
                               'autoScale': false,
                               'transitionIn': 'elastic',
                               'transitionOut': 'elastic',
                               'speedIn': 500,
                               'type': 'iframe',
                               'hideOnOverlayClick': false
                           });
                           $(".various3").fancybox({
                               'width': 700,
                               'height': 450,
                               'autoScale': false,
                               'transitionIn': 'elastic',
                               'transitionOut': 'elastic',
                               'speedIn': 500,
                               'type': 'iframe',
                               'hideOnOverlayClick': false
                           });                          
                           $(".various5").fancybox({
                               'width': 700,
                               'height': 365,
                               'autoScale': false,
                               'transitionIn': 'elastic',
                               'transitionOut': 'elastic',
                               'speedIn': 500,
                               'type': 'iframe',
                               'hideOnOverlayClick': false
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
                           $(".callback2").fancybox({
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

                           $("#FinishAll").click(function() {
                               $('#formproductos').ajaxForm({
                                   dataType: 'json',
                                   beforeSubmit: function(arr, $form, options) {
                                       $('#loader').css('display', 'block');
                                       $("#FinishAll").attr("disabled", "disabled");
                                       $("#FinishAll").addClass("buscarButtonDis");
                                       $("#FinishAll").removeClass("buscarButton");
                                       $("#CancelAll").attr("disabled", "disabled");
                                       $("#CancelAll").addClass("buscarButtonDis");
                                       $("#CancelAll").removeClass("buscarButton");
                                       if ($('#mytable >tbody >tr').length == 1 && $('#mytable >tbody >tr >td').attr("class") == "dataTables_empty") {
                                           message("no existen items en la compra", 'images/iconos_alerta/error.png');
                                           return false;
                                       } else {
                                           var uno = validates('formWarehouse');
                                           var dos = validates('formproductos');
                                           if (uno && dos) {
                                               return true;
                                           } else {
                                               $('#loader').css('display', 'none');
                                               $("#FinishAll").removeAttr("disabled", "disabled");
                                               $("#FinishAll").addClass("buscarButton");
                                               $("#FinishAll").removeClass("buscarButtonDis");
                                               $("#CancelAll").removeAttr("disabled", "disabled");
                                               $("#CancelAll").addClass("buscarButton");
                                               $("#CancelAll").removeClass("buscarButtonDis");
                                               return false;
                                           }
                                       }
                                   },
                                   uploadProgress: function(event, position, total, percentComplete) {
                                   },
                                   success: function(responseText) {                                      
                                       if (responseText.res == 'si') {
                                           window.location = "index.php?controlador=SupplierBuy&messageok=ok";
                                       }

                                   }
                               }).submit();
                           });
                           
        $("#formproductos input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
        $("#formWarehouse input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
                                   
       var today2 = new Date();                           
       $('td.item2 div.sumasuma input.onepic').unbind(); 
       $('td.item2 div.sumasuma input.onepic').simpleDatepicker({
            // chosendate:  $('input.onepic').attr("madate")? Number($('input.onepic').attr("madate")):today.getFullYear(),
            startdate: $('td.item2 div.sumasuma input.onepic').attr("midate") ? Number($('td.item2 div.sumasuma input.onepic').attr("midate")) : today.getFullYear() - 100,
            enddate: $('td.item2 div.sumasuma input.onepic').attr("madate") ? Number($('td.item2 div.sumasuma input.onepic').attr("madate")) : today.getFullYear(),
            x: 20,
            y: 20
        });
   });
</script>