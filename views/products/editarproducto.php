<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>

<div id="hidden_clicker" style="display:none;">
    <a class="overlay-flash" id="hiddenclicker" href="#" >Hidden Clicker</a>
</div>
<div align="center">    
    <form action="index.php?controlador=Products&accion=updateProduct" method="POST" id="formProduct">        
        <fieldset class="colorleyend" style="width: 90%">
            <legend class="colorleyendinto">Detalle producto</legend>
            <table cellspacing="5" border="0" style="width: 100%; line-height: 18px" align="center">
                <tr>
                    <td colspan="3" style="font-size: small">
                        A continuaci&oacute;n actualice la informaci&oacute;n del producto seleccionado, los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
                </tr>
                <tr>
                    <td width="25%">Nombre producto(*): </td>              
                    <td width="25%">
                        <?php
                        $view->input("name_products", 
                                "text",
                                "Nombre producto", array('required' => true, 'text' => 'regular', 'minsize' => '2'), 
                                array('maxlength' => '50', 'size' => '35', 'value' => $producto['nombre']));
                        ?>                          
                    </td>
                    <td rowspan="10" style="vertical-align: top">
                        <ul id="secondGallery" class="image-overlay">
                            <li>
                                <a class="otros3" href="index.php?controlador=Products&accion=imageManager">
                                    <div id="nonemig">
                                        <img title=""  alt="plentiful" src="<?php echo $producto['imagen'] ?>" />
                                        <input type="hidden" name="imagen" value="<?php echo $producto['idimagen'] ?>"/>
                                    </div>
                                    <div style="top: -46px; background-color: rgb(97, 11, 56); color: rgb(255, 128, 0);" class="caption">
                                        <h2><font style="font-size: 14px"><center>Cambiar imagen</center></font></h2>
                                    </div>
                                </a>
                            </li>    
                        </ul>                    
                    </td>
                </tr>
                <tr>
                    <td>Referencia: </td>
                    <td width="30%">
<?php /*
if ($perfilgrupe == "Superadministrador") {
    $view->input("referencia", "numeric", "Referencia", array('required' => true,
        'text' => 'numeric',
        'minsize' => '1',
        'norepeat' => 'val2',
        'except' => $producto['referencia']), array('maxlength' => '15',
        'size' => '20',
        'value' => $producto['referencia']));
} else {*/
    $view->input("referencia", "numeric", "Referencia", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('maxlength' => '15',
        'size' => '20',
        'value' => $producto['referencia'],
        'disabled' => 'disabled',
        'readonly' => 'readonly',
        'style' => 'cursor:default; background: #c9d3e8'));
    ?>
                            <input type="hidden" name="referencia" value="<?php echo $producto['referencia'] ?>"
                        <?php //} ?>
                    </td>
                </tr>
                <tr>
                    <td>Precio venta base(*): </td>
                    <td width="30%">
                        $ <?php
                        $view->input("price", "text", "Precio venta", array('required' => true, 'text' => 'decimal', 'minsize' => '2'), array('maxlength' => '8', "size" => "10", 'value' => $producto['precio']));
                        ?> / <?php echo ucfirst($producto['unidad']); ?>.   
                    </td>
                </tr>
                <tr>
                    <td>Iva (*): </td>
                    <td width="30%">
                        % <?php
                        $view->input("iva", "numeric", "Iva", array('required' => true, 'text' => 'digit', 'minsize' => '1'), array('maxlength' => '2', "size" => "4", 'value' => $producto['iva']));
                        ?>    
                    </td>
                </tr>
                <tr>
                    <td>Categoria: </td>
                    <td width="30%">
                        <select id="categorias" name="categorias">
