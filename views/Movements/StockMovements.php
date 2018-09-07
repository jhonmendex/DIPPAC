<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?> 
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Stock y movimientos</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">      
    <div style="float: left;width: 100%;">
        <fieldset class="colorleyend" style="width: 100%;"> 
            <legend class="colorleyendinto">Busqueda de movimientos por producto</legend>
            <form method="POST" action="index.php?controlador=StockMovements">
                <table cellspacing="2">
                    <tr>
                        <td>Referencia de producto:</td>     
                        <td>  
                            <div style="margin-left: 15px; float: left;">
                                <input type="text" name="codigopro" id="codeprod" maxlength="15" size="30" value="<?php echo $referencia ? $referencia : ""?>"/>                
                            </div>
                            <div style="margin-left: 2px;float: left; margin-top: 2px">
                                <a id="search" href="index.php?controlador=Retiros&accion=getProducts" title="Buscar producto">
                                    <img src="images/zoom.png" width="17" height="17"/>
                                </a>
                            </div>          
                            <div style="clear: both;"></div>                            
                        </td>  
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr><td colspan="6"></td></tr>
                
                    <tr><td colspan="6"></td></tr>
                    <tr>
                        <td><?php $doc->texto('DATEINI') ?>: </td>
                        <td>
                            <?php $view->input("dateini", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $fechainicial)); ?>
                        </td>
                        <td><?php $doc->texto('DATEFIN') ?>: </td>
                        <td>
                            <?php $view->input("datefin", "calendar", $doc->t('BORN_DATE'), array(), array('readonly' => 'readonly', "value" => $fechafinal)); ?>
                        </td>
                        <td></td>
                        <td><button class="buscarButton"><?php $doc->texto('SEE') ?></button></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div style="clear: left"></div>
    <?php if ($producto) { ?>
        <div style="font-size: 25px;font-weight: bold;color: #993300">Movimientos de: <?php echo $producto ?></div>
    <?php } ?>
    <div style="margin-top: 15px;margin-bottom: 20px">  
        <table class="table" border="0" cellspacing="0" cellpadding="3" id="example">  
            <thead>
                <tr align="center">
                    <td colspan="3"></td>
                    <td colspan="3" style="background-color:#bf5700; color: #fff; font-weight: bold; font-size: 15px;border-radius: 10px 10px 0 0;">ENTRADAS</td>
                    <td colspan="3" style="background-color:#bf6700; color: #fff; font-weight: bold; font-size: 15px;border-radius: 10px 10px 0 0;">SALIDAS</td>
                    <td colspan="3" style="background-color:#5c3800; color: #fff; font-weight: bold; font-size: 15px;border-radius: 10px 10px 0 0;">SALDOS</td>
                </tr>     
                <tr class="headall">      
                    <th class="headinit" style="cursor: pointer">FECHA</th>                        
                    <th class="head" style="cursor: pointer">DOCUMENTO</th>
                    <th class="head" style="width: 20px">TIPO MOVIMIENTO</th> 
                    <th class="head" style="width: 20px">CANTIDAD</th>
                    <th class="head" style="width: 20px">VR. UNITARIO</th> 
                    <th class="head" style="width: 20px">VR. TOTAL</th> 
                    <th class="head" style="width: 20px">CANTIDAD</th>
                    <th class="head" style="width: 20px">VR. UNITARIO</th> 
                    <th class="head" style="width: 20px">VR. TOTAL</th>  
                    <th class="head" style="width: 20px">CANTIDAD</th>
                    <th class="head" style="width: 20px">VR. UNITARIO</th> 
                    <th class="head" style="width: 20px">VR. TOTAL</th>                     
                </tr>
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                foreach ($movimientos as $value) {
                    ?>

                    <tr class="class<?php echo $estilo; ?>"> 
                        <td class="init2" align="center">
                            <?php echo $value["fecha"] ?>
                        </td>  
                        <td class="item2" align="center">
                            <?php echo $value["documento"] ?>  
                        </td> 
                        <td class="item2" align="center">
                            <?php echo $value["tmovimiento"] ?>  
                        </td>
                        <td class="item2" align="center">
                            <?php
                            if ($value["cantidadentrada"]) {
                                $partes = explode(".", $value["cantidadentrada"]);
                                if ($partes[1] == 0) {
                                    echo $value["cantidadentrada"];
                                } else {
                                    echo number_format($value["cantidadentrada"], 2, ',', '.');
                                }
                            }
                            ?>
                        </td>
                        <td class="item2" align="center">
                            <?php
                            if ($value["vrunitarioentrada"])
                                echo '&#36;' . number_format($value["vrunitarioentrada"], 2, ',', '.');
                            ?>  
                        </td>
                        <td class="item2"  align="center">
                            <?php
                            if ($value["vrtotalentrada"])
                                echo '&#36;' . number_format($value["vrtotalentrada"], 0, ',', '.');
                            ?> 
                        </td>
                        <td class="item2"  align="center">
                            <?php
                            if ($value["cantidad"]) {
                                $partes = explode(".", $value["cantidad"]);
                                if ($partes[1] == 0) {
                                    echo $value["cantidad"];
                                } else {
                                    echo number_format($value["cantidad"], 2, ',', '.');
                                }
                            }
                            ?>   
                        </td>
                        <td class="item2" align="center">
                            <?php
                            if ($value["vrunitario"])
                                echo '&#36;' . number_format($value["vrunitario"], 2, ',', '.');
                            ?> 
                        </td>
                        <td class="item2" align="center">                            
                            <?php
                            if ($value["vrtotalsalida"])
                                echo '&#36;' . number_format($value["vrtotalsalida"], 0, ',', '.');
                            ?>     
                        </td>
                        <td class="item2" align="center">
                            <?php
                            $partes = explode(".", $value["saldo"]);
                            if ($partes[1] == 0) {
                                echo $value["saldo"];
                            } else {
                                echo number_format($value["saldo"], 2, ',', '.');
                            }
                            ?>    
                        </td>
                        <td class="item2" align="center" >
                            <?php echo '&#36;' . number_format($value["saldocosto"], 2, ',', '.'); ?>    
                        </td>
                        <td class="item2" align="center" style="width: 450px;">
                            <?php echo '&#36;' . number_format($value["vrtotalsaldo"], 0, ',', '.'); ?>     
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
</div> 
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar la bodega <strong id="nombrecalldel"></strong>?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
        </div>
    </div>
</div>
        </div>
    </div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
</div>
<script>

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
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                { "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }, 
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
            ]
        } );
    });
</script>