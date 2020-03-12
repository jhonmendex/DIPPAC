<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">   
    <div style="float: left;width: 40%; margin-left: 0px"> 
        <fieldset class="colorleyend" style="width: 115%;">  
            <legend class="colorleyendinto">Informaci&oacute;n de Factura de compra</legend> 
            <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                <tr><th>Factura No</th><td><input type="text" disabled="disabled" readonly="readonly" value="<?php echo $docinfo["codigo"]; ?>"></td></tr>                
                <tr><th>Proveedor</th><td><input type="text" disabled="disabled" readonly="readonly" value="<?php echo $docinfo["empresa"]; ?>"></td></tr>
                <tr><th>Nit</th><td><input type="text" disabled="disabled" readonly="readonly" value="<?php echo $docinfo["nit"]; ?>" name="norden"></td></tr>
                <tr><th>Fecha</th><td><input type="text" disabled="disabled" readonly="readonly" value="<?php $novoarray=explode(" ",$docinfo["fecha"]);echo $novoarray[0]; ?>"></td></tr>                
                <tr><th>Subtotal</th><td><input type="text" disabled="disabled" readonly="readonly" value="<?php echo '&#36;' . number_format($docinfo["total"], 0, ',', '.'); ?>"></td></tr>                 
            </table>         
        </fieldset>   
    </div>          
    <div style="float: left;width: 40%; margin-left: 100px"> 
        <fieldset class="colorleyend" style="width: 100%"> 
            <legend class="colorleyendinto">Registrar devolución de compra</legend> 
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
            <legend class="colorleyendinto">Detalles de Factura de compra</legend> 
    <form method="POST" action="index.php?controlador=SupplierBuy&accion=finalizarDevolucion&iddocumento=<?php echo $_GET["iddoc"] ?>&tercero=<?php echo $docinfo["idtercero"] ?>" id="devolucionesform">
        <div>
            <table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" id="example">
                <thead>
                    <tr class="headall">
                        <th class="headinit" style="cursor: pointer;">Ref.</th> 
                        <th class="head" style="cursor: pointer;">Articulo</th>
                        <th class="head" style="cursor: pointer;">Cant. factura</th>
                        <th class="head" style="cursor: pointer;">Cant. devuelta</th>
                        <th class="head" style="cursor: pointer;">Stock</th>
                        <th class="head" style="cursor: pointer;">Cant. a devolver</th>                     
                        <th class="head" style="cursor: pointer;">Costo base</th> 
                        <th class="head" style="cursor: pointer;">Total</th> 
                        <th class="head" style="cursor: pointer;">Selec.</th> 
                    </tr> 
                </thead> 
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($detallesdoc) != 0) {
                        foreach ($detallesdoc as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["referencia"] ?>">
                                <td align="center" class="init2" style="width: 200px;" id="nameb<?php echo $value["id"] ?>">
                                    <?php echo $value["referencia"] ?>
                                </td>
                                <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["nombreproducto"] ?>
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
                                    <input id="devuelta<?php echo $value["idproducto"] ?>" item="<?php echo $value["idproducto"] ?>" disabled="disabled" type="text" value="<?php echo $value["cantdev"] ?>" style="background-color: #C9D3E8;" size="5">    
                                </td>  
                                <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>"> 
                                    <input id="stock<?php echo $value["idproducto"] ?>" disabled="disabled" item="<?php echo $value["stock"] ?>" type="text" value="<?php echo $value["stock"] ?>" style="background-color: #C9D3E8" size="5">    
                                </td>                           
                                <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>">
                                    <?php
                                    if ($value['unidad'] == 'und') {
                                        $view->input("cantdev", "numeric", "cantidad devolucion", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                            'maxlength' => '5',
                                            "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                            "id" => "cantdev" . $value["idproducto"],
                                            "item" => $value["idproducto"],
                                            "disabled" => "disabled",
                                            "style" => 'background-color:#C9D3E8',
                                            "value" => ""));
                                    } else {
                                        $view->input("cantdev", "text", "cantidad devolucion", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('size' => '5',
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
                                <td align="center" class="item2" style="width: 20px;" id="coast<?php echo $value["idproducto"] ?>">
                                    <?php echo number_format($value["costo"], 2, ',', '.'); ?>
                                </td>
                                <td align="center" class="item2" style="width: 170px;" id="dirb<?php echo $value["idproducto"] ?>">
                                    <?php echo '&#36;' . number_format($value["valortotal"], 0, ',', '.'); ?>
                                </td> 
                                <td align="center" class="item5" style="width: 170px;" id="dirb2<?php echo $value["idproducto"] ?>">  
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
                                        function contarcheck() {
                                            return $(':checkbox:checked').length;
                                        }                                        

                                        function seleccionar(id) {
                                            var devuelta = parseFloat($("#devuelta" + $("#" + id).attr("idck")).val());
                                            var valfact = parseFloat($("#cantfact" + $("#" + id).attr("idck")).val());
                                            var stock = parseFloat($("#stock" + $("#" + id).attr("idck")).val());
                                            var resta = valfact - devuelta;
                                            var costoenv = $.trim($("#coast" + $("#" + id).attr("idck")).html().replace(".", "").replace(",", "."));
                                            if (devuelta == valfact) {
                                                $("#ck" + $("#" + id).attr("idck")).attr('checked', false);
                                                $("#ck" + $("#" + id).attr("idck")).prop('disabled', true);
                                            } else {
                                                if ($("#" + id).is(":checked")) {
                                                    $("#cantdev" + $("#" + id).attr("idck")).prop('disabled', false);
                                                    $("#cantdev" + $("#" + id).attr("idck")).css('background-color', '#fff');
                                                    if (resta > stock) {
                                                        $("#cantdev" + $("#" + id).attr("idck")).val(stock);
                                                    } else {
                                                        $("#cantdev" + $("#" + id).attr("idck")).val(resta);
                                                    }
                                                    $("#boton").attr('disabled', false);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "index.php?controlador=SupplierBuy&accion=registrarDevolucion",
                                                        dataType: "json",
                                                        data: {cantidad: ($("#cantdev" + $("#" + id).attr("idck")).val()), idproducto: $("#" + id).attr("idck"), costo: costoenv},
                                                        success: function(data) {
                                                            $("#boton").removeAttr("disabled", "disabled");
                                                            $("#boton").removeClass("buscarButtonDis");
                                                            $('#boton').attr('class') != 'buscarButton' ? $("#boton").addClass("buscarButton") : null;
                                                            $("#cancelar").removeAttr("disabled", "disabled");
                                                            $("#cancelar").removeClass("buscarButtonDis");
                                                            $('#cancelar').attr('class') != 'buscarButton' ? $("#cancelar").addClass("buscarButton") : null;
                                                        }
                                                    });
                                                } else {
                                                    if (contarcheck() == 0) {
                                                        $("#boton").attr("disabled", "disabled");
                                                        $("#boton").removeClass("buscarButton");
                                                        $('#boton').attr('class') != 'buscarButtonDis' ? $("#boton").addClass("buscarButtonDis") : null;
                                                        $("#cancelar").attr("disabled", "disabled");
                                                        $("#cancelar").removeClass("buscarButton");
                                                        $('#cancelar').attr('class') != 'buscarButtonDis' ? $("#cancelar").addClass("buscarButtonDis") : null;
                                                    }
                                                    $("#cantdev" + $("#" + id).attr("idck")).prop('disabled', true);
                                                    $("#cantdev" + $("#" + id).attr("idck")).css('background-color', '#C9D3E8');
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "index.php?controlador=SupplierBuy&accion=eliminardetalle",
                                                        dataType: "json",
                                                        data: {detalleventa: ($("#" + id).attr("idck"))},
                                                        success: function(data) {
                                                            $("#cantdev" + $("#" + id).attr("idck")).val("");

                                                        }
                                                    });
                                                }
                                            }
                                        }


                                        function actualizar(id, item) {
                                            var valfact = parseFloat($("#cantfact" + item).val());
                                            var valdev = parseFloat($("#" + id).val());
                                            var devuelta = parseFloat($("#devuelta" + item).val());
                                            var stock = parseFloat($("#stock" + item).val());
                                            var suma = devuelta + valdev;
                                            var resta = valfact - devuelta;
                                            var costoenv = $.trim($("#coast" + item).html().replace(".", "").replace(",", "."));
                                            if ($("#ck" + item).is(':checked')) {
                                                if (valdev > stock) {
                                                    $("#" + id).val(stock);
                                                    message(' Verifique el valor ingresado', 'images/iconos_alerta/error.png');
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "index.php?controlador=SupplierBuy&accion=registrarDevolucion",
                                                        dataType: "json",
                                                        data: {cantidad: $("#" + id).val(), idproducto: item, costo: costoenv}
                                                    });
                                                } else {
                                                    if (valdev > valfact || valdev < 1 || suma > valfact) {
                                                        message(' Verifique el valor ingresado', 'images/iconos_alerta/error.png');
                                                        $("#" + id).val(resta);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "index.php?controlador=SupplierBuy&accion=registrarDevolucion",
                                                            dataType: "json",
                                                            data: {cantidad: $("#" + id).val(), idproducto: item, costo: costoenv}
                                                        });
                                                    } else {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "index.php?controlador=SupplierBuy&accion=registrarDevolucion",
                                                            dataType: "json",
                                                            data: {cantidad: $("#" + id).val(), idproducto: item, costo: costoenv}
                                                        });
                                                    }
                                                }
                                            }
                                        }

                                        function message(mensaje, imagen) {
                                            $("#titlemesagge", window.parent.document).html("<strong>" + mensaje + "<strong/>");
                                            $("#iconmesagge", window.parent.document).html(" <img src='" + imagen + "'/>");
                                            $("#barraf", window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
                                            $("#barraf", window.parent.document).slideUp(1000).fadeOut(400);
                                        }

                                        jQuery.fn.dataTableExt.oSort['numeric-comma-asc'] = function(a, b) {
                                            var x = (a == "-") ? 0 : a.replace(/,/, ".");
                                            var y = (b == "-") ? 0 : b.replace(/,/, ".");
                                            x = parseFloat(x);
                                            y = parseFloat(y);
                                            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                                        };

                                        jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a, b) {
                                            var x = (a == "-") ? 0 : a.replace(/,/, ".");
                                            var y = (b == "-") ? 0 : b.replace(/,/, ".");
                                            x = parseFloat(x);
                                            y = parseFloat(y);
                                            return ((x < y) ? 1 : ((x > y) ? -1 : 0));
                                        };

                                        jQuery.fn.dataTableExt.oSort['numeric-point-asc'] = function(a, b) {
                                            var x = (a == "-") ? 0 : a.replace("$", "").replace(".", "");
                                            var y = (b == "-") ? 0 : b.replace("$", "").replace(".", "");
                                            return (x - y);
                                        };

                                        jQuery.fn.dataTableExt.oSort['numeric-point-desc'] = function(a, b) {
                                            var x = (a == "-") ? 0 : a.replace("$", "").replace(".", "");
                                            var y = (b == "-") ? 0 : b.replace("$", "").replace(".", "");
                                            return (y - x);
                                        };
                                        $(document).ready(function() {
                                            $('img').css("border", "0");
                                            $('#example').dataTable({
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
                                                "aoColumns": [
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    {"bSortable": false, "bSearchable": false},
                                                    {"bSortable": false, "bSearchable": false},
                                                    {"sType": "numeric-point", "bSearchable": false}
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
                                                            $("#cancelar").removeClass("buscarButtonDis")
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
                                            
                                            $("#cancelar").click(function() {
                                            parent.$.fancybox.close();
                                            $.ajax({
                                                type: "POST",
                                                url: "index.php?controlador=SupplierBuy&accion=cancelarsesion",
                                                dataType: "json"
                                            });
                                        });
                                        });


</script>