<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">    
    <form method="POST" action="index.php?controlador=ManPurchaseOrder&accion=cambiarEstadoFactura" id="formdetailinvoice">
        <input type="hidden"  value="<?php echo $detalles[1]["idfactura"]; ?>" name="idfactura">
        <input type="hidden"  value="<?php echo $detalles[1]["consecutivo"]; ?>" name="consecutivo">
        <div style="float: left;width: 40%; margin-left: 0px">
            <fieldset class="colorleyend" style="width: 115%;">
                <legend class="colorleyendinto">Informaci&oacute;n de Factura No. <?php echo $detalles[1]["consecutivo"]; ?></legend> 
                <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">   
                    <tr><th width="40%">Nombre</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["usuario"]; ?>"></td></tr>                
                    <tr><th>Afiliado N°</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["idusuario"]; ?>"></td></tr>                             
                    <tr><th>Fecha</th><td><input type="text" readonly="readonly" value="<?php echo $detalles[1]["fecha"]; ?>"></td></tr>
                    <tr><th>Subtotal Factura</th><td><input type="text" readonly="readonly" value="<?php echo number_format($detalles[1]["subtotal"], 0, ',', '.'); ?>"></td></tr>
                    <tr><th>Total Iva</th><td><input type="text" readonly="readonly" value="<?php echo number_format($detalles[1]["totaliva"], 0, ',', '.'); ?>"></td></tr>
                    <tr><th>Total Factura</th><td><input type="text" readonly="readonly" style="font-weight: bold;" value="<?php echo number_format($detalles[1]["subtotal"] + $detalles[1]["totaliva"], 0, ',', '.'); ?>"></td></tr>
                </table>      
            </fieldset> 
        </div>
        <div style="float: left;width: 40%; margin-left: 100px">
            <fieldset class="colorleyend" style="width: 100%">
                <legend class="colorleyendinto">Administrar Factura</legend>
                <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">
                    <tr><td>
                            <strong>Etado factura:</strong> <?php echo ucfirst($detalles[1]["estado"]) ?>
                        </td>  
                        <td></td>                        
                    </tr>
                    <?php if ($detalles[1]["estado"] == "por entregar") { ?>
                        <tr><td>
                                <select id="estadofactura" name="estadofactura">
                                    <option value="entregado">Entregado</option>                            
                                </select>
                            </td>
                            <td>
                                <button class="buscarButton" style="height: 40px" id="ChangeInvoice">
                                    Cambiar <br>Estado
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
        <legend class="colorleyendinto">Detalles de Factura No. <?php echo $detalles[1]["consecutivo"]; ?></legend> 
        <div>
            <table width="100%" class="table" border="1" cellspacing="0" cellpadding="0" id="example">
                <thead>
                    <tr class="headall">
                        <th class="headinit" style="cursor: pointer;">Referencia</th>
                        <th class="head" style="cursor: pointer;">Articulo</th>
                        <th class="head" style="cursor: pointer;">Cantidad</th>
                        <th class="head" style="cursor: pointer;">Puntos</th>
                        <th class="head" style="cursor: pointer;">Total puntos</th>
                        <th class="head" style="cursor: pointer;">Precio articulo (IVA incluido)</th>
                        <th class="head" style="cursor: pointer;">Total Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($detalles[0])) {
                        foreach ($detalles[0] as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["referencia"] ?>">
                                <td align="center" class="init2" style="width: 200px;" id="nameb<?php echo $value["id"] ?>">
                                    <?php echo $value["referencia"] ?>
                                </td>
                                <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["articulo"] ?>
                                </td>
                                <td align="center" class="item2" style="width: 20px;" id="nameb<?php echo $value["id"] ?>">
                                    <?php echo $value["cantidad"] ?>
                                </td>
                                <td align="center" class="item2" style="width: 20px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo number_format($value["puntos"], 2, ',', ''); ?>
                                </td>
                                <td align="center" class="item2" style="width: 20px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo number_format($value["puntos"] * $value["cantidad"], 2, ',', ''); ?>
                                </td> 
                                <td align="center" class="item2" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo '&#36;' . number_format($value["precioiva"], 0, ',', '.'); ?>
                                </td>
                                <td align="center" class="item2" style="width: 170px;" id="dirb<?php echo $value["id"] ?>">
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
                    }
                    ?>
                </tbody>
            </table> 
        </div>
    </fieldset> 
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
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
            "aaSorting": [[0, "desc"]],
            "aoColumns": [
                null,
                null,
                null,
                {"sType": "numeric-point", "bSearchable": false},
                null,
                {"bSortable": false, "bSearchable": false},
                null
            ]
        });

        $("#ChangeInvoice").click(function() {
            $('#formdetailinvoice').ajaxForm({
                dataType: 'json',
                beforeSubmit: function(arr, $form, options) {
                    $('#loader').css('display', 'block');
                    $("#ChangeInvoice").attr("disabled", "disabled");
                    $("#ChangeInvoice").addClass("buscarButtonDis");
                    $("#ChangeInvoice").removeClass("buscarButton");
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    if (responseText.respuesta == 'si') {
                        parent.message('Se ha cambiado el estado de la factura', 'images/iconos_alerta/ok.png');
                        parent.updatedata(responseText.Nofact, responseText.estadofact);
                        parent.$.fancybox.close();
                    } else {
                        parent.message('No se ha podido cambiar el estado de la factura', 'images/iconos_alerta/error.png');
                    }

                }
            });
        });
    });
</script>