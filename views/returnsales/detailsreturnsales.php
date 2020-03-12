<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>       
<div class="container">  
    <div style="float: left;width: 40%; margin-left: 0px"> 
        <fieldset class="colorleyend" style="width: 115%;"> 
            <legend class="colorleyendinto">Informaci&oacute;n de factura</legend> 
            <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                <tr><th width="40%">Nombre</th><td><input type="text" readonly="readonly" size="40%" value="<?php echo $detalles[1]["usuario"]; ?>"></td></tr>                
                <tr><th>Afiliado N°</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["idusuario"]; ?>"></td></tr>
                <tr><th>Fecha</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["fecha"]; ?>"></td></tr>
                <tr><th>Puntos totales de factura</th><td><input type="text" readonly="readonly" value="<?php echo number_format($detalles[1]["puntos"], 2, ',', ''); ?>"></td></tr>             
                <tr><th>Total</th><td><input type="text" readonly="readonly" value="<?php echo '&#36;' . number_format($detalles[1]["totalorden"], 0, ',', '.'); ?>"></td></tr>                 
            </table>        
        </fieldset>   
    </div>    
    <div style="float: left;width: 40%; margin-left: 100px"> 
        <fieldset class="colorleyend" style="width: 100%"> 
            <legend class="colorleyendinto">Registrar devolución de venta</legend> 
            <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                <tr>                               
                    <td>                      
                        <button id="boton" class="buscarButtonDis" disabled="disabled" style="height: 40px">
                            Realizar devolución
                        </button>                        
                    </td>                       
                    <td>
                        <button id="cancelar" class="buscarButtonDis" disabled="disabled" style="height: 40px">
                            Cancelar devolución
                        </button>
                    </td>                      
                </tr>
                <tr><td  style="color: #900000"colspan="4">Debe seleccionar por lo menos un producto para poder realizar la devolucion</td></tr> 
            </table> 
            <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                <img src="images/ajax-loader.gif"/> Procesando...
            </div>
        </fieldset>   
    </div>   
    <div style="clear: left"></div>    
    <fieldset class="colorleyend" style="width: 100%">
            <legend class="colorleyendinto">Detalles de factura</legend> 
    <form method="POST" action="index.php?controlador=ReturnSales&accion=finalizarDevolucion&idfactura=<?php echo $_GET["codigo"] ?>" id="devolucionesform">
       <div> 
         <table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" id="example">
            <thead> 
                <tr class="headall">
                    <th class="headinit" style="cursor: pointer;">Referencia</th>
                    <th class="head" style="cursor: pointer;">Articulo</th>
                    <th class="head" style="cursor: pointer;">Cant. factura</th>
                    <th class="head" style="cursor: pointer;">Cant. devuelta</th>
                    <th class="head" style="cursor: pointer;">Cant. a devolver</th> 
                    <th class="head" style="cursor: pointer;">Pts.</th>
                    <th class="head" style="cursor: pointer;">Total Pts.</th>
                    <th class="head" style="cursor: pointer;">Precio articulo (IVA incluido)</th>
                    <th class="head" style="cursor: pointer;">Subtotal</th> 
                    <th class="head" style="cursor: pointer;">Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                foreach ($detalles[0] as $value) { 
                    ?>   
                    <tr class="<?php echo $estilo; ?>" id="<?php echo $value["iddetalle"] ?>">                     
                        <td align="center" class="init2" style="width: 200px;" id="nameb<?php echo $value["id"] ?>">
                            <?php echo $value["referencia"] ?>
                        </td>   
                        <td align="center" class="item2" style="width: 450px;" id="art<?php echo $value["iddetalle"] ?>">
                            <?php echo $value["articulo"] ?>
                        </td> 
                        <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>">
                            <?php  
                            $view->input("cantfact", "numeric", "cantidad factura", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                'maxlength' => '5', 
                                "id" => "cantfact" . $value["idproducto"],
                                "item" => $value["idproducto"],
                                "disabled" => "disabled",
                                "style" => 'background-color:#C9D3E8',  
                                "value" => $value["cantidad"])); 
                            ?>   
                        </td>             
                         <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>"> 
                             <input id="devuelta<?php echo $value["idproducto"] ?>" item="<?php echo $value["idproducto"] ?>" type="text" value="<?php echo $value["cantdev"]  ?>" style="background-color: #C9D3E8" size="5">    
                        </td> 
                         <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>">
                            <?php
                            if($value['unidad']=='und'){
                            $view->input("cantdev", "numeric", "cantidad devolucion",
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'),
                                    array('size' => '5',
                                'maxlength' => '5', 
                                "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                "id" => "cantdev" . $value["idproducto"],
                                "item" => $value["idproducto"], 
                                "disabled" => "disabled",  
                                "style" => 'background-color:#C9D3E8',
                                "value" => ""));  
                            }else{
                            $view->input("cantdev", "text", "cantidad devolucion", 
                                    array('required' => true, 'text' => 'decimal', 'minsize' => '1'),
                                    array('size' => '5',
                                'maxlength' => '6', 
                                "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                "id" => "cantdev" . $value["idproducto"],
                                "item" => $value["idproducto"], 
                                "disabled" => "disabled",  
                                "style" => 'background-color:#C9D3E8',
                                "value" => "")); 
                            }
                            ?> 
                        </td>    
                        <td align="center" class="item1" style="width: 20px;" id="dirb<?php echo $value["id"] ?>">
                            <?php echo number_format($value["puntos"], 2, ',', ''); ?>
                        </td>
                        <td align="center" class="item2" style="width: 20px;" id="dirb<?php echo $value["id"] ?>">
                            <?php echo number_format($value["puntos"] * $value["cantidad"], 2, ',', ''); ?>
                        </td> 
                        <td align="center" class="item3" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">
                            <?php echo '&#36;' . number_format($value["precioiva"], 0, ',', '.'); ?>
                        </td>
                        <td align="center" class="item4" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">
                            <?php echo '&#36;' . number_format($value["precioiva"] * $value["cantidad"], 0, ',', '.'); ?>
                        </td>    
                        <td align="center" class="item5" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">  
                            <input item ="<?php echo $value["idproducto"] ?>" type="checkbox" idck="<?php echo $value["idproducto"] ?>" id="ck<?php echo $value["idproducto"] ?>" name="nameCheck" onclick="seleccionar($(this).attr('id'))" >  
                        </td>                                
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
    </form>
    </fieldset>
