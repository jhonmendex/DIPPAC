<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div align="center">    
    <form action="index.php?controlador=Warehouse&accion=updatewarehouse" method="POST" id="formWarehouse"> 
    <fieldset class="colorleyend" style="width: 90%">
        <legend class="colorleyendinto">Editar bodega</legend>
        <table cellspacing="10" border="0" style="width: 100%;" align="center">
            <tr>
                    <td colspan="2" style="font-size: small; line-height: normal">
                        A continuaci&oacute;n actualice la informaci&oacute;n de la bodega seleccionada, los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
            </tr>
            <tr>
                <td>Nombre bodega(*): </td>              
                <td>
                    <?php $view->input("nombrebodega",
                            "text",
                            "Nombre Bodega",
                            array('required' => true, 'text' => 'regular', 'minsize' => '4','norepeat' => 'val7','except' => $bodega['nombre']), 
                            array('size' => '50', 'maxlength' => '40', 'value' => $bodega['nombre']));
                    ?>                    
                </td>
            </tr>
            <tr>
                <td>Direccion(*): </td>
                <td>
                    <?php $view->input("direccion",
                            "text", 
                            "direccion Bodega", 
                            array('required' => true, 'text' => 'address', 'minsize' => '4'),
                            array('size' => '50', 'maxlength' => '45', 'value' => $bodega['direccion']));
                    ?>     
                </td>
            </tr>
            <tr>
                <td>Departamento: </td>
                <td><?php echo $deps; ?></td>
            </tr>
            <tr>
                <td>Ciudad: </td>
                <td>
                    <div id="resCid"><?php echo $cids; ?></div>   
                </td>
            </tr>
            <tr>
                <td><?php $doc->texto('SECTOR') ?>: </td>
                <td> <?php echo $locvin; ?></td> 
            </tr>              
            <tr>
                <td><?php $doc->texto('NEIGHBORHOOD') ?>: </td>
                <td><div id="barrio"><?php echo $barrvin; ?></div></td> 
            </tr>         
        </table>
    </fieldset>     
    <input type="hidden" name="verification" value="<?php echo strrev(urlencode(base64_encode($bodega['id']))) ?>"/>
    <input type="hidden" name="formid" value="<?php echo sha1(2989140) ?>"/>
    </form>
    <button class="buscarButton" style="float: left;height: 40px; margin-left: 5%" id="finish">Editar <br>bodega</button>    
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script> 
    function message(mensaje,imagen){        
        $("#titlemesagge",window.parent.document).html("<strong>"+mensaje+"<strong/>");
        $("#iconmesagge",window.parent.document).html(" <img src='"+imagen+"'/>");       
        $("#barraf",window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf",window.parent.document).slideUp(1000).fadeOut(400);  
    }
    $(document).ready(function() { 
        $("#departamentos").val('<?php echo $bodega['departamento'] ?>');
        $("#locvin").val('<?php echo $bodega['localidad'] ?>');
        $("#barrvin").val('<?php echo $bodega['barrio'] ?>');
        $("#ciudades").val('<?php echo $bodega['ciudad'] ?>');
        $("#departamentos").change(function() {              
            var ajaxOpts = {
                type: "get",
                url: "index.php",
                data: "&controlador=Warehouse&accion=ajaxCiudades&departamento=" + $("#departamentos").val()+"&tag=ciudades",
                success: function(data) {							
                    $('#resCid').html(data);
                }
                
            };
            $.ajax(ajaxOpts);
        });   
        
        $("#locvin").change(function() {              
            var ajaxOpts = {
                type: "get",
                url: "index.php",
                data: "&controlador=Warehouse&accion=ajaxBarrios&localidad=" + $("#locvin").val()+"&tag=barrvin",
                success: function(data) {							
                    $('#barrio').html(data);
                }
                
            };
            $.ajax(ajaxOpts);
        });    
        
        $('#finish').click(function() {
            $('#formWarehouse').ajaxForm({
                dataType: 'json',
                beforeSubmit: function() {
                    $('#finish').attr('disabled', 'disabled');
                    $("#finish").addClass("buscarButtonDis");
                    $("#finish").removeClass("buscarButton");
                    $('#loader').css('display', 'block');
                    if (validates("formWarehouse")) {
                        return true;
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
                        parent.message("Se ha actualizado la bodega", "images/iconos_alerta/ok.png");
                        parent.updatedata(responseText.id,
                        responseText.nombre,
                        responseText.direccion);                        
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'no') {
                        parent.message('No se ha podido actualizar la bodega', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    }
                }
            }).submit();
        });
        
        $("#formWarehouse input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });  
    });
</script>

