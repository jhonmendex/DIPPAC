<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">     
    <form method="POST" action="index.php?controlador=ManPurchaseOrder&accion=cambiarEstado" id="formdetailsorder">
        <input type="hidden" name="norden" value="<?php echo $detalles[1]["norden"]; ?>"/>
        <div style="float: left;width: 40%; margin-left: 0px">
            <fieldset class="colorleyend" style="width: 115%;">
                <legend class="colorleyendinto">Informaci&oacute;n de Orden No. <?php echo $detalles[1]["norden"]; ?></legend> 
                <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                    <tr><th>Nombre</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["usuario"]; ?>"></td></tr>                
                    <tr><th>Afiliado N°</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["idusuario"]; ?>"></td></tr>                    
                    <tr><th>Fecha</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["fecha"]; ?>"></td></tr>
                    <tr><th>Puntos totales</th><td><input type="text" readonly="readonly" value="<?php echo number_format($detalles[1]["puntos"], 2, ',', ''); ?>"></td></tr>             
                    <tr><th>Total</th><td><input type="text" readonly="readonly" value="<?php echo '&#36;' . number_format($detalles[1]["totalorden"], 0, ',', '.'); ?>"></td></tr>                 
                </table>      
            </fieldset> 
        </div>
        <div style="float: left;width: 40%; margin-left: 100px">
            <fieldset class="colorleyend" style="width: 100%">
                <legend class="colorleyendinto">Administrar orden</legend>
                <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                    <tr><td>
                            <strong>Etado actual:</strong> <?php echo $detalles[1]["estado"] == "espera" ? "En espera" : "Anulada" ?>
                        </td>  
                        <td></td>                        
                    </tr>
                    <?php if ($detalles[1]["estado"] == "espera") { ?>
                        <tr>
                            <td>
                                <select id="estadoorden" name="estadoorden">
                                    <option value="none">Seleccionar estado nuevo</option>
                                    <option value="pagado">Pagado</option>
                                    <option value="anulado">Anulado</option>
                                </select>
                            </td>
                            <td>
                                <button class="buscarButtonDis" disabled="disabled" style="height: 40px" id="changeAll">
                                    Cambiar estado
                                </button>
                            </td>                        
                        </tr>   
                    <?php } ?>
                </table> 
                <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                    <img src="images/ajax-loader.gif"/> Procesando...
                </div>
            </fieldset>   
        </div> 
    </form>
    <div style="clear: left"></div>
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Detalles de Orden No. <?php echo $detalles[1]["norden"]; ?></legend>
        <div>
            <table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" id="example">
                <thead>
                    <tr class="headall">
                        <th class="headinit" style="cursor: pointer;">Referencia</th>
                        <th class="head">Articulo</th>
                        <th class="head" style="cursor: pointer;">Cantidad</th>
                        <?php if ($detalles[1]["estado"] == "espera") { ?>
                            <th class="head" style="cursor: pointer;">Stock en<br>bodega</th>
                            <th class="head" style="cursor: pointer;">Diferencia</th>
                        <?php } ?>
                        <th class="head">Puntos</th>
                        <th class="head">Total<br>puntos</th>
                        <th class="head" style="cursor: pointer;">Precio articulo<br>(IVA incluido)</th>
                        <th class="head" style="cursor: pointer;">Total<br>detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    foreach ($detalles[0] as $value) {
                        ?>
                        <tr class="class<?php echo $estilo; ?>">
                            <td align="center" class="init2" id="referencia">
                                <?php echo $value["referencia"] ?>
                            </td>
                            <td class="item2">
                                <?php echo $value["articulo"] ?>
                            </td>
                            <td align="center" class="item2">
                                <?php echo $value["cantidad"] ?>
                            </td>
                            <?php if ($detalles[1]["estado"] == "espera") { ?>
                                <td align="center" class="item2">
                                    <?php echo $value["referencia"]=="LICINS"?"N/A":$value["stock"] ?>
                                </td>
                                <td align="center" class="item2" style="color: <?php echo $value["stock"] - $value["cantidad"] < 0 ? "#990000" : "#00BB00" ?>">
                                    <strong><?php echo $value["referencia"]=="LICINS"?"N/A":$value["stock"] - $value["cantidad"] ?></strong>
                                </td>
                            <?php } ?>
                            <td align="center" class="item2">
                                <?php echo number_format($value["puntos"], 2, ',', ''); ?>
                            </td>
                            <td align="center" class="item2">
                                <?php echo number_format($value["puntos"] * $value["cantidad"], 2, ',', ''); ?>
                            </td> 
                            <td align="center" class="item2">
                                <?php echo '&#36;' . number_format($value["precioiva"], 0, ',', '.'); ?>
                            </td>
                            <td align="center" class="item2" >
                                <?php echo '&#36;' . number_format($value["precioiva"] * $value["cantidad"], 0, ',', '.'); ?>
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
    </fieldset>
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
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

        $("#estadoorden").change(function() {
            if ($("#estadoorden").val() == "none") {
                $("#changeAll").addClass("buscarButtonDis");
                $("#changeAll").removeClass("buscarButton");
                $("#changeAll").attr("disabled", "disabled");
            } else {
                $("#changeAll").addClass("buscarButton");
                $("#changeAll").removeClass("buscarButtonDis");
                $("#changeAll").removeAttr("disabled", "disabled");
            }
        });
        $('img').css("border", "0");
        
        var estado = '<?php echo $detalles[1]["estado"] ?>';
        var arreglofinal= estado=="espera"?[
                null,
                null,
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false},
                {"bSearchable": false},
                {"sType": "numeric-comma", "bSearchable": false},
                {"sType": "numeric-comma", "bSearchable": false},
                null,
                {"bSortable": false, "bSearchable": false}]:[
                null,
                null,
                {"bSortable": false, "bSearchable": false},                
                {"sType": "numeric-comma", "bSearchable": false},
                {"sType": "numeric-comma", "bSearchable": false},
                null,
                {"bSortable": false, "bSearchable": false}]; 
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
            "aaSorting": [[<?php if ($detalles[1]["estado"] == "espera") { ?>4<?php } else { ?>1<?php } ?>, "asc"]],            
            "aoColumns": arreglofinal                   
        });
        $("#changeAll").click(function() {
            var devuelta = true;
            $('#formdetailsorder').ajaxForm({
                dataType: 'json',
                beforeSubmit: function(arr, $form, options) {
                    $('#loader').css('display', 'block');
                    $("#changeAll").attr("disabled", "disabled");
                    $("#changeAll").addClass("buscarButtonDis");
                    $("#changeAll").removeClass("buscarButton");
                    if ($("#estadoorden").val() == "pagado") {
                        $.ajax({
                            type: "POST",
                            url: "index.php?controlador=ManPurchaseOrder&accion=validaStockVenta",
                            dataType: "json",
                            async: false,
                            data: {idventa: <?php echo $detalles[1]["norden"]; ?>},
                            success: function(data) {
                                if (data.respuesta == "no") {
                                    devuelta = false;
                                }
                            }
                        });
                    }
                    if (!devuelta) {
                        $('#loader').css('display', 'none');
                        $("#changeAll").removeAttr("disabled", "disabled");
                        $("#changeAll").removeClass("buscarButtonDis");
                        $("#changeAll").addClass("buscarButton");
                        parent.message('Faltan existencias en bodega para realizar la factura', 'images/iconos_alerta/error.png');
                        return false;
                    } else {
                        return true
                    }
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    if (responseText.respuesta == 'si') {
                        parent.message('Se ha generado una factura correctamente', 'images/iconos_alerta/ok.png');
                        parent.deleterow(responseText.orden);
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'sisi') {
                        parent.message('Se ha anulado la orden No. ' + responseText.orden + ' correctamente', 'images/iconos_alerta/ok.png');
                        parent.deleterow(responseText.orden);
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'no') {
                        parent.message('No se pudo generar la factura', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'nono') {
                        parent.message('No se pudo anular la orden de pedido', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    }
                }
            });
        });
    });
</script>