</div>   
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>  
    function contarcheck(){
        return $(':checkbox:checked').length;
    }          

  function seleccionar(id){    
           var devuelta = parseFloat($("#devuelta"+$("#"+id).attr("idck")).val());
           var valfact  = parseFloat($("#cantfact"+$("#"+id).attr("idck")).val());
           var resta = valfact-devuelta   
            if(devuelta == valfact){  
              $("#ck"+$("#"+id).attr("idck")).attr('checked', false); 
              $("#ck"+$("#"+id).attr("idck")).prop('disabled', true);             
            }else{ 
                if($("#"+id).is(":checked")){                
                    $("#cantdev"+$("#"+id).attr("idck")).prop('disabled', false); 
                    $("#cantdev"+$("#"+id).attr("idck")).css('background-color', '#fff');
                    $("#cantdev"+$("#"+id).attr("idck")).val(resta);   
                     $("#boton").removeAttr("disabled", "disabled");
                            $("#boton").removeClass("buscarButtonDis");
                            $('#boton').attr('class') != 'buscarButton' ? $("#boton").addClass("buscarButton") : null;
                            $("#cancelar").removeAttr("disabled", "disabled");
                            $("#cancelar").removeClass("buscarButtonDis");
                            $('#cancelar').attr('class') != 'buscarButton' ? $("#cancelar").addClass("buscarButton") : null;
                    $.ajax({   
                        type: "POST",                    
                        url: "index.php?controlador=ReturnSales&accion=registrarDevolucion",
                        dataType: "json",     
                        data: {cantidad:($("#cantdev"+$("#"+id).attr("idck")).val()), idproducto:$("#"+id).attr("idck")},                                                    
                    });    
                }else{    
                    if (contarcheck() == 0) {
                        $("#boton").attr("disabled", "disabled");
                        $("#boton").removeClass("buscarButton");
                        $('#boton').attr('class') != 'buscarButtonDis' ? $("#boton").addClass("buscarButtonDis") : null;
                        $("#cancelar").attr("disabled", "disabled");
                        $("#cancelar").removeClass("buscarButton");
                        $('#cancelar').attr('class') != 'buscarButtonDis' ? $("#cancelar").addClass("buscarButtonDis") : null;
                    }   
                    $("#cantdev"+$("#"+id).attr("idck")).prop('disabled', true);               
                    $("#cantdev"+$("#"+id).attr("idck")).css('background-color', '#C9D3E8');  
                    $.ajax({
                        type: "POST",                      
                        url: "index.php?controlador=ReturnSales&accion=eliminardetalle",
                        dataType: "json", 
                        data: {detalleventa:($("#"+id).attr("idck"))},
                        success: function(data) {
                            $("#cantdev" + $("#" + id).attr("idck")).val("");

                        }
                    });
                }
            } 
         }    
   
    function actualizar(id,item){ 
        var valfact   = parseFloat($("#cantfact"+item).val());
        var valdev    = parseFloat($("#"+id).val().replace(",", "."));
        var devuelta  = parseFloat($("#devuelta"+item).val()); 
        var suma = devuelta + valdev; 
        var resta= valfact - devuelta; 
        if($("#ck"+item).is(':checked')){               
            if(valdev > valfact || valdev < 1 || suma > valfact){      
                message(' Verifique el valor ingresado','images/iconos_alerta/error.png'); 
                $("#"+id).val(resta);       
                $.ajax({        
                    type: "POST",                     
                    url: "index.php?controlador=ReturnSales&accion=registrarDevolucion",
                    dataType: "json",      
                    data: {cantidad:$("#"+id).val(), idproducto :item }  
                });                 
            }    
            else{   
                $.ajax({   
                    type: "POST",                     
                    url: "index.php?controlador=ReturnSales&accion=registrarDevolucion",
                    dataType: "json",      
                    data: {cantidad:$("#"+id).val(), idproducto :item }  
                }); 
            }        
        }else{               
        }     
    }
    function message(mensaje,imagen){        
        $("#titlemesagge",window.parent.document).html("<strong>"+mensaje+"<strong/>");
        $("#iconmesagge",window.parent.document).html(" <img src='"+imagen+"'/>");       
        $("#barraf",window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf",window.parent.document).slideUp(1000).fadeOut(400);  
    }
    jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
    };

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
        $('#example').dataTable( {
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
            "aaSorting": [[ 0, "desc" ]],
            "aoColumns": [
                null,
                null,  
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }
            ]
        });
        
        $("#boton").click(function() {
            $('#devolucionesform').ajaxForm({
                dataType: 'json',
                beforeSubmit: function(arr, $form, options) {
                    $('#loader').css('display', 'block');
                    $("#boton").attr("disabled", "disabled");
                    $("#boton").addClass("buscarButtonDis");
                    $("#boton").removeClass("buscarButton");
                    $("#cancelar").attr("disabled", "disabled");
                    $("#cancelar").addClass("buscarButtonDis");
                    $("#cancelar").removeClass("buscarButton");
                    if (validates('devolucionesform')) {
                        return true;
                    } else {
                        $('#loader').css('display', 'none');
                        $("#boton").removeAttr("disabled", "disabled");
                        $("#boton").addClass("buscarButton");
                        $("#boton").removeClass("buscarButtonDis");
                        $("#cancelar").removeAttr("disabled", "disabled");
                        $("#cancelar").addClass("buscarButton");
                        $("#cancelar").removeClass("buscarButtonDis");
                        return false;
                    }
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    if (responseText.res == 'si') {
                        parent.message('Se ha realizado la devolucion', 'images/iconos_alerta/ok.png');
                        parent.$.fancybox.close();
                    }else{
                        parent.message('No se pudo realizar la devolucion', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    }
                }
            }).submit();
        });
        
        $("#cancelar").click(function(){  
          parent.$.fancybox.close(); 
            $.ajax({
                type: "POST",                        
                url: "index.php?controlador=ReturnSales&accion=cancelarsesion",
                dataType: "json"        
            });          
        });
    });
</script>