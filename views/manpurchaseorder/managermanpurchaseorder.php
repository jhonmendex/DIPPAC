<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content">
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody>
        <tr><td id="fancybox-title-float-main">Administrar ordenes de pedido</td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">   
    <div style="float: left;width: 100%;">
        <fieldset class="colorleyend" style="width: 100%;">
            <legend class="colorleyendinto">Busqueda de ordenes</legend>
            <form method="POST" action="index.php?controlador=ManPurchaseOrder">
                <table cellspacing="2">
                    <tr>
                        <td colspan="9"><p style="line-height: normal; font-size: small">Para consultar las facturas de venta asociadas a su bodega, seleccione el estado de orden "Pagado".</p></td>
                    </tr>
                    <tr>
                        <td colspan="1" style="padding-bottom: 15px">Bodega:</td>
                        <td colspan="8" style="padding-bottom: 15px"><strong><?php echo $nombrebodega?></strong></td>
                    </tr>
                    <tr>
                        <td><?php $doc->texto('DATEINI') ?>: </td>
                        <td>
                            <?php $view->input("dateini", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $fechaini)); ?>
                        </td>
                        <td><?php $doc->texto('DATEFIN') ?>: </td>
                        <td>
                            <?php $view->input("datefin", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $fechafin)); ?>
                        </td>
                        <td>Estado de orden</td>
                        <td><select id="estado" name="idestado">
                                <option value="pagado"> Pagado</option>
                                <option value="espera"> En espera</option>
                                <option value="anulado"> Anulado</option>
                            </select>
                        </td>
                        <td></td>
                        <td><button class="buscarButton"><?php $doc->texto('SEE') ?></button></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div style="clear: left"></div>
    <div style="margin-top: 15px;margin-bottom: 20px">
        <?php if ($idestado == 'pagado') { ?>
            <fieldset class="colorleyend" style="width: 100%;">
                <legend class="colorleyendinto">Facturas de venta</legend>
                <div style="float: left;height: 16px;margin-bottom: 10px">
                    <img src="images/list.png" width="15px" height="15px" /> : Detalles y administraci&oacute;n de una factura
                </div>
                <div style="clear: both; margin-bottom: 15px"></div>
                <div>
                    <table width="100%" class="table" border="0" cellspacing="0" cellpadding="0" id="example2">
                        <thead>
                            <tr class="headall">
                                <th class="headinit" style="cursor: pointer;">Numero de factura</th>
                                <th class="head" style="cursor: pointer;">Numero de orden</th>
                                <th class="head" style="cursor: pointer;">Seguimiento</th>
                                <th class="head" style="cursor: pointer;">Fecha</th>
                                <th class="head" style="cursor: pointer;">Valor</th>
                                <th class="head" style="cursor: pointer;">Codigo Afiliado</th>
                                <th class="head">Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($facturas)) {
                                foreach ($facturas as $value) {
                                    ?>
                                    <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>">
                                        <td align="center" class="init2" style="width: 450px;" id="nameb<?php echo $value["id"] ?>">
                                            <?php echo $value["consecutivo"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="nameb<?php echo $value["id"] ?>">
                                            <?php echo $value["idorden"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="estadof<?php echo $value["id"] ?>">
                                            <?php echo $value["estado"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo $value["fecha"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo '&#36;' . number_format($value["subtotal"]+$value["iva"], 0, ',', '.'); ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo $value["usuario"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 20px;">
                                            <a class="various4" title="Ver detalles y administrar factura" href="index.php?controlador=ManPurchaseOrder&accion=detailsInvoices&idfactura=<?php echo $value["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                                <img src="images/list.png" width="15px" height="15px" title="<?php $doc->texto('VIEW_DETAILS2'); ?>"/>
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
                </div></fieldset>
        <?php } else { ?>

            <fieldset class="colorleyend" style="width: 100%;">
                <?php if ($idestado == 'anulado') { ?>
                    <legend class="colorleyendinto">Ordenes de pedido anuladas</legend>
                    <div style="float: left;height: 16px;margin-bottom: 10px">
                    <img src="images/list.png" width="15px" height="15px" /> : Detalles de una orden de pedido
                </div>
                <div style="clear: both; margin-bottom: 15px"></div>
                <?php } else { ?>
                    <legend class="colorleyendinto">Ordenes de pedido en espera</legend>
                    <div style="float: left;height: 16px;margin-bottom: 10px">
                    <img src="images/list.png" width="15px" height="15px" /> : Detalles y administraci&oacute;n de una orden de pedido
                </div>
                <div style="clear: both; margin-bottom: 15px"></div>
                <?php } ?>
                <div>
                    <table width="100%" class="table" border="0" cellspacing="0" cellpadding="0" id="example">
                        <thead>
                            <tr class="headall">
                                <th class="headinit" style="cursor: pointer;">Numero de orden</th>
                                <th class="head" style="cursor: pointer;">Estado</th>
                                <th class="head" style="cursor: pointer;">Fecha</th>
                                <th class="head" style="cursor: pointer;">Valor</th>
                                <th class="head" style="cursor: pointer;">Codigo Afiliado</th>
                                <th class="head">Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($ventas)) {
                                foreach ($ventas as $value) {
                                    ?>
                                    <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>">
                                        <td align="center" class="init2" style="width: 450px;" id="nameb<?php echo $value["id"] ?>">
                                            <?php echo $value["id"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="estadoorden<?php echo $value["id"] ?>">
                                            <?php echo $value["estado"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo $value["fecha"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo '&#36;' . number_format($value["valor"], 0, ',', '.'); ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                            <?php echo $value["usuario"] ?>
                                        </td>
                                        <td align="center" class="item2" style="width: 20px;">
                                            <a class="various4" 
                                               <?php if ($idestado == 'anulado') { ?> title="Ver detalles de orden de pedido"<?php }else{ ?>title="Ver detalles y administrar orden de pedido"<?php } ?>
                                               href="index.php?controlador=ManPurchaseOrder&accion=details&idventa=<?php echo $value["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                                <img src="images/list.png" width="15px" height="15px" title="<?php $doc->texto('VIEW_DETAILS2'); ?>"/>
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
                </div></fieldset>
        <?php } ?>
    </div>
</div>
        </div>
    </div>
<script>
    var oTable;
    function deleterow(id) {
        oTable.fnDeleteRow(oTable.fnGetPosition($('#' + id).get(0)));
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

    function updatedata(id, estadofactura) {
        $("#estadof" + id).html(estadofactura);
    }
    
    $(document).ready(function() {
        $("#estado").val("<?php echo $idestado ?>");
        $(".various4").fancybox({
            'width': 1000,
            'height': 480,
            'autoScale': false,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'type': 'iframe',
            'hideOnOverlayClick': false
        });
        $('img').css("border", "0");
        $('#categorias').val("<?php echo $categoriaselected; ?>");

        oTable = $('#example').dataTable({
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
                {"bSortable": false, "bSearchable": false}
            ]
        });
        $('#example2').dataTable({
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
                null,
                null,
                null,
                {"bSortable": false, "bSearchable": false}
            ]
        });
    });
</script>