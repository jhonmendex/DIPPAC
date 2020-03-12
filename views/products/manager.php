<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Productos</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">  
            <div style="float: left;width: 100%;">
                <fieldset class="colorleyend" style="width: 100%;">
                    <legend class="colorleyendinto">Opciones</legend>
                    <?php if ($perfilgrupe != "Superadministrador") { ?>
                    <div id="cajaselect3" style="margin-bottom: 15px">
                        Bodega: <strong><?php echo $nombrebodega?></strong>
                        <p style="line-height: normal; font-size: small">Los productos creados en este módulo, estarán disponibles para todas las bodegas al mismo precio, pero al editar el precio base de un producto, este precio será únicamente para su bodega.</p>
                    </div>
                     <?php  } else{ ?>
                     <div id="cajaselect3" style="margin-bottom: 15px">
                        
                        <p style="line-height: normal; font-size: small">Los productos creados en este módulo, estarán disponibles para todas las bodegas al mismo precio, pero al editar el precio base de un producto, este precio será únicamente para el módulo de carrito de compras de los estudiantes.</p>
                    </div>
                     <?php  }?>
                    <form method="POST" action="index.php?controlador=Products">
                        <div id="cajaselect" style="margin-bottom: 15px">
                            Seleccione categoria:
                            <select id="categorias" name="idcat">
                                <?php if (sizeof($categorias) == 0) { ?> 
                                    <option value="9999999">
                                        NO EXISTEN CATEGORIAS DISPONIBLES
                                    </option>
                                <?php
                                } else {
                                    foreach ($categorias as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>  
                            <?php if (sizeof($categorias) == 0) { ?> 
                                <button class="buscarButtonDis" disabled="disabled" id="ordernow">ACEPTAR</button>
                            <?php } else { ?>
                                <button class="buscarButton" id="ordernow">ACEPTAR</button>
<?php } ?>
                        </div>
                    </form>
                    <div id="cajaselect2" style="margin-bottom: 15px">
                        <a style="cursor: pointer; color: #005500; font-weight: bold;"
                           class="various3"                            
                           href="index.php?controlador=Products&accion=crearproducto&idcat=<?php echo $categoriaselected; ?>"
                           title="Crear producto">
                            + Crear nuevo producto
                        </a>
                    </div>
<?php if ($perfilgrupe == "Superadministrador" || $perfilgrupe == "Superadministrador") { ?>
                        <div id="cajaselect3" style="margin-bottom: 15px">
                            <a style="cursor: pointer; color: #005500; font-weight: bold;" 
                               class="various3"
                               href="index.php?controlador=Products&accion=adminCategorys"
                               title="Administrar Categorias">
                                + Administrar categorias
                            </a>
                        </div>
<?php } ?>
                </fieldset>
            </div>
            <div style="clear: left"></div>
            <div style="margin-top: 15px;margin-bottom: 20px">
                    <fieldset class="colorleyend" style="width: 100%;">
                        <legend class="colorleyendinto">Productos <?php if (sizeof($categorias) != 0) {
        echo "de la categoria " . $categorias[$categoriaselected];
    } ?> </legend>      
                        <div style="float: left; height: 16px">
                            <img src="images/enable.png"/>: Producto activo
                        </div>
                        <?php if ($perfilgrupe == "Superadministrador") { ?>  
                        <div style="float: left; margin-left: 30px; height: 16px">
                            <img class="delete" src="images/disable.png"/>: Producto inactivo
                        </div>
                        <?php }?>  
                        <div style="float: left; margin-left: 30px; height: 16px">
                            <img src="images/edit.png" width="15px" height="15px" />: Editar un producto
                        </div>
                        <div style="float: left; margin-left: 30px; height: 16px">
                            <img src="images/proveedor.png" width="18px" height="18px"/> : Ver proveedores de un producto
                        </div>    
                        <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
                            <strong style="color: #252f38">N/A</strong> : No aplica
                        </div>   
                        <?php if ($perfilgrupe == "Superadministrador") { ?>  
                        <div style="float: left; margin-left: 30px; height: 16px; padding-top: 7px;">
                            (<a style="cursor: default; color: #005500; font-weight: bold;">inactivar</a>) : Inactivar un producto
                        </div>  
                        
                        <div style="float: left;height: 16px; margin-top: 10px; padding-top: 7px;">
                            (<a style="cursor: default; color: #005500; font-weight: bold;">activar</a>) : Activar un producto
                        </div>  
                         <?php }?>  
                        <div style="clear: both; margin-bottom: 15px"></div>
                        <div>
                        <table class="table" border="0" cellspacing="0" cellpadding="0" id="example">    
                            <thead>
                                <tr class="headall">     
                                    <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                                    <th class="head">Referencia</th>
                                    <th class="head" style="cursor: pointer;">Puntos</th>
                                    <th class="head">IVA</th>
                                    <th class="head">Estado</th>
                                    <th class="head" style="cursor: pointer;">Precio</th>
                                    <th class="head" style="cursor: pointer;">Precio(iva)</th> 
                                    <th class="head">Proveedores</th>    
                                    <th class="head">Editar</th>                     
                                </tr> 
                            </thead>
                            <tbody>
                                <?php
                                $estilo = 1;
                                if (sizeof($productos) != 0) {
                                    foreach ($productos as $value) {
                                        ?>
                                <tr class="class<?php echo $estilo; ?>" id="im<?php echo $value["id"] ?>"> 
                                            <td class="init2" style="width: 450px;" id="nome<?php echo $value["id"] ?>">
            <?php echo $value["nombre"] ?>
                                            </td>  
                                            <td class="item2" style="width: 40px;" id="refe<?php echo $value["id"] ?>">
                                                <?php echo $value["referencia"] ?>
                                            </td>
                                            <td class="item2" style="width: 40px;text-align: center" id="point<?php echo $value["id"] ?>">
                                                <?php
                                                echo number_format($value["puntos"], 2, ',', '.');
                                                ?></td>
                                            <td class="item2" style="width: 40px;;text-align: center" id="iva<?php echo $value["id"] ?>">
                                                    <?php echo $value["iva"] ?>%
                                            </td>
                                            <td class="item2" style="width: 40px;;text-align: center">                                                
            <?php if ($perfilgrupe == "Superadministrador") { ?>                                                       
                <?php if ($value['estado'] == 'activo') { ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                                <img class="delete" src="images/enable.png" title="activo"/>
                                                </div>
                                                <br>
                                                        <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px"> 
                                                            (<a id="dell<?php echo sha1($value['id']); ?>" 
                                                                callback="<?php echo $value['nombre']; ?>" 
                                                                tar="index.php?controlador=Products&accion=disablePro" 
                                                                verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                                                href="#"
                                                                onclick="confirmfunction($(this).attr('id'))"
                                                                style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)</div>
                <?php } else { ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                                <img class="delete" src="images/disable.png" title="inactivo"/>
                                                </div>
                                                <br>
                                                        <div id="otrootro<?php echo $value['id']; ?>" style="height: 4px"> 
                                                            (<a id="dell2<?php echo sha1($value['id']); ?>" 
                                                                callback="<?php echo $value['nombre']; ?>" 
                                                                tar="index.php?controlador=Products&accion=enablePro" 
                                                                verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                                                href="#"
                                                                onclick="confirmfunction2($(this).attr('id'))"
                                                                style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)</div>
                                                    <?php }
                                                }else{ ?>
                                                   <?php if ($value['estado'] == 'activo') { ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                                <img class="delete" src="images/enable.png" title="activo"/>
                                                </div> 
                                                 <?php }else{ ?>
                                                <div id="state<?php echo $value['id']; ?>" style="height: 0px"> 
                                                <img class="delete" src="images/disable.png" title="inactivo"/>
                                                </div>
                                                <?php }                                                
                                                }
                                                ?>                            
                                            </td>
                                            <td class="item2" style="width: 40px;;text-align: center" id="price<?php echo $value["id"] ?>">
                                                <?php
                                                echo '&#36;' . number_format($value["precio"], 0, ',', '.') . '/' . ucfirst($value["unidad"]) . '.';
                                                ?>
                                            </td>
                                            <td class="item2" style="width: 10px;text-align: center;" id="pricefull<?php echo $value["id"] ?>">
                                                <?php
                                                $precioiva = ($value["precio"] * $value["iva"]) / 100;
                                                echo '&#36;' . number_format($precioiva + $value["precio"], 0, ',', '.') . '/' . ucfirst($value["unidad"]) . '.';
                                                ?>
                                            </td>
                                            <td class="item2" style="width: 20px;text-align: center">
                                                <?php if ($value['proveedores'] != 0) { ?>
                                                    <a class="various4" href="index.php?controlador=Products&accion=viewProveedores&idpro=<?php echo $value["id"]; ?>" style="width: 15px; margin-left: auto; margin-right: auto;" title="Proveedores del producto">
                                                        <img src="images/proveedor.png" width="22px" height="22px" title="Ver Proveedores"/>                       
                                                    </a>  
                                                   <?php } else {?>
                                                    <strong style="color: #252f38">N/A</strong>
                                                    <?php } ?>
                                            </td>  
                                            <td class="item2" style="width: 20px;text-align: center">
                                                <a class="various3" href="index.php?controlador=Products&accion=editarproducto&idpro=<?php echo $value["id"]; ?>" style="width: 15px; margin-left: auto; margin-right: auto;"  title="Editar producto">
                                                    <img src="images/edit.png"width="21px" height="21px" title="<?php $doc->texto('EDIT'); ?>"/>                                              
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
    </div>
    <div style="display: none">
        <div id="contentcall">
            <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
                Esta seguro de inactivar el producto <strong id="nombrecalldel"></strong>?
            </div>
            <div style="text-align: center; margin-bottom: 12px;">
                <button class="buscarButton" id="accept">ACEPTAR</button>    
                <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
            </div>
        </div>
    </div>
    <div style="display: none">
        <a href="#contentcall" class="callback">Open Example</a>
    </div>
    <div style="display: none">
        <div id="contentcall2">
            <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
                Esta seguro de activar el producto <strong id="nombrecalldel2"></strong>?
            </div>
            <div style="text-align: center; margin-bottom: 12px;">
                <button class="buscarButton" id="accept2">ACEPTAR</button>    
                <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
            </div>
        </div>
    </div>
    <div style="display: none">
        <a href="#contentcall2" class="callback2">Open Example</a>
    </div>
<script>
var oTable;
eval("<?php echo $create ?>");
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
                   $('#state' + data.idrow).html('').append('<img class="delete" src="images/disable.png" title="inactivo"/>');
                   $('#' + id).removeAttr('tar');
                   $.fancybox.close();
                   $('#' + id).removeAttr('onclick');
                   $('#' + id).unbind('click');
                   $('#' + id).remove();
                   $("#otrootro" + data.idrow).html("").append('(<a id="' + data.ididid + '"\n\
                            callback="' + data.nombre + '"\n\
                            tar="index.php?controlador=Products&accion=enablePro" \n\
                            onclick="confirmfunction2($(this).attr(\'id\'))" \n\
                            verify="' + data.verify + '" \n\
                            href="#"\n\
                            style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)');
                   message("Se ha inactivado el producto", "images/iconos_alerta/ok.png");
               } else {
                   $.fancybox.close();
                   message("No se pudo inactivar el producto", "images/iconos_alerta/error.png");
               }
           }
       });
    });

    $('#cancel').click(function() {
       $.fancybox.close();
    });
}

