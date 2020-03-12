<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Compra a proveedores</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">    
    <div style="float: left;width: 50%;">
        <fieldset class="colorleyend" style="width: 100%;">
            <legend class="colorleyendinto">Opciones</legend>
            <div id="cajaselect3" style="margin-bottom: 15px">
                        Bodega: <strong><?php echo $nombrebodega?></strong>                        
           </div>
            <div id="cajaselect" style="margin-bottom: 15px">
                <?php if ($continue) { ?>
                    <div>
                        <a style="cursor: pointer; color: #005500; font-weight: bold" 
                           href="index.php?controlador=SupplierBuy&accion=inizialiteBuy">
                            + Continuar con compra guardada automaticamente
                        </a>
                    </div> 
                    <div style="margin-top: 15px">                                                  
                        <a style="cursor: pointer; color: #005500; font-weight: bold" 
                           tar="index.php?controlador=SupplierBuy&accion=inizialiteBuy&option=new"   
                           href='#'
                           id="newBuy"
                           onclick='confirmfunction($(this).attr("id"))'>
                            + Crear nueva compra
                        </a>                        
                    </div> 
                <?php } else { ?> 
                    <div>                                                  
                        <a style="cursor: pointer; color: #005500; font-weight: bold" 
                           href="index.php?controlador=SupplierBuy&accion=inizialiteBuy&option=new">
                            + Crear nueva compra
                        </a>                        
                    </div> 
                <?php } ?> 
            </div>
        </fieldset>
    </div> 
    <div style="clear: left"></div>
    <fieldset class="colorleyend" style="width: 100%;">
        <legend class="colorleyendinto">Facturas de compra</legend>
        <div style="float: left;height: 16px;margin-bottom: 10px">
           <img src="images/return.png" width="18px" height="18px" /> : Detalles de compra y devolucion a proveedor
        </div>                           
        <div style="clear: both; margin-bottom: 15px"></div>
        <div style="margin-top: 15px;margin-bottom: 20px"> 
            <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable"> 
                <thead>
                    <tr class="headall">     
                        <th class="headinit" style="cursor: pointer">Id</th>                        
                        <th class="head" style="cursor: pointer">No. Factura</th>
                        <th class="head">Fecha</th> 
                        <th class="head">Proveedor</th> 
                        <th class="head">Nit</th> 
                        <th class="head">Subtotal</th> 
                        <th class="head">Iva</th>
                        <th class="head">Total</th> 
                        <th class="head">Realizar<br>Devoluci&oacute;n</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($compras)) {
                        foreach ($compras as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>"> 
                                <td class="init2" style="width: 450px;" id="nameb<?php echo $value["id"] ?>">
                                    <?php echo $value["id"] ?>
                                </td>  
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["codigo"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php
                                    $array = split(" ", $value["fecha"]);
                                    echo $array[0]
                                    ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["empresa"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    <?php echo $value["nit"] ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    $<?php echo number_format($value["total"], 0, ',', '.') ?>
                                </td> 
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    $<?php echo number_format($value["ivatotal"], 0, ',', '.') ?>
                                </td>
                                <td class="item2" style="width: 450px;" id="dirb<?php echo $value["id"] ?>">
                                    $<?php echo number_format($value["ivatotal"] + $value["total"], 0, ',', '.') ?>
                                </td>
                                <td class="item2" style="width: 20px; text-align: center">
                                    <a class="various3" title="Detalles de compra y devolucion a proveedor" href="index.php?controlador=SupplierBuy&accion=getdetailsdocSupplierbuy&iddoc=<?php echo $value["id"] ?>" style="width: 15px; margin-left: auto; margin-right: auto;">
                                        <img src="images/return.png" width="18px" height="18px" title="Detalles de compra y devolucion a proveedor"/>                       
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
        </div> 
    </div> 
<div style="display: none">
    <div id="contentcall">
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Actualmente existe una compra sin finalizar, si inicia una nueva compra se borraran
            los datos guardados de la compra que no se finaliz&oacute;. Esta seguro de iniciar una nueva compra?.
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">Si</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel">No</button>
        </div>
    </div>
</div>
<div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>    
</div>
<script>
<?php if ($mensajito) { ?>
                               message('Se ha ingresado una nueva compra al sistema', 'images/iconos_alerta/ok.png');
<?php } ?>
                           var oTable;
                           function confirmfunction(id) {
                               $('.callback').trigger('click');
                               $('#accept').click(function() {
                                    window.location= $('#'+id).attr("tar");
                               });
                               $('#cancel').click(function() {
                                   $.fancybox.close();
                               });
                           }                       

                           $(document).ready(function() {
                               $(".various3").fancybox({
                                   'width': 1000,
                                   'height': 480,
                                   'autoScale': false,
                                   'transitionIn': 'elastic',
                                   'transitionOut': 'elastic',
                                   'speedIn': 500,
                                   'type': 'iframe',
                                   'hideOnOverlayClick': false
                               });
                               $(".callback").fancybox({
                                   'autoDimensions': false,
                                   'width': 420,
                                   'height': 150,
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
                               $('img').css("border", "0");
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
                                   },
                                   "aLengthMenu": [
                                       [10, 15, 20, -1],
                                       [10, 15, 20, "Todos"]
                                   ],
                                   "iDisplayLength": 10,
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
                                       {"bSortable": false, "bSearchable": false},
                                       {"bSortable": false, "bSearchable": true},
                                       {"bSortable": false, "bSearchable": true},
                                       {"bSortable": false, "bSearchable": false},
                                       {"bSortable": false, "bSearchable": false},
                                       {"bSortable": false, "bSearchable": false},
                                       {"bSortable": false, "bSearchable": false}
                                   ]
                               });

                           });
</script>
