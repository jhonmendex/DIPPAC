<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Ajuste de inventario</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">    
            <fieldset class="colorleyend" style="width: available;float: left; height: 138px">
                <legend class="colorleyendinto">Informaci&oacute;n</legend>
                <div style="float: left">
                    <form method="POST" action="index.php?controlador=InventoryAdjust">
                        <table>
                            <tr>
                                <td>Bodega:</td>
                                <td><strong><?php echo $bodega ?></strong></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 170px; height: 40px ">Seleccione categoria:</td>
                                <td>
                                    <select id="categorias" name="categoria">
                                        <option value="0">
                                            TODAS LAS CATEGORIAS
                                        </option>
                                        <?php foreach ($categorias as $key => $value) { ?>
                                            <option value="<?php echo $key ?>">
                                                <?php echo $value ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <button class="buscarButton" id="ordernow">Aceptar</button>  </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: small; line-height: normal; text-align:justify">Si va a realizar una carga masiva de la informaci&oacute;n del ajuste, hagalo 
                                    antes de colocar algun valor manualmente en la tabla de productos que se encuentra en la parte de abajo
                                    de este modulo, ya que si ingresa primero un valor manualmente, deshabilitara la opci&oacute;n de carga masiva.</td>                        
                            </tr>
                        </table>
                    </form>
                </div>
                <div style="clear: both"></div>
            </fieldset>
            <fieldset class="colorleyend" style="width: 120px;float: left;">
                <legend class="colorleyendinto">Opciones</legend>
                <div style="float: left">
                    <a id="subirtttintert"
                       href="index.php?controlador=InventoryAdjust&accion=massiveupload" title="Carga masiva de datos">
                        <button class="buscarButton" id="upload" style="height: 40px">
                            Carga<br>Masiva
                        </button>
                    </a>
                </div>
                <div style="float: left">
                    <button class="buscarButton" id="finish" style="height: 40px">
                        Realizar<br>Ajuste
                    </button>
                </div>        
                <div style="float: left">
                    <a tar='index.php?controlador=InventoryAdjust&accion=cancelAdjust'
                       id="allcancel"
                       onclick='confirmfunction($(this).attr("id"))'
                       href='#'>
                        <button class="buscarButton" id="cancel" style="height: 40px">
                            Cancelar<br>Ajuste
                        </button>
                    </a>
                </div>
                <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                    <img src="images/ajax-loader.gif"/> Procesando...
                </div>
                <div style="clear: both"></div>
            </fieldset>
            <div style="clear: both"></div>
            <?php if ($mensagge&&$mensagge!="Se ha realizado el ajuste correctamente") { ?>
                <div style="width: 265px;">
                    <a href="index.php?controlador=InventoryAdjust&accion=WriteExcelNotify">            
                        <p><img src="images/excel.png" width="22px" height="22px" style="margin-right: 5px" align="left"/>Descargar resultado de la carga masiva</p>
                    </a>
                </div>
            <?php } ?>
            <fieldset class="colorleyend" style="width: 98%">
                <legend class="colorleyendinto">Lista de porductos de <?php echo $categoriaactual == 0 ? "TODAS LAS CATEGORIAS" : $categorias[$categoriaactual] ?></legend>
                <div style="margin-top: 15px;margin-bottom: 20px">
                    <table class="table" border="0" cellspacing="0" cellpadding="0" id="example">
                        <thead>
                            <tr class="headall">
                                <th class="headinit">Nombre del producto</th>
                                <th class="head">Referencia</th>
                                <th class="head">Costo base</th>
                                <th class="head">Cantidad</th>
                                <th class="head">Cantidad fisica</th>
                                <th class="head">Diferencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $estilo = 1;
                            if (sizeof($productosstock) != 0) {
                                foreach ($productosstock as $value) {
                                    if ($value["id"]) {
                                        ?>
                                        <tr class="class<?php echo $estilo; ?>">
                                            <td class="init2">
                                                <?php echo $value["nombre"] ?>
                                            </td>
                                            <td class="item2">
                                                <?php echo $value["referencia"] ?>
                                            </td>
                                            <td class="item2" style="text-align: center" >
                                                <?php echo number_format($value["costo"], 2, ',', '.'); ?>
                                            </td>
                                            <td class="item2" style="text-align: center">
                                                <?php
                                                echo $value["stock"];
                                                ?> <?php echo ucfirst($value['unidad']) ?>s. </td>
                                            <td class="item2" style="text-align: center;">
                                                <?php
                                                if ($value['unidad'] == 'und') {
                                                    $view->input("cantidad", "numeric", "cantidad", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('maxlength' => '4',
                                                        "size" => "5",
                                                        "id" => "cantidad" . $value['id'],
                                                        "real" => $value["stock"],
                                                        "item" => $value['id'],
                                                        "costo" => number_format($value['costo'], 2, ".", ""),
                                                        "class" => "cantfis",
                                                        "value" => $value['cantidad']
                                                            // "onkeyup" => "actualizarDif($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))"));
                                                    ));
                                                } else {
                                                    $view->input("cantidad", "text", "cantidad", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('maxlength' => '8',
                                                        "size" => "10",
                                                        "id" => "cantidad" . $value['id'],
                                                        "real" => $value["stock"],
                                                        "item" => $value['id'],
                                                        "costo" => number_format($value['costo'], 2, ".", ""),
                                                        "class" => "cantfis",
                                                        "value" => $value['cantidad']
                                                            //"onkeyup" => "actualizarDif($(this).attr(\"id\"),$(this).attr(\"item\"),$(this).attr(\"reff\"))"));
                                                    ));
                                                }
                                                ?> <?php echo ucfirst($value['unidad']) ?>s.
                                            </td>
                                            <td class="item2"                                                 
                                                id="dif<?php echo $value['id'] ?>"
                                                style="text-align: center;color: <?php echo $value['cantidad'] != null?($value['proceso'] == "igual"?"#000":($value['proceso'] == "quitar" ? "#990000" : "#00BB00")):"#000" ?>">
                                                <strong><?php
            if ($value['cantidad'] != null) {
                echo $value['proceso'] == "quitar" || $value['proceso'] == "igual" ? $value['cantidad'] - $value["stock"] : "+" . ($value['cantidad'] - $value["stock"]);
            }
            ?></strong>
                                            </td>

                                        </tr>
        <?php } else { ?>
                                        <tr class="class<?php echo $estilo; ?>">
                                            <td class="init2" style="font-size: 20px; border-right: none !important">
                                                <strong><?php echo $value["nombrecat"] ?></strong>
                                            </td>
                                            <td class="init2" style="border-left: none !important; border-right: none !important">
                                            </td>
                                            <td class="init2" style="border-left: none !important; border-right: none !important">
                                            </td>
                                            <td class="init2" style="border-left: none !important; border-right: none !important">
                                            </td>
                                            <td class="init2" style="border-left: none !important; border-right: none !important">
                                            </td>
                                            <td class="init2" style="border-left: none !important">
                                            </td>
                                        </tr>
            <?php
        }
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
            Esta seguro de cancelar el ajuste de inventario actual?
        </div>
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">Aceptar</button>
            <button style="margin-left: 10px" class="buscarButton" id="cancelll">Cancelar</button>
        </div>
    </div>
</div><div style="display: none">
    <a href="#contentcall" class="callback">Open Example</a>
</div>
<script>
<?php if ($mensagge) { ?>
            message("<?php echo $mensagge; ?>", "images/iconos_alerta/ok.png");
<?php } ?>
    function confirmfunction(id) {
        $('.callback').trigger('click');
        $('#accept').click(function() {
            $.ajax({
                type: "POST",
                url: $('#' + id).attr('tar'),
                dataType: "json",                                
                data: {},
                success: function(data) {
                    if (data.respuesta == 'ok') {
                        window.location = 'index.php?controlador=InventoryAdjust';
                    }
                }
            });
        });
        $('#cancelll').click(function() {
            $.fancybox.close();
        });
    }
    $(document).ready(function() {
        $("#finish").click(function() {
            $.ajax({
                type: "POST",
                url: "index.php?controlador=InventoryAdjust&accion=finishAdjust",
                dataType: "json",
                beforeSend: function ( xhr ) {
                    $("#loader").css("display", "block");
                    $("#finish").attr("disabled", "disabled");
                    $("#finish").removeClass("buscarButton");
                    $("#finish").addClass("buscarButtonDis");
                    $("#cancel").attr("disabled", "disabled");
                    $("#cancel").removeClass("buscarButton");
                    $("#cancel").addClass("buscarButtonDis");                                       
                },
                data: {},                               
                success: function(data) {
                    if (data.respuesta == 'ok') {
                        window.location = 'index.php?controlador=InventoryAdjust&respuesta=Se ha realizado el ajuste correctamente';
                    }else{
                        $("#loader").css("display", "none");
                        $("#finish").removeAttr("disabled", "disabled");
                        $("#finish").addClass("buscarButton");
                        $("#finish").removeClass("buscarButtonDis");
                        $("#cancel").removeAttr("disabled", "disabled");
                        $("#cancel").addClass("buscarButton");
                        $("#cancel").removeClass("buscarButtonDis"); 
                        message("No se ha podido realizar el ajuste", "images/iconos_alerta/error.png") ;
                    }                    
                }
            });
        });                   
        $("#subirtttintert").fancybox({
            'width': 700,
            'height': 250,
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
<?php if (!$validacion) { ?>
            $("#finish").attr("disabled", "disabled");
            $("#finish").removeClass("buscarButton");
            $("#finish").addClass("buscarButtonDis");
            $("#cancel").attr("disabled", "disabled");
            $("#cancel").removeClass("buscarButton");
            $("#cancel").addClass("buscarButtonDis");
<?php } else { ?>
            $("#upload").attr("disabled", "disabled");
            $("#upload").removeClass("buscarButton");
            $("#upload").addClass("buscarButtonDis");
<?php } ?>
        $(".cantfis").keyup(function() {
            var resultado = $(this).val() - $(this).attr("real");
            $("#dif" + $(this).attr("item")).html(resultado > 0 ? "<strong>"+"+" + resultado+"</strong>" : "<strong>"+resultado+"</strong>");
            $("#dif" + $(this).attr("item")).css("color",resultado != 0?(resultado > 0 ? "#00BB00" : "#990000"):"#000");
            if ($(this).val() == null || $(this).val() == "") {
                $.ajax({
                    type: "POST",
                    url: 'index.php?controlador=InventoryAdjust&accion=removeItem',
                    dataType: "json",
                    data: {producto: $(this).attr("item")},
                    success: function(data) {
                        if (data.res == "none") {
                            if ($("#finish").attr("class") == "buscarButton") {
                                $("#finish").attr("disabled", "disabled");
                                $("#finish").removeClass("buscarButton");
                                $("#finish").addClass("buscarButtonDis");
                                $("#cancel").attr("disabled", "disabled");
                                $("#cancel").removeClass("buscarButton");
                                $("#cancel").addClass("buscarButtonDis");
                                $("#upload").removeAttr("disabled", "disabled");
                                $("#upload").removeClass("buscarButtonDis");
                                $("#upload").addClass("buscarButton");
                            }
                        } else if (data.res == "si") {
                            if ($("#finish").attr("class") == "buscarButtonDis") {
                                $("#finish").removeAttr("disabled", "disabled");
                                $("#finish").removeClass("buscarButtonDis");
                                $("#finish").addClass("buscarButton");
                                $("#upload").attr("disabled", "disabled");
                                $("#upload").removeClass("buscarButton");
                                $("#upload").addClass("buscarButtonDis");
                            }
                        }
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: 'index.php?controlador=InventoryAdjust&accion=addItem',
                    dataType: "json",
                    data: {cantfisica: $(this).val(), producto: $(this).attr("item"), cantsitema: $(this).attr("real"), costo: $(this).attr("costo")},
                    success: function(data) {
                        if ($("#finish").attr("class") == "buscarButtonDis") {
                            $("#finish").removeAttr("disabled", "disabled");
                            $("#finish").removeClass("buscarButtonDis");
                            $("#finish").addClass("buscarButton");
                            $("#cancel").removeAttr("disabled", "disabled");
                            $("#cancel").removeClass("buscarButtonDis");
                            $("#cancel").addClass("buscarButton");
                            $("#upload").attr("disabled", "disabled");
                            $("#upload").removeClass("buscarButton");
                            $("#upload").addClass("buscarButtonDis");
                        }
                    }
                });
            }
            if ($(this).val() == null || $(this).val() == "") {
                $("#dif" + $(this).attr("item")).css("color","#000");
                $("#dif" + $(this).attr("item")).html("");
            }
        });
        $('img').css("border", "0");
        $('#categorias').val("<?php echo $categoriaactual; ?>");
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
            "aaSorting": [],
            "aoColumns": [
                {"bSortable": false},
                {"bSortable": false},
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false},
                {"bSortable": false, "bSearchable": false}
            ]
        });
    });
</script>