function confirmfunction2(id) {
    $('#nombrecalldel2').html($('#' + id).attr('callback'));
    $('.callback2').trigger('click');
    $('#accept2').click(function() {
       $.ajax({
           type: "POST",
           url: $('#' + id).attr('tar'),
           dataType: "json",
           data: {verify: $('#' + id).attr('verify')},
           success: function(data) {
               if (data.res == 'si') {
                   $('#state' + data.idrow).html('').append('<img class="delete" src="images/enable.png" title="activo"/>');
                   $('#' + id).removeAttr('tar');
                   $.fancybox.close();
                   $('#' + id).removeAttr('onclick');
                   $('#' + id).unbind('click');
                   $('#' + id).remove();
                   $("#otrootro" + data.idrow).html("").append('(<a id="' + data.ididid + '"\n\
                        callback="' + data.nombre + '"\n\
                        tar="index.php?controlador=Products&accion=disablePro" \n\
                        onclick="confirmfunction($(this).attr(\'id\'))" \n\
                        verify="' + data.verify + '" \n\
                        href="#"\n\
                        style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)');
                   message("Se ha activado el producto", "images/iconos_alerta/ok.png");
               } else {
                   $.fancybox.close();
                   message("No se pudo activar el producto", "images/iconos_alerta/error.png");
               }
           }
       });
    });
    $('#cancel2').click(function() {
       $.fancybox.close();
    });
}