<?php foreach ($categorias as $key => $value) { ?>                           
                                <option value="<?php echo $key ?>">
    <?php echo $value ?>
                                </option>
<?php } ?>
                            <option value="1500">
                                CREAR CATEGORIA
                            </option>
                        </select> 
                    </td> 
                </tr>      
            </table>
        </fieldset>    

        <fieldset class="colorleyend" style="width: 90%">
            <legend class="colorleyendinto">Datos comisionables</legend>
            <table cellspacing="5" border="0" style="width: 100%; line-height: 20px" align="center">
                <tr>
                    <td width="15%" style="vertical-align: top;">Porcentaje de la utilidad del producto comisionable: </td>              
                    <td width="12%">
                        % <?php
                                if ($perfilgrupe == "Superadministrador") {
                                    $view->input("comission", "text", "Valor comisionable", 
                                            array('required' => true, 'text' => 'decimal', 'minsize' => '1'), 
                                            array('maxlength' => '3',
                                        "size" => "5",
                                        'value' => $producto['porcentajeutilidad'],
                                        "id"=>"commmisssion"));
                                } else {
                                    $view->input("comission", "text", "Valor comisionable", 
                                            array('required' => true, 'text' => 'decimal', 'minsize' => '1'),
                                            array('maxlength' => '5',
                                        "size" => "5",
                                        'value' => $producto['porcentajeutilidad'],
                                        'disabled' => 'disabled',
                                        'readonly' => 'readonly',
                                        'style' => 'cursor:default; background: #c9d3e8',
                                        "id"=>"commmisssion"));
                                    ?> 
                            <input type="hidden" name="comission" value="<?php echo $producto['porcentajeutilidad'] ?>"/>
                            <?php } ?>      
                    </td>
                </tr>                
            </table>
        </fieldset>  
        <input type="hidden" name="idproducto" value="<?php echo $producto['id'] ?>"/>
        <input type="hidden" name="unidad" value="<?php echo $producto['unidad'] ?>"/>
    </form>
    <button class="buscarButton" style="float: left;height: 40px; margin-left: 5%" id="finish">Editar producto</button>          
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    var defaultcat = '<?php echo $producto['idcategoria']; ?>';
    function updateSelect(idnuevo, nombrenuevo) {
        $("#categorias").append("<option value='" + idnuevo + "'>" + nombrenuevo + "</option>");
        $("#categorias").val("" + idnuevo + "");
    }
    function message(mensaje, imagen) {
        //parent.$.fancybox.close(); 
        $("#titlemesagge", window.parent.document).html("<strong>" + mensaje + "<strong/>");
        $("#iconmesagge", window.parent.document).html(" <img src='" + imagen + "'/>");
        $("#barraf", window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf", window.parent.document).slideUp(1000).fadeOut(400);
    }

    $(document).ready(function() {
        $("#categorias").val("<?php echo $producto['idcategoria']; ?>");
        $("#categorias").change(function() {
            if ($("#categorias").val() == 1500) {
                var j1 = document.getElementById("hiddenclicker");
                j1.href = "index.php?controlador=Products&accion=createCategory";
                $('#hiddenclicker').trigger('click');
            }
        });
        $("a.overlay-flash").fancybox({
            'autoDimensions': false,
            'width': 500,
            'height': 170,
            'autoScale': false,
            'transitionIn': 'elastic',
            'transitionOut': 'fade',
            'speedIn': 500,
            'type': 'iframe',
            'hideOnOverlayClick': false,
            'showCloseButton': false,
            'overlayColor': '#000',
            'margin': 15,
            'padding': 5
        });

        $(".otros3").fancybox({
            'autoDimensions': false,
            'width': 560,
            'height': 330,
            'autoScale': false,
            'overlayOpacity': 0.9,
            'transitionIn': 'elastic',
            'transitionOut': 'fade',
            'speedIn': 500,
            'type': 'iframe',
            'hideOnOverlayClick': true,
            'overlayColor': '#000',
            'showCloseButton': false,
            'padding': 0,
            'margin': 0
        });

        $('#finish').click(function() {
            $('#formProduct').ajaxForm({
                dataType: 'json',
                beforeSubmit: function() {
                    $('#finish').attr('disabled', 'disabled');
                    $("#finish").addClass("buscarButtonDis");
                    $("#finish").removeClass("buscarButton");
                    $('#loader').css('display', 'block');
                    if (validates("formProduct")) {
                        if ($('#commmisssion').val() > 100) {
                            $('#loader').css('display', 'none');
                            $('#finish').removeAttr('disabled');
                            $("#finish").addClass("buscarButton");
                            $("#finish").removeClass("buscarButtonDis");
                            parent.message('El valor de porcentaje de utilidad no puede ser mayor a 100ss', 'images/iconos_alerta/error.png');
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        $('#loader').css('display', 'none');
                        $('#finish').removeAttr('disabled');
                        $("#finish").addClass("buscarButton");
                        $("#finish").removeClass("buscarButtonDis");
                        return false;
                    }
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    $('#loader').css('display', 'none');
                    $('#finish').removeAttr('disabled');
                    if (responseText.respuesta == 'si') {
                        parent.message('Se ha actualizado correctamente el producto', 'images/iconos_alerta/ok.png');                        
                        if (responseText.idcategoria==$('#categorias', window.parent.document).val()) {
                            parent.updateData(responseText.id,
                                    responseText.nombre,
                                    responseText.puntos,
                                    responseText.iva,
                                    responseText.precio,
                                    responseText.precioiva,
                                    responseText.referencia,
                                    responseText.unidad);
                        } else { 
                            parent.oTable.fnDeleteRow(parent.oTable.fnGetPosition($('#im' + responseText.id, window.parent.document).get(0)));
                        }
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'no') {
                        parent.message("No se pudo actualizar el producto", "images/iconos_alerta/error.png");
                        parent.$.fancybox.close();
                    }
                }
            }).submit();
        });
        $("#formProduct input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });

    });
    $(window).load(function() {
        $("#secondGallery").ImageOverlay({
            border_color: "#005500",
            overlay_color: "#009900",
            overlay_origin: "top",
            overlay_text_color: "#FFFFFF"
        });
        $(".otros3").css("width", "200px");
        $(".otros3").css("height", "200px");
    });
</script>