<?php defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>'); ?>
<div class="container" style="width: 98% !important; margin: 15px auto 0;min-width: 400px;">
    <form id="miform" method="POST" action="index.php?controlador=InventoryAdjust&accion=updateAllStock" enctype="multipart/form-data">
        <fieldset class="colorleyend" style="width: 95%; height: auto">
            <legend class="colorleyendinto">Carga masiva de datos de ajuste de inventario</legend>           
            <table style="margin-top: 2px; margin-bottom: 5px">            
                <tr>
                    <td style="padding-left: 10px; vertical-align: middle; padding-bottom: 10px; line-height: 16px; font-size: 13px; text-align: justify" colspan="2">   
                        El formato del archivo debe ser de tipo .xls, .xlsx, csv. Las columnas que debe contener el archivo son: nombre del producto, referencia (codigo de barras), cantidad fisica.
                        Para descargar un archivo de excel con todos los productos y sus referencias haga click <a style="cursor: pointer; color: #EC690F" href="index.php?controlador=InventoryAdjust&accion=WriteExcelResult">aqui</a>.
                    </td>                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding-left: 10px; vertical-align: middle; padding-bottom: 10px">
                        Selecione el archivo: 

                    </td>
                    <td style="padding-left: 10px; vertical-align: middle; padding-bottom: 10px">                        
                        <input type="file" name="exceldatos" id="archivoex"/>
                    </td>

                </tr>
            </table>                          
            <p class="nuevo" style="float: left; text-align: left; margin-top: 5px; padding-left: 10px">                                
                <button class="buscarButton" id="ordernow">Subir archivo</button> 
            </p>  
            <div id="loader" style="float: left; margin-left: 20px; display: none;margin-top: 5px;">
                <img src="images/ajax-loader.gif"/>
            </div>

            <div style="clear: both"></div>
        </fieldset>
    </form>    
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script language="javascript">
    $(document).ready(function() {
        $('body').css('background', 'none');
        $('#miform').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#loader').css('display', 'block');
                $('#ordernow').attr("disabled","disabled");
                $('#ordernow').removeClass("buscarButton");
                $('#ordernow').addClass("buscarButtonDis");
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {               
                if (responseText.respuesta == 'no') {
                    $('#loader').css('display', 'none');
                    $('#ordernow').removeAttr("disabled");
                    $('#ordernow').removeClass("buscarButtonDis");
                    $('#ordernow').addClass("buscarButton");
                    parent.message(responseText.error, 'images/iconos_alerta/error.png');
                    $('#archivoex').val('');
                } else if (responseText.respuesta == 'si') {
                    $('#archivoex').val('');                    
                    window.parent.location = "index.php?controlador=InventoryAdjust&respuesta=Se ha realizado la carga masiva correctamente";
                }
            }
        });
    });
</script>