function updateData(id, nombre, puntos, iva, precio, precioiva,referencia ,unidad) {
    $('#nome' + id).html(nombre);
    $('#point' + id).html(puntos);
    $('#iva' + id).html(iva + "%");
    $('#price' + id).html("$" + precio + "/" + unidad.charAt(0).toUpperCase() + unidad.slice(1) + ".");
    $('#pricefull' + id).html("$" + precioiva + "/" + unidad.charAt(0).toUpperCase() + unidad.slice(1) + ".");
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
var x = (a == "-") ? 0 : a.replace("$", "").replace(".", "").replace("/Kg.", "").replace("/Und.", "");
var y = (b == "-") ? 0 : b.replace("$", "").replace(".", "").replace("/Kg.", "").replace("/Und.", "");
return (x - y);
};

jQuery.fn.dataTableExt.oSort['numeric-point-desc'] = function(a, b) {
var x = (a == "-") ? 0 : a.replace("$", "").replace(".", "").replace("/Kg.", "").replace("/Und.", "");
var y = (b == "-") ? 0 : b.replace("$", "").replace(".", "").replace("/Kg.", "").replace("/Und.", "");
return (y - x);
};
$(document).ready(function() {
    $(".various4").fancybox({
      'width': 900,
       'height': 380,
       'autoScale': false,
       'transitionIn': 'elastic',
       'transitionOut': 'elastic',
       'speedIn': 500,
       'type': 'iframe',
       'hideOnOverlayClick': false
    });
    $(".various3").fancybox({
       'width': 900,
       'height': 490,
       'autoScale': false,
       'transitionIn': 'elastic',
       'transitionOut': 'elastic',
       'speedIn': 500,
       'type': 'iframe',
       'hideOnOverlayClick': false
    });
    $('img').css("border", "0");
    $('#categorias').val("<?php echo $categoriaselected; ?>");
    $('#categorias').change(function() {
    if ($('#categorias').val() == "9999999") {
       $("#ordernow").attr("disabled", "disabled");
       $("#ordernow").addClass("buscarButtonDis");
       $("#ordernow").removeClass("buscarButton");
    } else {
       $("#ordernow").removeAttr("disabled");
       $("#ordernow").attr("class") == "buscarButton" ? null : $("#ordernow").addClass("buscarButton");
       $("#ordernow").removeClass("buscarButtonDis");
    }
    });
    oTable=$('#example').dataTable({
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
       {"bSortable": false},
       {"sType": "numeric-comma", "bSearchable": false},
       {"bSortable": false},
       {"bSortable": false},
       {"sType": "numeric-point", "bSearchable": false},
       {"sType": "numeric-point", "bSearchable": false},
       {"bSortable": false, "bSearchable": false},
       {"bSortable": false, "bSearchable": false}
    ]
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
});
</script>